@extends('layouts.app')

@section('title', 'My calendar')

@section('links')
    <link rel="stylesheet" href="{{ asset('vendor/fullcalendar/fullcalendar.min.css') }}">
    {{-- Type-media is ESSENTIAL --}}
    <link rel="stylesheet" href="{{ asset('vendor/fullcalendar/fullcalendar.print.min.css') }}" type="media">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.css" />
    <link rel="stylesheet" href="{{ asset('vendor/timepicker/jquery-ui-timepicker-addon.css') }}">
    <style>
        /*datepicker is under bs modal by default*/
        .ui-datepicker{
            z-index: 1600 !important; /*must be > 1050*/
        }
        .mark-holiday .ui-state-default{
            color: red !important;
        } 
    </style>
@endsection

@section('content')
    <div id="calendar"></div>
    @include('events.partials._eventModal')
        
@endsection

@section('scripts')
    {{-- CSRF Token --}}
    <script src="{{ asset('js/custom_app.js') }}"></script>
    <script src="{{ asset('vendor/moment/moment.js') }}"></script>
    <script src="{{ asset('vendor/fullcalendar/fullcalendar.min.js') }}"></script>
    <script src="{{ asset('vendor/fullcalendar/gcal.min.js') }}"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>
    <script src="{{ asset('vendor/timepicker/jquery-ui-timepicker-addon.js') }}"></script>

    <script>
    var calendar = $('#calendar');
    var dateFormat = 'YYYY-MM-DD';
    var timeFormat = 'HH:mm';
    var eventModal = $('#eventModal');
    var form = $("#eventForm");

    

        $("#eventDate").datepicker({
            dateFormat: "yy-mm-dd", // 2017-09-27
            minDate: 0, // today
            maxDate: datepickerMaxDate(),
            changeMonth: true,
            changeYear: true,
            firstDay: 1, // Monday,
            beforeShowDay: function(date) // disable and mark in red Sundays & holidays
            {
                var day = date.getDay(),
                    year = date.getFullYear(),
                    formattedDate = jQuery.datepicker.formatDate('yy-mm-dd', date),

                    January1 = year + "-01-01",
                    January2 = year + "-01-02",
                    January7 = year + "-01-07",
                    February15 = year + "-02-15",
                    February16 = year + "-02-16",
                    May1 = year + "-05-01",
                    May2 = year + "-05-02",
                    November11 = year + "-11-11",
                    GoodFriday = orthodoxEasterSunday(year).subtract(2, 'd').format(dateFormat),
                    EasterMonday = orthodoxEasterSunday(year).add(1, 'd').format(dateFormat);

                    var holidays = [January1, January2, January7, February15, February16, May1, May2, November11, GoodFriday, EasterMonday];

                // Sundays
                if (day == 0)
                {
                    // false = nonselectable field, markholiday = css class
                    return [false, "mark-holiday"];
                }
                else
                {
                    // returns -1 if the value is not in the array, otherways returns the value of the index
                    return (holidays.indexOf(formattedDate) == -1) ? [true] : [false, "mark-holiday"];
                }
            }
        });


        var startTime = $('#start');
        var endTime = $('#end');

        $.timepicker.timeRange(
            startTime, 
            endTime,
            {
                controlType: 'select', //dropdown instead slider
                oneLine: true, 
                hourMin: 8,
                hourMax: 20,
            }
        )


  
  </script>


    <script>
   
    $(".modal").on("hidden.bs.modal", function() {
            $("input, textarea, select").val("").end();
        });  

    

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
            if (isNotPast(start) && isNotSunday(start)) {
                eventModal.modal('show');
            }
            else{
                alert('Pasta date, holidays and Sundays are not available for creating for event!');
            }

            $('.modal-title i').addClass('fa-pencil');
            $('.modal-title span').text('New event');
            $('.cancel-button').text('Cancel');
            $('.event-button').text('Create event').attr('id', 'storeEvent');

            //Selected field for event start    
            start = moment(start.format());
            $('#eventDate').val(start.format(dateFormat));
            $('#start').val(start.format(timeFormat));
            $('#end').val(start.format(timeFormat));
        },

        eventClick: function(event, jsEvent, view)
            {
            //Open link in new window
            if (event.url) {
                window.open(event.url);
                return false;
            }

            // Open modal
            eventModal.modal('show').attr('data-event', event.id);

            // set modal parameters
            $('.modal-title i').addClass('fa-pencil-square-o');
            $('.modal-title span').text('Edit event');
            $('.cancel-button').text('Delete').attr('id', 'deleteEvent');
            $('.event-button').text('Save changes').attr('id', 'updateEvent');

            // Populate modal form fields with evnt data
            $("#title").val(event.title);
            $("#subject_id").val(event.subject_id);
            $("#eventDate").val(moment(event.start).format(dateFormat));
            $("#start").val(moment(event.start).format(timeFormat));
            $("#end").val(moment(event.end).format(timeFormat));
        },



    });//Fullcalendar

    </script>

    <script>

     
    // Form submit
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

        // Store event
        if ($('.event-button').attr('id') == 'storeEvent') 
        {
            // Displey the event in the calendar
            calendar.fullCalendar('renderEvent', event);

            // Store event in DB
            $.ajax({
                url: baseUrl,
                type: 'POST',
                data: event,
                success: function(response){
                    $('.modal').modal('hide');

                    calendar.fullCalendar('refetchEvents');

                    console.log(response.event);
                    console.log(response.message);
                }
            })
        }

        // Update event
        if ($('.event-button').attr('id') == 'updateEvent')
        {
            // Event url
            var eventId = eventModal.attr('data-event');
            var eventUrl = baseUrl + '/' + eventId;

            // Update event in calendar
            var allEvents = calendar.fullCalendar('clientEvents', eventId);

            allEvents[0].title = title;
            allEvents[0].subject_id = subjectId;
            allEvents[0].start = startTime;
            allEvents[0].end = endTime;

            calendar.fullCalendar('updateEvent', allEvents[0]);

            // Update event in DB
            $.ajax({
                 url: eventUrl,
                 type: 'PUT',
                 data: event,
                 success: function(response){
                    $('.modal').modal('hide');

                    console.log(response.event);
                    console.log(response.message);
                 }
            })
        }
    });//Submit form
        

    $(document).on('click', '#deleteEvent', function(){

        // Event url
        var eventId = eventModal.attr('data-event');
        var eventUrl = baseUrl + '/' + eventId;

        // Remove event from calendar
        calendar.fullCalendar('removeEvents', eventId);

        // Remove event from database
        $.ajax({
            url: eventUrl,
            type: 'DELETE',
            success: function(response){
                console.log(response.message);
             }
        })

    })

    

    </script>  
@endsection
 