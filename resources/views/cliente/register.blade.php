@extends('layouts.auth')

@section('htmlheader_title')
Register
@endsection

<!-- Main Header -->
<header class="main-header">
    <img src="img/comodo_secure_seal_76x26_transp.png" alt="..." class="img-responsive">
</header>

@section('content')

<body class="hold-transition register-page">
  <div class="register-box">
    <div class="login-logo" style="padding-left: 70px;padding-right: 70px">
      <img src="img/logofinal.png" class="img-responsive">
    </div><!-- /.login-logo -->


    @if (count($errors) > 0)
    <div class="alert alert-danger">
      <strong>Whoops!</strong> There were some problems with your input.<br><br>
      <ul>
        @foreach ($errors->all() as $error)
        <li>{{ $error }}</li>
        @endforeach
      </ul>
    </div>
    @endif

    <div class="register-box-body">
      <p class="login-box-msg">Registro de Usuario Web - Admin Dashboard</p>
      <form id="myform" action="{{ url('/register') }}" method="post" autocomplete="off" >
        <div class="row">
          <div class="col-md-6" style="border-right: 1px;border-right-style: solid;">
            <p class="login-box-msg">Usuario Admin</p>
            <input type="hidden" name="_token" value="{{ csrf_token() }}">
            <div class="form-group has-feedback">
              <input type="text" class="form-control" autocomplete="off" placeholder="Codigo de Cliente" maxlength="20" name="cliente" value="{{ old('cliente') }}"/>
              <span class="glyphicon glyphicon-home form-control-feedback"></span>
            </div>
            <!-- <div class="form-group has-feedback">
            <input type="text" class="form-control" autocomplete="off" placeholder="Username" size="20" maxlength="10" name="username" value="{{ old('username') }}"/>
            <span class="glyphicon glyphicon-user form-control-feedback"></span>
          </div> -->
          <div class="form-group has-feedback input-group" style="margin-bottom: 0px;">
            <input type="text" class="form-control" id="username" autocomplete="off" placeholder="Username" size="20" maxlength="10" name="username" value="{{ old('username') }}"/>
            <span class="input-group-addon" id="span1"><i class="fa fa-exclamation-circle"></i></span>
          </div>
          <small><p class="help-block" id="allert" style="color:red;padding-left: 8px;margin-top: 0px;"></p></small>
          <div class="form-group has-feedback">
            <input type="email" class="form-control" autocomplete="off" placeholder="Email" maxlength="40" name="email" value="{{ old('email') }}"/>
            <span class="glyphicon glyphicon-envelope form-control-feedback"></span>
          </div>
          <div class="form-group has-feedback inputShowPwd">
            <input type="text" class="form-control" placeholder="Password" maxlength="80" value="" />
            <input type="password" id="pass1"  class="form-control" autocomplete="off" placeholder="Password" maxlength="10" name="password" value="" />
            <span class="showEle"></span>
          </div>
          <div class="form-group has-feedback inputShowPwd" style="margin-bottom: 0px;">
            <input type="text" class="form-control" placeholder="Retype password" maxlength="80">
            <input type="password" id="pass2" class="form-control" autocomplete="off" placeholder="Retype password" maxlength="10" name="password_confirmation"></input>
            <span class="showEle"></span>
          </div>
          <small><p class="help-block" id="passallert" style="color:red;padding-left: 8px;margin-top: 0px;"></p></small>
          <div class="form-group">
            <div class="col-md-12" style="padding-bottom: 10px;padding-top: 10px;text-align: center;">
              <div style="display: inline-block;">
                {!! app('captcha')->display(); !!}
              </div>

            </div>
          </div>
        </div>
        <div class="col-md-6">
          <p class="login-box-msg">Cliente</p>
          <!-- <div class="row"> -->
          <div class="form-group has-feedback col-xs-12" style="padding-left: 0px;padding-right: 0px;">
            <textarea type="text" rows="2" class="form-control input-sm" autocomplete="off" placeholder="Razon social" maxlength="80" name="nombre" value="{{ old('nombre') }}"/></textarea>
            <span class="glyphicon glyphicon-user form-control-feedback"></span>
          </div>
          <div class="form-group has-feedback col-xs-12" style="padding-left: 0px;padding-right: 0px;">
            <input type="text" class="form-control input-sm" autocomplete="off" placeholder="RIF" maxlength="20" name="rif" value="{{ old('rif') }}"/>
            <span class="glyphicon glyphicon-barcode form-control-feedback"></span>
          </div>
          <!-- </div> -->
          <div class="form-group has-feedback col-xs-12" style="padding-left: 0px;padding-right: 0px;">
            <!-- <input type="text" class="form-control" autocomplete="off" placeholder="Dirección" name="direccion" value=""/> -->
            <textarea class="form-control input-sm" rows="2" placeholder="Dirección" maxlength="100" name="direccion" value="{{ old('direccion') }}"></textarea>
            <span class="glyphicon glyphicon-home form-control-feedback"></span>
          </div>
          <div class="form-group has-feedback col-xs-6" style="padding-left: 0px;padding-right: 0px;">
            <input type="text" class="form-control input-sm" autocomplete="off" placeholder="Representante" maxlength="40" name="representante" value="{{ old('representante') }}"/>
            <span class="glyphicon glyphicon-user form-control-feedback"></span>
          </div>
          <div class="form-group has-feedback col-xs-6" style="padding-right: 0px;">
            <input type="email" class="form-control input-sm" autocomplete="off" placeholder="Email Representante" maxlength="40" name="email_representante" value="{{ old('email_representante') }}"/>
            <span class="glyphicon glyphicon-envelope form-control-feedback"></span>
          </div>
          <div class="form-group has-feedback col-xs-6" style="padding-left: 0px;padding-right: 0px;">
            <input type="text" class="form-control input-sm" autocomplete="off" placeholder="Telefono" maxlength="20" name="telefono" value="{{ old('telefono') }}"/>
            <span class="glyphicon glyphicon-phone-alt form-control-feedback"></span>
          </div>
          <div class="form-group has-feedback col-xs-6" style="padding-right: 0px;">
            <input type="text" class="form-control input-sm" autocomplete="off" placeholder="Telefono Representante" maxlength="20" name="telefono_representante" value="{{ old('telefono_representante') }}"/>
            <span class="glyphicon glyphicon-earphone form-control-feedback"></span>
          </div>
          <div class="form-group has-feedback col-xs-6" style="padding-left: 0px;padding-right: 0px;margin-bottom: 5px;">
            <input type="text" class="form-control input-sm" autocomplete="off" placeholder="SSID WIFI"  maxlength="50" name="ssid_wifi" value="{{ old('ssid_wifi') }}" />
            <span class="glyphicon glyphicon-signal form-control-feedback"></span>
          </div>
          <div class="form-group has-feedback col-xs-6" style="padding-right: 0px;margin-bottom: 5px;">
            <input type="text" class="form-control input-sm" autocomplete="off" placeholder="Clave Wifi" maxlength="20" name="password_portal" value="{{ old('password_portal') }}"/>
            <span class="glyphicon glyphicon-lock form-control-feedback"></span>
          </div>
          <div class="form-group has-feedback col-xs-6" style="padding-right: 0px; padding-left: 0px;">
            <label style="margin-bottom: 0px;"><small>Tipo:</small></label>
            <select class="form-control input-sm" name="tipo">
              @foreach($tipo_clientes as $tipo)
              <option value="{{$tipo->id_tipo_cliente}}">{{$tipo->tipo_cliente}}</option>
              @endforeach
            </select>
          </div>
          <div class="form-group has-feedback col-xs-6" style="padding-right: 0px;">
            <label style="margin-bottom: 0px;"><small>Sector:</small></label>
            <select class="form-control input-sm" name="sector">
              @foreach($sectores as $sector)
              <option value="{{$sector->id_sector}}">{{$sector->state}}, {{$sector->city}}</option>
              @endforeach
            </select>
          </div>
          <div class="form-group has-feedback col-xs-6" style="padding-right: 0px; padding-left: 0px;">
            <label style="margin-bottom: 0px;"><small>Servicio Portalhook:</small></label>
            <select class="form-control input-sm servicio" name="tipo_contrato">
              <option value="0">Basic</option>
              <option value="1">Premium</option>
            </select>
          </div>
          <div class="bootstrap-iso">
            <div class="form col-xs-6" style="padding-right: 0px;padding-top: 20px;"> <!-- Date input -->
              <input class="form-control input-sm" id="fecha_activacion" name="fecha_activacion" placeholder="Fecha de activación" type="text" value="{{ old('fecha_activacion') }}"/>
              <span class="glyphicon glyphicon-calendar form-control-feedback" style="padding-top: 20px;"></span>
            </div>
          </div>
        </div>
      </div>
      <!-- <p>{!! Form::submit('Enviar') !!}</p> -->
      <div class="row" style="padding-top: 15px;">
        <div class="col-xs-8">
          <div class="checkbox icheck" >
            <label class="icheck">
              <input type="checkbox" id="checkbox1" name="acuerdo" style="margin-left: 0px;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;He leido y estoy de acuerdo con los <a data-toggle="modal" data-target="#myModal">términos y condiciones.</a>
            </label>
          </div>
        </div><!-- /.col -->
        <div class="col-xs-4">
          <button type="submit btnregistrar" id="btnregistrar" class="btn btn-primary btn-block btn-flat">Registrar</button>
        </div><!-- /.col -->
      </div>
      <div class="row">
        <div class="col-xs-12">
          <div class="checkbox icheck" >
            <label class="icheck">
              <input type="checkbox" id="checkbox2" name="contrato" style="margin-left: 0px;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;He leido y acepto el <a class="contrato" target="_blank" href="{{ url('contract/basic') }}">Contrato asociado al tipo de Servicio Portalhook Seleccionado.</a></input>
            </label>
          </div>
        </div>
      </div>
    </form>


    <a href="{{ url('/login') }}" class="text-center"><i class="fa fa-arrow-left"></i>&nbsp;Ya tengo una cuenta</a>
  </div><!-- /.form-box -->
</div><!-- /.register-box -->

<!-- Modal -->
<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">Términos y Condiciones</h4>
      </div>
      <div class="modal-body">
        <p><b>1.- Usuarios.-</b></p>

        <p style="text-align: justify;">Todos los usuarios que accedan a la red del proveedor potenciada por PortalHook, aceptan de manera directa los términos y condiciones de uso acá descritos sin ninguna reserva así como cualquier condición adicional que en el futuro pudiera complementar estos términos.</p>

        <p style="text-align: justify;">El usuario accede al servicio bajo su entera responsabilidad. El usuario podrá acceder a los contenidos de Internet que no están bajo el control de los establecimientos proveedores de internet WIFI ni de PortalHook. Por lo tanto, ni el proveedor de acceso a la red ni PortalHook, son responsables de ninguno de estos sitios, su contenido o sus políticas de privacidad. El proveedor de acceso a la red y su personal, así también como PortalHook y sus colaboradores, no respaldan ni representan a ninguno de estos sitios, o cualquier información, software u otros productos o materiales que se encuentran allí, o cualquier resultado que pueda obtenerse mediante su utilización. Si el usuario decide acceder a cualquier contenido de Internet, lo hace bajo su propio riesgo y es responsable de asegurarse de que cualquier página visitada o material descargado no infrinja las leyes del gobierno local, de forma exhaustiva que cubre, derechos de autor, marcas comerciales, la pornografía, o cualquier otro material que es calumnioso, difamatorio o pueda causar ofensa de cualquier otra manera.</p>

        <p style="text-align: justify;">El servicio de internet cuenta con protección contra virus, malware y anti spam, filtro de contenido prohibido y maliciosos según la legislación local actual, filtro de conexiones entre clientes y de conexiones bancarias o de transacciones así como un sistema de prevención de intrusos (IPS). Aun así, de ninguna forma ni en caso alguno el proveedor de la red o PortalHook, serán responsables por cualquier daño que pueda sufrir el equipo o dispositivo usado para establecer la conexión. Para evitar problemas de virus, acceso a cuentas personales y cualquier otro posible tema de seguridad en el acceso se invita a los usuarios a controlar los sitios Web a visitar.</p>

        <p style="text-align: justify;">Para poder acceder al internet a través de PortalHook los Usuarios podrán registrarse previamente, completando electrónicamente con datos exactos, verdaderos y actuales el formulario de registro proporcionado en la plataforma electrónica de PortalHook, lo que les permitirá crear su contraseña de acceso propia. Igualmente, están obligados a mantener actualizados sus datos de registro permanentemente. PortalHook se reserva el derecho a utilizar los medios que estime pertinentes para verificar la identidad de los Usuarios, así como de requerir con dicho fin comprobantes o cualquier información adicional a la solicitada en el formulario de registro, cuando lo considere. Una vez registrados, los Usuarios podrán acceder a su cuenta particular en PortalHook, ingresando sus datos, incluyendo su contraseña de acceso. Los Usuarios no podrán contar con más de una cuenta de usuario, están obligados a mantener la confidencialidad de su contraseña de acceso y asumen que su cuenta es particular, única e intransferible, de modo que todas las operaciones efectuadas desde su cuenta particular son de su exclusiva responsabilidad. Los Usuarios serán responsable por guardar la seguridad de su contraseña y aceptan responsabilidad por las operaciones fraudulentas que puedan ser realizadas por medio del uso de las mismas, hasta el momento en que informe a PortalHook sobre la violación a la seguridad y confidencialidad de su contraseña. PortalHook se reserva el derecho de negar las solicitudes de registro o de suspender de forma temporal o definitiva a los Usuarios cuyos datos no sean posibles confirmar, sin que tal suspensión genere en ellos derecho a resarcimiento alguno. PortalHook no se hace responsable por la certeza de los datos de registro proporcionados por los Usuarios, quienes garantizan y se hacen responsables de forma exclusiva por la exactitud, veracidad y vigencia de sus datos de registro, así como de su capacidad legal para contratar y cumplir con todas las obligaciones contraídas, incluyendo con las contenidas en estos Términos y Condiciones y de su cumplimiento con las normas vigentes.</p>

        <p style="text-align: justify;">La información proporcionada en PortalHook se procesa y almacena en servidores o medios magnéticos que mantienen altos estándares de seguridad y protección física y tecnológica. PortalHook no garantiza el acceso y uso continuado e ininterrumpido a su plataforma, ni tampoco se hace responsable por cualquier violación o usurpación que pueda sufrir su sistema de seguridad, aunque declara que procurará solucionar las fallas ordinarias o extraordinarias que puedan presentarse con ocasión de fallas en los sistemas, en la internet o por cualquier otra circunstancia y hacer los esfuerzos necesarios para mantener la seguridad de su plataforma. Al registrarse, los Usuarios aceptan recibir notificaciones de publicaciones realizadas por PortalHook y los establecimientos proveedores de internet WIFI. Los datos personales aportados por los Usuarios al momento de su registro y durante el uso de la cuenta, forman parte integrante del modelo de negocios de PortalHook. En este sentido, los Usuarios autorizan expresamente a PortalHook y a los establecimientos proveedores del internet WIFI a utilizar tal información proporcionada a los efectos de la prestación de sus servicios, incluyendo la posibilidad de utilizar los datos personales para establecer perfiles comerciales de los Usuarios, el envío de publicidad comercial y el envío de notificaciones. PortalHook mantendrá la confidencialidad de los datos personales de los Usuarios, excepto en los siguientes casos: a) cuando le sean requeridos por las autoridades competentes; b) cuando a los fines de una prestación adecuada de los servicios o de procurar ofertas promocionales para los Usuarios deba compartirlos con los prestadores de servicios de internet WIFI, administradores de correos electrónicos, entre otros; o c) cuando terceras personas realicen operaciones mercantiles que les garanticen el control sobre PortalHook. Los Usuarios declaran aceptar pertenecer a la lista de distribución de PortalHook, y en tal sentido, declaran conocer que al momento de registrarse como Usuarios será incluido en dicha lista de distribución, a menos que indique lo contrario. Los Usuarios declaran que los correos que reciban de PortalHook o los establecimientos proveedores del internet WIFI no serán considerados como mensajes "no solicitados". Los Usuarios podrán excluirse de la lista de distribución a través de la plataforma electrónica de PortalHook. Mientras los Usuarios estén registrados, PortalHook podrá utilizar la lista de distribución con fines comerciales y a los efectos de conseguir nuevos establecimientos proveedores de internet WIFI para los Usuarios. Los Usuarios podrán, igualmente, acceder, modificar o eliminar los datos personales en poder de PortalHook accediendo a su cuenta personal, o poniéndose en contacto con PortalHook directamente y acreditando su identidad. Los Usuarios también declaran aceptar que PortalHook podrá obtener y mantener información de los Usuarios que no constituyan datos personales, otorgando en tal sentido autorización amplia a PortalHook para que sea usada y compartida. PortalHook podrá instalar cookies en los sistemas de los Usuarios y almacenar información y datos no personales, para mejorar la calidad de los servicios.</p>

        <p style="text-align: justify;">Cualquier controversia o disputa que surja entre las partes con ocasión de los servicios, será resuelta de manera amistosa. Si esta solución amistosa no fuere posible, luego de explorar soluciones mutuamente satisfactorias durante un plazo de ciento veinte (120) días continuos, contados desde aquél en que una de las partes notifique a la otra de una controversia o disputa, las partes expresamente convienen en que será resuelta, exclusivamente, mediante un arbitraje institucional de Derecho, en la ciudad de Caracas de acuerdo con las disposiciones del Reglamento de Conciliación y Arbitraje del Centro Empresarial de Conciliación y Arbitraje (CEDCA). El Tribunal Arbitral estará integrado por tres (3) árbitros, seleccionados en la forma prevista en el citado Reglamento.</p>

        <p style="text-align: justify;">Las notificaciones que deba realizar PortalHook a los Usuarios podrán ser realizadas a través de su cuenta de correo electrónico depositada durante el registro de su cuenta en la plataforma. Los Usuarios podrán dirigir sus notificaciones a PortalHook a la siguiente dirección de correo electrónico: info@admingca.com.</p>

        <p style="text-align: justify;"><b>2.- Establecimientos proveedores de internet WIFI</b></p>

        <p>Todos los establecimientos que descarguen y/o instalen la aplicación que permite el uso de la plataforma tecnológica de PortalHook, aceptan de manera directa los términos y condiciones de uso acá descritos sin ninguna reserva así como cualquier condición adicional que en el futuro pudiera complementar estos términos.</p>

        <p style="text-align: justify;">Los establecimientos que descarguen y/o instalen la aplicación que permite el uso de la plataforma tecnológica de PortalHook lo hacen de forma voluntaria y asumen las obligaciones del mismo. Para poder utilizar la aplicación de PortalHook es obligatorio que los establecimientos se registren previamente, completando electrónicamente con datos exactos, verdaderos y actuales el formulario de registro proporcionado en la plataforma electrónica de PortalHook y creando su contraseña de acceso. Igualmente, están obligados a mantener actualizados sus datos de registro permanentemente. PortalHook se reserva el derecho a utilizar los medios que estime pertinentes para verificar la identidad de los Establecimientos, así como de requerir con dicho fin comprobantes o cualquier información adicional a la solicitada en el formulario de registro, cuando lo considere. Una vez registrados, los establecimientos podrán acceder a su cuenta particular en PortalHook, ingresando sus datos, incluyendo su contraseña de acceso y gozar de los beneficios de la aplicación. Los establecimientos no podrán contar con más de una cuenta de usuario, están obligados a mantener la confidencialidad de su contraseña de acceso y asumen que su cuenta es particular, única e intransferible, de modo que todas las operaciones efectuadas desde su cuenta particular son de su exclusiva responsabilidad. Los establecimientos serán responsable por guardar la seguridad de su contraseña y aceptan responsabilidad por las operaciones fraudulentas que puedan ser realizadas por medio del uso de las mismas, hasta el momento en que informe a PortalHook sobre la violación a la seguridad y confidencialidad de su contraseña. PortalHook se reserva el derecho de negar las solicitudes de registro o de suspender de forma temporal o definitiva a los establecimientos cuyos datos no sean posibles confirmar, sin que tal suspensión genere en ellos derecho a resarcimiento alguno. PortalHook no se hace responsable por la certeza de los datos de registro proporcionados por los Usuarios, quienes garantizan y se hacen responsables de forma exclusiva por la exactitud, veracidad y vigencia de sus datos de registro, así como de su capacidad legal para contratar y cumplir con todas las obligaciones contraídas, incluyendo con las contenidas en estos Términos y Condiciones y de su cumplimiento con las normas vigentes.</p>

        <p style="text-align: justify;">La información proporcionada en PortalHook se procesa y almacena en servidores o medios magnéticos que mantienen altos estándares de seguridad y protección física y tecnológica. PortalHook no garantiza el acceso y uso continuado e ininterrumpido a sus servicios, ni tampoco se hace responsable por cualquier violación o usurpación que pueda sufrir su sistema de seguridad, aunque declara que procurará solucionar las fallas ordinarias o extraordinarias que puedan presentarse con ocasión de fallas en los sistemas, en la internet o por cualquier otra circunstancia y hacer los esfuerzos necesarios para mantener la seguridad de su plataforma. Al registrarse, los establecimientos aceptan que PortalHook podrá hacer publicidad comercial en su aplicación que será observada por los Usuarios. PortalHook mantendrá la confidencialidad de los establecimientos, excepto en los siguientes casos: a) cuando le sean requeridos por las autoridades competentes; b) cuando a los fines de una prestación adecuada de los servicios deba compartirlos con terceros. Los establecimientos declaran aceptar pertenecer a la lista de distribución de PortalHook, y en tal sentido, declaran conocer que al momento de descargar la aplicación serán incluidos en dicha lista de distribución, a menos que indique lo contrario. Los establecimientos podrán eliminar la aplicación de PortalHook pero inmediatamente dejarán de gozar de los beneficios que disfrutan de la misma. Los establecimientos también declaran aceptar que PortalHook podrá obtener y mantener información de los Usuarios que no constituyan datos personales, otorgando en tal sentido autorización amplia a PortalHook para que sea usada y compartida. PortalHook podrá instalar cookies en los sistemas de los Usuarios y almacenar información y datos no personales, para mejorar la calidad de los servicios.</p>

        <p style="text-align: justify;">PortalHook no se hace responsable por los ingresos que hagan los Usuarios a portales en internet. El establecimiento expresamente reconoce que libera a PortalHook de toda responsabilidad por los accesos de los usuarios en cualquier contenido de Internet, en el entendido, que estos lo hacen bajo su propio riesgo y son ellos responsables de asegurarse de que cualquier página visitada o material descargado no infrinja las leyes, de forma exhaustiva que cubre, derechos de autor, marcas comerciales, la pornografía, o cualquier otro material que es calumnioso, difamatorio o pueda causar ofensa de cualquier otra manera.</p>

        <p style="text-align: justify;">La aplicación de PortalHook cuenta con protección contra virus, malware y anti spam, filtro de contenido prohibido y maliciosos según la legislación local actual, filtro de conexiones entre clientes y de conexiones bancarias o de transacciones así como un sistema de prevención de intrusos (IPS). Por ello, de ninguna forma ni en caso alguno PortalHook será responsable por los daños que puedan sufrir el establecimiento o los usuarios.</p>

        <p style="text-align: justify;">Cualquier controversia o disputa que surja entre las partes con ocasión de los servicios, será resuelta de manera amistosa. Si esta solución amistosa no fuere posible, luego de explorar soluciones mutuamente satisfactorias durante un plazo de ciento veinte (120) días continuos, contados desde aquél en que una de las partes notifique a la otra de una controversia o disputa, las partes expresamente convienen en que será resuelta, exclusivamente, mediante un arbitraje institucional de Derecho, en la ciudad de Caracas de acuerdo con las disposiciones del Reglamento de Conciliación y Arbitraje del Centro Empresarial de Conciliación y Arbitraje (CEDCA). El Tribunal Arbitral estará integrado por tres (3) árbitros, seleccionados en la forma prevista en el citado Reglamento.</p>

        <p style="text-align: justify;">Las notificaciones que deba realizar PortalHook a los establecimientos podrán ser realizadas a través de su cuenta de correo electrónico depositada durante el registro y descarga de la aplicación. Los establecimientos podrán dirigir sus notificaciones a PortalHook a la siguiente dirección de correo electrónico: <b>info@admingca.com.</b></p>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
      </div>
    </div>
  </div>
</div>

@include('layouts.partials.scripts_auth')

{!! Form::open(array('url' => '/send_info')) !!}
{!! Form::close() !!}

{!! Form::open(['route' => ['verifyusername', ':User'], 'method' =>'get', 'id' => 'form-verifyusername']) !!}
{!!Form::close() !!}


<script type="text/javascript">
$.noConflict();

$.ajaxSetup({
  headers: {
    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
  }
});

var vfecha=$('input[name="fecha_activacion"]'); //our date input has the name "date"
var container=$('.bootstrap-iso form').length>0 ? $('.bootstrap-iso form').parent() : "body";
var options={
  format: 'yyyy/mm/dd',
  container: container,
  todayHighlight: true,
  autoclose: true,
};
vfecha.datepicker(options); //initiali110/26/2015 8:20:59 PM ze plugin

$(function(){
 var _input = new inputShowPwd('inputShowPwd');
});

$(document).ready(function(){

  $('#btnregistrar').prop('disabled', true);

  $('.icheck').click(function() {
    if($('#checkbox1').is(":checked") && $('#checkbox2').is(":checked")){
      $('#btnregistrar').prop('disabled', false);
    }else
    $('#btnregistrar').prop('disabled', true);
  });

  $('#checlbox1').click(function() {
    if($('#checkbox1').is(":checked") && $('#checkbox2').is(":checked")){
      $('#btnregistrar').prop('disabled', false);
    }else
    $('#btnregistrar').prop('disabled', true);
  });

  $( ".servicio" ).change(function() {
    var servicio = $('.servicio').find(":selected").text();
    if(servicio === 'Basic')
    $(".contrato").attr("href", "{{ url('contract/basic') }}");
    else {
      $(".contrato").attr("href", "{{ url('contract/premium') }}");
    }
  });

  $( "#checlbox1" ).hover(function(){
    console.log('hover');
  });

  $('#username').on('input',function(e){
    var user = $('#username').val();
    if(user === ""){
      $('#allert').text('');
      $('#span1').html('<i class="fa fa-exclamation-circle"></i>');
    }else{
      var form = $('#form-verifyusername');
      var url = form.attr('action').replace(':User', user);
      var data = form.serialize();
      $.ajax({
        type: 'get',
        url: url,
        data: data,
        success: function(data){
          if(data == 'true'){
            $('#allert').text(' El username "'+user+'" esta en uso, intente con otro');
            $('#span1').html('<i class="fa fa-exclamation-circle"></i>');
          }else{
            $('#allert').text('');
            $('#span1').html('<i class="fa fa-check"></i>');
          }
        }
      });
    }
  });

  $('#pass1').on('input',function(e){
    var password1 = $('#pass1').val();
    var password2 = $('#pass2').val();

    if( $.trim(password1) == '' ){
      $('#passallert').text('Las contraseñas no pueden estar en blanco');

    }else{
      if(password1 == password2){
        $('#passallert').text('');

      }else{
        $('#passallert').text('Las contraseñas no coinciden');
      }
    }
  });


  $('#pass2').on('input',function(e){
    var password1 = $('#pass1').val();
    var password2 = $('#pass2').val();

    if( $.trim(password2) == '' ){
      $('#passallert').text('Las contraseñas no pueden estar en blanco');

    }else{
      if(password1 == password2){
        $('#passallert').text('');

      }else{
        $('#passallert').text('las contraseñas no coinciden');
      }
    }
  });




})
</script>
</body>

@endsection
