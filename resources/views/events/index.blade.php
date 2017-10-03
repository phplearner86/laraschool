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
    @include('events.partials._eventModal')
        
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
        eventSources: [ //Fetch all events
            {
                url: baseUrl
            }
        ],
        eventColor: 'red',
        displayEventTime: false,
        select: function(start, event, jsEvent, view)
        {
            // Open modal
            $('#eventModal').modal('show');
            $('.modal-title span').text('New event');
            $('.modal-title i').addClass('fa-pencil');
            $('.event-button').text('Create event').attr('id', 'storeEvent');
            $('.cancel-button').text('Cancel');

            //Selected field for event start    
            start = moment(start.format());
            $('#date').val(start.format('YYYY-MM-DD'));
            $('#start').val(start.format('08:00'));
            $('#end').val(start.format('08:45'));
           // alert(start);

        },



    });//Fullcalendar

    </script>

    <script>

    $.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
});
        
    $(document).on('click', '#storeEvent', function(){

        //Variables
        var title = $('#title').val();
        var subjectId = $('#subject_id').val();
        var date = $('#date').val();
        var start = $('#start').val();
        var end = $('#end').val();
        var startTime = date + ' ' + start;
        var endTime = date + ' ' + end;

        //Display event in full calendar
        var event = {
            title: title,
            start: startTime,
            end: endTime,
            allDay: false
        }

        calendar.fullCalendar('renderEvent', event);

        //Store event in DB
        $.ajax({
            url: baseUrl,
            type: 'POST',
            data: {
                title: title,
                subject_id: subjectId,
                start: startTime,
                end: endTime,
            },
            success: function(response){
                console.log(response.message);
                console.log(response.event);
            }
        })
    });

    </script>  
@endsection
 