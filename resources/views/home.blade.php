@extends('layouts.app')

@section('css')
<style>
@import url(http://fonts.googleapis.com/css?family=Lato:100,400);
.mb20{
    margin-bottom:20px;
}
section {
    padding: 40px 0;
}
#timer .countdown-wrapper {
    margin: 0 auto;
}
#timer #countdown {
    font-family: 'Lato', sans-serif;
    text-align: center;
    color: #eee;
    text-shadow: 1px 1px 5px black;
    padding: 0px 0;
}
#timer .countdown-wrapper #countdown .timer {
    margin: 10px;
    padding: 20px;
    font-size: 90px;
    border-radius: 50%;
    cursor: pointer;
}
#timer .col-md-4.countdown-wrapper #countdown .timer {
    margin: 10px;
    padding: 20px;
    font-size: 35px;
    border-radius: 50%;
    cursor: pointer;
}
#timer .countdown-wrapper #countdown #day {
    -webkit-box-shadow: 0 0 0 5px rgba(92, 184, 92, .5);
    -moz-box-shadow: 0 0 0 5px rgba(92, 184, 92, .5);
    box-shadow: 0 0 0 5px rgba(92, 184, 92, .5);
}
#timer .countdown-wrapper #countdown #day:hover {
    -webkit-box-shadow: 0px 0px 15px 1px rgba(92, 184, 92, 1);
    -moz-box-shadow: 0px 0px 15px 1px rgba(92, 184, 92, 1);
    box-shadow: 0px 0px 15px 1px rgba(92, 184, 92, 1);
}
#timer .countdown-wrapper #countdown #hour {
    -webkit-box-shadow: 0 0 0 5px rgba(91, 192, 222, .5);
    -moz-box-shadow: 0 0 0 5px rgba(91, 192, 222, .5);
    box-shadow: 0 0 0 5px rgba(91, 192, 222, .5);
}
#timer .countdown-wrapper #countdown #hour:hover {
    -webkit-box-shadow: 0px 0px 15px 1px rgba(91, 192, 222, 1);
    -moz-box-shadow: 0px 0px 15px 1px rgba(91, 192, 222, 1);
    box-shadow: 0px 0px 15px 1px rgba(91, 192, 222, 1);
}
#timer .countdown-wrapper #countdown #min {
    -webkit-box-shadow: 0 0 0 5px rgba(91, 192, 222, .5);
    -moz-box-shadow: 0 0 0 5px rgba(91, 192, 222, .5);
    box-shadow: 0 0 0 5px rgba(91, 192, 222, .5);
}
#timer .countdown-wrapper #countdown #min:hover {
    -webkit-box-shadow: 0px 0px 15px 1px rgb(91, 192, 222);
    -moz-box-shadow: 0px 0px 15px 1px rgb(91, 192, 222);
    box-shadow: 0px 0px 15px 1px rgb(91, 192, 222);
}
#timer .countdown-wrapper #countdown #sec {
    -webkit-box-shadow: 0 0 0 5px rgba(255, 0, 0, .5);
    -moz-box-shadow: 0 0 0 5px rgba(255, 0, 0, .5);
    box-shadow: 0 0 0 5px rgba(255, 0, 0, .5)
}
#timer .countdown-wrapper #countdown #sec:hover {
    -webkit-box-shadow: 0px 0px 15px 1px rgba(255, 0, 0, 1);
    -moz-box-shadow: 0px 0px 15px 1px rgba(255, 0, 0, 1);
    box-shadow: 0px 0px 15px 1px rgba(255, 0, 0, 1);
}
#timer .countdown-wrapper .card .card-footer .btn {
    margin: 2px 0;
}
@media (min-width: 992px) and (max-width: 1199px) {
    #timer .countdown-wrapper #countdown .timer {
        margin: 10px;
        padding: 20px;
        font-size: 65px;
        border-radius: 50%;
        cursor: pointer;
    }
}
@media (min-width: 768px) and (max-width: 991px) {
     #timer .countdown-wrapper #countdown .timer {
        margin: 10px;
        padding: 20px;
        font-size: 72px;
        border-radius: 50%;
        cursor: pointer;
    }
}
@media (max-width: 768px) {
    #timer .countdown-wrapper #countdown .timer {
        margin: 10px;
        padding: 20px;
        font-size: 73px;
        border-radius: 50%;
        cursor: pointer;
    }
}
@media (max-width: 767px) {
    #timer .countdown-wrapper #countdown #day,
    #timer .countdown-wrapper #countdown #hour,
    #timer .countdown-wrapper #countdown #min,
    #timer .countdown-wrapper #countdown #sec {
        font-size: 60px;
        border-radius: 4%;
    }
}
@media (max-width: 576px){
  #timer .countdown-wrapper #countdown #day,
    #timer .countdown-wrapper #countdown #hour,
    #timer .countdown-wrapper #countdown #min,
    #timer .countdown-wrapper #countdown #sec {
        font-size: 25px;
        border-radius: 4%;
    }
    #timer .countdown-wrapper #countdown .timer {
        padding: 13px;
    }
}
</style>
@endsection
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
                  <div class="card-contain text-center p-t-10">
                    <h5 class="text-capitalize p-b-10">Will you attend the service on:</h5>
                    <p class="text-muted">{{date('l jS \of F Y', strtotime($pending_attendance->event_edate))}}?</p>
                    <div id="timer">
                      <div class="row">
                        <div class="col-xs-12 col-sm-12 col-md-12 countdown-wrapper text-center mb20" style="padding-right: 15px; padding-left: 0;">
        	                <div id="countdown">
                            <p class="text-muted">Time Left</p>
                              <div class="row" >
                                <div class="col-xs-3">
                                  <span id="day" class="timer bg-success"></span>
                                  <span id="" class="">Days</span>
                                </div>
                                <div class="col-xs-3">
                                  <span id="hour" class="timer bg-primary"></span>
                                  <span id="" class="">Hrs</span>
                                </div>
                                <div class="col-xs-3">
                                  <span id="min" class="timer bg-info"></span>
                                  <span id="" class="">Mins</span>
                                </div>
                                <div class="col-xs-3">
                                  <span id="sec" class="timer bg-danger"></span>
                                  <span id="" class="">Secs</span>
                                </div>
                              </div>
                        	</div>
                        </div>
                      </div>
                    </div>
                  </div>
                  <div class="card-button"><!-- p-t-50 -->
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
    var countDownDate = new Date("{{$pending_attendance->event_edate}}").getTime();
    // Update the count down every 1 second
    var x = setInterval(function() {
      // Get todays date and time
      var now = new Date().getTime();
      // Find the distance between now and the count down date
      var distance = countDownDate - now;
      // Time calculations for days, hours, minutes and seconds
      var days = Math.floor(distance / (1000 * 60 * 60 * 24));
      var hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
      var minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
      var seconds = Math.floor((distance % (1000 * 60)) / 1000);
      // Output the result"
      jQuery('#countdown #day').html(days);
      jQuery('#countdown #hour').html(hours);
      jQuery('#countdown #min').html(minutes);
      jQuery('#countdown #sec').html(seconds);
      // If the count down is over, hide the event
      if (distance < 0) {
        clearInterval(x);
        $('#question').hide();
      }
    }, 1000);

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
@endsection
