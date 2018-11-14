@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{URL::asset('css/counter.css')}}">
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
  <!-- <div id='loader'></div> -->
    <div id="question-div" class="slide">
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
                    <h5 class="text-capitalize p-b-10">Will you attend the {{$pending_attendance->service->name}} on:</h5>
                    <p class="text-muted">{{date('l jS \of F Y', strtotime($pending_attendance->event_edate))}}?</p>
                    <div id="timer">
                      <div class="row">
                        <div class="col-xs-12 col-sm-12 col-md-12 countdown-wrapper text-center mb20" style="padding-right: 15px; padding-left: 0;">
        	                <div id="countdown">
                            <p class="text-muted">Time Left</p>
                            <br>
                              <div class="row" >
                                <div class="col-xs-3">
                                  <span id="day" class="timer bg-success"></span>
                                  <span id="" class="intervals">Days</span>
                                </div>
                                <div class="col-xs-3">
                                  <span id="hour" class="timer bg-primary"></span>
                                  <span id="" class="intervals">Hrs</span>
                                </div>
                                <div class="col-xs-3">
                                  <span id="min" class="timer bg-info"></span>
                                  <span id="" class="intervals">Mins</span>
                                </div>
                                <div class="col-xs-3">
                                  <span id="sec" class="timer bg-danger"></span>
                                  <span id="" class="intervals">Secs</span>
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

              <div id='root'></div>

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
<script type="text/babel" >
function Header(props){
  return (
    <div className="top-card text-center section-title">
      <i className="fa fa-user-circle"></i>
      <h5 className="p-b-10">Hello!</h5>
      <h5 className="text-capitalize p-b-10">{props.name[0] +' '+props.name[1]}</h5>
    </div>
  )
}

function Timer(props){
  let id = props.id
  return (
    <div id="timer">
      <div className="row">
        <div className="col-xs-12 col-sm-12 col-md-12 countdown-wrapper text-center mb20" style=@{{paddingRight:" 15px", paddingLeft: "0"}}>
          <div id="countdown">
            <p className="text-muted">Time Left</p>
            <br />
              <div className="row" >
                <div className="col-xs-3">
                  <span id={"day"+id} className="timer bg-success">{props.time.days}</span>
                  <span id="" className="intervals">Days</span>
                </div>
                <div className="col-xs-3">
                  <span id={"hour"+id} className="timer bg-primary">{props.time.hours}</span>
                  <span id="" className="intervals">Hrs</span>
                </div>
                <div className="col-xs-3">
                  <span id={"min"+id} className="timer bg-info">{props.time.mins}</span>
                  <span id="" className="intervals">Mins</span>
                </div>
                <div className="col-xs-3">
                  <span id={"sec"+id} className="timer bg-danger">{props.time.secs}</span>
                  <span id="" className="intervals">Secs</span>
                </div>
              </div>
          </div>
        </div>
      </div>
    </div>
  )
}

function Event(props){
  function slicer(num){
    return ("0" + num).slice(-2)
  }
  return (
    <div className="card-contain text-center p-t-10">
      <h5 className="text-capitalize p-b-10">Will you attend the {props.event.name} on:</h5>
      <p className="text-muted">{props.event.edate}?</p>
      <Timer id={props.timer.id} time=@{{days: slicer(2), hours: slicer(3), mins: slicer(4), secs: slicer(5)}} />
    </div>
  )
}
function Marker(props){
  let id = props.id
  return (
    <div className="card-button">
      <form id={"mark_form" + id} method="post" onSubmit={event.preventDefault()}>
        <input id={"attendance_input" + id} type="hidden" name="attendance" />
        <input id="" type="hidden" name="_token" value="{{csrf_token()}}" />
        <input id="" type="hidden" name="event_id" value={id} />
        <div className="col-6 pull-right">
          <a onClick={() => props.mark(event, 1)}  id={"yes" + id} className="btn btn-success btn-round"><i className="fa fa-thumbs-up"></i> Yes</a>
        </div>
        <div className="col-6 pull-left">
          <a onClick={() => props.mark(event, 0)} id={"no" + id} className="btn btn-danger btn-round"><i className="fa fa-thumbs-down"></i> No</a>
        </div>
      </form>
    </div>
  )
}

class Attendance extends React.Component {
  constructor(props) {
    super(props)
    this.state = {
      attendance : props.attendance,
      refresh: props.refresh
    }
    console.log(this.state.refresh)
  }

  componentDidMount(){
    let id = this.state.attendance.id
    this.counter(this.state.attendance.event_edate)
  }

  componentWillUnmount(){
    clearInterval(this.state.x)
  }

  mark = (e,num) => {
    console.log(num)
    let id = this.state.attendance.id
    $('#attendance_input' + id).val(num);
    swal({
          title: "Are you sure?",
          text: "After success wait till the next event",
          type: "warning",
          buttons: true,
          dangerMode: true,
          showCancelButton: true,
        },function(){
        var values = {};
        $.each($('#mark_form' + id).serializeArray(), function(i, field) {
          values[field.name] = field.value;
        });
        //disble buttons
        $('#yes' + id).prop('disabled', true);
        $('#no' + id).prop('disabled', true);
        //process the form
        $.ajax({
            type: 'POST', url: "{{route('mark')}}", data: values, dataType: 'json', encode: true
        }).done(function(response){
          if(response.status){
            swal("Success!", "Attendance Marked Successfully", "success");
            console.log(this.state.refresh);
            () => this.state.refresh
          }else{
            if(response.e){
              console.log(response.e);
              swal("Oops", "Error occured! Error: "+response.e, "error");
              () => this.state.refresh
            }else{
              swal("Oops", ""+response.reason, "error");
              () => this.state.refresh
            }
          }
        });
      });
  }

  counter(date){
    var countDownDate = new Date(date).getTime();
    //
    let id = this.state.attendance.id
    // Update the count down every 1 second
    let x = setInterval(function() {
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
    jQuery('#countdown #day' + id).html(("0" + days).slice(-2));
    jQuery('#countdown #hour' + id).html(("0" + hours).slice(-2));
    jQuery('#countdown #min' + id).html(("0" + minutes).slice(-2));
    jQuery('#countdown #sec' + id).html(("0" + seconds).slice(-2));
    // If the count down is over, hide the event
    if (distance < 0) {
      clearInterval(this.state.x);
      $('#question').hide();
    }}, 1000);
    this.intervalId = x
  }

  render(){
    return(
      <div className="user-card-block card" id="prompt">
        <div class="card-block">
          <Header name={["Michael", "Ishola"]} />
          <Event timer=@{{id: this.state.attendance.id}}
            event=@{{name: this.state.attendance.service.name, edate: this.state.attendance.event_edate}}
          />
          <Marker id={this.state.attendance.id} mark={this.mark} />
        </div>
      </div>
    )
  }
}

class App extends React.Component {
  constructor() {
    super()
    this.state = {
      attendance : [],
    }
  }

  componentDidMount(){
    this.getAttendance()
  }

  getAttendance = () => {
    $.ajax({url: "{{route('attendance.get')}}", type: 'GET', dataType: 'json', encode: true})
    .done((response) => {
      if (response.status) {
        this.setState({attendance: response.pending_attendance})
      }else{

      }
    })
    .error(() => {
      alert('error')
    })
  }
  render(){
    let cards = []
    this.state.attendance.forEach((attendance) => {
      cards.push(<Attendance refresh={this.getAttendance} attendance={attendance} />)
    })
    return (
      <div>
        {cards}
      </div>
    )
  }
}

class Apps extends React.Component {
  constructor() {
    super()
    this.state = {
      todos : [],
    }
  }
  render(){
    return (
      <Card />
    )
  }
}
ReactDOM.render(
<App />,
document.getElementById('root')
)
</script>
<script>
  $(document).ready(function(){
    @if(isset($pending_attendance))
    counter("{{$pending_attendance->event_edate}}");
    @endif

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
        //disble buttons
        $('#yes').prop('disabled', true);
        $('#no').prop('disabled', true);
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
<script src="{{URL::asset('js/counter.js')}}"></script>
<script src="{{URL::asset('js/react.min.js')}}"></script>
<script src="{{URL::asset('js/react-dom.min.js')}}"></script>
<script src="{{URL::asset('js/babel.js')}}"></script>
@endsection
