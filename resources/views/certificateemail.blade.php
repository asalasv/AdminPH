@extends('layouts.app')

@section('htmlheader_title')
Usuarios Registrados
@endsection


@section('main-content')

<div class="row">
	<div class="col-md-12">
		<div class="box">
			<div class="box-header with-border">
				<i class="fa fa-certificate"></i><h3 class="box-title">Certificación de Email</h3>

				<div class="box-tools pull-right">
					<button type="button" class="btn btn-box-tool" data-widget="collapse" data-toggle="tooltip" title="Collapse">
						<i class="fa fa-minus"></i>
					</button>
				</div>
			</div>
			<div class="box-body">
				<div class="col-xs-5" id="tipomensaje" style="vertical-align: middle;">
					@if($cliente->certifica_email == 'V')
					<i class="fa fa-toggle-on" style="font-size: 20px"></i>&nbsp;<b>Activado</b>
					<input type="hidden" id="tipo" value="activado"></input>
					@else
					<i class="fa  fa-toggle-off" style="font-size: 20px"></i>&nbsp;<b>Desactivado</b>
					<input type="hidden" id="tipo" value="desactivado"></input>
					@endif
				</div>
			</div>
			<!-- /.box-body -->
			<div class="box-footer">
				<div class="col-xs-2">
					<button type="button" id="cambiar" class="btn btn-block btn-primary btn-sm">
						@if($cliente->certifica_email == 'V')
						Desactivar
						@else
						Activar
						@endif
					</button>
				</div>
				
			</div>
			<!-- /.box-footer-->
		</div>
	</div>
</div>

	{!! Form::open(['route' => ['changevalidate'], 'method' =>'post', 'id' => 'form-change']) !!}
	{!!Form::close() !!}


<script type="text/javascript">
	$.ajaxSetup({
		headers: {
			'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
		}
	});
	$(document).ready(function(){

		$('#cambiar').click(function(){
			var form = $('#form-change');
			var url = form.attr('action');
			var data = form.serialize();

			//console.log("$('#tipo').val() ="+ $('#tipo').val() );

			if($('#tipo').val() == 'desactivado')
				var verbo = 'Activar';
			else
				var verbo = 'Desactivar';

			if (confirm('¿Está seguro que desea '+verbo+' la certificación de email?')) {
				$.ajax({
						type: 'post',
						url: url,
						data: data,
						success: function(data){
							console.log(data);
							if($('#tipo').val() == 'activado'){
								//console.log('desactivamos');
								$( "#tipomensaje" ).html( '<i class="fa fa-toggle-off" style="font-size: 20px"></i>&nbsp;<b>Desactivado</b><input type="hidden" id="tipo" value="desactivado"></input>' );
								$('#cambiar').text('Activar');
							}else{
								//console.log('activamos');
								$( "#tipomensaje" ).html( '<i class="fa fa-toggle-on" style="font-size: 20px"></i>&nbsp;<b>Activado</b><input type="hidden" id="tipo" value="activado"></input>' );
								$('#cambiar').text('Desactivar');
							}
					}
				});
			}
		});

	});

	

</script>

@endsection

