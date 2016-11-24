@extends('layouts.app')

@section('htmlheader_title')
Home
@endsection


@section('main-content')

<div class="row">
	<div class="col-md-6">
		<div class="box box-success">
			<div class="box-header with-border">
				<h3 class="box-title">Promedio de Conexiones</h3>
				<div class="box-tools pull-right">
					<button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
					</button>
				</div>
			</div>
			<div class="box-body">
				<div class="row">
					<form class="form-inline col-md-12" id="prom_conex">
						<input type="hidden" name="_token" value="{{ csrf_token() }}">
						<div class="form-group">
							<label>Cliente</label>
							<select class="form-control input-sm cliente">
								<option value="0">Todos</option>
								@foreach($clientes as $cliente )
								<option value="{{$cliente->id_cliente}}"> {{$cliente->nombre}}</option>
								@endforeach
							</select>
						</div>
						<div class="row" style="margin-left: 0px; margin-right: 0px; padding-top: 10px; padding-bottom: 10px;">
							<div class="form-group"> <!-- Date input -->
								<label class="control-label" for="date">Desde</label>
								<input class="form-control" id="vdesde" name="vdesde" placeholder="MM/DD/YYY" type="text"/>
							</div>
							<div class="form-group"> <!-- Date input -->
								<label class="control-label" for="date">Hasta</label>
								<input class="form-control" id="vhasta" name="vhasta" placeholder="MM/DD/YYY" type="text"/>
							</div>
						</div>
						<button type="button" class="btn btn-success center-block prom_conex">Generar</button>
					</form>
				</div>
			</div>
			<div class="box-footer">
				<p id="conexiones" style="text-align: center;">Cantidad de Conexiones:</p>
				<div class="row" style="padding-top: 15px;">
					<div class="col-md-8" style="float: none; margin: 0 auto;">
						<div class="info-box bg-green" style="min-height: 70px;">
							<span class="info-box-icon" style="height: 70px; width: 70px; line-height: 70px"><i class="ion ion-network"></i></span>
							<div class="info-box-content" style="margin-left: 70px;">
								<span class="info-box-text">Promedio de Conexiones</span>
								<span class="info-box-number" id="conexprom" style="font-size: 28px;">0</span>
							</div>
							<!-- /.info-box-content -->
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	<div class="col-md-6">
		<div class="box box-warning">
			<div class="box-header with-border">
				<h3 class="box-title">Promedio de Registros</h3>
				<div class="box-tools pull-right">
					<button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
					</button>
				</div>
			</div>
			<div class="box-body">
				<div class="row">
					<form class="form-inline col-md-12" id="prom_regis">
						<input type="hidden" name="_token" value="{{ csrf_token() }}">
						<div class="form-group">
							<label>Cliente</label>
							<select class="form-control input-sm cliente">
								<option value="0">Todos</option>
								@foreach($clientes as $cliente )
								<option value="{{$cliente->id_cliente}}"> {{$cliente->nombre}}</option>
								@endforeach
							</select>
						</div>
						<div class="row" style="margin-left: 0px; margin-right: 0px; padding-top: 10px; padding-bottom: 10px;">
							<div class="form-group"> <!-- Date input -->
								<label class="control-label" for="date">Desde</label>
								<input class="form-control" id="vdesde" name="vdesde" placeholder="MM/DD/YYY" type="text"/>
							</div>
							<div class="form-group"> <!-- Date input -->
								<label class="control-label" for="date">Hasta</label>
								<input class="form-control" id="vhasta" name="vhasta" placeholder="MM/DD/YYY" type="text"/>
							</div>
						</div>
						<button type="button" id="dates" class="btn btn-warning center-block prom_regis">Generar</button>
					</form>
				</div>
			</div>
			<div class="box-footer">
				<p id="registros" style="text-align: center;">Cantidad de Registros:</p>
				<div class="row" style="padding-top: 15px;">
					<div class="col-md-8" style="float: none; margin: 0 auto;">
						<div class="info-box bg-yellow" style="min-height: 70px;">
							<span class="info-box-icon" style="height: 70px; width: 70px; line-height: 70px"><i class="ion ion-ios-personadd-outline"></i></span>

							<div class="info-box-content" style="margin-left: 70px;">
								<span class="info-box-text">Promedio de Registros</span>
								<span class="info-box-number" id="regisprom" style="font-size: 28px;">0</span>
							</div>
							<!-- /.info-box-content -->
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	<div class="col-md-6">
		<div class="box box-danger">
			<div class="box-header with-border">
				<h3 class="box-title">Cantidad de Visitantes Nuevos</h3>
				<div class="box-tools pull-right">
					<button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
					</button>
				</div>
			</div>
			<div class="box-body">
				<div class="row">
					<form class="form-inline col-md-12" id="cant_visi">
						<input type="hidden" name="_token" value="{{ csrf_token() }}">
						<div class="form-group">
							<label>Cliente</label>
							<select class="form-control input-sm cliente">
								<option value="0">Todos</option>
								@foreach($clientes as $cliente )
								<option value="{{$cliente->id_cliente}}"> {{$cliente->nombre}}</option>
								@endforeach
							</select>
						</div>
						<div class="row" style="margin-left: 0px; margin-right: 0px; padding-top: 10px; padding-bottom: 10px;">
							<div class="form-group"> <!-- Date input -->
								<label class="control-label" for="date">Desde</label>
								<input class="form-control" id="vdesde" name="vdesde" placeholder="MM/DD/YYY" type="text"/>
							</div>
							<div class="form-group"> <!-- Date input -->
								<label class="control-label" for="date">Hasta</label>
								<input class="form-control" id="vhasta" name="vhasta" placeholder="MM/DD/YYY" type="text"/>
							</div>
						</div>
						<button type="button" id="dates" class="btn btn-danger center-block cant_visi">Generar</button>
					</form>
				</div>
			</div>
			<div class="box-footer">
				<div class="row" style="padding-top: 15px;">
					<div class="col-md-8" style="float: none; margin: 0 auto;">
						<div class="info-box bg-red" style="min-height: 70px;">
							<span class="info-box-icon" style="height: 70px; width: 70px; line-height: 70px"><i class="ion ion-person-stalker"></i></span>

							<div class="info-box-content" style="margin-left: 70px;">
								<span class="info-box-text">Cantidad de Visitantes Nuevos</span>
								<span class="info-box-number" id="cantidadvisitantes" style="font-size: 28px;">0</span>
							</div>
							<!-- /.info-box-content -->
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	<div class="col-md-6">
		<div class="box box-info">
			<div class="box-header with-border">
				<h3 class="box-title">Cantidad de Usuarios Registrados</h3>
				<div class="box-tools pull-right">
					<button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
					</button>
				</div>
			</div>
			<div class="box-body">
				<div class="row">
					<form class="form-inline col-md-12" id="cant_user">
						<input type="hidden" name="_token" value="{{ csrf_token() }}">
						<div class="row" style="margin-left: 0px; margin-right: 0px; padding-top: 10px; padding-bottom: 10px;">
							<div class="form-group"> <!-- Date input -->
								<label class="control-label" for="date">Desde</label>
								<input class="form-control" id="vdesde" name="vdesde" placeholder="MM/DD/YYY" type="text"/>
							</div>
							<div class="form-group"> <!-- Date input -->
								<label class="control-label" for="date">Hasta</label>
								<input class="form-control" id="vhasta" name="vhasta" placeholder="MM/DD/YYY" type="text"/>
							</div>
						</div>
						<button type="button" id="dates" class="btn btn-info center-block cant_user">Generar</button>
					</form>
				</div>
			</div>
			<div class="box-footer">
				<div class="row" style="padding-top: 15px;">
					<div class="col-md-8" style="float: none; margin: 0 auto;">
						<div class="info-box bg-aqua" style="min-height: 70px;">
							<span class="info-box-icon" style="height: 70px; width: 70px; line-height: 70px"><i class="ion ion-person-add"></i></span>

							<div class="info-box-content" style="margin-left: 70px;">
								<span class="info-box-text">Cantidad de Usuarios Registrados</span>
								<span class="info-box-number" id="cantidadusuarios" style="font-size: 28px;">0</span>
							</div>
							<!-- /.info-box-content -->
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	<div class="col-md-12">
		<div class="box box-navy">
			<div class="box-header with-border">
				<h3 class="box-title">Conexiones Fraudulentas</h3>
				<div class="box-tools pull-right">
					<button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
					</button>
				</div>
			</div>
			<div class="box-body">
				<div class="row">
					<form class="form-inline col-md-12" id="conex_fraudu">
						<input type="hidden" name="_token" value="{{ csrf_token() }}">
						<div class="form-group">
							<label>Cliente</label>
							<select class="form-control input-sm cliente">
								<option value="0">Todos</option>
								@foreach($clientes as $cliente )
								<option value="{{$cliente->id_cliente}}"> {{$cliente->nombre}}</option>
								@endforeach
							</select>
						</div>
						<div class="form-group"> <!-- Date input -->
							<label class="control-label" for="date">Desde</label>
							<input class="form-control" id="vdesde" name="vdesde" placeholder="MM/DD/YYY" type="text"/>
						</div>
						<div class="form-group"> <!-- Date input -->
							<label class="control-label" for="date">Hasta</label>
							<input class="form-control" id="vhasta" name="vhasta" placeholder="MM/DD/YYY" type="text"/>
						</div>
						<button type="button" id="dates" class="btn btn-navy conex_fraudu">Generar</button>
					</form>
				</div>
			</div>
			<div class="box-footer">
				<div class="row" style="padding-top: 15px;">
					<div class="col-md-6" style="float: none; margin: 0 auto;">
						<div class="info-box bg-navy" style="min-height: 70px;">
							<span class="info-box-icon" style="height: 70px; width: 70px; line-height: 70px"><i class="ion ion-android-warning"></i></span>

							<div class="info-box-content" style="margin-left: 70px;">
								<span class="info-box-text">Conexiones Fraudulentas</span>
								<span class="info-box-number" id="conexfraudu" style="font-size: 28px;">0</span>
							</div>
							<!-- /.info-box-content -->
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>

<script>
    var vhasta=$('input[name="vhasta"]'); //our date input has the name "date"
    var vdesde=$('input[name="vdesde"]'); //our date input has the name "date"
    var container=$('.bootstrap-iso form').length>0 ? $('.bootstrap-iso form').parent() : "body";
    var options={
    	format: 'mm/dd/yyyy',
    	container: container,
    	todayHighlight: true,
    	autoclose: true,
    };
    vdesde.datepicker(options); //initiali110/26/2015 8:20:59 PM ze plugin
    vhasta.datepicker(options); //initiali110/26/2015 8:20:59 PM ze plugin
</script>

<script type="text/javascript">
	$.ajaxSetup({
		headers: {
			'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
		}
	});

	$(document).ready(function(){

	//FUnciones al abrir ventana
	var dataString = "cliente=0&desde=&hasta=";
	$.ajax({
		type: "get",
		url: "/conexionesprom",
		data: dataString,
		success: function(data){
			console.log(data[1]);
			$('#conexiones').html(data[1]);
			$('#conexprom').html(data[0]);
		}
	});
	$.ajax({
		type: "get",
		url: "/registroprom",
		data: dataString,
		success: function(data){
			$('#registros').html(data[1]);
			$('#regisprom').html(data[0]);
		}
	});
	$.ajax({
		type: "get",
		url: "/registroprom",
		data: dataString,
		success: function(data){
			$('#registros').html(data[1]);
			$('#regisprom').html(data[0]);
		}
	});
	$.ajax({
		type: "get",
		url: "/cantvisitantes",
		data: dataString,
		success: function(data){
			console.log(data);
			$('#cantidadvisitantes').text(data);
		}
	});
	$.ajax({
		type: "get",
		url: "/cantidadregistros",
		data: dataString,
		success: function(data){
			console.log(data);
			$('#cantidadusuarios').text(data);
		}
	});
	$.ajax({
		type: "get",
		url: "/conexfraudulentas",
		data: dataString,
		success: function(data){
			console.log(data);
			$('#conexfraudu').text(data);
		}
	});



	$(document).ajaxStart(function () {
		var current_effect = 'bounce';
		run_waitMe(current_effect);
	}).ajaxStop(function () {
		$("body").waitMe("hide");
	});

	$(".prom_conex").click(function(){

		var cliente = $( "#prom_conex .cliente option:selected" ).val();
		var vdesde = $("#prom_conex :input[name='vdesde']").val();
		var vhasta = $("#prom_conex :input[name='vhasta']").val();

		var dataString = "cliente="+cliente+"&desde="+vdesde+"&hasta="+vhasta;
		console.log(dataString);
		$.ajax({
			type: "get",
			url: "/conexionesprom",
			data: dataString,
			success: function(data){
				console.log('data: '+data);
				console.log(data[1]);
				$('#conexiones').html(data[1]);
				$('#conexprom').html(data[0]);
			}
		});

	});

	$(".prom_regis").click(function(){

		var cliente = $( "#prom_regis .cliente option:selected" ).val();
		var vdesde = $("#prom_regis :input[name='vdesde']").val();
		var vhasta = $("#prom_regis :input[name='vhasta']").val();

		var dataString = "cliente="+cliente+"&desde="+vdesde+"&hasta="+vhasta;

		$.ajax({
			type: "get",
			url: "/registroprom",
			data: dataString,
			success: function(data){
				console.log(data);
				$('#registros').html(data[1]);
				$('#regisprom').html(data[0]);
			}
		});

	});

	$(".cant_visi").click(function(){

		var cliente = $( "#cant_visi .cliente option:selected" ).val();
		var vdesde = $("#cant_visi :input[name='vdesde']").val();
		var vhasta = $("#cant_visi :input[name='vhasta']").val();

		var dataString = "cliente="+cliente+"&desde="+vdesde+"&hasta="+vhasta;

		$.ajax({
			type: "get",
			url: "/cantvisitantes",
			data: dataString,
			success: function(data){
				console.log(data);
				$('#cantidadvisitantes').text(data);
			}
		});

	});

	$(".cant_user").click(function(){

		var cliente = $( "#cant_user .cliente option:selected" ).val();
		var vdesde = $("#cant_user :input[name='vdesde']").val();
		var vhasta = $("#cant_user :input[name='vhasta']").val();

		var dataString = "cliente="+cliente+"&desde="+vdesde+"&hasta="+vhasta;

		$.ajax({
			type: "get",
			url: "/cantidadregistros",
			data: dataString,
			success: function(data){
				console.log(data);
				$('#cantidadusuarios').text(data);
			}
		});

	});

	$(".conex_fraudu").click(function(){

		var cliente = $( "#conex_fraudu .cliente option:selected" ).val();
		var vdesde = $("#conex_fraudu :input[name='vdesde']").val();
		var vhasta = $("#conex_fraudu :input[name='vhasta']").val();

		var dataString = "cliente="+cliente+"&desde="+vdesde+"&hasta="+vhasta;

		$.ajax({
			type: "get",
			url: "/conexfraudulentas",
			data: dataString,
			success: function(data){
				console.log(data);
				$('#conexfraudu').text(data);
			}
		});

	});

	function run_waitMe(effect){
		$("body").waitMe({

			//none, rotateplane, stretch, orbit, roundBounce, win8,
			//win8_linear, ios, facebook, rotation, timer, pulse,
			//progressBar, bouncePulse or img
			effect: 'bounce',

			//place text under the effect (string).
			text: 'Por favor no cierre ni actualice',

			//background for container (string).
			bg: 'rgba(0,0,0,.8)',

			//color for background animation and text (string).
			color: '#ffffff',

			//change width for elem animation (string).
			sizeW: '',

			//change height for elem animation (string).
			sizeH: '',

			// url to image
			source: '',

			// callback
			onClose: function() {
			}
		});
	};

});

</script>

@endsection
