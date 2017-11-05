@extends('layouts.app')

@section('title', 'New Lesson')

@section('content')

    @include('flash::message')
    @include('errors._list')
    
    <h1 class="page-header"><i class="fa fa-plus"></i> New lesson</h1>

    <form action="{{ route('lessons.store', $user) }}" method="POST">
        {{ csrf_field() }}

        @include('lessons.partials._lessonForm', [
            'subject_id' => old('subject_id'),
            'year' => old('year'),
            'title' => old('title'),
            'topic' => old('topic'),
            'goals' => old('goals'),
            'button' => 'Create lesson'
        ])
        
    </form>
        
@endsection

@section('scripts')
    
    <script>


    $('#subject_id').on('change', function(e){

        var subjectId = e.target.value;
        var url = '../../subjects/{{ $user->name }}/' + subjectId;

        $.ajax({
            url: url,
            type: 'GET',
            success:function(response)
            {
                console.log(response);
                $('#year').html(response);
            }
        })
    })
    </script>

@endsection
 