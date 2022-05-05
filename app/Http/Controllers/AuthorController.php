<?php

namespace App\Http\Controllers;

use App\Models\Author;
use Illuminate\Http\Request;
use App\Http\Requests\AuthorRequest;
use Illuminate\Support\Facades\Auth;

class AuthorController extends Controller
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
            ['name' => 'Authors', 'link' => '/authors']
        ];

        $authors = Author::paginate(Author::PER_PAGE);
        return view('authors.index', compact('authors', 'breadcrumbs'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(AuthorRequest $request)
    {
        $name = join(" ", [$request->first_name, $request->last_name]);
        $new_author = Author::create(['name' => $name]);

        $authors = Author::paginate(Author::PER_PAGE);

        if ($new_author) {
            alert()->success('New author added', 'Success')->autoclose(5000);
        } else {
            alert()->error('An error has occurred. Try again later.', 'Error')->autoclose(5000);
        }

        return view('authors.index', compact('authors'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Author  $author
     * @return \Illuminate\Http\Response
     */
    public function edit(Author $author)
    {
        $breadcrumbs = [
            ['name' => 'Home', 'link' => '/'],
            ['name' => 'Authors', 'link' => '/authors'],
            ['name' => 'Update author details', 'link' => '/authors/'.$author->id.'/edit'],
        ];

        return view('authors.edit', compact(['author', 'breadcrumbs']));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Author  $author
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Author $author)
    {
        $update = $author->update(['name' => $request->name]);

        if ($update) {
            alert()->success('Information updated.', 'Success')->autoclose(5000);
        } else {
            alert()->error('An error has occurred. Try again later.', 'Error')->autoclose(5000);
        }

        $authors = Author::paginate(Author::PER_PAGE);
        return view('authors.index', compact('authors'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Author  $author
     * @return \Illuminate\Http\Response
     */
    public function destroy(Author $author)
    {
        if ($author->books()->count()) {
            alert()->error('Please first delete books associated with this author.')->autoclose(5000);
        } else {
            $author->delete();
            alert()->success('Author successfully deleted.', 'Success')->autoclose(5000);
        }

        return redirect()->route('authors.index');
    }
}
