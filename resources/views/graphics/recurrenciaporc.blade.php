@extends('layouts.app')

@section('htmlheader_title')
Porcentaje de Recurrencia
@endsection


@section('main-content')

<div class="row">
	<div class="col-md-12">
		<!-- AREA CHART -->
		<div class="box box-primary">
			<div class="box-header with-border">
				<i class="fa fa-line-chart"></i><h3 class="box-title">Porcentaje de Recurrencia <small> Los ultimos 6 meses</small></h3>
			</div>
			<div class="box-body">
				<div class="bootstrap-iso">
					<div class="row">
						<form class="form-inline col-md-12">
							<input type="hidden" name="_token" value="{{ csrf_token() }}">
						</form>
					</div>
				</div>	
				<div class="row">
					<div id="graphic1" class="col-md-12 center-block"></div>
				</div>

			</div>
			<!-- /.box-body -->
		</div>
		<!-- /.box -->
	</div>
</div>

<script type="text/javascript">
	$.ajaxSetup({
		headers: {
			'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
		}
	});

	$(document).ready(function(){
		
		$(function(){
			$('#menu-grafic').addClass('active');  
		});

		var dataString = "desde= &hasta=";

		$.ajax({
			type: "get",
			url: "/recurrenciaporc/get",
			data: dataString,
			success: function(data){
				console.log(data);
				var chart = {
					chart: {
						renderTo: 'graphic1',
						type: 'column'
					},
					title: {
						text: 'Porcentaje de Recurrecia <small>(ultimos 6 meses)</small>'
					},
					xAxis: {
						categories: [],
						labels: {
							style: {
								color: 'black',
								fontSize:'16px'
							}
						}
					},
					yAxis: {
						title: {
							text: '% de Recurrencia'
						}
					},
					plotOptions: {
						line: {
							dataLabels: {
								enabled: true
							},
							enableMouseTracking: false
						}
					},
					series: [{
						name: '% de Recurrencia',
						data: []
					}]
				};

				var series = [];
				var categories = [];

				var array = $.map(data, function(value, index) {
					[value];
				});
				var a = data.length;

				for(var i=0; i<a; i++){
					categories.push(data[i][1]);
					series.push(data[i][0]);
				};
				console.log('categorias');
				console.log(categories);
				console.log('series: ');
				console.log(series);

				chart.series[0].data = series;
				chart.xAxis.categories = categories;

				// console.log(chart);

				new Highcharts.Chart(chart);
			}
		});
		
	});
</script> <!-- your script -->
@endsection
