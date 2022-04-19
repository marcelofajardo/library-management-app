<?php

namespace App\Http\Controllers;

use App\Models\BookLending;
use Illuminate\Support\Facades\DB;

class HomeController extends Controller
{
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $bookLendings = BookLending::with(['book_copy', 'book_copy.book', 'user'])->paginate(BookLending::PER_PAGE);

        $recordsOnPage = ($bookLendings::resolveCurrentPage() - 1) * BookLending::PER_PAGE;
        return view('home', compact(['bookLendings', 'recordsOnPage']));
    }
}
