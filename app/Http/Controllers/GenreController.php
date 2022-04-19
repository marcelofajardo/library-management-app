<?php

namespace App\Http\Controllers;

use App\Models\Genre;
use App\Http\Requests\GenreRequest;

class GenreController extends Controller
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
            ['name' => 'Genres', 'link' => '/genres'],
        ];

        $genres = Genre::paginate(Genre::PER_PAGE);
        return view('genres.index', compact(['genres', 'breadcrumbs']));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(GenreRequest $request)
    {
        $new_genre = Genre::create($request->validated());

        if ($new_genre) {
            alert()->success('New genre added', 'Success')->autoclose(5000);
        } else {
            alert()->error('An error has occurred. Try again later.', 'Error')->autoclose(5000);
        }

        $genres = Genre::paginate(Genre::PER_PAGE);
        return view('genres.index', compact('genres'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Genre  $genre
     * @return \Illuminate\Http\Response
     */
    public function edit(Genre $genre)
    {
        $breadcrumbs = [
            ['name' => 'Home', 'link' => '/'],
            ['name' => 'Genres', 'link' => '/genres'],
            ['name' => 'Update genre details', 'link' => '/genres/'.$genre->id.'/edit'],
        ];
        return view('genres.edit', compact(['genre', 'breadcrumbs']));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Genre  $genre
     * @return \Illuminate\Http\Response
     */
    public function update(GenreRequest $request, Genre $genre)
    {
        $update = $genre->update($request->validated());

        if ($update) {
            alert()->success('The genre has been updated', 'Success')->autoclose(5000);
        } else {
            alert()->error('An error has occurred. Try again later.', 'Error')->autoclose(5000);
        }

        $genres = Genre::paginate(Genre::PER_PAGE);
        return view('genres.index', compact('genres'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Genre  $genre
     * @return \Illuminate\Http\Response
     */
    public function destroy(Genre $genre)
    {
        //
    }
}
