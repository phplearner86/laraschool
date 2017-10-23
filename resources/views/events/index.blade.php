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
    {{-- CSRF Token --}}
    <script src="{{ asset('js/custom.js') }}"></script>
    <script src="{{ asset('vendor/moment/moment.js') }}"></script>
    <script src="{{ asset('vendor/fullcalendar/fullcalendar.min.js') }}"></script>
    <script src="{{ asset('vendor/fullcalendar/gcal.min.js') }}"></script>
    <script src="{{ asset('vendor/datepicker/jquery-ui.min.js') }}"></script>
    <script src="{{ asset('vendor/timepicker/jquery-ui-timepicker-addon.js') }}"></script>

    <script>
   
    $(".modal").on("hidden.bs.modal", function() {
            $("input, textarea, select").val("").end();
        });  

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
        googleCalendarApiKey: 'AIzaSyDCHznGd0tw07cQQfGZONGqTaknvzF7r2Q',
        eventSources: [ //Fetch all events
            {
                url: baseUrl
            },
            {
                googleCalendarId: 'en.rs#holiday@group.v.calendar.google.com'
            }
        ],
        eventColor: 'red',
        displayEventTime: false,
        select: function(start, event, jsEvent, view)
        {
            // Open modal
            $('#eventModal').modal('show');

            $('.modal-title i').addClass('fa-pencil');
            $('.modal-title span').text('New event');
            $('.cancel-button').text('Cancel');
            $('.event-button').text('Create event').attr('id', 'storeEvent');

            //Selected field for event start    
            start = moment(start.format());
            $('#eventDate').val(start.format('YYYY-MM-DD'));
            $('#start').val(start.format('HH:mm'));
            $('#end').val(start.format('HH:mm'));
           // alert(start);

        },

        eventClick: function(event, jsEvent, view)
        {
            //Open link in new window
            if (event.url) {
                window.open(event.url);
                return false;
            }

            $('#eventModal').modal('show').attr('data-event', event.id);
            $('.modal-title span').text('Edit event');
            $('.modal-title i').addClass('fa-pencil-square-o');
            $('.event-button').text('Save changes').attr('id', 'editEvent');
            $('.cancel-button').text('Delete').attr('id', 'deleteEvent');

            $("input[name=title]").attr('id', '_title').val(event.title);
            $("input[name=test]").attr('id', '_test').val(event.test);
            $("select[name=subject_id]").attr('id', '_subject_id').val(event.subject_id);
            $("input[name=date]").attr('id', '_date').val(moment(event.start).format('YYYY-MM-DD'));
            $("input[name=start]").attr('id', '_start').val(moment(event.start).format('HH:mm'));
            $("input[name=end]").attr('id', '_end').val(moment(event.end).format('HH:mm'));
        },



    });//Fullcalendar

    </script>

    <script>

     var form = $("#eventForm");

    form.on('submit', function(e){

        // Prevents page refresh
        e.preventDefault();

        // Event attributes
        var title = $('#title').val();
        var subjectId = $('#subject_id').val();
        var date = $('#eventDate').val();
        var start = $('#start').val();
        var end = $('#end').val();
        var startTime = date + ' ' + start;
        var endTime = date + ' ' + end;

        // Create new event object
        event = {
            title: title,
            subject_id: subjectId,
            start: startTime,
            end: endTime,
        }

        // Displey the event in the calendar
        calendar.fullCalendar('renderEvent', event);

        // Store event in DB
        $.ajax({
            url: baseUrl,
            type: 'POST',
            data: event,
            success: function(response){
                $('.modal').modal('hide');
                console.log(response.event);
                console.log(response.message);
            }
        })


    });
        

    

    

    </script>  
@endsection
 