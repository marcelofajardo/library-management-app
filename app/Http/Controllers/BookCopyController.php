<?php

namespace App\Http\Controllers;

use App\Models\BookCopy;
use App\Http\Requests\BookCopyRequest;
use App\Models\BookCondition;
use Illuminate\Support\Facades\Storage;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

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

        for ($i = 0; $i < $number_of_copies; $i++) {
            
            BookCopy::create([
                'book_id' => $data['book_id'],
                'price' => $data['price'][$i],
                'date_of_purchase' => $data['date_of_purchase'][$i],
                'publication_date' => $data['publication_date'][$i],
                'condition_id' => $data['condition_id'][$i],
                'edition' => $data['edition'][$i],
            ]);
            
            // $new_copy->update(['qr_code' => '/read-qr-info/1']);
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
        //
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
        
        $bookCopy->update($data);
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

    public function readQRCode(BookCopy $bookCopy) 
    {
        $book = $bookCopy->book;

        $breadcrumbs = [
            ['name' => 'Home', 'link' => '/home'],
            ['name' => 'Books', 'link' => '/books'],
            ['name' => 'Book details', 'link' => '/books/'.$book],
        ];

        $conditions = BookCondition::all();
        return redirect()->route('books.show', ['book' => $book, 'breadcrumbs' => $breadcrumbs, 'conditions' => $conditions]);
    } 
}
