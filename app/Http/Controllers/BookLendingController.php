<?php

namespace App\Http\Controllers;

use App\Models\BookLending;
use Illuminate\Http\Request;
use App\Http\Requests\BookLendingRequest;
use App\Models\BookCopy;
use App\Models\BookStatus;
use App\Models\User;
use Carbon\Carbon;


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
        // $breadcrumbs = [
        //     ['name' => 'Home', 'link' => '/home'],
        //     ['name' => 'Book lending details', 'link' => '/book-lendings/'.$bookLending->id],
        // ];

        return view('book-lendings.show', compact(['bookLending']));
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
        // $request->session()->forget(['book_copy_ids', 'user_id']);

        if ($request->session()->has('user_id')) {
        $user_id = session('user_id')['user_id'];
        } else {
            return 'Please select a user';
            //should add an alert and maybe redirect to step 1 
        }
        
        // $book_copy_ids = $request->validate([
        //     'book_copy_ids' => 'required|array',
        //     'book_copy_ids.*' => 'required|exists:book_copies,id'
        // ]);

        if ($request->session()->has('book_copy_ids')) {
            $book_copy_ids = session('book_copy_ids');
            // return $book_copy_ids;
        } else {
            return 'Please select at least one book';
            //should add an alert and maybe redirect to step 1 
        }
        // return $book_copy_ids['book_copy_ids'][0];

        // dd($user_id, $book_copy_ids);

        // dd($book_copy_ids['book_copy_ids']);
        
        // foreach($book_copy_ids['book_copy_ids'] as $book_copy_id) {
            // dd($book_copy_id);
            // $count = BookLending::where('book_copy_id', $book_copy_id)->where('return_date', NULL)->count();
            
            // if ($count > 0) {
                //     return 'The book has already been checked out.';
                // }
                
                // $count_of_borrowed_books = BookLending::where('user_id', $user_id)->where('return_date', NULL)->count();
                
                // if ($count_of_borrowed_books < User::MAX_BOOKS) {
                    // $user_id = 2;
                    // $book_copy_ids = [15, 16];

                    $deadline = Carbon::now()->addWeeks(BookLending::LENDING_TIME);
                    $count = count($book_copy_ids);
                    for ($i = 0; $i < $count; $i++) {
                        $lending = BookLending::create([
                        'book_copy_id' => $book_copy_ids[$i],
                        'user_id' => $user_id,
                        'deadline' => $deadline
                        ]);
                        $book_copy = BookCopy::where('id', $book_copy_ids[$i])->first();
                        $update = $book_copy->update(['book_status_id' => BookStatus::UNAVAILABLE]);  
                    }
                // } else {
                    //     return 'The user has checked out a maximum number of books already.';
                    // }
                    // } 
                    $request->session()->forget(['book_copy_ids', 'user_id']);

                    return 'success';
                    // return redirect()->route('home');
    }

    public function return() 
    {
        return view('book-lendings.return');
    }

    public function redirect(Request $request)
    {

        $book_copy = BookCopy::where('id', $request->borrowed_book_id)->first();
        if ($book_copy) {
            $lending = BookLending::where('book_copy_id', $book_copy->id)->whereNull('return_date')->firstOrFail();
            if (!$lending) {
                return 'This book is not currently checked out.';
            } else {
                return ['lending_id' => $lending->id];
            }
        } else {
            return 'Please scan a valid QR code';
        }
    }
}         