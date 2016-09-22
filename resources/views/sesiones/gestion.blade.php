@extends('layouts.app')

@section('htmlheader_title')
Home
@endsection


@section('main-content')

<div class="row">
	<div class="col-md-12">
		<div class="box box-primary">
			<div class="box-body">
				<div class="box-header">
					<i class='fa fa-eye'></i><h3 class="box-title">Gestion de dispositivos</h3>
					<div class="box-tools">
						<div class="input-group" style="width: 50px;">
							<!-- Button trigger modal -->
                            <button data-toggle="modal" data-target="#macblock" class="btn btn-primary btn-sm">Mac Especifica</button>
						</div>
					</div>
				</div><!-- /.box-header -->
				<div class="box-body table-responsive no-padding">
				<input type="hidden" id="vivo" name="vivo" value="{{$vivo}}">
					<input type="hidden" name="_token" value="{{ csrf_token() }}">
					<table class="table table-hover">
						<thead>
							<tr>
								<th>Mac</th>
								<th>Descripcion</th>
								<th>Status</th>
								<th></th>
								<th></th>
							</tr>
						</thead>
						@foreach($macs as $mac)
						<tr data-mac="{{$mac->mac}}" data-name ="">
							<td>{{$mac->mac}}</td>
							<td>{{$mac->descr}}</td>
							@if($mac->action == 'block')
								<td><span class="label label-danger">block</span></td>
								<td><a href="#" data-toggle="modal" data-mac ="{{ $mac->mac}}" data-orden ="{{ $mac->orden}}" data-target="#descripcion" class="btn-delete option desblock"><i class="fa fa-fw fa-times-circle"></i></i>Habilitar</a></td>

							@else
								<td><span class="label label-primary">pass</span></td>
								<td><a href="#" data-toggle="modal" data-mac ="{{ $mac->mac}}" data-orden ="{{ $mac->orden}}" data-target="#descripcion" class="btn-delete option block"><i class="fa fa-fw fa-times-circle"></i></i>Bloquear</a></td>
							@endif
							<td><a href="#" data-orden="{{ $mac->orden}}" class="btn-delete btn-desblock"><i class="fa fa-times"></i></i>&nbsp;Eliminar</a></td>
						</tr>
						@endforeach
					</table>
				</div>
				<!-- /.box-body -->
			</div>
			<!-- /.box -->
		</div>
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
					<label class="control-label" for="date" id="msj"></label>
					<input type="text" class="form-control" name="descr" id="descr" placeholder="Descripción">
					<input type="hidden" id="mac" name="mac" >
					<input type="hidden" id="orden" name="orden">
				</div>
			</div>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
				<button type="button" class="btn btn-primary action" id="">Bloquear</button>
			</div>
		</div>
	</div>
</div>

<!-- Modal Agregar Descripcion-->
<div class="modal fade" id="macblock" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				<h4 class="modal-title" id="myModalLabel">Bloqueao de Mac especifica</h4>
			</div>
			<div class="modal-body">
			<div class="row">
				<div class="col-xs-12">
					<label class="control-label">Por favor ingrese mac</label>
					<input type="text" class="form-control" name="mac1" id="mac1" placeholder="00:00:00:00:00:00">
				</div>
			</div>
			<div class="row" style="padding-top: 10px;">
				<div class="col-xs-12">
					<label class="control-label">Descripcion</label>
					<input type="text" class="form-control" name="descr1" id="descr1" placeholder="Descripción">
				</div>
			</div>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-danger" id="action2">Bloquear</button>
				<button type="button" class="btn btn-success" id="action3">Habilitar</button>
				<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
			</div>
		</div>
	</div>
</div>
	{!! Form::open(['route' => ['bloqueodesbloqueo', ':mac', ':act', ':descr'], 'method' =>'post', 'id' => 'form-bloqueodesbloqueo']) !!}
	{!!Form::close() !!}

	{!! Form::open(['route' => ['desblock', ':mac', ':orden'], 'method' =>'post', 'id' => 'form-desblock']) !!}
	{!!Form::close() !!}

<script type="text/javascript">
	$.ajaxSetup({
		headers: {
			'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
		}
	});

	$(document).ready(function(){

		if($('#vivo').val() == '0')
			alert(' Parece que el cliente remoto no posee internet en estos momentos... Por favor intente mas tarde.');

		$(document).ajaxStart(function () {
			var current_effect = 'bounce'; 
			run_waitMe(current_effect);
		})

		$(function(){
			$('#menu-sesiones').addClass('active');  
		});

		$('#macblock').on('hidden.bs.modal', function (e) {
			$(this)
			.find("input")
			.val('')
			.end()
		});

		$('#descripcion').on('hidden.bs.modal', function (e) {
			$(this)
			.find("input")
			.val('')
			.end()
		});

		$(document).on("click", ".option", function () {
		     var mac = $(this).data('mac');
		     var orden = $(this).data('orden');
		     $(".modal-body #mac").val( mac );
		     $(".modal-body #orden").val( orden );
		});

		$('.desblock').click(function(){
			$('#msj').text('Agregar descripción del desbloqueo');
			$('.action').attr("id","desbloq");
			$('.action').text('Desbloquear');
		});

		$('.block').click(function(){
			$('#msj').text('Agregar descripción del bloqueo');
			$('.action').attr("id","bloq");
			$('.action').text('Bloquear');
		});

		$('.action').click(function(){

			var id = $('.action').attr('id');

			var mac =  $('#mac').val();

			if(!(/^([0-9A-Fa-f]{2}[:]){5}([0-9A-Fa-f]{2})$/.test(mac)))
				alert('Debe ingresar una mac valida. Ejm: "00:00:00:00:00:00"');
			else{

				var orden =  $('#orden').val();

				var form = $('#form-bloqueodesbloqueo');
				var url = form.attr('action').replace(':mac',mac);
				var url = url.replace(':orden', orden);

				if($('#descr').val() == "")
					var url = url.replace(':descr', 'Vacio');
				else
					var url = url.replace(':descr', $('#descr').val());

				if(id == 'bloq'){
					var verbo = 'bloquear';
					var url = url.replace(':act', 'block');
				}else{
					var verbo = 'desbloquear';
					var url = url.replace(':act', 'pass');
				}
				
				var data = form.serialize();

				if(confirm('¿Está seguro que desea '+verbo+' esta mac?')){
					$.ajax({
						type: 'post',
						url: url,
						data: data,
						success: function(data){
							window.location.reload();
						}
					});	
				}
			}	
		});

		$('#action2').click(function(){
			
			var mac =  $('#mac1').val()
			var descr =  $('#descr1').val();

			if(!(/^([0-9A-Fa-f]{2}[:]){5}([0-9A-Fa-f]{2})$/.test(mac)))
				alert('Debe ingresar una mac valida. Ejm: "00:00:00:00:00:00"');
			else{

				console.log(mac);
				console.log(descr);

				var act = 'block';

				var form = $('#form-bloqueodesbloqueo');
				var url = form.attr('action').replace(':mac',mac);
				var url = url.replace(':act', act);

				if($('#descr1').val() == "")
					var url = url.replace(':descr', 'Vacio');
				else
					var url = url.replace(':descr', descr);

				var data = form.serialize();

				if(confirm('¿Está seguro que desea bloquear esta mac?')){
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
			}
		});


		$('#action3').click(function(){

			var mac =  $('#mac1').val()
			var descr =  $('#descr1').val();

			if(!(/^([0-9A-Fa-f]{2}[:]){5}([0-9A-Fa-f]{2})$/.test(mac)))
				alert('Debe ingresar una mac valida. Ejm: "00:00:00:00:00:00"');
			else{

			var act = 'pass';

			var form = $('#form-bloqueodesbloqueo');
			var url = form.attr('action').replace(':mac',mac);
			var url = url.replace(':act', act);

			if($('#descr1').val() == "")
				var url = url.replace(':descr', 'Vacio');
			else
				var url = url.replace(':descr', descr);

			var data = form.serialize();

			if(confirm('¿Está seguro que desea habilitar todos los permisos a esta mac?')){
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
			}
		});

		$('.btn-desblock').click(function(){

			var row = $(this).parents('tr');
			var mac = row.data('mac');
			var orden = $(this).data('orden');

			var form = $('#form-desblock');
			var url = form.attr('action').replace(':mac',mac);
			var url = url.replace(':orden', orden);
			var data = form.serialize();

			if(confirm('¿Está seguro que desea eliminar esta mac?')){
				$.ajax({
					type: 'post',
					url: url,
					data: data,
					success: function(data){
						window.location.reload();
					}
				});	
			}
			
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
