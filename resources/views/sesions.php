@extends('layouts.app')

@section('htmlheader_title')
Home
@endsection


@section('main-content')

<div class="row">
	<input type="hidden" name="_token" value="{{ csrf_token() }}">
	<div class="col-md-12">
		<!-- AREA CHART -->
		<div class="box box-primary">
			<div class="box-body">
				<div class="box-header">
					<i class='fa fa-desktop'></i><h3 class="box-title">Sesiones</h3>
				</div><!-- /.box-header -->
				<div class="box-body table-responsive no-padding">
					<input type="hidden" name="_token" value="{{ csrf_token() }}">
					<table class="table table-hover">
						<thead>
							<tr>
								<th>Ip</th>
								<th>Usuario</th>
								<th>Mac</th>
								<th>Tipo</th>
								<th>Navegador</th>
								<th></th>
							</tr>
						</thead>
						@foreach($sesiones as $sesion)
						<?php $var = '0'; ?>
						<tr data-sesion ="{{ $sesion->sesion}}"" data-mac ="{{ $sesion->mac}}">
							<td>{{$sesion->ip}}</td>
							<td>{{$sesion->usuario}}</td>
							<td>{{$sesion->mac}}</td>
							@foreach($acti_portales as $acti)
								@if($var == '0')
									@if($sesion->mac == $acti->mac)
									<?php $var = '1'; ?>
										<td>{{$acti->resumen}}</td>
										<td>{{$acti->navegador}}</td>
									@endif
								@endif
							@endforeach
							@if($var == '0')
									<td></td>
									<td></td>
							@endif
							<td><a href="#" class="btn-delete btn-desconectar"><i class="fa fa-fw fa-close"></i></i>Desconectar</a></td>
							<?php $mm = '0'; ?>
							@foreach($man_mac as $mac)
								@if($mac->mac == $sesion->mac and $mac->id_equipo == $cliente->id_equipo)
									<?php $mm = '1'; ?>
									@if($mac->action == 'block')
									<td><a href="#" data-orden="{{ $mac->orden}}" class="btn-delete btn-desblock"><i class="fa fa-check"></i></i>Desbloquear</a></td>
									@else
									<td><a href="#" data-toggle="modal" data-sesion ="{{ $sesion->sesion}}"" data-mac ="{{ $sesion->mac}}" data-target="#descripcion" class="btn-delete block"><i class="fa fa-fw fa-times-circle"></i></i>Bloquear</a></td>
									@endif
								@endif
							@endforeach
							@if($mm == '0')
								<td><a href="#" data-toggle="modal" data-sesion ="{{ $sesion->sesion}}"" data-mac ="{{ $sesion->mac}}" data-target="#descripcion" class="btn-delete block"><i class="fa fa-fw fa-times-circle"></i></i>Bloquear</a></td>
							@endif
						</tr>
						@endforeach
					</table>
				</div>
				<!-- /.box-body -->
			</div>
			<!-- /.box -->
	</div>
</div>
	<!-- Modal Agregar Descripcion-->
		<div class="modal fade" id="descripcion" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
			<div class="modal-dialog" role="document">
				<div class="modal-content">
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
						<h4 class="modal-title" id="myModalLabel">Descripción</h4>
					</div>
					<div class="modal-body">
					<div class="row">
						<div class="col-xs-12">
							<label class="control-label" for="date">Agregar descripción del bloqueo</label>
							<input type="text" class="form-control" name="descr" id="descr" placeholder="Descripción">
							<input type="hidden" id="mac" name="mac" >
							<input type="hidden" id="sesion" name="sesion">
						</div>
					</div>
					</div>
					<div class="modal-footer">
						<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
						<button type="button" class="btn btn-primary BlockSession" id="btn-add">Bloquear</button>
					</div>
				</div>
			</div>
		</div>

	{!! Form::open(['route' => ['desconectar', ':sesion'], 'method' =>'post', 'id' => 'form-desconectar']) !!}
	{!!Form::close() !!}

	{!! Form::open(['route' => ['bloquear', ':mac', ':sesion', ':descr'], 'method' =>'post', 'id' => 'form-bloquear']) !!}
	{!!Form::close() !!}

	{!! Form::open(['route' => ['desblock', ':mac', ':orden'], 'method' =>'post', 'id' => 'form-desblock']) !!}
	{!!Form::close() !!}

	{!! Form::open(['route' => ['habilitar', ':mac'], 'method' =>'post', 'id' => 'form-habilitar']) !!}
	{!!Form::close() !!}

	<script type="text/javascript">
		$.ajaxSetup({
			headers: {
				'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
			}
		});
		$(document).ready(function(){

			$(document).on("click", ".block", function () {
			     var sesion = $(this).data('sesion');
			     var mac = $(this).data('mac');
			     $(".modal-body #mac").val( mac );
			     $(".modal-body #sesion").val( sesion );
			});

			$(function(){
				$('#menu-sesiones').addClass('active');  
			});

			$('#descripcion').on('hidden.bs.modal', function (e) {
				$(this)
				.find("input")
				.val('')
				.end()
			});

			$(document).ajaxStart(function () {
				var current_effect = 'bounce'; 
				run_waitMe(current_effect);
		    }).ajaxStop(function () {

		    });

			setTimeout(function(){
			  window.location.reload();
			}, 60000);

			$('.btn-desconectar').click(function(){

				var row = $(this).parents('tr');
				var sesion = row.data('sesion');

				var form = $('#form-desconectar');
				var url = form.attr('action').replace(':sesion',sesion);
				var data = form.serialize();

				if(confirm('¿Está seguro que desea desconectar esta sesion?')){
					$.ajax({
						type: 'post',
						url: url,
						data: data,
						success: function(data){
							//console.log(data);
							window.location.reload();
						}
					});	
				}
				
			});

			$('.BlockSession').click(function(){

				var row = $(this).parents('tr');
				var mac =  $('#mac').val()
				var sesion =  $('#sesion').val();

				var form = $('#form-bloquear');
				var url = form.attr('action').replace(':mac',mac);
				var url = url.replace(':sesion', sesion);

				if($('#descr').val() == "")
					var url = url.replace(':descr', 'Vacio');
				else
					var url = url.replace(':descr', $('#descr').val());

				var data = form.serialize();

				if(confirm('¿Está seguro que desea bloquear esta mac?')){
					$.ajax({
						type: 'post',
						url: url,
						data: data,
						success: function(data){
							console.log(data);
							window.location.reload();
						}
					});	
				}
			});

			$('.btn-habilitar').click(function(){

				var row = $(this).parents('tr');
				var mac = row.data('mac');

				var form = $('#form-habilitar');
				var url = form.attr('action').replace(':mac',mac);
				var data = form.serialize();

				if(confirm('¿Está seguro que desea habilitar esta mac?')){
					$.ajax({
						type: 'post',
						url: url,
						data: data,
						success: function(data){
							//console.log(data);
							window.location.reload();
						}
					});	
				}
				
			});


			$('.btn-desblock').click(function(){

				var row = $(this).parents('tr');
				var mac = row.data('mac');
				var orden = $(this).data('orden');

				console.log('mac: '+mac);
				console.log('orden: '+orden);

				var form = $('#form-desblock');
				var url = form.attr('action').replace(':mac',mac);
				var url = url.replace(':orden', orden);
				var data = form.serialize();

				if(confirm('¿Está seguro que desea desbloquear esta mac?')){
					$.ajax({
						type: 'post',
						url: url,
						data: data,
						success: function(data){
							//console.log(data);
							window.location.reload();
						}
					});	
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
			text: 'Por favor no cierre',

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
