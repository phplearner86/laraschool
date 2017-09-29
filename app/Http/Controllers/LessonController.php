<?php

namespace App\Http\Controllers;

use App\Http\Requests\LessonRequest;
use App\Lesson;
use App\Services\Utilities\Year;
use App\User;
use Illuminate\Http\Request;

class LessonController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(User $user)
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(User $user)
    {
        return view('lessons.create', compact('user'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(LessonRequest $request, User $user)
    {
        //Create lesson
        $lesson = Lesson::createNew($request);

        //Assign the lesson to the user
        $user->saveLesson($lesson);

        flash()->success('Lesson has been created');
        return back();
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Lesson  $lesson
     * @return \Illuminate\Http\Response
     */
    public function show(Lesson $lesson, User $user)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Lesson  $lesson
     * @return \Illuminate\Http\Response
     */
    public function edit(User $user, Lesson $lesson)
    {
        return view('lessons.edit', compact('lesson', 'user'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Lesson  $lesson
     * @return \Illuminate\Http\Response
     */
    public function update(LessonRequest $request, User $user, Lesson $lesson)
    {
        $lesson->saveChanges($request, $lesson);

        flash()->success('The lesson has been updated');
        return redirect()->route('lessons.edit', [$user, $lesson]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Lesson  $lesson
     * @return \Illuminate\Http\Response
     */
    public function destroy(Lesson $lesson, User $user)
    {
        //
    }
}
