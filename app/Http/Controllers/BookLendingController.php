<?php

namespace App\Http\Controllers;

use App\Models\BookLending;
use Illuminate\Http\Request;

class BookLendingController extends Controller
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
        return view('book-lendings.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\BookLending  $bookLending
     * @return \Illuminate\Http\Response
     */
    public function show(BookLending $bookLending)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\BookLending  $bookLending
     * @return \Illuminate\Http\Response
     */
    public function edit(BookLending $bookLending)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\BookLending  $bookLending
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, BookLending $bookLending)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\BookLending  $bookLending
     * @return \Illuminate\Http\Response
     */
    public function destroy(BookLending $bookLending)
    {
        //
    }
}
