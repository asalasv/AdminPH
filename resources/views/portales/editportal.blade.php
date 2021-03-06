@extends('layouts.app')

@section('htmlheader_title')
Editar Portal
@endsection


@section('main-content')

<div class="row">
	<div class="col-md-12">
		<!-- AREA CHART -->
		<div class="box box-primary">
			<div class="box-body">
				<div class="box-header">
					<i class='fa fa-desktop'></i><h3 class="box-title">Actualizar Portal</h3>
				</div><!-- /.box-header -->
				<div class="box-body">
					<input type="hidden" name="_token" value="{{ csrf_token() }}">
					{!! Form::model ($portal, ['route'=> ['editportal', $portal], 'method' => 'put', 'class'=>'form-horizontal', 'files'=>true, 'enctype'=>'multipart/form-data', 'onsubmit' => 'return formulario(this)']) !!}
					<div class="row">
						<div class="col-xs-6">
							<label class="control-label" for="date">Descripcion o nombre del portal</label>
							<input type="text" class="form-control" name="descripcion" id="descripcion" placeholder="Nombre" value="{{$portal->descripcion}}"></input>
						</div>
						<div class="col-xs-3">
							<label class="control-label" for="date">Predeterminado</label>
							<div class="checkbox" style="margin-top: 0px;">
								<input type="hidden" id="id" value="{{$portal->id_portal_cliente}}"></input>
								@if($portal->predeterminado == "F")
								<label>
									<input type="checkbox" name="predeterminado" id="check"> Marcar si desea que este portal sea el predeterminado
								</label>
								@else
								<label>
									<input type="checkbox" name="predeterminado" id="check" checked="checked"> Marcar si desea que este portal sea el predeterminado
								</label>
								@endif
							</div>
						</div>
						<div class="col-xs-3">
							<label class="control-label" for="date">Horario Parcial</label>
							<div class="checkbox" style="margin-top: 0px;">
								<input type="hidden" id="id" value="{{$portal->horario_parcial}}"></input>
								@if($portal->horario_parcial == "F")
								<label>
									<input type="checkbox" name="horario_parcial" id="check1"> Seleccione si el horario del portal es parcial
								</label>
								@else
								<label>
									<input type="checkbox" name="horario_parcial" id="check1" checked="checked"> Seleccione si el horario del portal es parcial
								</label>
								@endif
							</div>
						</div>
					</div>
					<div class="bootstrap-iso">
						<div class="row" style="padding-top: 10px;">
							<div class="form col-xs-6"> <!-- Date input -->
								<label class="control-label" for="date"><i class="fa fa-calendar-check-o"></i>&nbsp;Fecha Inicio</label>
								<input class="form-control" id="fecha_inicio" name="fecha_inicio" placeholder="MM/DD/YYY" type="text" value="{{$portal->fecha_inicio}}" />
							</div>
							<div class="form col-xs-6"> <!-- Date input -->
								<label class="control-label" for="date"><i class="fa  fa-calendar-times-o"></i>&nbsp;Fecha Fin</label>
								<input class="form-control" id="fecha_fin" name="fecha_fin" placeholder="MM/DD/YYY" type="text" value="{{$portal->fecha_fin}}" />
							</div>

						</div>
					</div>
					<div class="row">
						<div class="form col-xs-6">
							<label class="control-label" for="date"><i class="fa fa-clock-o"></i>&nbsp;Hora Inicio</label>
							<input class="form-control"  name="hora_inicio" id="hora_inicio" value="{{$portal->hora_inicio}}" data-default="20:48">
						</div>
						<div class="form col-xs-6">
							<label class="control-label" for="date"><i class="fa fa-clock-o"></i>&nbsp;Hora Fin</label>
							<input class="form-control" name="hora_fin" id="hora_fin" value="{{$portal->hora_fin}}" data-default="20:48">
						</div>
					</div>
					<div class="row">
						<h4 style="padding-left: 15px; margin-top: 20px;"><i class="fa fa-file-image-o"></i>&nbsp;Imágenes</h4>
					</div>
					<div class="row ">
						<div class="col-xs-4">
							@if($portal->imagen_publicidad)
							<div class="panel-body">
								<img src='{{ asset("images/$portal->imagen_publicidad") }}'  style="height: 200px;" alt="..." class="img-rounded center-block img-responsive">
								<div class="form-group" style="padding-left: 15px; padding-top: 10px;">
									<label for="exampleInputFile">Cambiar Publicidad &nbsp;</label><small></small>
									<input type="file" class="input-file" id="imagen_publicidad" ext="jpg" name="imagen_publicidad" size="150">
								</div>
							</div>
							@else
							<div class="form-group" style="padding-left: 15px;">
								<label for="exampleInputFile">Imagen Publicidad &nbsp;</label><small></small>
								<input type="file" class="input-file" id="imagen_publicidad" ext="jpg" name="imagen_publicidad" size="150">
							</div>
							@endif
						</div>

						<div class="col-xs-4">
							@if($portal->imagen_logo)
							<div class="panel-body">
								<img src='{{ asset("images/$portal->imagen_logo") }}'  style="height: 200px;" alt="..." class="img-rounded center-block img-responsive">
								<div class="form-group" style="padding-left: 15px; padding-top: 10px;">
									<label for="exampleInputFile">Cambiar Logo &nbsp;</label><small></small>
									<input type="file" class="input-file" id="imagen_logo" name="imagen_logo" ext="png" size="100">
								</div>
							</div>
							@else
							<div class="form-group">
								<label for="exampleInputFile">Logo Local &nbsp;</label><small></small>
								<input type="file" class="input-file" id="imagen_logo" name="imagen_logo" ext="png" size="100">
							</div>
							@endif

						</div>

						<div class="col-xs-4">
							@if($portal->imagen_fondo)
							<div class="panel-body">
								<img src='{{ asset("images/$portal->imagen_fondo") }}'  style="height: 200px;" alt="..." class="img-rounded center-block img-responsive">
								<div class="form-group" style="padding-left: 15px; padding-top: 10px;">
									<label for="exampleInputFile">Cambiar fondo &nbsp;</label><small></small>
									<input type="file" class="input-file" id="imagen_fondo" name="imagen_fondo" ext="jpg" size="60">
								</div>
							</div>
							@else
							<div class="form-group">
								<label for="exampleInputFile">Imagen Fondo &nbsp;</label><small></small>
								<input type="file" class="input-file" id="imagen_fondo" name="imagen_fondo" ext="jpg" size="60">
							</div>
							@endif
						</div>
					</div>
				</div>
			</div>
			<div class="modal-footer">
				<button type="submit" class="btn btn-primary" id="actualizar">Actualizar Portal</button>
			</div>
			{!! Form::close()!!}

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

var hora_inicio = $('#hora_inicio');
hora_inicio.clockpicker({
	autoclose: true
});
var hora_fin = $('#hora_fin');
hora_fin.clockpicker({
	autoclose: true
});

var vhasta=$('input[name="fecha_fin"]'); //our date input has the name "date"
var vdesde=$('input[name="fecha_inicio"]'); //our date input has the name "date"
var container=$('.bootstrap-iso form').length>0 ? $('.bootstrap-iso form').parent() : "body";
var options={
	format: 'yyyy/mm/dd',
	container: container,
	todayHighlight: true,
	autoclose: true,
};
vdesde.datepicker(options); //initiali110/26/2015 8:20:59 PM ze plugin
vhasta.datepicker(options); //initiali110/26/2015 8:20:59 PM ze plugin

$(document).ready(function(){

	window.URL = window.URL || window.webkitURL;

	/* Valida el tamaño maximo y formato de un archivo adjunto */
	$('.input-file').change(function (){
		var file = this.files[0];
		var filename = file.name;

		// var img = new Image();

		//    img.src = window.URL.createObjectURL( file );

		//    img.onload = function() {
		//        var width = img.naturalWidth,
		//            height = img.naturalHeight;

		//        window.URL.revokeObjectURL( img.src );

		//        alert('width: ' + width + ', height: '+ height);

		//        if( width == 400 && height == 300 ) {

		//        }
		//        else {

		//        }
		//    };


		var extension = filename.substr( (filename.lastIndexOf('.') +1) );

		if ( extension === 'jpg' || extension === 'jpeg' || extension === 'png' || extension === 'gif' || extension === 'mov'){

			// if($(this).attr('ext') == extension){
			// var sizeByte = this.files[0].size;

			// var siezekiloByte = parseInt(sizeByte / 1024);

			// if(siezekiloByte > $(this).attr('size')){
			// 	alert('El tamaño supera el limite permitido ('+$(this).attr('size')+' Kb)');
			// 	$(this).val('');
			// }
		}else{
			// alert("El formato para '"+$(this).attr('name')+"' debe ser '"+$(this).attr('ext')+"'");
			// $(this).val('');
			alert("Los formato para '"+$(this).attr('name')+"' pertmitido son (jpg, jpeg, png, gif o mov)");
			$(this).val('');
		}


	});

	var predeterminado;

	if ($('#check').is(':checked') == true){
		$('#fecha_inicio').prop('disabled', true);
		$('#fecha_fin').prop('disabled', true);
		$('#hora_inicio').prop('disabled', true);
		$('#hora_fin').prop('disabled', true);
		predeterminado = true;
		console.log('checked');
	} else {
		$('#fecha_inicio').prop('disabled', false);
		$('#fecha_fin').prop('disabled', false);
		$('#hora_inicio').prop('disabled', false);
		$('#hora_fin').prop('disabled', false);
		console.log('unchecked');
		predeterminado = false;
	}

	$('#check').change(function(){
		if ($('#check').is(':checked') == true){
			$('#fecha_inicio').prop('disabled', true);
			$('#fecha_fin').prop('disabled', true);
			$('#hora_inicio').prop('disabled', true);
			$('#hora_fin').prop('disabled', true);
			predeterminado = true;
			console.log('checked');
		} else {
			$('#fecha_inicio').prop('disabled', false);
			$('#fecha_fin').prop('disabled', false);
			$('#hora_inicio').prop('disabled', false);
			$('#hora_fin').prop('disabled', false);
			console.log('unchecked');
			predeterminado = false;
		}
	});

	$("#actualizar").click(function(){
		// alert('Su portal ha sido actualizado con éxito!');
	});

});


function formulario(f) {

	if($('#check').is(':checked') == false){

		var vid= $("#id").val();

		$.ajax({
			type: "get",
			url: "/predeterminado",
			data: "",
			success: function(data){
				console.log(data);
				if(data == vid){
					alert ('Actualmente este es el portal predeterminado, no lo puede quitar, al menos que cree otro portal predeterminado');
					return false;
				}
			}
		});

		if(f.fecha_inicio.value == '0000-00-00' || f.fecha_fin.value == '0000-00-00' ||
		f.fecha_inicio.value == '' || f.fecha_fin.value == ''){
			alert ('Ningun campo fecha puede ser 0000-00-00 o vacio');
			f.fecha_inicio.focus();
			f.fecha_fin.focus();
			return false;
		}

		//COMPARACION DE QUE LA FECHA FIN NO SEA MENOR A LA FECHA INICIO
		var fecha1 = f.fecha_inicio.value.replace(/-/g , "/");
		var fecha2 = f.fecha_fin.value.replace(/-/g , "/");

		//Comparamos las fechas
		if (Date.parse(fecha1) > Date.parse(fecha2)){
			alert ('La fecha fin debe ser mayor y al menos 1 hora dsps que la fecha inicio');
			f.fecha_fin.focus();
			return false;
		}

		var date = new Date();
		var month = date.getMonth()+1;
		var day = date.getDate();

		var now = date.getFullYear() + '/' +
		((''+month).length<2 ? '0' : '') + month + '/' +
		((''+day).length<2 ? '0' : '') + day;

		if(Date.parse(fecha1) < Date.parse(now)){
			alert ('La fecha inicio tiene que ser mayor a hoy');
			f.fecha_inicio.focus();
			return false;
		}

		if(fecha1 == now){
			var dt = new Date();
			var time = dt.getHours() + ":" + dt.getMinutes() + ":" + dt.getSeconds();

			var inicio = f.hora_inicio.value.split(':');
			var fin = time.split(':');
			var hrsinicio = parseInt(inicio[0]);
			var hrsfin = parseInt(fin[0]);
			var minutosinicio = parseInt(inicio[1]);
			var minutosfin = parseInt(fin[1]);

			var begin = (hrsinicio*60) + minutosinicio;
			var end = (hrsfin*60) + minutosfin;

			if(begin < end){
				alert ('La hora de inicio tiene que ser mayor a la hora actual ('+time+')');
				f.hora_inicio.focus();
				return false;
			}
		}


		if(f.fecha_inicio.value == f.fecha_fin.value){
			var inicio = f.hora_inicio.value.split(':');
			var fin = f.hora_fin.value.split(':');
			var hrsinicio = parseInt(inicio[0]);
			var hrsfin = parseInt(fin[0]);
			var minutosinicio = parseInt(inicio[1]);
			var minutosfin = parseInt(fin[1]);

			var begin = (hrsinicio*60) + minutosinicio;
			var end = (hrsfin*60) + minutosfin;

			var diff = end - begin;

			if(diff < 60){
				alert ('El portal debe tener una duracion de almenos 1 hora');
				f.hora_fin.focus();
				return false;
			}
		}

		if(f.fecha_inicio.value == '0000-00-00' || f.fecha_fin.value == '0000-00-00'){
			alert ('Ningun campo fecha puede ser 0000-00-00');
			f.fecha_inicio.focus();
			f.fecha_fin.focus();
			return false;
		}


	}
	if (f.descripcion.value   == '') {
		alert ('El campo descripcion/nombre esta vacío');
		f.descripcion.focus();
		return false;
	}else{
		var current_effect = 'bounce'; //
		run_waitMe(current_effect);

	}
}

function run_waitMe(effect){
	$("body").waitMe({

		//none, rotateplane, stretch, orbit, roundBounce, win8,
		//win8_linear, ios, facebook, rotation, timer, pulse,
		//progressBar, bouncePulse or img
		effect: 'bounce',

		//place text under the effect (string).
		text: 'Actualizando Portal, Por favor no cierre ni actualice.',

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
			alert('Su portal ha sido actualizado con éxito!');
		}

	});
};

</script>

@endsection
