<?php

namespace App\Http\Controllers;

use App\Models\BookLending;
use Illuminate\Http\Request;
use App\Http\Requests\BookLendingRequest;
use App\Models\BookCondition;
use App\Models\BookCopy;
use App\Models\BookStatus;
use App\Models\User;
use Carbon\Carbon;
use DateTime;

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
            ['name' => 'Home', 'link' => '/'],
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
        // dd($bookLending);
        $breadcrumbs = [
            ['name' => 'Home', 'link' => '/'],
            ['name' => 'Book lending details', 'link' => '/book-lendings/'.$bookLending->id],
        ];

        $deadline = $bookLending->deadline->startOfDay();
        $today = now()->startOfDay();

        $lateness_fine = 0.00;

        if ($deadline->isPast()) {
            $lateness_fine = $today->diffInDays($deadline) * BookLending::DAILY_LATENESS_FINE;
        }
        
        $lendingPeriod = BookLending::LENDING_TIME;
        $bookConditions = BookCondition::all();

        return view('book-lendings.show', compact(['bookLending', 'breadcrumbs', 'lendingPeriod', 'bookConditions', 'lateness_fine']));
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
    public function update(BookLendingRequest $request, BookLending $bookLending)
    {
        // dd($request);
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
            $user = User::find(session('user_id'));
        }

        return view('book-lendings.create_step1', compact('user'));
    }

    public function post_one(Request $request) 
    {
        $user = User::find($request->user_id);

        if (!$user) {
            abort(422, 'Please scan a valid user card.');
        }

        $count = BookLending::where('user_id', $user->id)->whereNull('return_date')->count();

        if ($count >= User::MAX_BOOKS) {
            abort(422, 'Error. The user has already checked out a maximum number of books.');
        } else {
            $request->session()->put('user_id', $user->id);
        }
    }

    public function create_two(Request $request) 
    {
        $book_copies = '';

        if ($request->session()->has('book_copy_ids')) {
            $book_copies = BookCopy::with('book')->whereIn('id', session('book_copy_ids'))->get();
        }

        return view('book-lendings.create_step2', compact('book_copies'));
    }
    
    public function post_two(Request $request)
    {
        // $request->session()->forget(['book_copy_ids', 'user_id']);

        if ($request->session()->has('user_id')) {
            $user_id = session('user_id');
        } else {
            abort(422, 'Please scan a valid user card.');
            //should add an alert and maybe redirect to step 1 
        }

        if ($request->session()->has('book_copy_ids') && session('book_copy_ids') != []) {
            $book_copy_ids = session('book_copy_ids');
        } else {
            abort(422, 'Please add at least one book.');
            //should add an alert and maybe redirect to step 1 
        }

        $count_of_borrowed_books = BookLending::where('user_id', session('user_id'))->whereNull('return_date')->count();

        if ($count_of_borrowed_books + count($book_copy_ids) > User::MAX_BOOKS) {
            abort(403, 'No more than '.User::MAX_BOOKS.' books can be checked out at the same time. The user has already borrowed '.$count_of_borrowed_books.'.');
        }

        foreach($book_copy_ids as $book_copy_id) {

            $count = BookLending::where('book_copy_id', $book_copy_id)->whereNull('return_date')->count();
            
            if ($count > 0) {
                abort(418, "The selected book has already been checked out.".$book_copy_id);
            }
                
            $deadline = Carbon::now()->addWeeks(BookLending::LENDING_TIME);
                
            $lending = BookLending::create([
                'book_copy_id' => $book_copy_id,
                'user_id' => $user_id,
                'deadline' => $deadline
            ]);

            $book_copy = BookCopy::find($book_copy_id);
            $update = $book_copy->update(['book_status_id' => BookStatus::UNAVAILABLE]);  
        }

        $request->session()->forget(['book_copy_ids', 'user_id']);
        return 'success';
    }

    public function return() 
    {
        return view('book-lendings.return');
    }

    public function redirect(Request $request)
    {
        $book_copy = BookCopy::find($request->borrowed_book_id);

        if ($book_copy) {
            $lending = BookLending::where('book_copy_id', $book_copy->id)->whereNull('return_date')->first();
            if (!$lending) {
                abort(422, 'This book is not currently checked out.');
            } else {
                $breadcrumbs = [
                    ['name' => 'Home', 'link' => '/'],
                    ['name' => 'Book lending details', 'link' => '/book-lendings/'.$lending->id],
                ];

                $lending_period = BookLending::LENDING_TIME;
                return ['lending_id' => $lending->id, 'breadcrumbs' => $breadcrumbs, 'lending_period' => $lending_period];
            }
        } else {
            abort(422, 'Please scan a valid QR code');
        }
    }

    public function extendDeadline(BookLending $bookLending)
    {
        if ($bookLending->return_date == null) {
            $new_deadline = $bookLending->deadline->addWeeks(BookLending::LENDING_TIME);
            
            // allow a max of two deadline extensions
            if ($new_deadline->diffInDays($bookLending->created_at) > 3 * BookLending::LENDING_TIME * 7) {
                alert()->error('Return date cannot be extended more than twice.', 'Could not update')->autoclose(5000);
            } else {
                $bookLending->update(['deadline' => $new_deadline]);
            }
        } else {
            alert()->error('You cannot extend the deadline for a book that has already been returned.', 'Could not update')->autoclose(5000);
        }

        return redirect()->back();
    }

    public function returnBook(BookLending $bookLending) 
    {
        if ($bookLending->return_date == null) {
            $bookLending->update(['return_date' => now()]);
            alert()->success('The book has been returned.', 'Success');
        } else {
            alert()->error('The book has already been returned.', 'Could not update')->autoclose(5000);
        }
        return redirect()->back();

        // dd($bookLending);
    }
}    
