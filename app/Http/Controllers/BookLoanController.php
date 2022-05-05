<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\BookLoanRequest;
use App\Models\BookLoan;
use App\Models\BookCondition;
use App\Models\BookCopy;
use App\Models\BookStatus;
use App\Models\User;
use App\Notifications\CheckedOutBookNotification;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Notification;


class BookLoanController extends Controller
{
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $breadcrumbs = [
            ['name' => 'Home', 'link' => '/'],
            ['name' => 'Issue books', 'link' => '/book-loans/create'],
        ];

        return view('book-loans.create', compact(['breadcrumbs']));
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\BookLoan  $bookLoan
     * @return \Illuminate\Http\Response
     */
    public function show(BookLoan $bookLoan)
    {
        $breadcrumbs = [
            ['name' => 'Home', 'link' => '/'],
            ['name' => 'Book lending details', 'link' => '/book-loans/'.$bookLoan->id],
        ];

        $deadline = $bookLoan->deadline->startOfDay();
        $today = now()->startOfDay();

        $latenessFine = 0;

        if ($deadline->isPast()) {
            $latenessFine = $today->diffInDays($deadline) * BookLoan::DAILY_LATENESS_FINE;
        }

        $lendingPeriod = BookLoan::LENDING_TIME;
        $bookConditions = BookCondition::all();

        return view('book-loans.show', compact(['bookLoan', 'breadcrumbs', 'lendingPeriod', 'bookConditions', 'latenessFine']));
    }

    // used for returning a book
    public function update(BookLoanRequest $request, BookLoan $book_loan)
    {
        $validated = $request->validated();

        $lateness_fine = 0;

        if (isset($validated['lateness_fine'])) {
            $lateness_fine = $validated['lateness_fine'];
        }

        DB::beginTransaction();

        $update1 = $book_loan->update([
            'return_date'  => now(),
            'damage_desc' => $validated['damage_desc'],
            'condition_fine' => $validated['condition_fine'],
            'lateness_fine' => $lateness_fine
        ]);

        $update2 = $book_loan->book_copy->update([
            'condition_id' => $validated['condition_id'],
            'book_status_id' => BookStatus::AVAILABLE
        ]);

        if (!$update1 || !$update2) {
            DB::rollBack();
            alert()->error('An error has occurred. Try again later.', 'Error')->autoclose(5000);
        } else {
            DB::commit();
            alert()->success('The book has been returned.', 'Success')->autoclose(5000);
        }
    }

    public function create_one(Request $request)
    {
        $user = '';

        if ($request->session()->has('user_id')) {
            $user = User::find(session('user_id'));
        }

        return view('book-loans.create_step1', compact('user'));
    }

    public function post_one(Request $request)
    {
        $user = User::find($request->user_id);

        if (!$user) {
            abort(422, 'Please scan a valid user card.');
        }

        $count = BookLoan::where('user_id', $user->id)->whereNull('return_date')->count();

        if ($count >= User::MAX_BOOKS) {
            abort(422, 'Error. The user has already checked out the maximum number of books.');
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

        return view('book-loans.create_step2', compact('book_copies'));
    }

    public function post_two(Request $request)
    {
        $loans = [];

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
            //should add an alert
        }

        $count_of_borrowed_books = BookLoan::where('user_id', session('user_id'))->whereNull('return_date')->count();

        if ($count_of_borrowed_books + count($book_copy_ids) > User::MAX_BOOKS) {
            abort(403, 'No more than '.User::MAX_BOOKS.' books can be checked out at the same time. The user has already borrowed '.$count_of_borrowed_books.'.');
        }

        DB::beginTransaction();

        foreach($book_copy_ids as $book_copy_id) {

            $count = BookLoan::where('book_copy_id', $book_copy_id)->whereNull('return_date')->count();

            if ($count > 0) {
                abort(418, "The selected book has already been checked out.".$book_copy_id);
            }

            $deadline = Carbon::now()->addWeeks(BookLoan::LENDING_TIME);

            $newLoan = BookLoan::create([
                'book_copy_id' => $book_copy_id,
                'user_id' => $user_id,
                'deadline' => $deadline
            ]);

            $loanInfo = BookLoan::where('id', '=', $newLoan->id)->with(['book_copy.book', 'user', 'book_copy'])->first();

            $loans[] = $loanInfo;

            $update = $newLoan->book_copy->update(['book_status_id' => BookStatus::CHECKED_OUT]);

            if (!$newLoan || !$update) {
                DB::rollBack();
                alert()->error('An error has occurred. Try again later.', 'Error')->autoclose(5000);
                return redirect()->back();
            }
        }

        DB::commit();
        alert()->success('The transaction has been saved.', 'Success')->autoclose(5000);

        $user = User::find($user_id);
//        Notification::send($user, new CheckedOutBookNotification($loans));

        $request->session()->forget(['book_copy_ids', 'user_id']);
    }

    public function return()
    {
        return view('book-loans.return');
    }

    public function redirect(Request $request)
    {
        $book_copy = BookCopy::find($request->borrowed_book_id);

        if ($book_copy) {
            $loan = BookLoan::where('book_copy_id', $book_copy->id)->whereNull('return_date')->first();
            if (!$loan) {
                abort(422, 'This book is not currently checked out.');
            } else {
                $breadcrumbs = [
                    ['name' => 'Home', 'link' => '/'],
                    ['name' => 'Book loan details', 'link' => '/book-loans/'.$loan->id],
                ];

                $lendingPeriod = BookLoan::LENDING_TIME;
                return ['loanId' => $loan->id, 'breadcrumbs' => $breadcrumbs, 'lendingPeriod' => $lendingPeriod];
            }
        } else {
            abort(422, 'Please scan a valid QR code');
        }
    }

    public function extendDeadline(BookLoan $bookLoan)
    {
        if ($bookLoan->return_date == null) {
            $new_deadline = $bookLoan->deadline->addWeeks(BookLoan::LENDING_TIME);

            // allow a max of two deadline extensions
            if ($new_deadline->diffInDays($bookLoan->created_at) > 3 * BookLoan::LENDING_TIME * 7) {
                alert()->error('Return date cannot be extended more than twice.', 'Could not update')->autoclose(5000);
            } else {
                $update = $bookLoan->update(['deadline' => $new_deadline]);
                if (!$update) {
                    alert()->error('There has been an error. Try again later.', 'Error')->autoclose(5000);
                } else {
                    alert()->success('Return date updated.', 'Success')->autoclose(5000);
                }
            }
        } else {
            alert()->error('You cannot extend the deadline for a book that has already been returned.', 'Could not update')->autoclose(5000);
        }

        return redirect()->back();
    }
}
