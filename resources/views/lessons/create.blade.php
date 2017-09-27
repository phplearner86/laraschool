@extends('layouts.app')

@section('title', 'New Lesson')

@section('content')
 @include('flash::message')

    <form action="{{ route('lessons.store', $user) }}" method="POST">
        {{ csrf_field() }}

        <div class="row">

            <div class="col-md-8">
                <div class="form-group">
                    <label for="subject_id">Subject</label>
                    <select name="subject_id" id="subject_id" class="form-control">
                        <option selected disabled="">Select Subject</option>
                        @foreach ($user->teacher->subjects->unique() as $subject)
                            <option value="{{ $subject->id }}"> 
                                {{ ucfirst($subject->name) }}
                            </option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="col-md-4">
                <div class="form-group">
                    <label for="year">Academic Year</label>
                    <select name="year" id="year" class="form-control">
                        <option selected disabled="">Select Year</option>
                        @foreach (Year::all() as $label=>$year)
                            <option value="{{ $label }}"> 
                                {{ $label }}
                            </option>
                        @endforeach
                    </select>
                </div>
            </div>

        </div>
        <div class="form-group">
            <label for="title">Title</label>
            <input type="text" class="form-control" name="title" placeholder="Enter lesson title" value="{{ old('title') }}">
        </div>

        <div class="form-group">
            <button class="btn btn-success">Create lesson</button>
        </div>
        
    </form>
        
@endsection
 