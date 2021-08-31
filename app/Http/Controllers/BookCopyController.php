<?php

namespace App\Http\Controllers;

use App\Models\BookCopy;
use App\Http\Requests\BookCopyRequest;
use App\Models\BookCondition;
use Illuminate\Support\Facades\Storage;
use SimpleSoftwareIO\QrCode\Facades\QrCode;
use Illuminate\Http\Request;
use App\Models\BookLending;
use App\Models\User;
use Illuminate\Support\Facades\DB;

class BookCopyController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(BookCopyRequest $request)
    {
        $data = $request->validated();
        $number_of_copies = count($data['price']);

        DB::beginTransaction();

        for ($i = 0; $i < $number_of_copies; $i++) {
            $new_copy = BookCopy::create([
                'book_id' => $data['book_id'],
                'price' => $data['price'][$i],
                'date_of_purchase' => $data['date_of_purchase'][$i],
                'publication_date' => $data['publication_date'][$i],
                'condition_id' => $data['condition_id'][$i],
                'edition' => $data['edition'][$i],
                'book_status_id' => $data['book_status_id'][$i]
            ]);

            if (!$new_copy) {
                DB::rollBack();
                alert()->error('An error has occured. Try again later.', 'Error')->autoclose(5000);
            } 
        }

        DB::commit();
        alert()->success('Book copies were successfully added.', 'Success')->autoclose(5000);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\BookCopy  $bookCopy
     * @return \Illuminate\Http\Response
     */
    public function show(BookCopy $bookCopy)
    {
        $breadcrumbs = [
            ['name' => 'Home', 'link' => '/'],
            ['name' => 'QR Scan', 'link' => '/qrcode/scan'],
            ['name' => 'Book details', 'link' => '/book-copies/'.$bookCopy->id],
        ];

        $book = $bookCopy->book;

        $conditions = BookCondition::all();
        return view('book-copies.show', compact(['book', 'conditions', 'breadcrumbs', 'bookCopy']));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\BookCopy  $bookCopy
     * @return \Illuminate\Http\Response
     */
    public function edit(BookCopy $bookCopy)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\BookCopy  $bookCopy
     * @return \Illuminate\Http\Response
     */
    public function update(BookCopyRequest $request, BookCopy $bookCopy)
    {
        $data = $request->validated();
        unset($data['id']);
        
        $update = $bookCopy->update($data);

        if ($update) {
            alert()->success('The data has been updated.', 'Success')->autoclose(5000);
        } else {
            alert()->error('An error has occured. Try again later.', 'Error')->autoclose(5000);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\BookCopy  $bookCopy
     * @return \Illuminate\Http\Response
     */
    public function destroy(BookCopy $bookCopy)
    {
        //
    }

    public function downloadQRCode(BookCopy $bookCopy)
    {
        $image = QrCode::generate(BookCopy::QR_BASE_URL.$bookCopy->id);

        $imageName = 'qr-code';
        $type = 'svg';

        Storage::put('public/qr-codes/'.$imageName, $image);

        return response()->download('storage/qr-codes/'.$imageName, $imageName.'.'.$type);
    }

    public function scanQRCode() 
    {
        $breadcrumbs = [
            ['name' => 'Home', 'link' => '/'],
            ['name' => 'QR Scan', 'link' => '/qrcode/scan']
        ];

        return view('qrcode-scan', compact('breadcrumbs'));
    }

    public function readBookQRCode(Request $request, $id) 
    {
        $bookCopy = BookCopy::with(['book', 'condition'])->where('id', $id)->first();

        if (!$bookCopy) {
            abort(403, 'Please scan a valid book QR.');
        }
        
        if (!$bookCopy->is_available) {
            abort(403, 'The book is not available for checking out.');
        } 
        
        $count_of_borrowed_books = BookLending::where('user_id', session('user_id'))->whereNull('return_date')->count();
            
        if ($count_of_borrowed_books == User::MAX_BOOKS) {
            abort(403, 'The user has reached the maximum number of books that can be checked out at the same time.');
        }

        if ($request->flag == true) {
            if ($request->session()->exists('book_copy_ids')) {
                // check that this book has not been already added to the session
                if (!in_array($id, session('book_copy_ids'))){
                    $request->session()->push('book_copy_ids', $id);
                } else {
                    abort(403, 'This book has already been added.');
                }
            } else {
                $request->session()->put('book_copy_ids', [$id]);
            }
        }
        return $bookCopy;
    }

    public function removeBookCopy(Request $request, $id) 
    {
        $index = array_search($id, session('book_copy_ids'));

        $request->session()->forget("book_copy_ids.$index");
        
        return redirect()->back();
    }

    public function download_all() 
    {
        $books = BookCopy::with(['book', 'condition'])->get();
        $chunked =  array_chunk($books->toArray(), 2, true);
        return view('download_all', compact(['chunked']));
    }

}
