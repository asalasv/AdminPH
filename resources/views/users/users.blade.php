	@extends('layouts.app')

	@section('htmlheader_title')
	Usuarios Registrados
	@endsection


	@section('main-content')

	<div class="row">
		<div class="col-md-12">
      @if( Auth::user()->id_usuario_web == '1' or Auth::user()->id_usuario_web == '29')
				<div class="box">
				<div class="box-header with-border">
					<i class="fa fa-cog"></i><h3 class="box-title">Tipo de cliente</h3>

					<div class="box-tools pull-right">
						<button type="button" class="btn btn-box-tool" data-widget="collapse" data-toggle="tooltip" title="Collapse">
							<i class="fa fa-minus"></i>
						</button>
					</div>
				</div>
				<div class="box-body">
					<div class="col-xs-6" id="tipomensaje" style="vertical-align: middle;">
						@if($cliente->privado == 'V')
						<i class="fa fa-lock" style="font-size: 20px"></i>&nbsp;Actualmente este Portal se encuentra configurado como <b>Privado</b>
						<input type="hidden" id="tipo" value="privado"></input>
						@else
						<i class="fa fa-unlock" style="font-size: 20px"></i>&nbsp;Actualmente este Portal se encuentra configurado como <b>Público</b>
						<input type="hidden" id="tipo" value="publico"></input>
						@endif
					</div>
				</div>
				<!-- /.box-body -->
				<div class="box-footer">
					<div class="col-xs-3">
						<button type="button" id="cambiar" class="btn btn-block btn-primary btn-sm">
							@if($cliente->privado == 'V')
								Cambiar a Público
							@else
								Cambiar a Privado
							@endif
						</button>
					</div>

				</div>
				<!-- /.box-footer-->
			</div>
			@endif
			<!-- AREA CHART -->
			<div class="box box-primary" id="usertable">

				<div class="box-header">
					<i class='fa fa-users'></i><h3 class="box-title" style="padding-right: 25;">Gestion de Usuarios</h3>
					<div class="box-tools">
						<div class="input-group" style="width: 50px;">
							<!-- Button trigger modal -->
							<button type="button" class="btn btn-block btn-primary btn-sm" data-toggle="modal" data-target="#myModal">
								<i class="fa fa-user-plus"></i>
							</button>
						</div>
					</div>
				</div><!-- /.box-header -->
				<div class="box-body" style="padding-top: 5px;">
					<div class="row" style="padding-bottom: 10px;">
						<div class="col-xs-12" style="padding-left: 20px;">

							<button type="button" id="accionxlote" class="btn btn-default btn-xs dropdown-toggle" data-toggle="dropdown">Accion por lote
								<span class="caret"></span>
							</button>
							<ul class="dropdown-menu" style="margin-left: 20px;">
								<li role="presentation"><a role="menuitem" id="asignargrupo" tabindex="-1" data-toggle="modal" data-target="#AsignGroup" href="#"><i class='fa fa-group'></i></i>Asignar a grupo</a></li>
								<li role="presentation"><a role="menuitem" id="desagrupar" href="#"><i class='fa fa-mail-reply'></i></i>Desagrupar</a></li>
								<li role="presentation"><a role="menuitem" id="habilitar" tabindex="-1" href="#"><i class="fa fa-circle-o"></i></i>Habilitar</a></li>
								<li role="presentation"><a role="menuitem" id="deshabilitar" tabindex="-1" href="#"><i class="fa fa-ban"></i>Deshabilitar</a></li>
								<li role="presentation"><a role="menuitem" id="borrar" tabindex="-1" href="#"><i class='fa fa-trash'></i>Eliminar</a></li>
							</ul>

							<button type="button" id="grupos" class="btn btn-default btn-xs" data-toggle="modal" data-target="#Group"><i class='fa fa-group'></i>&nbsp;Grupos</button>
						</div>
					</div>
					<div class="box-body table-responsive no-padding">
						<input type="hidden" name="_token" value="{{ csrf_token() }}">
						<table class="table table-hover">
							<thead>
								<tr>
									<th>
										<input type="checkbox" id="selectAll" />
									</th>
									<th>Nombre</th>
									<th>Apellido</th>
									<th>Email</th>
									<th>Grupo</th>
									<th>Estatus</th>
									<th></th>
									<th></th>
									<th>Estatus PH</th>
									<th></th>
								</tr>
							</thead>
							@foreach($usuarios as $user)
							<tr data-id="{{ $user->id_usuario_ph}}" data-name ="{{$user->nombre}}">
								<td>
									<input type="checkbox" />
								</td>
								<td>{{$user->nombre}}</td>
								<td>{{$user->apellido}}</td>
								<td>{{$user->email}}</td>
								@foreach($clientes_usuarios as $client_us)
								@if($client_us->id_usuario_ph == $user->id_usuario_ph)
								<td>{{$client_us->grupo}}</td>
								<td style="display:none;" class="fecha_inic">{{$client_us->fecha_inicio}}</td>
								<td style="display:none;" class="hora_inic">{{$client_us->hora_inicio}}</td>
								<td style="display:none;" class="fecha_fi">{{$client_us->fecha_fin}}</td>
								<td style="display:none;" class="hora_fi">{{$client_us->hora_fin}}</td>
								@if($client_us->status == '1')
								<td><span class="label label-success">Habilitado</span></td>
								<td><a href="#" class="btn-bloq disable"><i class="fa fa-ban"></i></i>&nbsp;Deshabilitar</a></td>
								@else
								<td><span class="label label-danger">Deshabilitado</span></td>
								<td><a href="#" class="btn-bloq enable"><i class="fa fa-circle-o"></i></i>&nbsp;Habilitar</a></td>
								@endif
								@endif
								@endforeach
								<td><a href="#" class="btn-delete"><i class="fa fa-fw fa-user-times"></i></i>Eliminar</a></td>
								@if($user->status == '1' || $user->status == '2')
								<td><span class="label label-success">Activo</span></td>
								@elseif($user->status == '0')
								<td><span class="label label-danger">Bloqueado por PortalHook</span></td>
								@elseif($user->status == '3')
								<td><span class="label label-warning">Dado de baja</span></td>
								@endif
								<td><a href="#" class="horario" data-toggle="modal" data-target="#Horario"><i class="fa fa-fw fa-clock-o"></i></i>Horario de Uso</a></td>
								@endforeach
							</table>
							{!! $usuarios->render() !!}
						</div>
						<!-- /.box-body -->
					</div>
					<!-- /.box -->
				</div>
			</div>

			<!-- Modal -->
			<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
				<div class="modal-dialog" role="document">
					<div class="modal-content">
						<div class="modal-header">
							<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
							<h4 class="modal-title" id="myModalLabel">Agregar Usuario</h4>
						</div>
						<div class="modal-body">
							<div class="row">
								<div class="col-xs-12">
									<label for="exampleInputEmail1">Email address</label>
									<div class="input-group">
										<input type="email" class="form-control" id="Email" placeholder="Email">
										<span class="input-group-addon" id="span2"><i class="fa fa-exclamation-circle"></i></span>
									</div>
									<p class="help-block" id="allert" style="color:red; padding-left: 8px;"></p>
									<p class="help-block" id="goodallert" style="color:green; padding-left: 8px;"></p>
								</div>
							</div>
						</div>
						<div class="modal-footer">
							<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
							<button type="button" class="btn btn-primary" id="btn-add">Agregar</button>
						</div>
					</div>
				</div>
			</div>

			<!-- Modal -->
			<div class="modal fade" id="AsignGroup" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
				<div class="modal-dialog" role="document">
					<div class="modal-content">
						<div class="modal-header">
							<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
							<h4 class="modal-title" id="myModalLabel"><i class='fa fa-group'></i>&nbsp;Asignar a Grupo</h4>
						</div>
						<div class="modal-body">
							<div class="row col-xs-9">
								<p class="help-block" id="bad-mess" style="color:red;"></p>
								<p class="help-block" id="good-mess"></p>
							</div>
							<div class="box-tools pull-right">
								<button data-toggle="modal" data-target="#NewGroup" type="button" class="btn btn-block btn-primary btn-sm creargrupo" style="margin-bottom: 5px;">
									<i class="fa fa-user-plus"></i>&nbsp;Crear Grupo
								</button>
							</div>
							<table class="table table-hover" id="table">
								<thead>
									<tr>
										<th>Nombre Grupo</th>
									</tr>
								</thead>
								@foreach($grupos as $grupo)
								<tr data-name ="{{$grupo}}">
									<td>{{$grupo}}</td>
								</tr>
								@endforeach
							</table>
							<div class="modal-footer">
								<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
								<button type="button" class="btn btn-primary asignar" id="btn-add">Asignar</button>
							</div>
						</div>
					</div>
				</div>
			</div>

			<!-- Modal GRUPOS-->
			<div class="modal fade" id="Group" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
				<div class="modal-dialog" role="document">
					<div class="modal-content">
						<div class="modal-header">
							<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
							<h4 class="modal-title" id="myModalLabel"><i class='fa fa-group'></i>&nbsp;Grupos</h4>
						</div>
						<div class="modal-body">
							<div class="row col-xs-9">
								<p class="help-block">Para crear un grupo debe seleccionar al menos un usuario</p>
							</div>
							<div class="box-tools pull-right">
								<button data-toggle="modal" data-target="#NewGroup" type="button" class="btn btn-block btn-primary btn-sm creargrupo" style="margin-bottom: 5px;">
									<i class="fa fa-user-plus"></i>&nbsp;Crear Grupo
								</button>
							</div>
							<table class="table table-hover">
								<thead>
									<tr data-name="header">
										<th>Nombre Grupo</th>
										<th></th>
										<th></th>
										<!-- 		<th></th> -->
									</tr>
								</thead>
								@foreach($grupos as $grupo)
								<tr data-id="" data-name ="{{$grupo}}">
									<td>{{$grupo}}</td>
									<td><a href="#" class="btn-changestatus-group" id="0"><i class="fa fa-ban"></i></i>Deshabilitar</a></td>
									<td><a href="#" class="btn-changestatus-group" id="1"><i class="fa fa-circle-o"></i></i>Habilitar</a></td>
									<!-- 								<td><a href="#" class="btn-delete_group"><i class="fa fa-trash"></i></i>Eliminar</a></td> -->
									@endforeach
								</table>
							</div>
							<div class="modal-footer">
								<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
							</div>
						</div>
					</div>
				</div>
			</div>

			<!-- Modal ASIGNAR A GRUPO-->
			<div class="modal fade" id="NewGroup" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
				<div class="modal-dialog" role="document">
					<div class="modal-content">
						<div class="modal-header">
							<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
							<h4 class="modal-title" id="myModalLabel">Nuevo Grupo</h4>
						</div>
						<div class="modal-body">
							<div class="row">
								<div class="col-xs-9">
									<label class="control-label" for="date">Nombre del grupo</label>
									<input type="text" class="form-control" name="namegrup" id="namegrup" placeholder="Nombre">
								</div>
							</div>
						</div>
						<div class="modal-footer">
							<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
							<button type="button" class="btn btn-primary CreateGrupo" id="btn-add">Crear</button>
						</div>
					</div>
				</div>
			</div>

			<!-- Modal HORARIOS-->
			<div class="modal fade" id="Horario" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
				<div class="modal-dialog" role="document">
					<div class="modal-content">
						<div class="modal-header">
							<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
							<h4 class="modal-title" id="myModalLabel"><i class='fa fa-clock-o'></i>&nbsp;Horarios de uso</h4>
						</div>
						{!! Form::open (['route'=> ['updatehour'], 'method' => 'POST', 'class'=>'form-horizontal','files'=>true, 'enctype'=>'multipart/form-data', 'onsubmit' => 'return formulario(this)']) !!}
						<div class="modal-body">
							<div class="bootstrap-iso">
								<input class="form-control" type="hidden" name="id" id="id_user">
								<div class="row" style="padding-top: 10px;">
									<div class="form col-xs-6"> <!-- Date input -->
										<label class="control-label" for="date"><i class="fa fa-calendar-check-o"></i>&nbsp;Fecha Inicio</label>
										<input class="form-control datepick" id="fecha_inicio" name="fecha_inicio" placeholder="MM/DD/YYY" type="text"/>
									</div>
									<div class="form col-xs-6"> <!-- Date input -->
										<label class="control-label" for="date"><i class="fa  fa-calendar-times-o"></i>&nbsp;Fecha Fin</label>
										<input class="form-control datepick" id="fecha_fin" name="fecha_fin" placeholder="MM/DD/YYY" type="text"/>
									</div>
								</div>
							</div>
							<div class="row" style="padding-top: 10px;">
								<div class="form col-xs-6">
									<label class="control-label" for="date"><i class="fa fa-clock-o"></i>&nbsp;Hora Inicio</label>
									<input class="form-control"  name="hora_inicio" id="hora_inicio" value="" data-default="20:48">
								</div>
								<div class="form col-xs-6">
									<label class="control-label" for="date"><i class="fa fa-clock-o"></i>&nbsp;Hora Fin</label>
									<input class="form-control" name="hora_fin" id="hora_fin" value="" data-default="20:48">
								</div>
							</div>
						</div>
						<div class="modal-footer">
							<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
							<button type="submit" class="btn btn-primary btn_actualizar_hr" id="btn_actualizar_hr">Actualizar</button>
						</div>
						{!! Form::close()!!}
					</div>
				</div>
			</div>


			{!! Form::open(['route' => ['deleteusuario', ':USER_ID'], 'method' =>'delete', 'id' => 'form-delete']) !!}
			{!!Form::close() !!}

			{!! Form::open(['route' => ['postusuario', ':Email'], 'method' =>'post', 'id' => 'form-post']) !!}
			{!!Form::close() !!}

			{!! Form::open(['route' => ['verifyemail', ':Email'], 'method' =>'get', 'id' => 'form-get']) !!}
			{!!Form::close() !!}

			{!! Form::open(['route' => ['changestatus'], 'method' =>'post', 'id' => 'form-change']) !!}
			{!!Form::close() !!}

			{!! Form::open(['route' => ['changestatusph', ':Users'], 'method' =>'post', 'id' => 'form-changeph']) !!}
			{!!Form::close() !!}

			{!! Form::open(['route' => ['habilitarph', ':Users'], 'method' =>'post', 'id' => 'form-hablitarph']) !!}
			{!!Form::close() !!}

			{!! Form::open(['route' => ['inhabilitarph', ':Users'], 'method' =>'post', 'id' => 'form-inhabilitarph']) !!}
			{!!Form::close() !!}

			{!! Form::open(['route' => ['asignargrupo', ':Users', ':Grupo'], 'method' =>'post', 'id' => 'form-asignargrupo']) !!}
			{!!Form::close() !!}

			{!! Form::open(['route' => ['changestatusgroup', ':Grupo', ':status'], 'method' =>'post', 'id' => 'form-changestatusgroup']) !!}
			{!!Form::close() !!}


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
    	container: 'container',
    	todayHighlight: true,
    	autoclose: true,
    };

    vdesde.datepicker(options); //initiali110/26/2015 8:20:59 PM ze plugin
    vhasta.datepicker(options); //initiali110/26/2015 8:20:59 PM ze plugin

    $('.datepick').css('z-index','10000');

    $(document).ready(function(){

    	$('.horario').click(function(){

    		var row = $(this).parents('tr');
			var id = row.data('id');
		    var fecha_inicio = $(this).closest("tr")   // Finds the closest row <tr>
                       .find(".fecha_inic")     // Gets a descendent with class="nr"
                       .text();         // Retrieves the text within <td>
   		    var hora_inicio = $(this).closest("tr")   // Finds the closest row <tr>
                   .find(".hora_inic")     // Gets a descendent with class="nr"
                   .text();         // Retrieves the text within <td>
   		    var fecha_fin = $(this).closest("tr")   // Finds the closest row <tr>
                   .find(".fecha_fi")     // Gets a descendent with class="nr"
                   .text();         // Retrieves the text within <td>
   		    var hora_fin = $(this).closest("tr")   // Finds the closest row <tr>
                   .find(".hora_fi")     // Gets a descendent with class="nr"
                   .text();

           $("#fecha_inicio").val( fecha_inicio );
           $("#hora_inicio").val( hora_inicio );
           $("#fecha_fin").val( fecha_fin );
           $("#hora_fin").val( hora_fin );
           $("#id_user").val( id );
           console.log( $("#id_user").val());
       });

    	$('.close').prop('disabled', false);
			// $('close').prop('disabled', false);

			$("#table tr").click(function(){
				$(this).addClass('active').siblings().removeClass('active');
				var value=$(this).find('td:first').html();
			});

			if($('#tipo').val() == 'privado')
				$("#usertable").show(1000);
			else
				$("#usertable").hide();

			$(document).ajaxStart(function () {
				$("#loading").show();
			}).ajaxStop(function () {
				$("#loading").hide();
			});

			$('#btn-add').prop('disabled', true);

			$('#Email').on('input',function(e){
				var email = $('#Email').val();
				var form = $('#form-get');
				var url = form.attr('action').replace(':Email',email);;
				var data = form.serialize();
				$.ajax({
					type: 'get',
					url: url,
					data: data,
					success: function(data){
						if(data == 'true'){
							$('#allert').text('');
							$('#goodallert').text(' El email "'+email+'" si se encuentra nuestros registros');
							$('#btn-add').prop('disabled', false);
							$('#span2').html('<i class="fa fa-check"></i>');
						}else{
							$('#allert').text(' El email "'+email+'" no coincide con nuestros registros');
							$('#goodallert').text('');
							$('#btn-add').prop('disabled', true);
							$('#span2').html('<i class="fa fa-times-circle-o"></i>');
						}
					}
				});

			});

			$('.enable').click(function(){
				var row = $(this).parents('tr');
				var id = row.data('id');
				var form = $('#form-changeph');
				var url = form.attr('action').replace(':Users',id)
				var data = form.serialize();

				$.ajax({
					type: 'post',
					url: url,
					data: data,
					success: function(data){
						window.location.reload();
					}
				});
			});

			$('.disable').click(function(){
				var row = $(this).parents('tr');
				var id = row.data('id');
				var form = $('#form-changeph');
				var url = form.attr('action').replace(':Users',id)
				var data = form.serialize();

				$.ajax({
					type: 'post',
					url: url,
					data: data,
					success: function(data){
						window.location.reload();
					}
				});
			});


			$('#habilitar').click(function(){
				var rowsid = getselectedrows();
				if(rowsid == null)
					alert('Debe seleccionar al menos un usuario')
				else{
					var id = rowsid;
					var form = $('#form-hablitarph');
					var url = form.attr('action').replace(':Users',id)
					var data = form.serialize();

					$.ajax({
						type: 'post',
						url: url,
						data: data,
						success: function(data){
							window.location.reload();
						}
					});
					//habilitar los usuarios que esten en rowsid
				}
			});

			$('#deshabilitar').click(function(){
				var rowsid = getselectedrows();
				if(rowsid == null)
					alert('Debe seleccionar al menos un usuario')
				else{
					var id = rowsid;
					var form = $('#form-inhabilitarph');
					var url = form.attr('action').replace(':Users',id)
					var data = form.serialize();

					$.ajax({
						type: 'post',
						url: url,
						data: data,
						success: function(data){
							window.location.reload();
						}
					});
					//dhabilitar los usuarios que esten en rowsid
				}
			});

			$('#borrar').click(function(){
				var rowsid = getselectedrows();
				if(rowsid == null)
					alert('Debe seleccionar al menos un usuario')
				else{
					var id = rowsid;
					var form = $('#form-delete');
					var url = form.attr('action').replace(':USER_ID',id)
					var data = form.serialize();

					if (confirm('¿Está seguro que desea eliminar los usuarios seleccionados de sus registros?')) {
						$.ajax({
							type: 'delete',
							url: url,
							data: data,
							success: function(data){
								alert(data);
								window.location.reload();
							}
						});

						row.fadeOut();
					}

					//eliminar los usuarios que esten en rowsid
				}
			});

			$('#asignargrupo').click(function(){
				var rowsid = getselectedrows();
				if(rowsid == null){
					$('.creargrupo').prop('disabled', true);
					$('.asignar').prop('disabled', true);
					$("#good-mess").text("");
					$("#bad-mess").text("Debe seleccionar al menos un usuario");
				}else{
					$('.creargrupo').prop('disabled', false);
					$('.asignar').prop('disabled', false);
					$("#bad-mess").text("");
					$("#good-mess").text("Seleccione un grupo o cree uno nuevo");
					//Asignar los usuarios que esten en rowsid al grupo seleccionado
				}
			});

			$('#grupos').click(function(){
				var rowsid = getselectedrows();
				if(rowsid == null){
					$('.creargrupo').prop('disabled', true);
				}else{
					$('.creargrupo').prop('disabled', false);
				}
			});

			$('.asignar').click(function(){
				if(typeof $('#table .active').html() === "undefined"){
					alert('Debe seleccionar un grupo o crear uno nuevo');
				}else{
					var rowsid = getselectedrows();
					var row = $('#table .active');
					var nombre = row.data('name');
					if (typeof nombre === "undefined") {
						alert('Debe seleccionar un grupo o crear uno nuevo');
					}else{
						var id = rowsid;
						var form = $('#form-asignargrupo');
						var url = form.attr('action').replace(':Users',id);
						var url = url.replace(':Grupo', nombre);
						var data = form.serialize();

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

			$('#desagrupar').click(function(){
				var rowsid = getselectedrows();
				if(rowsid == null){
					alert('Debe seleccionar al menos un usuario');
				}else{
					var id = rowsid;
					var form = $('#form-asignargrupo');
					var url = form.attr('action').replace(':Users',id);
					var url = url.replace(':Grupo', '0');
					var data = form.serialize();

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



			$('.btn-changestatus-group').click(function(){

				var status = this.id;
				var row = $(this).parents('tr');
				var grupo = row.data('name');
					// alert('Grupo: '+grupo+' status: '+status)
					var form = $('#form-changestatusgroup');
					var url = form.attr('action').replace(':Grupo',grupo);
					var url = url.replace(':status', status);
					var data = form.serialize();

					$.ajax({
						type: 'post',
						url: url,
						data: data,
						success: function(data){
							window.location.reload();
						}
					});

				});

			// $('.btn-delete_group').click(function(){
			// 	var grupo = row.data('name');
			// 		// alert('Grupo: '+grupo+' status: '+status)
			// 	var form = $('#form-deletegroup');
			// 	var url = form.attr('action').replace(':Grupo',grupo);
			// 	var data = form.serialize();

			// 	$.ajax({
			// 		type: 'post',
			// 		url: url,
			// 		data: data,
			// 		success: function(data){
			// 			window.location.reload();
			// 		}
			// 	});

			// });


			$('.CreateGrupo').click(function(){
				// 	alert('El nombre del grupo no puede estar en vacio')
				// }else{
					var rowsid = getselectedrows();
					var id = rowsid;
					var form = $('#form-asignargrupo');
					var url = form.attr('action').replace(':Users',id);
					if($('#namegrup').val() == "")
						var url = url.replace(':Grupo', '0');
					else
						var url = url.replace(':Grupo', $('#namegrup').val());
					var data = form.serialize();

					$.ajax({
						type: 'post',
						url: url,
						data: data,
						success: function(data){
							window.location.reload();
						}
					});
				// }
			});

			// $('#close').click(function(){
			// 	$('#allert').text('');
			// 	$('#goodallert').text('');
			// 	$('#span2').html('<i class="fa fa-times-circle-o"></i>');
			// 	$('#btn-add').prop('disabled', true);
			// });

			$('#cambiar').click(function(){
				var form = $('#form-change');
				var url = form.attr('action');
				var data = form.serialize();

				if (confirm('¿Está seguro que desea cambiar el Tipo de configuración?')) {
					$.ajax({
						type: 'post',
						url: url,
						data: data,
						success: function(data){
							if($('#tipo').val() == 'privado'){
								//console.log('abrimos tabla');
								$("#usertable").hide(1000);
								$( "#tipomensaje" ).html( '<i class="fa fa-unlock" style="font-size: 20px"></i>&nbsp;Actualmente este Portal se encuentra configurado como <b>Público</b><input type="hidden" id="tipo" value="publico"></input>' );
								$('#cambiar').text('Cambiar a Privado');
							}else{
								//console.log('escondemos tabla');
								$("#usertable").show(1000);
								$( "#tipomensaje" ).html( '<i class="fa fa-lock" style="font-size: 20px"></i>&nbsp;Actualmente este Portal se encuentra configurado como <b>Privado</b><input type="hidden" id="tipo" value="privado"></input>' );
								$('#cambiar').text('Cambiar a Público');
							}
						}
					});
				}
			});



			$('.btn-delete').click(function(){
				var row = $(this).parents('tr');
				var id = row.data('id');
				var form = $('#form-delete');
				var url = form.attr('action').replace(':USER_ID',id)
				var data = form.serialize();


				if (confirm('¿Está seguro que desea eliminar a "'+row.data('name')+'" de sus registros?')) {
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
			});

			$('#myModal').on('hidden.bs.modal', function (e) {
				$(this)
				.find("input")
				.val('')
				.end()
			})

			$('#selectAll').click(function (e) {
				$(this).closest('table').find('td input:checkbox').prop('checked', this.checked);
			});

			$('#btn-add').click(function(){
				var form = $('#form-post');
				var email= $("#Email").val();
				var url = form.attr('action').replace(':Email',email);
				var data = form.serialize();

				if(email==""){
					alert("Ingrese un email por favor")
				}else{
					$.ajax({
						type: 'post',
						url: url,
						data: data,
						success: function(data){

							if(data==""){
								alert(email+' no se encuentra en nuestros registros');
							}
							if (data == "refresh"){
					    	window.location.reload(); // This is not jQuery but simple plain ol' JS
					    }
					    console.log(data);
					}
				});
				}
			});

		});

	function getselectedrows() {
		var selectedIds = [];

		$(":checked").each(function() {

			var row = $(this).parents('tr');
			var id = row.data('id');
			if (typeof id === "undefined") {

			}else
			selectedIds.push(id);
		});
		if(Object.keys(selectedIds).length == 0)
			return null;
		return selectedIds;
	}

    function formulario(f) {
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

    }

</script>

@endsection
