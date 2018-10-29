@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{URL::asset('css/pignose.calendar.min.css')}}">
<link rel="stylesheet" href="{{URL::asset('css/datatables.min.css')}}">
@endsection
@section('content')
<div class="col-md-12 col-xl-7">
<div class="row">
<div class="col-sm-12">
<div class="card borderless-card">
<div class="row">
<div class="col-sm-4 weather-card-1  text-center">
<div class="mob-bg-calender bg-primary">
<h3 class="text-uppercase">{{date('l', strtotime(NOW()))}}</h3>
<h1 class="weather-temp">{{date('d', strtotime(NOW()))}}</h1>
</div>
</div>
<div class="col-sm-8 p-l-0">
<div class="weather-calender">
<div class="widget-calender"></div>
</div>
</div>
</div>
</div>
</div>
</div>
</div>

<div class="card">
  <div class="card-header">
    <h5>Active Event Report</h5>
    <div class="card-header-right">
      <i class="icofont icofont-rounded-down"></i>
      <i class="icofont icofont-refresh"></i>
      <i class="icofont icofont-close-circled"></i>
    </div>
  </div>
  <div class="card-block">
    <div class="table-responsive dt-responsive">
      <table id="myTable" class="table table-striped table-bordered nowrap">
        <thead>
        <tr>
          <th>Fistname</th>
          <th>Lastname</th>
          <th>Department</th>
          <th>Action</th>
          <th>Date</th>
        </tr>
        </thead>
      <tbody>
      </tbody>
      </table>
    </div>
  </div>
</div>

<div class="card">
  <div class="card-header">
    <h5>Historical Till Date</h5>
    <div class="card-header-right">
      <i class="icofont icofont-rounded-down"></i>
      <i class="icofont icofont-refresh"></i>
      <i class="icofont icofont-close-circled"></i>
    </div>
  </div>
  <div class="card-block">
    <div class="table-responsive dt-responsive">
      <table id="history" class="table table-striped table-bordered nowrap">
        <thead>
        <tr>
          <th>Fistname</th>
          <th>Lastname</th>
          <th>Department</th>
          <th>Coming</th>
          <th>Not Coming</th>
          <th>Ignored</th>
        </tr>
        </thead>
      <tbody>
      </tbody>
      </table>
    </div>
  </div>
</div>
@endsection

@section('script')
<script>
$(document).ready(function() {
  //get the datas
  let values = {'alltime': true, '_token': '{{ csrf_token() }}'};
  $.ajax({
    type: "GET", url: "{{route('event.report')}}", data: values, dataType: "json", encode: true
  }).done(function(data){
    $('#myTable tbody').html('');
    $('#history tbody').html('');
    appendRow(data);

    //append for history
  data.history.forEach(function(history){
    $('#history tbody').append(`<tr>
      <td>${history.firstname}</td>
      <td>${history.lastname}</td>
      <td>${history.role}</td>
      <td>${history.yes}</td>
      <td>${history.no}</td>`+
      '<td>'+(history.ignored)+'</td></tr>');
  });
    // $('#myTable').DataTable().rows().invalidate('data').draw(false);
    // $('#history').DataTable().rows().invalidate('data').draw(false);
  });
  function handleSelect(date, context){
    var text = 'You applied date ';
    if (date[0] !== null) {
      let sdate = date[0].format('YYYY-MM-DD');
      $.ajax({url: "{{route('event.report')}}", type: "GET", data: {'find': true, 'date': sdate}, dataType: 'json', encode: true})
      .done(function(response){
        if (response.status) {
          swal('Success!', `Report for ${response.report[0].event_date} fetched`, 'success');
          $('#myTable tbody').html('');
          appendRow(response);
        }else{
          swal("Oops", `No Report for ${response.date}`, "error");
        }
      })
      .error(function(data) {
        console.log(data.responseText);
      swal("Oops", "Error occured! Error: "+data.statusText, "error");
      });
    }

  }
  $(function() {
    $('.widget-calender').pignoseCalendar({
      theme: 'blue',
      select: handleSelect,
    });
  });
  $('table').DataTable();
//  $('#myTable').DataTable();
});

function appendRow(data){
  data.report.forEach(function(report){
    let attend = report.attendance ? report.attendance == 1 ? 'Yes' : 'No response/Ignored' : 'No';
    $('#myTable tbody').append(`<tr>
      <td>${report.firstname}</td>
      <td>${report.lastname}</td>
      <td>${report.role}</td>`+
      '<td>'+attend+'</td> <td>'+report.event_date+'</td>   </tr>');
    });
}
</script>
@endsection

@section('jslink')
<script src="{{URL::asset('js/pignose.calendar.full.min.js')}}"></script>
<script src="{{URL::asset('js/datatables.min.js')}}"></script>
@endsection
