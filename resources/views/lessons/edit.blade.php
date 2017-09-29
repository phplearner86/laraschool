@extends('layouts.app')

@section('title', 'Edit Lesson')

@section('content')

    @include('flash::message')
    @include('errors._list')

    <h1 class="page-header"><i class="fa fa-penci-square-o"></i> Edit lesson</h1>

    <form action="{{ route('lessons.update', [$user, $lesson]) }}" method="POST">
        {{ csrf_field() }}
        {{ method_field('PUT') }}

        @include('lessons.partials._lessonForm', [
            'subject_id' => $lesson->subject_id,
            'year' => $lesson->year,
            'title' => $lesson->title,
            'topic' => $lesson->topic,
            'goals' => $lesson->goals,
            'button' => 'Save changes'
        ])
        
    </form>
        
@endsection
 