<?php

namespace App\Http\Controllers;

use App\Models\Publisher;
use Illuminate\Http\Request;
use App\Http\Requests\PublisherRequest;

class PublisherController extends Controller
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
            ['name' => 'Publishers', 'link' => '/publishers'],
        ];

        $publishers = Publisher::paginate(Publisher::PER_PAGE);
        return view('publishers.index', compact('publishers', 'breadcrumbs'));
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
    public function store(PublisherRequest $request)
    {
        $new_publisher = Publisher::create($request->validated());

        if ($new_publisher) {
            alert()->success('New publisher added', 'Success')->autoclose(5000);
        } else {
            alert()->error('An error has occurred. Try again later.', 'Error')->autoclose(5000);
        }

        $publishers = Publisher::paginate(Publisher::PER_PAGE);
        return view('publishers.index', compact('publishers'));
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Publisher  $publisher
     * @return \Illuminate\Http\Response
     */
    public function show(Publisher $publisher)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Publisher  $publisher
     * @return \Illuminate\Http\Response
     */
    public function edit(Publisher $publisher)
    {
        $breadcrumbs = [
            ['name' => 'Home', 'link' => '/'],
            ['name' => 'Publishers', 'link' => '/publishers'],
            ['name' => 'Update publisher details', 'link' => '/publishers/'.$publisher->id.'/edit'],
        ];
        return view('publishers.edit', compact('publisher', 'breadcrumbs'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Publisher  $publisher
     * @return \Illuminate\Http\Response
     */
    public function update(PublisherRequest $request, Publisher $publisher)
    {
        $update = $publisher->update($request->validated());

        if ($update) {
            alert()->success('The publisher has been updated', 'Success')->autoclose(5000);
        } else {
            alert()->error('An error has occurred. Try again later.', 'Error')->autoclose(5000);
        }

        $publishers = Publisher::paginate(Publisher::PER_PAGE);
        return view('publishers.index', compact('publishers'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Publisher  $publisher
     * @return \Illuminate\Http\Response
     */
    public function destroy(Publisher $publisher)
    {
        if ($publisher->books->count()) {
            alert()->error('Please first delete books associated with this publisher.')->autoclose(5000);
        } else {
            $publisher->delete();
            alert()->success('Publisher successfully deleted.', 'Success')->autoclose(5000);
        }

        return back();
    }
}
