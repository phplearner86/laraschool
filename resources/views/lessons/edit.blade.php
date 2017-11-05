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
 

 @section('scripts')
    
    <script>

        var subjectId = $('#subject_id').val();
        var url = '../../../subjects/{{ $user->name }}/' + subjectId + '/' + '{{ $lesson->slug }}';

        $.ajax({
            url: url,
            type: 'GET',
            success:function(response)
            {
                console.log(response);
                $('#year').html(response);
            }
        })


    $('#subject_id').on('change', function(e){

        var subjectId = e.target.value;
        var url = '../../../subjects/{{ $user->name }}/' + subjectId;

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