@extends('layouts.app')

@section('htmlheader_title')
Registros Ultima Semama
@endsection


@section('main-content')

<div class="row">
	<div class="col-md-12">
		<!-- AREA CHART -->
		<div class="box box-primary">
			<div class="box-header with-border">
				<i class="fa fa-warning "></i><h3 class="box-title">Conexiones Fraudulentas<small>&nbsp;&nbsp;-&nbsp;&nbsp;Direcciones Macs que se hayan conectado mas de 2 veces en un dia durante los ultimos 7 dias</small></h3>
			</div>
			<div class="box-body table-responsive">
				<table class="table table-hover">
					<thead>
						<tr>
							<th><i class="fa fa-desktop"></i>&nbsp;Mac</th>
							<th><i class="fa fa-plug"></i>&nbsp;Conexiones</th> 
							<th><i class="fa fa-calendar"></i>&nbsp;Fecha</th>
							<th></th>
						</tr>
					</thead>
					<tbody>
					<?php $cont = 0;?>
						@foreach($macs as $mac)
							<?php $cont = $cont+1; ?>
						<tr class="accordion-toggle" data-toggle="collapse" data-mac ="{{ $mac->mac}}" data-target="#<?php echo $cont; ?>">
							<td>{{ $mac->mac }}</td>
							<td>{{ $mac->Conexiones }}</td>
							<td>{{ $mac->fecha }}</td>
							<td><a href="#" data-mac ="{{ $mac->mac}}" data-toggle="modal" data-target="#descripcion" class="btn-delete block"><i class="fa fa-fw fa-times-circle"></i></i>Bloquear</a></td>
						</tr>
						<tr class="table-responsive">
										<td class="accordion-body collapse" id="<?php echo $cont; ?>">
											<table class="table table-condensed table-striped table-bordered">
												<thead>
													<th>Fecha Registro</th>
													<th>ID Usuario PH</th>
													<th>Nombre</th>
													<th>Apellido</th>
													<th>Email</th>
												</thead>
												<tbody>
												@foreach($conexiones as $conexion)
													@foreach($conexion as $conec)
														@if($conec->mac == $mac->mac and $conec->fecha == $mac->fecha)
														<tr>
															<td>{{ $conec->fecha_registro }}</td>
															<td>{{ $conec->id_usuario_ph }}</td>
															<td>{{ $conec->nombre }}</td>
															<td>{{ $conec->apellido }}</td>
															<td>{{ $conec->email }}</td>
														</tr>
														@endif
													@endforeach
												@endforeach
												</tbody>
											</table>
										</td>
									</tr>
						
						@endforeach
					</tbody>
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
						<button type="button" class="btn btn-primary btn-bloquear" id="btn-add">Crear</button>
					</div>
				</div>
			</div>
		</div>


	{!! Form::open(['route' => ['habilitar', ':mac'], 'method' =>'post', 'id' => 'form-habilitar']) !!}
	{!!Form::close() !!}

	{!! Form::open(['route' => ['bloquear', ':mac', ':sesion', ':descr'], 'method' =>'post', 'id' => 'form-bloquear']) !!}
	{!!Form::close() !!}


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

		$(document).on("click", ".block", function () {
		     var mac = $(this).data('mac');
		     $(".modal-body #mac").val( mac );
		});

		$('#descripcion').on('hidden.bs.modal', function (e) {
			$(this)
			.find("input")
			.val('')
			.end()
		});

		$(function(){
			$('#menu-sesiones').addClass('active');  
		});

		$(document).ajaxStart(function () {
			var current_effect = 'bounce'; 
			run_waitMe(current_effect);
	    }).ajaxStop(function () {

	    });

		$('.btn-bloquear').click(function(){

			var row = $(this).parents('tr');
			var mac =  $('#mac').val();

			var form = $('#form-bloquear');
			var url = form.attr('action').replace(':mac',mac);
			var url = url.replace(':sesion', '1');
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
						//console.log(data);
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

</script> <!-- your script -->
@endsection
