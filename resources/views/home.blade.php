@extends('layouts.app')

@section('content')
<?php $user = Auth::user(); ?>

<!-- done process -->
    <div class="done-process" id="done" style="{{isset($message) ? 'display:block' : 'display:none'}}">
        <div class="container">
            <div class="content">
                <i class="fa fa-check"></i>
                <p id="message-text">{{isset($message) ? $message : ''}}</p>
            </div>
        </div>
    </div>
	<!-- end done process -->
@if(isset($pending_attendance))
<!-- slide -->
<div class="container bg-primary" id="question" style="{{isset($success) && ($success == 1 ) || !(isset($message)) ? 'display:block' : 'display:none'}}">
    <div class="slide">
        <div class="slide-show owl-carousel owl-theme">
          <div class="row">
            <div class="col-md-12">
              <div class="user-card-block card" id="prompt">
                <div class="card-block">
                  <div class="top-card text-center section-title">
                    <!-- <i class="fa fa-user-circle"></i> -->
                    <h5 class="p-b-10">Hello!</h5>
                    <h5 class="text-capitalize p-b-10">{{ucwords($user->firstname.' '.$user->lastname)}}</h5>
                  </div>
                  <div class="card-contain text-center p-t-40">
                    <h5 class="text-capitalize p-b-10">Will you attend the service on:</h5>
                    <p class="text-muted">{{date('l jS \of F Y', strtotime($pending_attendance->event_date))}}?</p>
                    <h1 id='timer'> </h1>
                  </div>

                  <div class="card-button p-t-50">
                    <form id="mark_form" method="post" onsubmit="event.preventDefault();">
                      @csrf
                      <input id="attendance_input" type="hidden" name="attendance" />
                      <input id="" type="hidden" name="event_id" value="{{$pending_attendance->id}}" />
                      <div class="col-6 pull-right">
                        <button id="yes" class="btn btn-success btn-round"><i class="fa fa-thumbs-up"></i> Yes</button>
                      </div>
                      <div class="col-6 pull-left">
                        <button id="no" class="btn btn-danger btn-round"><i class="fa fa-thumbs-down"></i> No</button>
                      </div>
                    </form>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
    </div>
</div>
<!-- end slide -->
@else
<!-- No event yet -->
<div class="container" style="{{isset($success) && !($success == 1 ) || !(isset($message)) ? 'display:block' : 'display:none'}}">
    <div class="col-md-12 col-xl-12">
        <div class="bg-primary card week-status-card">
            <div class="card-block-big text-center">
                <p>No Attendance Yet</p>
                <h2>Check back later</h2>
            </div>
            <div class="card-footer">
                <p class="text-right m-0">
                    {{NOW()}} <span> </span> <i class="icofont icofont-caret-down text-danger"></i>
                </p>
            </div>
        </div>
    </div>
</div>
<!-- end no event yet -->
@endif

@endsection

@section('script')
<script src="https://code.jquery.com/ui/1.11.4/jquery-ui.js"></script>
<script>
  $(document).ready(function(){
    var Countdown = new countdown({
  selector: '#timer',
  msgBefore: 'Will start at Christmas!',
  msgAfter: 'Happy new year folks!',
  msgPattern:
    '{days} days, {hours} hours and {minutes} minutes before new year!',
  dateStart: new Date('2018/10/31 18:27'),
  dateEnd: new Date('Jan 1, 2019 12:00'),
  onStart: function() {
    console.log('Merry Christmas!')
  },
  onEnd: function() {
    console.log('Happy New Year!')
  }
  });
    //
    $('#close').click(function(){
      $('#done').hide();
    });

    //$('#prompt').effect('shake');
    $('#yes').click(function(){
        mark(1);
    });
    $('#no').click(function(){
        mark(0);
    });
    //
    // $('#yes, #no').click(function(){
    //   $('#question').hide();
    //   $('#done').show();
    // });
  });
  function mark(num){
    $('#attendance_input').val(num);
    swal({
              title: "Are you sure?",
              text: "After success wait till the next event",
              type: "warning",
              buttons: true,
              dangerMode: true,
              showCancelButton: true,
            },function(){
        var values = {};
        $.each($('#mark_form').serializeArray(), function(i, field) {
          values[field.name] = field.value;
        });
        //process the form
        $.ajax({
            type        : 'POST', // define the type of HTTP verb we want to use (POST for our form)
            url         : "{{route('mark')}}", // the url where we want to POST
            data        : values, // our data object
            dataType    : 'json', // what type of data do we expect back from the server
            encode      : true
        }).done(function(response){
          if(response.status){
            swal("Success!", "Attendance Marked Successfully", "success");
                setTimeout(location.reload.bind(location), 2000);
          }else{
            if(response.e){
              console.log(response.e);
              swal("Oops", "Error occured! Error: "+response.e, "error");
              //setTimeout(location.reload.bind(location), 2000);
            }else{
              swal("Oops", ""+response.reason, "error");
              setTimeout(location.reload.bind(location), 2000);
            }
          }
        });
            });
  }
  function status(message){
    $('#question').hide();
    swal("Success!", ""+message, "success");
    // $('#message-text').html(message);
    // $('#done').show();
  }
</script>
@endsection
@section('jslink')
<script src="{{URL::asset('js/countdown.min.js')}}"></script>
@endsection
