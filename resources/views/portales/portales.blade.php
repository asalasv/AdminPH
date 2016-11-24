@extends('layouts.app')

@section('htmlheader_title')
Portales
@endsection


@section('main-content')

<div class="row">
	<div class="col-md-12">
		<div class="box">
			<div class="box-header with-border">
				<i class='fa fa-calendar'></i><h3 class="box-title">Calendario de Portales</h3>
				<div class="box-tools pull-right">
					<button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
					</button>
				</div>
			</div>
			<div class="box-body">
				<!-- Calendario -->

				<div id="calendar">
				</div>


				<!-- Calendario end -->
			</div>
		</div>

		<div class="box box-primary">
			<div class="box-body">
				<div class="box-header">
					<i class='fa fa-desktop'></i><h3 class="box-title">Portales</h3>

					<div class="box-tools">
						<div class="input-group" style="width: 50px;">
							<!-- Button trigger modal -->
							@if( $cliente->certifica_email == 'V' or Auth::user()->id_usuario_web == '1' or Auth::user()->id_usuario_web == '29')
							<a href="{{ url('/newportal') }}" >
								<button class="btn btn-primary btn-sm">Agregar Portal</button>
							</a>
							@else
							<button class="btn btn-primary btn-sm" disabled="">Agregar Portal</button>
							@endif
						</div>
					</div>
				</div><!-- /.box-header -->
				<div class="box-body table-responsive no-padding">
					<input type="hidden" name="_token" value="{{ csrf_token() }}">
					<table class="table table-hover">
						<thead>
							<tr>
								<th>Descripción</th>
								<th>Fecha inicio</th>
								<th>Fecha fin</th>
								<th>Hora Inicio</th>
								<th>Hora fin</th>
								<th>Tipo</th>
							</tr>
						</thead>
						@foreach($portales as $portal)
						<tr data-id="{{ $portal->id_portal_cliente}}" data-name ="{{$portal->descripcion}}" data-prede="{{$portal->predeterminado }}">
							<td>{{$portal->descripcion}}</td>
							@if($portal->fecha_inicio != '')
							<td>{{$portal->fecha_inicio}}</td>
							@else
							<td>-</td>
							@endif
							@if($portal->fecha_fin != '')
							<td>{{$portal->fecha_fin}}</td>
							@else
							<td>-</td>
							@endif
							@if($portal->hora_inicio != '00:00:00')
							<td>{{$portal->hora_inicio}}</td>
							@else
							<td>-</td>
							@endif
							@if($portal->hora_inicio != '00:00:00')
							<td>{{$portal->hora_fin}}</td>
							@else
							<td>-</td>
							@endif
							@if($portal->predeterminado == 'V')
							<td><span class="label label-success">Predeterminado</span></td>
							@else
							@if($portal->horario_parcial == 'V')
							<td><span class="label label-info">Parcial</span></td>
							@else
							<td><span class="label label-warning">Continuo</span></td>
							@endif
							@endif
							<td><a href="{{ url('editportal', $portal) }}"><i class="fa fa-fw fa-edit"></i>Editar</a></td>
							<td><a href="#" class="btn-delete"><i class="fa fa-fw fa-times"></i>Eliminar</a></td>
						</tr>
						@endforeach
					</table>
					{!! $portales->render() !!}
				</div>
				<!-- /.box-body -->
			</div>
			<!-- /.box -->
		</div>
	</div>

	{!! Form::open(['route' => ['deleteportal', ':PORTAL_ID'], 'method' =>'delete', 'id' => 'form-delete']) !!}
	{!!Form::close() !!}

	{!! Form::open(['route' => ['api'], 'method' =>'get', 'id' => 'form-api']) !!}
	{!!Form::close() !!}

	<script type="text/javascript">
	$.noConflict();
	$.ajaxSetup({
		headers: {
			'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
		}
	});
	$(document).ready(function(){

		var form = $('#form-get');
		var data = form.serialize();
		$.ajax({
			type: 'get',
			url: 'api',
			data: data,
			success: function(data){
			}
		});

		var currentLangCode = 'es';//cambiar el idioma al español

		            $('#calendar').fullCalendar({
										contentHeight: 350,
		                eventClick: function(calEvent, jsEvent, view) {

		                    $(this).css('background', 'red');
		                    //al evento click; al hacer clic sobre un evento cambiara de background
		                    //a color rojo y nos enviara a los datos generales del evento seleccionado
		                },

		                header: {
		                    left: 'prev,next today myCustomButton',
		                    center: 'title',
		                    right: 'month,agendaWeek,agendaDay'
		                },

		                lang:currentLangCode,
		                editable: true,
		                eventLimit: true,
		                events:{
		                    //para obtener los resultados del controlador y mostrarlos en el calendario
		                    //basta con hacer referencia a la url que nos da dicho resultado, en el ejemplo
		                    //en la propiedad url de events ponemos el enlace
		                    //y listo eso es todo ya el plugin se encargara de acomodar los eventos
		                    //segun la fecha.
		                    url:'{{ asset("/api") }}'
		                }
		            });


		$('.btn-delete').click(function(){
			var row = $(this).parents('tr');
			var id = row.data('id');
			var predeterminado = row.data('prede')
			var form = $('#form-delete');
			var url = form.attr('action').replace(':PORTAL_ID',id)
			var data = form.serialize();

			if (predeterminado == 'V'){
				alert('No se puede borrar el portal predeterminado, puede cambiar otro portal a predeterminado y borrar este')
			}else{
				if (confirm('¿Está seguro que desea eliminar el portal "'+row.data('name')+'" de sus registros?')) {
					$.ajax({
						type: 'delete',
						url: url,
						data: data,
						success: function(data){
							alert(data);
						}
					});

					row.fadeOut();
				}

			}



		});
	});

	</script>

	@endsection
