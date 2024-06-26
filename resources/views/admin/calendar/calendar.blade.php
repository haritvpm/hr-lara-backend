@extends('layouts.admin')
@section('content')
<h3 class="page-title">{{ trans('global.systemCalendar') }}</h3>
<div class="card">
    <div class="card-header">
        {{ trans('global.systemCalendar') }}
    </div>

    <div class="card-body">
        <link rel='stylesheet' href='https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.1.0/fullcalendar.min.css' />

        <div id='calendar'></div>
    </div>
</div>



@endsection

@section('scripts')
@parent
<script src='https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.17.1/moment.min.js'></script>
<script src='https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.9.0/fullcalendar.min.js'></script>
<script>
    $(document).ready(function() {
        var SITEURL = "{{url('/admin')}}";
        // page is now ready, initialize the calendar...
        const urlParams = new URLSearchParams(window.location.search);
        let currentDate = new Date().toJSON().slice(0, 10);
        const dateQueryStr = urlParams.get('date') || currentDate;

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        $('#calendar').fullCalendar({
            // put your options and callbacks here
            events: SITEURL + "/fullcalender",
            displayEventTime: false,
            editable: true,
            defaultDate: dateQueryStr,
            eventClick: function(event, element, view) {
                //event should have {start:moment(),title:"Title",editlink:"abc"}
                //goto  SITEURL/govt-calendars/event.id
                //if (event.editlink)
                {
                    window.location.href = SITEURL + "/govt-calendars/" + event.id;
                }

            },
            eventRender: function(event, element, view) {
                /// element.find('.fc-title').append("<br/>" + event.date);
                let txt = event.is_holiday ? 'Holiday ' : '';
                txt += event.is_restricted ? 'RH ' : '';
                txt += event.is_sitting_day ? 'Sitting_day ' : '';

                element.popover({
                    title: event.date,
                    content: txt,
                    trigger: 'hover',
                    placement: 'top',
                    container: 'body'
                });
            },

            dayClick: function(date, jsEvent, view) {

               //alert('Clicked on: ' + date.format()); alert('Current view: ' + view.name);
               window.location.href = SITEURL + "/govt-calendars/date/" +date.format();
                // change the day's background color just for fun
                //$(this).css('background-color', 'red');

            },
            dayRender: function (date, cell) {
              //  cell.css("background-color", "red");
            }

        })
    });
</script>
@stop
