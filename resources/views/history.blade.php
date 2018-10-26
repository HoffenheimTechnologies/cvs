@extends('layouts.app')

@section('content')
<?php
$dataPoints = array(
array("label"=> "Ignored", "y"=> $attendance->event - $attendance->no - $attendance->yes),
array("label"=> "No", "y"=> $attendance->no),
array("label"=> "Yes", "y"=> $attendance->yes),
);
?>
<div class="container segments-page">
<div id="chartContainer" style="height: 370px; width: 100%;"></div>
	<div class="page-header">
		<div class="page-header-title">
			<h4>History</h4>
		</div>
	</div>
	<div class="row">
		<div class="col-xs-4 col-xl-4">
			<div class="row">
				<div class="col-12 m-b-30">
					<div class="chart-stat-card-1">
						<div class="col-6 chart-stat-cont card-block text-center">
							<h6 class="m-t-5">Yes</h6>
							<span>{{$attendance->yes}}</span>
						</div>
						<div class="col-6 chart-stat-graph card-block text-center">
							<span class="resource-barchart1"><canvas width="116" height="70" style="display: inline-block; width: 116px; height: 70px; vertical-align: top; margin-bottom: -2px; margin-left: -2px;"></canvas></span>
						</div>
					</div>
				</div>
			</div>
		</div>

		<div class="col-xs-4 col-xl-4">
			<div class="row">
				<div class="col-12 m-b-30">
					<div class="chart-stat-card-2">
						<div class="col-6 chart-stat-cont card-block text-center">
							<h6 class="m-t-5">No</h6>
							<span>{{$attendance->no}}</span>
						</div>
					<div class="col-6 chart-stat-graph card-block text-center">
						<span class="resource-barchart2"><canvas width="116" height="70" style="display: inline-block; width: 116px; height: 70px; vertical-align: top; margin-bottom: -2px; margin-left: -2px;"></canvas></span>
						</div>
					</div>
				</div>
			</div>
		</div>

		<div class="col-xs-4 col-xl-4">
			<div class="row">
				<div class="col-12 m-b-30">
					<div class="chart-stat-card-3">
						<div class="col-6 chart-stat-cont card-block text-center">
							<h6 class="m-t-5">Ignored</h6>
							<span>{{$attendance->event - $attendance->no - $attendance->yes}}</span>
						</div>
						<div class="col-6 chart-stat-graph card-block text-center">
							<span class="resource-barchart3"><canvas width="116" height="70" style="display: inline-block; width: 116px; height: 70px; vertical-align: top; margin-bottom: -2px; margin-left: -2px;"></canvas></span>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
@endsection

@section('script')
<script>
window.onload = function () {

var chart = new CanvasJS.Chart("chartContainer", {
	animationEnabled: true,
	exportEnabled: true,
	title:{
		text: "Overall Attendance"
	},
	subtitles: [{
		text: ""
	}],
	data: [{
		type: "pie",
		showInLegend: "true",
		legendText: "{label}",
		indexLabelFontSize: 16,
		indexLabel: "{label} - #percent%",
		// yValueFormatString: "฿#,##0",
		dataPoints: <?php echo json_encode($dataPoints, JSON_NUMERIC_CHECK); ?>
	}]
});
chart.render();

}
</script>
@endsection
