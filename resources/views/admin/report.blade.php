@extends('layouts.app')

<!-- <link rel="stylesheet" href="{{URL::asset('css/datatables.min.css')}}"> -->

@section('css')
<link rel="stylesheet" href="{{URL::asset('css/pignose.calendar.min.css')}}">
<link rel="stylesheet" href="https://cdn.datatables.net/1.10.19/css/jquery.dataTables.min.css">
<link rel="stylesheet" href="https://cdn.datatables.net/buttons/1.5.4/css/buttons.dataTables.min.css">
<link rel="stylesheet" href="https://cdn.datatables.net/select/1.2.7/css/select.dataTables.min.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/material-design-lite/1.1.0/material.min.css">
<link rel="stylesheet" href="https://cdn.datatables.net/1.10.19/css/dataTables.material.min.css">
@endsection
@section('content')
<div class="container">



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
    <div class="row" >
      <!-- <div class="col-md-12 col-xl-7">
        <div class="row"> -->
          <div class="col-sm-12 col-xl-12">
            <div class="card borderless-card">
              <div class="row">
                <div class="col-sm-12 weather-card-1  text-center p-l-0">
                  <div class="mob-bg-calender bg-primary">
                    <h3 class="text-uppercase" style="margin-top:0px;">{{date('l', strtotime(NOW()))}}</h3>
                    <h1 class="weather-temp">{{date('d', strtotime(NOW()))}}</h1>
                  </div>
                </div>
                <div class="col-sm-12 p-l-0">
                  <div class="weather-calender">
                    <div class="widget-calender"></div>
                  </div>
                </div>
              </div>
            </div>
          </div>

        <!-- </div>
      </div> -->
      <div class="col-sm-12 col-xl-12">
        <div class="table-responsive dt-responsive">
          <table id="report" class="table table-striped table-bordered nowrap">
            <thead>
            <tr>
              <th>Firstname</th>
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
          <th>Firstname</th>
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
</div>
@endsection

@section('script')
<script>
$(document).ready(function() {
  function handleSelect(date, context){
    var text = 'You applied date ';
    if (date[0] !== null) {
      let sdate = date[0].format('YYYY-MM-DD');
        reportTable.destroy();
        reportTable = $('#report').DataTable({
          processing: true,
          serverSide: true,
          ajax: {
            "url": "{{route('event.report')}}",
            "type": "GET",
            data: {"find": "1", 'date': sdate},
            dataType: 'json', encode: true,
            error: function(response){
              alert('Error Occured');
            },
            dataSrc: function (response) {
              if(response.data.length > 0){
                swal('Success!', `Report for ${response.data[0][4].split(' ')[0]} fetched`, 'success');
              }else{
                swal("Oops", `No Report for ${sdate}`, "error");
              }
              return response.data;
            },
          },
          "columns": [
             { title: "Firstname","data": "0" },
             { "data": "1" },
             { "data": "2" },
             { "data": "3",
               render : function( data, type, full, meta ) {
                 return data ? data == 1 ? 'Yes' : 'No response/Ignored' : 'No'
               }
             },
             { "data": "4" }
           ]
       });
    }
  }
  $(function() {
    $('.widget-calender').pignoseCalendar({
      theme: 'blue',
      select: handleSelect,
    });
  });
  //history table
  $('#history').DataTable({
    processing: true,
    serverSide: true,
    ajax: {
      "url": "{{route('event.report')}}",
      "type": "GET",
      "data": {
         "history": "1"
      }
    }
  });
  //report table
  var reportTable = $('#report').DataTable({
    processing: true,
    serverSide: true,
    ajax: {
      "url": "{{route('event.report')}}",
      "type": "GET",
      "data": {
         "report": "1"
      }
    },
    "columns": [
       { title: "Firstname","data": "0" },
       { "data": "1" },
       { "data": "2" },
       { "data": "3",
         render : function( data, type, full, meta ) {
           return data ? data == 1 ? 'Yes' : 'No response/Ignored' : 'No'
         }
       },
       { "data": "4" }
     ]
  });
});

function appendRow(data){
  data.report.forEach(function(report){
    let attend = report.attendance ? report.attendance == 1 ? 'Yes' : 'No response/Ignored' : 'No';
    $('#report tbody').append(`<tr>
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
<!-- <script src="{{URL::asset('js/datatables.min.js')}}"></script> -->
<script src="https://cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.5.4/js/dataTables.buttons.min.js"></script>
<script src="https://cdn.datatables.net/select/1.2.7/js/dataTables.select.min.js"></script>
<script src="https://cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.10.19/js/dataTables.material.min.js"></script>
@endsection
