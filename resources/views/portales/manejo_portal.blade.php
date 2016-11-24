@extends('layouts.app')

@section('htmlheader_title')
Cambiar Contraseña
@endsection

@section('main-content')

<div class="row">
  <div class="col-md-6">
    <!-- AREA CHART -->
    <div class="box box-primary">
      {!! Form::open (['route'=> 'updatemanejo_portal', 'method' => 'put', 'class'=>'form-horizontal']) !!}
      <input type="hidden" name="_token" value="{{ csrf_token() }}">
      <div class="box-header">
        <i class='fa fa-gear'></i><h3 class="box-title">Tiempo de Conxión y URL de redirección</h3>
      </div><!-- /.box-header -->
      <div class="box-body">
        <div class="row" style="margin-bottom: 10px;">
          <div class="col-xs-12">
            <label for="exampleInputPassword1"><i class="fa fa-clock-o"></i>&nbsp;&nbsp;Tiempo de conexión</label>
              <input id="tiempo" type="number" name="tiempo_sesion" class="form-control" placeholder="120 segundos" value="{{$cliente->tiempo_sesion}}"/>
          </div>
        </div>
        <div class="row" style="margin-bottom: 10px;">
          <div class="col-xs-12">
            <label for="exampleInputPassword1"><i class="fa fa-external-link"></i>&nbsp;&nbsp;URL de redirección </label>
              <input id="web" type="text" name="web_redir" class="form-control" placeholder="http://example.com" value="{{$cliente->web_redir}}" onblur="checkURL(this)"/>
          </div>
        </div>
        <div class="col-xs-6 center" style="padding-left: 0px;">
          <button type="submit" class="btn btn-block btn-primary">Actualizar Datos</button>
        </div>
      </div>
      {!! Form::close()!!}
      <!-- /.box-body -->
    </div>
    <!-- /.box -->
  </div>
  <div class="col-md-6">
		<!-- AREA CHART -->
		<div class="box box-primary">
			{!! Form::open (['route'=> 'updateportalpass', 'method' => 'put', 'class'=>'form-horizontal']) !!}
			<input type="hidden" name="_token" value="{{ csrf_token() }}">
			<div class="box-header">
				<i class='fa fa-lock'></i><h3 class="box-title">Cambiar Contraseña del Portal</h3>
			</div><!-- /.box-header -->
			<div class="box-body">
				<div class="row">
					<div class="col-xs-12">
						<label for="exampleInputPassword1">Contraseña Nueva</label>
						<div class="input-group">
							<input id="pass1" type="text" name="password" class="form-control" placeholder="Password"/>
							<span class="input-group-addon" id="span1"><i class="fa fa-exclamation-circle"></i></span>
						</div>
						<p class="help-block" id="allert" style="color:red; padding-left: 8px;"></p>
					</div>
				</div>
				<div class="col-xs-6" style="padding-left: 0px;">
					<button type="submit" class="btn btn-block btn-primary" id="cambiar">Cambiar Contraseña</button>
				</div>
			</div>
			{!! Form::close()!!}
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
  function checkURL (abc) {
    var string = abc.value;
    if (!~string.indexOf("http")) {
      string = "http://" + string;
    }
    abc.value = string;
    return abc
  }
  $(document).ready(function(){
    $(function(){
      $('#menu-config').addClass('active')
      $('#menu-wifi').addClass('active');
    });

    $('#cambiar').prop('disabled', true)

    $('#pass1').on('input',function(e){
      var password1 = $('#pass1').val();

      if( $.trim(password1) == '' ){
        $('#allert').text('La contraseña no pueden estar en blanco');
        $('#span1').html('<i class="fa fa-times-circle-o"></i>');
        $('#cambiar').prop('disabled', true);

      }else{
        $('#allert').text('');
        $('#span1').html('<i class="fa fa-check"></i>');
        $('#cambiar').prop('disabled', false);
        // habilitar boton cambiar

      }
    });

  });

  </script>

  @endsection
