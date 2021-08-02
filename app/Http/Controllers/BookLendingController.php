<?php

namespace App\Http\Controllers;

use App\Models\BookLending;
use Illuminate\Http\Request;
use App\Http\Requests\BookLendingRequest;
use App\Models\BookCopy;
use App\Models\BookStatus;

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
        $breadcrumbs = [
            ['name' => 'Home', 'link' => '/home'],
            ['name' => 'Issue books', 'link' => '/book-lendings/create'],
        ];

        return view('book-lendings.create', compact(['breadcrumbs']));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(BookLendingRequest $request)
    {
        $count = BookLending::where('book_copy_id', $request->book_copy_id)->where('return_date', NULL)->count();

        if ($count != 0) {
            return 'Error. The book has already been checked out.';
        } else {
            $new_lending = BookLending::create($request->validated());
            $updated_book_status = BookCopy::find($request->book_copy_id)->update(['book_status_id' => BookStatus::UNAVAILABLE]);

            if ($new_lending && $updated_book_status) {
                return 'successfully issued';
            } else {
                return 'error with processing';
            }
        }
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
