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
				<i class="fa fa-line-chart"></i><h3 class="box-title">Dispositivos mas conectados</h3>
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

		var vdesde= $("#vdesde").val();
		var vhasta= $("#vhasta").val();

		var dataString = "desde="+vdesde+"&hasta="+vhasta;

		$.ajax({
			type: "GET",
			url: "/dispmasconect/get",
			data: dataString,
			success: function(data){
				console.log(data);
				var chart = {
				 	chart: {
			            plotBackgroundColor: null,
			            plotBorderWidth: null,
			            plotShadow: true,
			            renderTo: 'graphic1',
			            type: 'pie'
			        },
			        title: {
			            text: 'Marcas de Dispositivos conectados al portal'
			        },
			        tooltip: {
			            pointFormat: '{series.name}: <b>{point.percentage:.1f}%</b>'
			        },
			        plotOptions: {
			            pie: {
			                allowPointSelect: true,
			                cursor: 'pointer',
			                dataLabels: {
			                    enabled: true,
			                    format: '<b>{point.name}</b>: {point.percentage:.1f} %',
			                    style: {
			                        color: (Highcharts.theme && Highcharts.theme.contrastTextColor) || 'black'
			                    }
			                }
			            }
			        },
			        series: [{
			            name: 'Uso',
			            colorByPoint: true,
			            data: []
		            }]
				};

				var data1 = [];

				for (i in data){
					data1.push({
						"name" 	: data[i][0],
						"y" 	: data[i][1]
					});
				}
				console.log(data1);

				chart.series[0].data = data1;

				new Highcharts.Chart(chart);
			}
		});

	});
</script> <!-- your script -->
@endsection
