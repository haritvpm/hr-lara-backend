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
            var SITEURL = "{{url('/admin')}}";
            // page is now ready, initialize the calendar...


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

                eventClick: function (event, element, view) {
                    //event should have {start:moment(),title:"Title",editlink:"abc"}
                    //goto  SITEURL/govt-calendars/event.id
                    //if (event.editlink)
                    {
                        window.location.href = SITEURL + "/govt-calendars/" + event.id;
                    }

            }


            })
        });
</script>
@stop
