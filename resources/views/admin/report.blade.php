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
<h3 class="text-uppercase">Monday</h3>
<h1 class="weather-temp">27</h1>
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
    <h5>Last Event Report</h5>
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
    <h5>History</h5>
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
  let values = {'i': 'i', '_token': '{{ csrf_token() }}'};
  $.ajax({
    type: "GET", url: "{{route('event.report')}}", data: values, dataType: "json", encode: true
  }).done(function(data){
    $('#myTable tbody').html('');
    $('#history tbody').html('');
    data.report.forEach(function(report){
      let attend = report.attendance ? 'Yes' : 'No';
      $('#myTable tbody').append(`<tr>
        <td>${report.firstname}</td>
        <td>${report.lastname}</td>
        <td>${report.role}</td>`+
        '<td>'+attend+'</td>   </tr>');
      });

    //append for history
  data.history.forEach(function(history){
    $('#history tbody').append(`<tr>
      <td>${history.firstname}</td>
      <td>${history.lastname}</td>
      <td>${history.role}</td>
      <td>${history.yes}</td>
      <td>${history.no}</td>`+
      '<td>'+(history.event - history.yes - history.no)+'</td>   </tr>');
  });
    // $('#myTable').DataTable().rows().invalidate('data').draw(false);
    // $('#history').DataTable().rows().invalidate('data').draw(false);
  });
  $(function() {
    $('.widget-calender').pignoseCalendar();
  });
  $('#history').DataTable();
  $('#myTable').DataTable(
    // {
    //     "processing": true,
    //     "serverSide": true,
    //     "sServerMethod": "GET",
    //     "iDisplayLength": 50,
    //     "ajax": {"url": "{{route('event.report')}}", "data": {'i': 'i', '_token': '{{ csrf_token() }}'}}
    // }
  );
});
</script>
@endsection

@section('jslink')
<script src="{{URL::asset('js/pignose.calendar.full.min.js')}}"></script>
<script src="{{URL::asset('js/datatables.min.js')}}"></script>
@endsection
