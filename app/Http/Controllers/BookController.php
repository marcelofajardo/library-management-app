<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\Publisher;
use App\Models\Author;
use App\Http\Requests\BookRequest;
use App\Models\BookCondition;
use App\Models\BookStatus;

class BookController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $breadcrumbs = [
            ['name' => 'Home', 'link' => '/'],
            ['name' => 'Books', 'link' => '/books']
        ];

        $books = Book::withCount('book_copies')->paginate(Book::PER_PAGE);
        $currentPage = $books::resolveCurrentPage() - 1;
        return view('books.index', compact(['books', 'breadcrumbs', 'currentPage']));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $authors = Author::query()->orderBy('name', 'asc')->get();
        $publishers = Publisher::query()->orderBy('name', 'asc')->get();
        return view('books.create', compact(['authors', 'publishers']));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(BookRequest $request)
    {
        $book = Book::create($request->validated());
        $breadcrumbs = [
            ['name' => 'Home', 'link' => '/'],
            ['name' => 'Books', 'link' => '/books'],
            ['name' => 'Book details', 'link' => '/books/'.$book->id],
        ];

        if ($book) {
            alert()->success('The book has been added.', 'Success')->autoclose(5000);
        } else {
            alert()->error('An error has occurred. Try again later.', 'Error')->autoclose(5000);
        }

        $conditions = BookCondition::all();
        $copies = '';

        return redirect()->action(
            [BookController::class, 'show'], ['book' => $book, 'conditions' => $conditions, 'copies' => $copies, 'breadcrumbs' => $breadcrumbs]
        );

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Book  $book
     * @return \Illuminate\Http\Response
     */
    public function show(Book $book)
    {
        $breadcrumbs = [
            ['name' => 'Home', 'link' => '/'],
            ['name' => 'Books', 'link' => '/books'],
            ['name' => 'Book details', 'link' => '/books/'.$book->id],
        ];

        $book->load('book_copies')->loadCount('book_copies');

        $book_statuses = BookStatus::all();
        $conditions = BookCondition::all();

        return view('books.show', compact(['book', 'conditions', 'book_statuses', 'breadcrumbs']));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Book  $book
     * @return \Illuminate\Http\Response
     */
    public function edit(Book $book)
    {
        $authors = Author::query()->orderBy('name', 'asc')->get();
        $publishers = Publisher::query()->orderBy('name', 'asc')->get();

        $breadcrumbs = [
            ['name' => 'Home', 'link' => '/'],
            ['name' => 'Books', 'link' => '/books'],
            ['name' => 'Update book details', 'link' => '/books/'.$book->id.'/edit'],
        ];

        return view('books.edit', compact(['book', 'breadcrumbs', 'authors', 'publishers']));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Book  $book
     * @return \Illuminate\Http\Response
     */
    public function update(BookRequest $request, Book $book)
    {
        $update = $book->update($request->validated());

        if ($update) {
            alert()->success('The book has been updated.', 'Success')->autoclose(5000);
        } else {
            alert()->error('An error has occurred. Try again later.', 'Error')->autoclose(5000);
        }

        return redirect()->route('books.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Book  $book
     * @return \Illuminate\Http\Response
     */
    public function destroy(Book $book)
    {
        if ($book->book_copies()->count()) {
            alert()->error('Please delete book copies first.', 'Error')->autoclose(5000);
        } else {
            $book->delete();
            alert()->success('The book has been deleted.', 'Success')->autoclose(5000);
        }

        return back();
    }
}
