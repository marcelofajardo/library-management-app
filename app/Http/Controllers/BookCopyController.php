<?php

namespace App\Http\Controllers;

use App\Models\BookCopy;
use Illuminate\Http\Request;
use App\Http\Requests\BookCopyRequest;

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
        foreach($request['price'] as $key => $num) {
            BookCopy::create([
            'book_id' => $request['book_id'],
            'price' => $num,
            'date_of_purchase' => $request['date_of_purchase'][$key],
            'publication_date' => $request['publication_date'][$key],
            'condition_id' => $request['condition_id'][$key],
            'edition' => $request['edition'][$key],
            ]);
        };
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
}
