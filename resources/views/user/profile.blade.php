@extends('layouts.app')

@section('css')
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
<table class="table table-striped table-bordered" id="example-1">
<thead>
<tr>
<th>#</th>
<th>First</th>
<th>Last</th>
<th>Nickname</th>
</tr>
</thead>
<tbody>
<tr>
<th scope="row">1</th>
<td class="tabledit-view-mode"><span class="tabledit-span">{{$user->firstname}}</span>
<input class="tabledit-input form-control input-sm" type="text" name="firstname" value="{{$user->firstname}}">
</td>
<td class="tabledit-view-mode"><span class="tabledit-span">{{$user->lastname}}</span>
<input class="tabledit-input form-control input-sm" type="text" name="lastname" value="{{$user->lastname}}">
</td>
<td class="tabledit-view-mode"><span class="tabledit-span">{{$user->name}}</span>
<input class="tabledit-input form-control input-sm" type="text" name="name" value="{{$user->name}}">
</td>
</tr>
</tbody>
</table>
</div>
</div>
</div>
@endsection

@section('script')
<script>
$(document).ready(function(){
  $('#example-1').Tabledit({
    editButton:true,
    deleteButton:false,hideIdentifier:true,
    columns:{
      identifier:[0,'id'],editable:[[1,'First Name'],[2,'Last Name'],[3,'Nickname']]
    }
  });
});

function add_row(){
  var table=document.getElementById("example-1");
  var t1=(table.rows.length);
  var row=table.insertRow(t1);
  var cell1=row.insertCell(0);
  var cell2=row.insertCell(1);
  var cell3=row.insertCell(2);
  cell1.className='abc';
  cell2.className='abc';
  $('<span class="tabledit-span" >Click Me To Edit</span><input class="tabledit-input form-control input-sm" type="text" name="First" value="undefined" disabled="">')
  .appendTo(cell1);
  $('<span class="tabledit-span" >Click Me To Edit</span><input class="tabledit-input form-control input-sm" type="text" name="Last" value="undefined"  disabled="">')
  .appendTo(cell2);
  $('<span class="tabledit-span" >@mdo</span><select class="tabledit-input form-control input-sm" name="Nickname"  disabled="" ><option value="1">@mdo</option><option value="2">@fat</option><option value="3">@twitter</option></select>')
  .appendTo(cell3);
};
</script>
@endsection

@section('jslink')
<script src="{{URL::asset('js/jquery.tabledit.js')}}"></script>
@endsection
