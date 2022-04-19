<?php

namespace App\Http\Controllers;

use App\Models\Subject;
use Illuminate\Http\Request;
use App\Http\Requests\SubjectRequest;

class SubjectController extends Controller
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
            ['name' => 'Subjects', 'link' => '/subjects'],
        ];

        $subjects = Subject::paginate(Subject::PER_PAGE);
        return view('subjects.index', compact('subjects', 'breadcrumbs'));
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
    public function store(SubjectRequest $request)
    {
        $new_subject = Subject::create($request->validated());

        if ($new_subject) {
            alert()->success('The subject has been added', 'Success')->autoclose(5000);
        } else {
            alert()->error('An error has occurred. Try again later.', 'Error')->autoclose(5000);
        }

        $subjects = Subject::paginate(Subject::PER_PAGE);
        return view('subjects.index', compact('subjects'));
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Subject  $subject
     * @return \Illuminate\Http\Response
     */
    public function show(Subject $subject)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Subject  $subject
     * @return \Illuminate\Http\Response
     */
    public function edit(Subject $subject)
    {
        $breadcrumbs = [
            ['name' => 'Home', 'link' => '/'],
            ['name' => 'Subjects', 'link' => '/subjects'],
            ['name' => 'Update subject details', 'link' => '/subjects/'.$subject->id.'/edit'],
        ];
        return view('subjects.edit', compact(['subject', 'breadcrumbs']));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Subject  $subject
     * @return \Illuminate\Http\Response
     */
    public function update(SubjectRequest $request, Subject $subject)
    {
        $update = $subject->update($request->validated());

        if ($update) {
            alert()->success('The subject has been updated', 'Success')->autoclose(5000);
        } else {
            alert()->error('An error has occurred. Try again later.', 'Error')->autoclose(5000);
        }

        $subjects = Subject::paginate(Subject::PER_PAGE);
        return view('subjects.index', compact('subjects'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Subject  $subject
     * @return \Illuminate\Http\Response
     */
    public function destroy(Subject $subject)
    {
        //
    }
}
