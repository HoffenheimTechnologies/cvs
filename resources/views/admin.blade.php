@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{URL::asset('css/bootstrap-datetimepicker.min.css')}}">
<link rel="stylesheet" href="{{URL::asset('css/counter.css')}}">
<link rel="stylesheet" href="{{URL::asset('css/jquery.dataTables.min.css')}}">
<!-- <link rel="stylesheet" href="https://cdn.datatables.net/1.10.19/css/jquery.dataTables.min.css"> -->
<!-- <link rel="stylesheet" href="https://cdn.datatables.net/buttons/1.5.4/css/buttons.dataTables.min.css"> -->
<!-- <link rel="stylesheet" href="https://cdn.datatables.net/select/1.2.7/css/select.dataTables.min.css"> -->
<link rel="stylesheet" href="{{URL::asset('css/material.min.css')}}">
<!-- <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/material-design-lite/1.1.0/material.min.css"> -->
<!-- <link rel="stylesheet" href="https://cdn.datatables.net/1.10.19/css/dataTables.material.min.css"> -->
@endsection
@section('content')
<div class="container">
		@if(isset($active->event_edate))
			<div class="card">
				<div class="card-header">
					<h5 class="card-header-text">Active Event</h5>
					<div class="card-header-right">
						<i class="icofont icofont-rounded-down"></i>
						<i class="icofont icofont-refresh"></i>
						<i class="icofont icofont-close-circled"></i>
					</div>
				</div>
				<div class="card-block" style="">
					<div class="row" id="draggableWithoutImg">
						<div class="col-md-3 col-sm-offset-4 col-xs-12 m-b-20 text-center">
							<div class="card-sub">
								<div class="card-block text-center">
									<h4 class="card-title">{{date('l jS \of F Y', strtotime($active->event_edate))}}</h4>
									<button id="disable-event" type="button"
									class="tabledit-save-button btn btn-sm btn-info" data-loading-text="<i class='fa fa-circle-o-notch fa-spin'></i> Processing Order">Disable</button><br>
									<input id="event_id" type="hidden" value="{{$active->id}}" />
								</div>
							</div>
						</div>
						<div id="timer">
							<div class="row">
								<div class="col-xs-12 col-sm-12 col-md-12 countdown-wrapper text-center mb20" style="padding-right: 15px; padding-left: 0;">
									<div class="card-header">
										<h5 class="card-header-text" style="margin-bottom:50px">Event Countdown</h5>
									</div>
									<div id="countdown">
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
													<span id="min" class="timer bg-warning"></span>
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
					<div class="card-header">
						<h5 class="card-header-text">Stat</h5>
					</div>
					<div class="col-sm-12 col-md-4 col-xl-4">
						<div class="card counter-card-1">
							<div class="card-block-big">
								<div class="row">
									<div class="col-6 counter-card-icon">
										<i class="icofont icofont-chart-histogram"></i>
									</div>
									<div class="col-6  text-right">
										<div class="counter-card-text">
											<h3>{{$stat->yes}}</h3>
											<p>Coming</p>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>

					<div class="col-sm-12 col-md-4 col-xl-4">
						<div class="card counter-card-2">
							<div class="card-block-big">
								<div class="row">
									<div class="col-6 counter-card-icon">
										<i class="icofont icofont-chart-line-alt"></i>
									</div>
									<div class="col-6 text-right">
										<div class="counter-card-text">
											<h3>{{$stat->no}}</h3>
											<p>Not Coming</p>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>

					<div class="col-sm-12 col-md-4 col-xl-4">
						<div class="card counter-card-3">
							<div class="card-block-big">
								<div class="row">
									<div class="col-6 counter-card-icon">
										<i class="icofont icofont-chart-line"></i>
									</div>
									<div class="col-6 text-right">
										<div class="counter-card-text">
											<h3>{{$stat->ignored}}</h3>
											<p>Ignoring</p>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>

				</div>
			</div>

		@endif
		<div class="page-body">
			<div class="row">
				<div class="col-sm-12">

					<div class="card">
						<div class="card-header">
							<h5 class="card-header-text">Create Event</h5>
							<div class="card-header-right">
								<i class="icofont icofont-rounded-down"></i>
								<i class="icofont icofont-refresh"></i>
								<i class="icofont icofont-close-circled"></i>
							</div>
						</div>
						<div class="card-block">

							<div class="row">
								<div class="col-xs-12 col-md-6 mobile-inputs">
									<h4 class="sub-title">Event Date</h4>
									<form>
										<div class="form-group">
											<div class="input-group">
												<input id="start" class="form-control form-txt-primary datetimepicker" type="text" placeholder="Select event start date&time" readonly="readonly">
												<span class="input-group-addon bg-default">
													<span class="icofont icofont-ui-calendar"></span>
												</span>
											</div>
										</div>
									</form>
									<form>
										<div class="form-group">
											<div class="input-group">
												<input id="end" class="form-control form-txt-primary datetimepicker" type="text" placeholder="Select event end date&time" readonly="readonly">
												<span class="input-group-addon bg-default">
													<span class="icofont icofont-ui-calendar"></span>
												</span>
											</div>
										</div>
									</form>
								</div>
								<div class="col-xs-12 col-md-6 mobile-inputs">
									<h4 class="sub-title">Submit</h4>
									<button style="background-color: #dd4b39;" id="create" class="btn btn-inverse">
										<i class="icofont icofont-exchange"></i>Create event
									</button>
								</div>
							</div>
						</div>

						<div class="card-header">
							<h5 class="card-header-text">List Of Events</h5>
						</div>
						<div class="card-block">
							<div class="table-responsive">
								<table id="events" class="table table-striped table-bordered nowrap">
									<thead>
									</thead>
									<tbody>
									</tbody>
								</table>
							</div>
						</div>

					</div>

				</div>
			</div>
		</div>

		<div class="page-body">
			<div class="row">
				<div class="col-sm-12">

					<div class="card">
						<div class="card-header">
							<h5 class="card-header-text">Create Service</h5>
							<div class="card-header-right">
								<i class="icofont icofont-rounded-down"></i>
								<i class="icofont icofont-refresh"></i>
								<i class="icofont icofont-close-circled"></i>
							</div>
						</div>
						<div class="card-block">

							<div class="row">
								<div class="col-xs-12 col-md-6 mobile-inputs">
									<h4 class="sub-title">Service Name</h4>
										<div class="form-group">
											<div class="input-group">
												<input id="name" class="form-control form-txt-primary" type="text" placeholder="SERVICE NAME" >
												<span class="input-group-addon bg-default">
													<span class="fa fa-keyboard-o"></span>
												</span>
											</div>
										</div>
								</div>
								<div class="col-xs-12 col-md-6 mobile-inputs">
									<h4 class="sub-title">Service Start Day
										<!-- And Time -->
									</h4>
									<?php $weekdays = ["Sundays","Mondays","Tuesdays","Wednesdays","Thursdays","Fridays","Saturdays"]; ?>
										<div class="form-group">
											<div class="input-group">
												<select class="form-control form-txt-primary" id="service_start" required style="display:block">
													<option selected disabled value="">Choose day</option>
													@foreach($weekdays as $day)
													<option value="{{$day}}">{{$day}}</option>
													@endforeach
												</select>
												<span class="input-group-addon bg-default">
													<span class="icofont icofont-ui-calendar"></span>
												</span>
											</div>
										</div>
								</div>
								<div class="col-xs-12 col-md-6 mobile-inputs">
									<h4 class="sub-title">Service End Day
										<!-- And Time -->
									</h4>
										<div id="service-div" class="form-group">
											<div class="input-group">
												<select class="form-control form-txt-primary" id="service_end" required style="display:block">
													<option selected disabled value="">Choose day</option>
													@foreach($weekdays as $day)
													<option value="{{$day}}">{{$day}}</option>
													@endforeach
												</select>
												<span class="input-group-addon bg-default">
													<span class="icofont icofont-ui-calendar"></span>
												</span>
											</div>
										</div>
								</div>
								<div class="col-xs-12 col-md-6 mobile-inputs">
									<h4 class="sub-title">Submit</h4>
									<button style="background-color: #dd4b39;" id="create_service" class="btn btn-inverse">
										<i class="icofont icofont-exchange"></i>Create Service
									</button>
								</div>
							</div>
						</div>

						<div class="card-header">
							<h5 class="card-header-text">List Of Services</h5>
						</div>
						<div class="card-block">
							<div class="table-responsive">
								<table id="service" class="table table-striped table-bordered nowrap">
									<thead>
									</thead>
									<tbody>
									</tbody>
								</table>
							</div>
						</div>

					</div>

				</div>
			</div>
		</div>
</div>
@endsection

@section('script')
<script type="text/javascript">
  $(document).ready(function(){
		// get list of services
		var services = async (fn) => {
			$.ajax({url: "{{route('getService')}}"})
			.done((res) => {
				fn(res.services)
			})
		}
		//create service
		$('#create_service').click(function(){
			let $this = $(this)
			let name = $('#name');
			let sdate = $('#service_start');
			let edate = $('#service_end');
			//check empty fields
			if (name.val() === '') {
				swal("Oops", "Please input service name", "error");
				return ;
			}
			if (!sdate.val()  || !edate.val() ) {
				swal("Oops", "Please choose service days", "error");
				return ;
			}
			//process the form
			swal({
			  title: "Are you sure you want to the service?",
			  text: "...",
			  type: "warning",
			  buttons: true,
			  dangerMode: true,
			  showCancelButton: true,
			},function(){
				toggleAble($($this), true)
				let values = {'sdays': sdate.val(), 'edays': edate.val(), 'name': name.val(), '_token': '{{ csrf_token() }}'};
			  	$.ajax(
			  		{type: "POST", url: "{{route('service.create')}}", data: values, dataType: "json", encode: true}
			  	).done(function(response){
			  		if(response.status){
							toggleAble($($this), false)
      				swal("Success!", "Service Created", "success");
							serviceTable.ajax.reload(null, false);
							name.val('')
							sdate.val('')
							edate.val('')
			  		}else{
							toggleAble($($this), false)
			  			swal("Oops", ""+response.reason, "error");
			  		}
          		}).error(function(data) {
								toggleAble($($this), false)
								console.log(data.responseText);
			        swal("Oops", "Error occured! Error: "+data.statusText, "error");
			    });
			});
		});

		//counter
		counter("{{$active->event_edate}}");
		//time picker for create event
		$(function(){
   		$('.datetimepicker').datetimepicker({
				format: 'yyyy-mm-dd hh:00',
				autoclose: true,
				startDate: "{{NOW()}}",
				todayHighlight: true,
		    autoclose: true,
		    clearBtn: true,
        pick12HourFormat: false
	    });
		});

		//cretae eveent
  	// $('#dropper-default').dateDropper();
		$('#create').click(function(){
			let sdate = $('#start').val();
			let edate = $('#end').val();
			//validate on empty fields
			if (sdate === '' || edate === '') {
				swal("Oops", "Please choose event dates", "error");
				return ;
			}
			//validate on invalid dates
			if (new Date(sdate) > new Date(edate)) {
				swal("Oops", "End date must be greater than the start date", "error");
				return;
			}
			swal({
				title: "Are you sure you want to create the event?",
			  text: "Oncreation will remove active event",
				showSpinner: true,
				showLoaderOnConfirm: true,
				confirmButtonText: 'Create',
			  type: "warning",
			  buttons: true,
			  dangerMode: true,
				allowOutsideClick: false,
			  showCancelButton: true,
			},function(){
				let values = {'event_sdate': sdate, 'event_edate': edate, '_token': '{{ csrf_token() }}'};
				toggleAble('#create', true);
			  	$.ajax(
			  		{type: "POST", url: "{{route('event.create')}}", data: values, dataType: "json", encode: true}
			  	).done(function(response){
						toggleAble('#create', false);
			  		if(response.status){
      				swal("Success!", "Event Created", "success");
							$('#start').val(null)
							$('#end').val(null)
							eventTable.ajax.reload(null, false)
			  		}else{
			  			swal("Oops", ""+response.reason, "error");
			  		}
          		}).error(function(data) {
								toggleAble('#create', false);
								console.log(data.responseText);
			        swal("Oops", "Error occured! Error: "+data.statusText, "error");
			    });
			});
	 	});

		//service table
	  var serviceTable = $('#service').DataTable({
	    processing: true,
	    serverSide: true,
			oLanguage: {sProcessing: "<div id='loader'></div>"},
	    ajax: {
	      "url": "{{route('services.get')}}",
	      "type": "GET",
	      "data": {
	         "report": "1"
	      }
	    },
	    "columns": [
					{ title: "S/N", "data": "0" },
	      	{ title: "Service", "data": "1" },
	       	{ title: "Day start", "data": "2" },
	       	{ title: "Day end", "data": "3" },
	       	{ title: "Action", //"data": "4",
	         render : function( data, type, full, meta ) {
	           return `
						 <div class="tabledit-toolbar btn-toolbar" style="text-align: left;"><div class="btn-group btn-group-sm" style="float: none;">
							 <button type="button" class="tabledit-edit-button btn btn-primary waves-effect waves-light" style="float: none;margin: 5px;"><span class="icofont icofont-ui-edit"></span></button>
							 <button type="button" class="deleteBtn tabledit-delete-button btn btn-danger waves-effect waves-light" style="float: none;margin: 5px;"><span class="icofont icofont-ui-delete"></span></button>
						 </div>
						 `
	         }
	       },
	     ]
	  });

		//event table
	  var eventTable = $('#events').DataTable({
	    processing: true,
	    serverSide: true,
			oLanguage: {sProcessing: "<div class='text-center' id='loader'></div>"},
	    ajax: {
	      "url": "{{route('events.get')}}",
	      "type": "GET",
	      "data": {
	         "report": "1"
	      }
	    },
	    "columns": [
					{ title: "S/N", "data": "0" },
	      	{ title: "Start Date", "data": "1" },
	       	{ title: "End Date", "data": "2" },
	       	{ title: "Service Type", "data": "7",//<input type='hidden' value='7.id' />" },
						render : (data) => {
							return `<td>
							${data.name}
							<input id="" type='hidden' value='${data.id}' />
							</td>`
						},
					},
					{ title: "Active", //"data": "4",
						render : function( data, type, full, meta ) {
						 return `
						 <div class="tabledit-toolbar btn-toolbar" style="text-align: left;">
		 		 			<div class="btn-group btn-group-sm" style="float: none;">`+
							(data == '0' ? `
							 <button type="button" data-placement="up" title="Enable" class="event-toggle tabledit-edit-button btn btn-danger  waves-effect waves-light" style="float: none;margin: 5px;"><span class="icofont icofont-ui-close"></span></button>
							 `:`
							 <button type="button" data-placement="up" title="Disable" class="event-toggle deleteBtn tabledit-delete-button btn btn-success waves-effect waves-light" style="float: none;margin: 5px;"><span class="icofont icofont-ui-check"></span></button>
						 	`)+`</div>
						 </div>
						 `
					 	}
					},
	       	{ title: "Action", //"data": "4",
	         render : function( data, type, full, meta ) {
	           return `
						 <div class="tabledit-toolbar btn-toolbar" style="text-align: left;">
		 		 			<div class="btn-group btn-group-sm" style="float: none;">
							 <button type="button" class="tabledit-edit-button btn btn-primary waves-effect waves-light" style="float: none;margin: 5px;"><span class="icofont icofont-ui-edit"></span></button>
							 <button type="button" class="deleteBtn tabledit-delete-button btn btn-danger waves-effect waves-light" style="float: none;margin: 5px;"><span class="icofont icofont-ui-delete"></span></button>
						 	</div>
						 </div>
						 `
	         }
	       },
	     ]
	  });

		// delete table row
    $('#service').on( 'click', 'tbody tr td .deleteBtn', function (e) { //td:not(:first-child)
			id = $(this).parent().closest('tr').find('td').first().text()
			//confirm delete
			swal({
				title: "Are you sure",
				confirmButtonText: 'Delete',
				type: "warning",
				buttons: true,
				dangerMode: true,
				showCancelButton: true,
			},function(){
					//delete from server
					ajaxConnect("{{route('service.delete')}}", {'id': id, '_token': '{{ csrf_token() }}'}, serviceTable.ajax.reload)
			})
    });

		// serice edit table row
    $('#service').on( 'click', 'tbody tr td .tabledit-edit-button ', function (e) {
			id = $(this).parent().closest('tr').find('td').first().text()
			let i = 0;
			columns = $(this).parent().closest('tr').find('td').each(function(){
				if (i == 1) {
					$(this).html('<input value="'+$(this).text()+'" />')
				}else if (i == 2 || i == 3) {
					$(this).html(`<select class="days-select form-control form-txt-primary" id="" required style="display:block">
						<option selected value="`+$(this).text()+`">`+$(this).text()+`</option>
						<option value="Sundays">Sundays</option>
						<option value="Mondays">Mondays</option>
						<option value="Tuesdays">Tuesdays</option>
						<option value="Wednesdays">Wednesdays</option>
						<option value="Thursdays">Thursdays</option>
						<option value="Fridays">Fridays</option>
						<option value="Saturdays">Saturdays</option>
					</select>`)
				}else if (i == 4) {
						$(this).html(`
							<button type="button" class="tabledit-restore-button btn btn-sm btn-warning" style="float: left;">Cancel</button><div>
							<button type="button" class="tabledit-save-button btn btn-sm btn-success" style="float: right;">Save</button>
							`)
				}
				i++
			})
    });

		//service
		//for cancel
		$('#service').on( 'click', 'tbody tr td .tabledit-restore-button', function (e) {
			serviceTable.ajax.reload(null, false)
		})

		// service
		//for save
		$('#service').on( 'click', 'tbody tr td .tabledit-save-button', function (e) {
			let days = $(this).parent().closest('tr').find('td .days-select')
			let id = $($(this).parent().closest('tr').find('td')[0]).text()
			let name = $($(this).parent().closest('tr').find('td input')).val()
			let sdays = $(days[0]).val()
			let edays = $(days[1]).val()
			swal({
				title: "Are you sure",
				confirmButtonText: 'Save',
				type: "warning",
				buttons: true,
				dangerMode: true,
				showCancelButton: true,
			},function(){
				// update from server
				ajaxConnect("{{route('service.update')}}", {'id': id, 'sdays': sdays, 'edays': edays, 'name': name, '_token': '{{ csrf_token() }}'}, serviceTable.ajax.reload)
			})
		})

		//event
		// toggleEventActivity table
		$('#events').on( 'click', 'tbody tr td .event-toggle', function (e) {
			let id = $($(this).parent().closest('tr').find('td')[0]).text()
			toggleEventActivity(id, function(response){
				eventTable.ajax.reload(null, false)
			})
		})

		// delete event table row
    $('#events').on( 'click', 'tbody tr td .deleteBtn', function (e) { //td:not(:first-child)
			id = $(this).parent().closest('tr').find('td').first().text()
			//confirm delete
			swal({
				title: "Are you sure",
				confirmButtonText: 'Delete',
				type: "warning",
				buttons: true,
				dangerMode: true,
				showCancelButton: true,
			},function(){
					//delete from server
					ajaxConnect("{{route('event.delete')}}", {'id': id, '_token': '{{ csrf_token() }}'}, function(){
						eventTable.ajax.reload(null, false)
					})
			})
    });

		//disable event
		$('#disable-event').click(function(){
			let $this = $(this);
			let id = $('#event_id').val()
			var loadingText = '<i class="fa fa-circle-o-notch fa-spin"></i> loading...';
			if ($(this).html() !== loadingText) {
				$this.data('original-text', $(this).html());
				// $this.data('false-text', $this.text())
				$this.html(loadingText);
			}
			toggleEventActivity(id, function(response){
				console.log(response)
				$this.html($this.data('original-text'))
				if (response.state) {
					$this.text('Disable')
				}else{
					$this.text('Enable')
				}
				eventTable.ajax.reload(null, false )
			})
		})

		// event edit table row
		$('#events').on( 'click', 'tbody tr td .tabledit-edit-button ', async function (e) {
			let makeOption = (service) => {
				let value = []
				service.forEach((res) => {
					// '<option value="Sundays">Sundays</option>'
					value.push(`<option value="${res.id}">${res.name}</option>`)
				})
				return value
			}
			services((service) => {

				id = $(this).parent().closest('tr').find('td').first().text()
				let i = 0;
				columns = $(this).parent().closest('tr').find('td').each(function(){
					if (i == 1 || i == 2) {
						$(this).html(`<input id="" value="${$(this).text()}" class="form-control form-txt-primary datetimepicker" type="text" readonly="readonly">
						`)
					}else if (i == 3) {
						$(this).html(`<select class="service-select form-control form-txt-primary" id="" required style="display:block">
							<option selected value="`+$(this).find('input').val()+`">`+$(this).text()+`</option> ${makeOption(service)}
						</select>`)
					}else if (i == 4) {
						$(this).html(`
							${$(this).html()}
						`)
					}else if (i == 5) {
						$(this).html(`
							<button type="button" class="tabledit-restore-button btn btn-sm btn-warning" style="float: left;">Cancel</button><div>
							<button type="button" class="tabledit-save-button btn btn-sm btn-success" style="float: right;">Save</button>
						`)
					}
					i++
				})
			})
		});

		//events
		//for cancel
		$('#events').on( 'click', 'tbody tr td .tabledit-restore-button', function (e) {
			eventTable.ajax.reload(null, false)
		})

		// event
		//for save
		$('#events').on( 'click', 'tbody tr td .tabledit-save-button', function (e) {
			let service = $(this).parent().closest('tr').find('td .service-select').val()
			let id = $($(this).parent().closest('tr').find('td')[0]).text()
			let dates = $(this).parent().closest('tr').find('td .datetimepicker')
			let sdate = $(dates[0]).val()
			let edate = $(dates[1]).val()
			swal({
				title: "Are you sure",
				confirmButtonText: 'Save',
				type: "warning",
				buttons: true,
				dangerMode: true,
				showCancelButton: true,
			},function(){
				// update from server
				ajaxConnect("{{route('event.update')}}", {'id': id, 'service_id': service, 'event_sdate': sdate, 'event_edate': edate, '_token': '{{ csrf_token() }}'}, () => {
					eventTable.ajax.reload(null, false)
				})
			})
		})

 	});

	//disable event
	function toggleEventActivity(id, fn){
		ajaxConnect("{{route('event.able')}}", {'id': id, '_token': '{{ csrf_token() }}'}, false, fn)
	}

	function ajaxConnect(url, data, reloadcall, fn){
		// let status = 'false'
		$.ajax({
			type: "POST",
			url: url,
			data: data,
			dataType: "json", encode: true
		})
		.done(function(response){
			if(response.status){
				swal("Success!", "", "success");
				if (reloadcall) {
					reloadcall()
				}
			}else{
				swal("Oops", "Not successfull", "error");
			}
			if (typeof fn === "function") {
				fn(response)
			}else if(!fn){
				// fn()
			}else{
				fn(response)
			}
		})
		.error(function(error){
			swal("Oops", "Error occured", "error");
			return error;
		})
	}
</script>
@endsection

@section('jslink')
<!-- <script src="{{URL::asset('js/datedropper.min.js')}}"></script> -->
<script src="{{URL::asset('js/bootstrap-datetimepicker.min.js')}}"></script>
<script src="{{URL::asset('js/counter.js')}}"></script>
<!--  -->
<script src="{{URL::asset('js/jquery.dataTables.min.js')}}"></script>
<!-- <script src="https://cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js"></script> -->
<!-- <script src="https://cdn.datatables.net/buttons/1.5.4/js/dataTables.buttons.min.js"></script> -->
<!-- <script src="https://cdn.datatables.net/select/1.2.7/js/dataTables.select.min.js"></script> -->
<script src="{{URL::asset('js/dataTables.material.min.js')}}"></script>
<!-- <script src="https://cdn.datatables.net/1.10.19/js/dataTables.material.min.js"></script> -->
<!-- <script src="{{URL::asset('js/dataTables.editor.min.js')}}"></script> -->
@endsection
