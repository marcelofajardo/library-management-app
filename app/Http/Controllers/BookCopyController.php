<?php

namespace App\Http\Controllers;

use App\Models\BookCopy;
use App\Http\Requests\BookCopyRequest;
use App\Models\BookCondition;
use Illuminate\Support\Facades\Storage;
use SimpleSoftwareIO\QrCode\Facades\QrCode;
use Illuminate\Http\Request;
use App\Models\BookLoan;
use App\Models\User;
use App\Models\Book;
use Illuminate\Support\Facades\DB;
use PDF;

class BookCopyController extends Controller
{
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(BookCopyRequest $request)
    {
        $new_copy = BookCopy::create($request->validated());

        if (!$new_copy) {
            alert()->error('An error has occurred. Try again later.', 'Error')->autoclose(5000);
        } else {
            alert()->success('A book copy was successfully added.', 'Success')->autoclose(5000);
        }

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
            alert()->error('An error has occurred. Try again later.', 'Error')->autoclose(5000);
        }
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

        $count_of_borrowed_books = BookLoan::where('user_id', session('user_id'))->whereNull('return_date')->count();

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

    public function downloadAll()
    {
        $books = BookCopy::with(['book', 'condition'])->get();
        $chunked =  array_chunk($books->toArray(), 2, true);
        return view('download.download_all', compact(['chunked']));
    }

    public function booksPdf(Request $request)
    {
        // get the book ids selected or all if none selected
        if ($request['book_ids'] == null) {
            $book_ids = Book::pluck('id');
        } else {
            $book_ids = $request['book_ids'];
        }

        $books = BookCopy::with(['condition', 'book'])
                            ->whereHas('book', function($query) use ($book_ids) {
                                $query->whereIn('id', $book_ids);
                            })->get();

        // to better display on a page
        $chunked =  array_chunk($books->toArray(), 2, true);

        $pdf = PDF::loadView('download.download_books', compact(['chunked']))->setOptions(['defaultFont' => 'sans-serif']);
        return $pdf->download('qrcodes.pdf');
    }

    public function usersPdf(Request $request)
    {
        // get the user ids selected or all if none selected
        if ($request['user_ids'] == null) {
            $user_ids = User::pluck('id');
        } else {
            $user_ids = $request['user_ids'];
        }

        $users = User::whereIn('id', $user_ids)->get();

        // to better display on a page
        $chunked =  array_chunk($users->toArray(), 2, true);

        $pdf = PDF::loadView('download.download_users', compact(['chunked']))->setOptions(['defaultFont' => 'sans-serif']);
        return $pdf->download('qrcodes.pdf');
    }

    public function downloadOptions()
    {
        $books = Book::all();
        $users = User::all();

        return view('download.download_options', compact('books', 'users'));
    }

    public function destroy(BookCopy $bookCopy)
    {
        if ($bookCopy->loans->count()) {
            alert()->error('Please first delete loans still connected to this book.')->autoclose(5000);
        } else {
            $bookCopy->delete();
            alert()->success('A book copy was successfully deleted.', 'Success')->autoclose(5000);
        }

        return back();
    }
}
