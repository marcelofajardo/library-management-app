<?php

namespace App\Http\Controllers;

use App\Http\Requests\BookCopyRequest;
use App\Models\BookLending;
use Illuminate\Http\Request;
use App\Http\Requests\BookLendingRequest;
use App\Models\BookCopy;
use App\Models\BookStatus;
use App\Models\User;

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

    public function create_one(Request $request) 
    {
        $user = '';

        if ($request->session()->has('user_id')) {
            $user = User::find(session('user_id'))->first();
        }

        return view('book-lendings.create_step1', compact('user'));
    }

    public function post_one(Request $request) 
    {

        $user_id = $request->validate([
            'user_id' => ['required', 'exists:users,id']
        ]);

        $count = BookLending::where('user_id', $user_id)->where('return_date', NULL)->count();

        if ($count >= User::MAX_BOOKS) {
           return 'Error. The user has already checked out a maximum number of books.';
        } else {
            $request->session()->put('user_id', $user_id);
        }
        return redirect()->route('book-lendings-create-step2');
    }

    public function create_two(Request $request) 
    {
        $book_copies = '';

        if ($request->session()->has('book_copy_ids')) {
            $book_copies = BookCopy::with('book')->whereIn('id', session('book_copy_ids'))->get();
        }

        // dd($book_copies);
        return view('book-lendings.create_step2', compact('book_copies'));
    }

    public function post_two(Request $request)
    {
        // dd($request);

        if ($request->session()->has('user_id')) {
            $user_id = session('user_id');
        } else {
            return 'Please select a user';
            // should add an alert and maybe redirect to step 1 
        }

        $book_copy_ids = $request->validate([
            'book_copy_ids' => 'required|array',
            'book_copy_ids.*' => 'required|exists:book_copies,id'
        ]);

        foreach($book_copy_ids['book_copy_ids'] as $book_copy_id) {
            $count = BookLending::where('book_copy_id', $book_copy_id)->where('return_date', NULL)->count();

            if ($count > 0) {
                return 'The book has already been checked out.';
            }

            $count_of_borrowed_books = BookLending::where('user_id', $user_id)->where('return_date', NULL)->count();
        
            if ($count_of_borrowed_books < User::MAX_BOOKS) {
                $new_lending = BookLending::create([
                    'book_copy_id' => $book_copy_id,
                    'user_id' => $user_id['user_id'],
                ]);
    
                $updated_book_status = BookCopy::find($book_copy_id)->update(['book_status_id' => BookStatus::UNAVAILABLE]);
            } else {
                return 'The user has checked out a maximum number of books already.';
            }
    
        } 
        
        $request->session()->forget(['book_copy_ids', 'user_id']);
        return redirect()->route('home');
    }
}
