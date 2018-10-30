@extends('layouts.app')

@section('css')
<style>
</style>
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
      <table class="table table-striped" id="example-1" style="width:1800px">
        <thead>
          <tr>
            <th>#</th>
            <th>Firstname</th>
            <th>Lastname</th>
            <th>Phone</th>
            <!-- <th>role</th> -->
            <!-- <th>gender</th> -->
            <th>Address1</th>
            <th>Address2</th>
            <th>City</th>
            <th>State</th>
            <th>Postalcode</th>
            <th>Country</th>
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
            <td class="tabledit-view-mode"><span class="tabledit-span">{{$user->phone}}</span>
              <input class="tabledit-input form-control input-sm" type="text" name="phone" value="{{$user->phone}}">
            </td>
            <!-- <td class="tabledit-view-mode"><span class="tabledit-span">{{$user->role}}</span>
              <input class="tabledit-input form-control input-sm" type="text" name="role" value="{{$user->role}}">
            </td> -->
            <!-- <td class="tabledit-view-mode"><span class="tabledit-span">{{$user->gender ? 'Male' : 'Female'}}</span>
              <input class="tabledit-input form-control input-sm" type="text" name="gender" value="{{$user->gender}}"> -->
              <!-- <select name="gender" class="tabledit-input form-control input-sm" disabled="" style="display:block;">
                <option "{{$user->gender ? 'selected' : ''}}" value="1">Male</option>
                <option "{{$user->gender ? '' : 'selected'}}" value="0">Female</option>
              </select>
            </td> -->
            <td class="tabledit-view-mode"><span class="tabledit-span">{{$user->address1}}</span>
              <input class="tabledit-input form-control input-sm" type="text" name="address1" value="{{$user->address1}}">
            </td>
            <td class="tabledit-view-mode"><span class="tabledit-span">{{$user->address2}}</span>
              <input class="tabledit-input form-control input-sm" type="text" name="address2" value="{{$user->address2}}">
            </td>
            <td class="tabledit-view-mode"><span class="tabledit-span">{{$user->city}}</span>
              <input class="tabledit-input form-control input-sm" type="text" name="city" value="{{$user->city}}">
            </td>
            <td class="tabledit-view-mode"><span class="tabledit-span">{{$user->state}}</span>
              <input class="tabledit-input form-control input-sm" type="text" name="state" value="{{$user->state}}">
            </td>
            <td class="tabledit-view-mode"><span class="tabledit-span">{{$user->postalcode}}</span>
              <input class="tabledit-input form-control input-sm" type="text" name="postalcode" value="{{$user->postalcode}}">
            </td>
            <td class="tabledit-view-mode"><span class="tabledit-span">{{$user->country}}</span>
              <input class="tabledit-input form-control input-sm" type="text" name="country" value="{{$user->country}}">
            </td>
            <td style="display:none" class="tabledit-view-mode"><span class="tabledit-span">_token</span>
                <input class="tabledit-input form-control input-sm" type="text" name="_token" value="{{csrf_token()}}">
            </td>
          </tr>
          <!-- <tr>
            <th scope="row"></th>
            <th>Gender</th>
            <td class="tabledit-view-mode"><span class="tabledit-span">{{$user->gender ? 'Male' : 'Female'}}</span>
              <select name="gender" class="tabledit-input form-control input-sm" disabled="" style="display:block;">
                <option "{{$user->gender ? 'selected' : ''}}" value="1">Male</option>
                <option "{{$user->gender ? '' : 'selected'}}" value="0">Female</option>
              </select>
              <input class="tabledit-input form-control input-sm" type="text" name="gender" value="{{$user->gender}}">
            </td>
            <td style="display:none" class="tabledit-view-mode"><span class="tabledit-span">_token</span>
                <input class="tabledit-input form-control input-sm" type="text" name="_token" value="{{csrf_token()}}">
            </td>
          </tr> -->
          <!-- <tr>
            <th scope="row"></th>
            <th>Address1</th>
            <td class="tabledit-view-mode"><span class="tabledit-span">{{$user->address1}}</span>
              <input class="tabledit-input form-control input-sm" type="text" name="address1" value="{{$user->address1}}">
            </td>
            <td style="display:none" class="tabledit-view-mode"><span class="tabledit-span">_token</span>
                <input class="tabledit-input form-control input-sm" type="text" name="_token" value="{{csrf_token()}}">
            </td>
          </tr>
          <tr>
            <th scope="row"></th>
            <th>Address2</th>
            <td class="tabledit-view-mode"><span class="tabledit-span">{{$user->address2}}</span>
              <input class="tabledit-input form-control input-sm" type="text" name="address2" value="{{$user->address2}}">
            </td>
            <td style="display:none" class="tabledit-view-mode"><span class="tabledit-span">_token</span>
                <input class="tabledit-input form-control input-sm" type="text" name="_token" value="{{csrf_token()}}">
            </td>
          </tr>
          <tr>
            <th scope="row"></th>
            <th>City</th>
            <td class="tabledit-view-mode"><span class="tabledit-span">{{$user->city}}</span>
              <input class="tabledit-input form-control input-sm" type="text" name="city" value="{{$user->city}}">
            </td>
            <td style="display:none" class="tabledit-view-mode"><span class="tabledit-span">_token</span>
                <input class="tabledit-input form-control input-sm" type="text" name="_token" value="{{csrf_token()}}">
            </td>
          </tr>
          <tr>
            <th scope="row"></th>
            <th>State</th>
            <td class="tabledit-view-mode"><span class="tabledit-span">{{$user->state}}</span>
              <input class="tabledit-input form-control input-sm" type="text" name="state" value="{{$user->state}}">
            </td>
            <td style="display:none" class="tabledit-view-mode"><span class="tabledit-span">_token</span>
                <input class="tabledit-input form-control input-sm" type="text" name="_token" value="{{csrf_token()}}">
            </td>
          </tr>
          <tr>
            <th scope="row"></th>
            <th>Postalcode</th>
            <td class="tabledit-view-mode"><span class="tabledit-span">{{$user->postalcode}}</span>
              <input class="tabledit-input form-control input-sm" type="text" name="postalcode" value="{{$user->postalcode}}">
            </td>
            <td style="display:none" class="tabledit-view-mode"><span class="tabledit-span">_token</span>
                <input class="tabledit-input form-control input-sm" type="text" name="_token" value="{{csrf_token()}}">
            </td>
          </tr>
          <tr>
            <th scope="row"></th>
            <th>Country</th>
            <td class="tabledit-view-mode"><span class="tabledit-span">{{$user->country}}</span>
              <input class="tabledit-input form-control input-sm" type="text" name="country" value="{{$user->country}}">
            </td>
            <td style="display:none" class="tabledit-view-mode"><span class="tabledit-span">_token</span>
                <input class="tabledit-input form-control input-sm" type="text" name="_token" value="{{csrf_token()}}">
            </td>
          </tr> -->
            <!-- <td class="tabledit-view-mode"><span class="tabledit-span">{{$user->lastname}}</span>
              <input class="tabledit-input form-control input-sm" type="text" name="lastname" value="{{$user->lastname}}">
            </td>
            <td class="tabledit-view-mode"><span class="tabledit-span">{{$user->phone}}</span>
              <input class="tabledit-input form-control input-sm" type="text" name="phone" value="{{$user->phone}}">
            </td>
            <td class="tabledit-view-mode"><span class="tabledit-span">{{$user->role}}</span>
              <input class="tabledit-input form-control input-sm" type="text" name="role" value="{{$user->role}}">
            </td>
            <td class="tabledit-view-mode"><span class="tabledit-span">{{$user->gender ? 'Male' : 'Female'}}</span>
              <input class="tabledit-input form-control input-sm" type="text" name="gender" value="{{$user->gender}}">
            </td>
            <td class="tabledit-view-mode"><span class="tabledit-span">{{$user->name}}</span>
              <input class="tabledit-input form-control input-sm" type="text" name="namew" value="{{$user->name}}">
            </td>
            <td style="display:none" class="tabledit-view-mode"><span class="tabledit-span">_token</span>
                <input class="tabledit-input form-control input-sm" type="text" name="_token" value="{{csrf_token()}}">
            </td>
          </tr>
          <tr>
            <th scope="row">1</th>
            <td class="tabledit-view-mode"><span class="tabledit-span">{{$user->firstname}}</span>
              <input class="tabledit-input form-control input-sm" type="text" name="firstname" value="{{$user->firstname}}">
            </td>
            <td class="tabledit-view-mode"><span class="tabledit-span">{{$user->lastname}}</span>
              <input class="tabledit-input form-control input-sm" type="text" name="lastname" value="{{$user->lastname}}">
            </td>
            <td class="tabledit-view-mode"><span class="tabledit-span">{{$user->phone}}</span>
              <input class="tabledit-input form-control input-sm" type="text" name="phone" value="{{$user->phone}}">
            </td>
            <td class="tabledit-view-mode"><span class="tabledit-span">{{$user->role}}</span>
              <input class="tabledit-input form-control input-sm" type="text" name="role" value="{{$user->role}}">
            </td>
            <td class="tabledit-view-mode"><span class="tabledit-span">{{$user->gender ? 'Male' : 'Female'}}</span>
              <input class="tabledit-input form-control input-sm" type="text" name="gender" value="{{$user->gender}}">
            </td>
            <td class="tabledit-view-mode"><span class="tabledit-span">{{$user->name}}</span>
              <input class="tabledit-input form-control input-sm" type="text" name="namew" value="{{$user->name}}">
            </td>
            <td style="display:none" class="tabledit-view-mode"><span class="tabledit-span">_token</span>
                <input class="tabledit-input form-control input-sm" type="text" name="_token" value="{{csrf_token()}}">
            </td>
          </tr> -->
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
      identifier:[0,'id'],editable:[[1,'firstname'],[2,'lastname'],[3,'phone'],
      //[4,'role'],[5,'gender','{"1": "Male", "0": "Female"}'],
      [4,'address1'],[5,'address2'],[7,'state'],[8,'postalcode'],[9,'country'],[6,'city'],]//[10,'_token'],
    }
  });
});
</script>
@endsection

@section('jslink')
<script src="{{URL::asset('js/jquery.tabledit.js')}}"></script>
@endsection
