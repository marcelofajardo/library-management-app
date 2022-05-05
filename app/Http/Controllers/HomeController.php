<?php

namespace App\Http\Controllers;

use App\Models\BookLending;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class HomeController extends Controller
{
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index(Request $request)
    {
        $bookLendings = BookLending::when($request->filled('search'), function ($query) use ($request) {
                                          $query->whereHas('book_copy', function ($query) use ($request) {
                                              $query->whereHas('book', function ($query) use ($request) {
                                                  $query->where('title', 'LIKE', "%{$request->search}%")
                                                      ->orWhere(function ($query) use ($request) {
                                                          $query->whereHas('author', function ($query) use ($request) {
                                                              $query->where('name', 'LIKE', "%{$request->search}%");
                                                          })
                                                          ->orWhere('isbn', 'LIKE', "%{$request->search}%");
                                                  });
                                              });
                                          })
                                          ->orWhereHas('user', function ($query) use ($request) {
                                                  $query->where('name', 'LIKE', "%{$request->search}%");
                                          });
                                        })
                                        ->with(['book_copy', 'book_copy.book', 'user'])
                                        ->paginate(BookLending::PER_PAGE)->withQueryString();

        $recordsOnPage = ($bookLendings::resolveCurrentPage() - 1) * BookLending::PER_PAGE;
        return view('home', compact(['bookLendings', 'recordsOnPage']));
    }
}
