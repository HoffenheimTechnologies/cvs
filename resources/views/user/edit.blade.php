@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="https://cdn.datatables.net/1.10.19/css/jquery.dataTables.min.css">
<link rel="stylesheet" href="https://cdn.datatables.net/buttons/1.5.4/css/buttons.dataTables.min.css">
<link rel="stylesheet" href="https://cdn.datatables.net/select/1.2.7/css/select.dataTables.min.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/material-design-lite/1.1.0/material.min.css">
<link rel="stylesheet" href="https://cdn.datatables.net/1.10.19/css/dataTables.material.min.css">
@endsection
@section('content')
<div class="card">
  <div class="card-header">
  <h5>My Profile</h5>
  <span>Click on edit action then Enter for save</span>
  <div class="card-header-right">
    <i class="icofont icofont-rounded-down"></i>
    <i class="icofont icofont-refresh"></i>
    <i class="icofont icofont-close-circled"></i>
  </div>
  </div>
  <div class="card-block">
    <div class="table-responsive">
      <table class="datatable mdl-data-table dataTable" cellspacing="0"
          width="100%" role="grid" style="width: 100%;">
          <thead>
              <tr>
                  <th>ID</th>
                  <th>First Name</th>
                  <th>Last Name</th>
                  <th>Email</th>
                  <th>Gender</th>
                  <th>Country</th>
                  <th>Salary</th>
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
var editor; // use a global for the submit and return data rendering in the examples

$(document).ready(function() {
  $('.datatable').DataTable({
            processing: true,
            serverSide: true,
            ajax: "{{ route('serverSide') }}",
            columnDefs: [{
                targets: [0, 1, 2],
                className: 'mdl-data-table__cell--non-numeric'
            }]
        })
} );
</script>
@endsection

@section('jslink')
<!-- <script src="https://code.jquery.com/jquery-3.3.1.js"></script> -->
<script src="https://cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.5.4/js/dataTables.buttons.min.js"></script>
<script src="https://cdn.datatables.net/select/1.2.7/js/dataTables.select.min.js"></script>
<script src="https://cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.10.19/js/dataTables.material.min.js"></script>
@endsection
