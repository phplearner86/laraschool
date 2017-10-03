@extends('layouts.app')

@section('title', 'My calendar')

@section('links')
    <link rel="stylesheet" href="{{ asset('vendor/fullcalendar/fullcalendar.min.css') }}">
    {{-- Type-media is ESSENTIAL --}}
    <link rel="stylesheet" href="{{ asset('vendor/fullcalendar/fullcalendar.print.min.css') }}" type="media">
    <link rel="stylesheet" href="{{ asset('vendor/datepicker/jquery-ui.min.css') }}">
    <link rel="stylesheet" href="{{ asset('vendor/timepicker/jquery-ui-timepicker-addon.css') }}">
@endsection

@section('content')

    <div id="calendar"></div>
        
@endsection

@section('scripts')
    <script src="{{ asset('vendor/moment/moment.js') }}"></script>
    <script src="{{ asset('vendor/fullcalendar/fullcalendar.min.js') }}"></script>
    <script src="{{ asset('vendor/datepicker/jquery-ui.min.js') }}"></script>
    <script src="{{ asset('vendor/timepicker/jquery-ui-timepicker-addon.js') }}"></script>

    <script>
   
    var calendar = $('#calendar');
    var userName = "{{ $user->name }}";
    var baseUrl = '../calendar/' + userName;
    
    calendar.fullCalendar({
        header:{
            left:'prev,next',
            center:'title',
            right:'month, agendaWeek, agendaDay, list'
        },
        defaultView: 'month',
        slotDuration: '00:15:00',
        firstDay: '1',
        editable: true,
        selectable: true,
        selectHelper: true,
        businessHours: [
            {
                dow: [1,2,3,4,5],
                start: '08:00:00',
                end: '20:00:00',
            },
            {
                dow: [6],
                start: '08:00:00',
                end: '14:00:00',
            }
        ],
        eventLimit: true,
        eventSources: [
            {
                url: baseUrl
            }
        ],
        eventColor: 'red',
        displayEventTime: false,
        select: function(start, event, jsEvent, view){
            // Open modal
        },



    });//Fullcalendar

    </script>
@endsection
 