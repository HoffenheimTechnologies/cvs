@extends('layouts.app')

@section('content')
<div class="container segments-page">

</div>
<div class="container">
	<div class="row">
		<div class="row">
			<div class="col-sm-4 col-xl-4">
				<div class="card counter-card-1">
					<div class="card-block-big">
						<div class="row">
							<div class="col-6 counter-card-icon">
								<i class="icofont icofont-chart-histogram"></i>
							</div>
							<div class="col-6  text-right">
								<div class="counter-card-text">
									<h3>23%</h3>
									<p>Attending</p>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>

			<div class="col-sm-4 col-xl-4">
				<div class="card counter-card-2">
					<div class="card-block-big">
						<div class="row">
							<div class="col-6 counter-card-icon">
								<i class="icofont icofont-chart-line-alt"></i>
							</div>
							<div class="col-6 text-right">
								<div class="counter-card-text">
									<h3>15%</h3>
									<p>Missing</p>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>

			<div class="col-sm-4 col-xl-4">
				<div class="card counter-card-3">
					<div class="card-block-big">
						<div class="row">
							<div class="col-6 counter-card-icon">
								<i class="icofont icofont-chart-line"></i>
							</div>
							<div class="col-6 text-right">
								<div class="counter-card-text">
									<h3>35%</h3>
									<p>Ignoring</p>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>

		<div class="col-lg-12 col-xl-12">
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
						<div class="col-md-3 col-xs-12 m-b-20">
							<div class="card-sub">
								<div class="card-block">
									<h4 class="card-title">{{date('l jS \of F Y', strtotime($active->event_date))}}</h4>
									<!-- <div class="col-6 counter-card-icon card-block-big">
										<i class="icofont icofont-chart-line"></i>
									</div> -->
								</div>
							</div>
						</div>
					<!-- <div class="col-md-3 col-xs-6">
						<div class="card-sub">
							<div class="card-block">
								<h4 class="card-title">Yes</h4>
								<p class="card-text">Some quick example text to build on the card title and make up the bulk of the card's content.</p>
							</div>
						</div>
					</div>
					<div class="col-md-3 col-xs-6">
						<div class="card-sub">
							<div class="card-block">
								<h4 class="card-title">No</h4>
								<p class="card-text">Some quick example text to build on the card title and make up the bulk of the card's content.</p>
							</div>
						</div>
					</div>
					<div class="col-md-3 col-xs-12">
						<div class="card-sub">
							<div class="card-block">
								<h4 class="card-title">Yet to respond</h4>
								<p class="card-text">Some quick example text to build on the card title and make up the bulk of the card's content.</p>
							</div>
						</div>
					</div> -->
					</div>
				</div>
			</div>
		</div>

		<div class="page-header">
			<div class="page-header-title">
				<h4>Create Event</h4>
			</div>
		</div>


		<div class="page-body">
			<div class="row">
				<div class="col-sm-12">

					<div class="card">
						<div class="card-block">

							<div class="row">
								<div class="col-xs-6 mobile-inputs">
									<h4 class="sub-title">Event Date</h4>
									<form>
										<div class="form-group">
											<input id="dropper-default" class="form-control form-txt-primary" type="text" placeholder="Select your event date" readonly="readonly">
										</div>
									</form>
								</div>
								<div class="col-xs-6 mobile-inputs">
									<h4 class="sub-title">Submit</h4>
									<button style="background-color: #dd4b39;" id="create" class="btn btn-inverse">
										<i class="icofont icofont-exchange"></i>Create event
									</button>
								</div>
							</div>
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

  	$('#dropper-default').dateDropper();
		$('#create').click(function(){
			if ($('#dropper-default').val() === '') {
				swal("Oops", "Please choose event date", "error");
				return ;
			}
			swal({
			  title: "Are you sure you want to create the event?",
			  text: "Oncreation will remove active event",
			  type: "warning",
			  buttons: true,
			  dangerMode: true,
			  showCancelButton: true,
			},function(){
				let event_date = $('#dropper-default').val();
				let values = {'event_date': event_date, '_token': '{{ csrf_token() }}'};
			  	$.ajax(
			  		{type: "POST", url: "{{route('event.create')}}", data: values, dataType: "json", encode: true}
			  	).done(function(response){
			  		if(response.status){
          				swal("Success!", "Event Created", "success");
			  		}else{
			  			swal("Oops", ""+response.reason, "error");
			  		}
          		}).error(function(data) {
								console.log(data.responseText);
			        swal("Oops", "Error occured! Error: "+data.statusText, "error");
			    });
			});
	 	});
 	});
</script>
@endsection

@section('jslink')
<script src="{{URL::asset('js/datedropper.min.js')}}"></script>
@endsection
