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
    $(document).ready(function () {
            // page is now ready, initialize the calendar...
            events={!! json_encode($events) !!};
            $('#calendar').fullCalendar({
                // put your options and callbacks here
                events: events,
                customButtons: {
                    myCustomButton: {
                        text: 'custom!',
                        click: function() {
                            alert('clicked the custom button!');
                        }
                    }
                },
                eventClick: function(calEvent, jsEvent, view) {
                    alert('Event: ' + calEvent.title);
                    //alert('Coordinates: ' + jsEvent.pageX + ',' + jsEvent.pageY);
                    //alert('View: ' + view.name);

                    // change the border color just for fun
                    $(this).css('border-color', 'red');

                },
                eventRender: function(event, element) {
                    event.allDay = true;
                    element.popover({
                        animation:true,
                        html:true,
                        content: event.title,
                        trigger: 'hover'
                    });
                }




            })
        });
</script>
@stop
