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
                $('#start').val(start.format('HH:mm'));
                $('#end').val(start.format('HH:mm'));
           // alert(start);

        },

        eventClick: function(event, jsEvent, view)
        {
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

    $.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
    });
        
    $(document).on('click', '#storeEvent', function(){

        //Variables
        var title = $('#title').val();
        var test = $('#test').val();
        var subjectId = $('#subject_id').val();
        var date = $('#date').val();
        var start = $('#start').val();
        var end = $('#end').val();
        var startTime = date + ' ' + start;
        var endTime = date + ' ' + end;

        //Display event in full calendar
        var event = {
            title: title,
            test: test,
            subject_id: subjectId,
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
                test: test,
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

    $(document).on('click', '#editEvent', function(){

        //Variables
        var title = $('#_title').val();
        var test = $('#_test').val();
        var subjectId = $('#_subject_id').val();
        var date = $('#_date').val();
        var start = $('#_start').val();
        var end = $('#_end').val();
        var startTime = date + ' ' + start;
        var endTime = date + ' ' + end;

        var eventId = $('#eventModal').attr('data-event');
        var eventUrl = baseUrl + '/' + eventId;

        //Update calendar

        var event = calendar.fullCalendar('clientEvents', eventId);
        event[0].id = eventId;
        event[0].title = title;
        event[0].test = test;
        event[0].subject_id = subjectId;
        event[0].date = date;
        event[0].start = start;
        event[0].end = end;

        calendar.fullCalendar('updateEvent', event[0]);      

        //Update DB
        $.ajax({
            url: eventUrl,
            type: 'PUT',
            data: {
                id: eventId,
                title: title,
                test: test,
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

    $(document).on('click', '#deleteEvent', function()
    {
        //Ebent URl
        var eventId = $('#eventModal').attr('data-event');
        var eventUrl = baseUrl + '/' + eventId;

        //Remove from calendar

        calendar.fullCalendar('removeEvents', eventId);

        //Delete from DB
          $.ajax({
            url: eventUrl,
            type: 'DELETE',
            data: {
                id: eventId,
            },
            success: function(response){
                console.log(response.message);
            }
        })
        
    });

    

    </script>  
@endsection
 