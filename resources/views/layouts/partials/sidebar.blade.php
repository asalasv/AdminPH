<!-- Left side column. contains the logo and sidebar -->
<aside class="main-sidebar">

  <!-- sidebar: style can be found in sidebar.less -->
  <section class="sidebar">

    <!-- Sidebar user panel (optional) -->
    @if (! Auth::guest())
    <div class="user-panel" style="margin-bottom: 10px;margin-top: 10px;">
      <div class="pull-left image">
        @if(Session::has('client.logo'))
        <img src='{{ asset("images/$cliente->logo") }}' class="img-thumbnail" alt="User Image" />
        @else
        <img src="{{asset('/img/dashboard-1.jpg')}}" class="img-thumbnail" alt="User Image" />
        @endif

      </div>
      <div class="pull-left info" style="bottom: 0px;">
        <p>{{ Auth::user()->username }} <br/>
          <small>{{ Auth::user()->email }}</small></p>
          <!-- Status -->
          <a href="#"><i class="fa fa-circle text-success"></i> Online</a>
        </div>
      </div>
      @endif

      <!-- search form (Optional) -->
      <form action="#" method="get" class="sidebar-form">
        <div class="input-group">
          <input type="text" name="q" class="form-control" placeholder="Search..."/>
          <span class="input-group-btn">
            <button type='submit' name='search' id='search-btn' class="btn btn-flat"><i class="fa fa-search"></i></button>
          </span>
        </div>
      </form>
      <!-- /.search form -->

      <!-- Sidebar Menu -->
      <ul class="sidebar-menu ">
        <li class="header">MENÚ</li>
        <!-- Optionally, you can add icons to the links -->
        <li class="treeview"><a href="{{ url('home') }}"><i class='fa fa-home'></i> <span>Home</span></a></li>
        <li class="treeview"><a href="#" data-toggle="modal" data-target="#SelectModal"><i class='fa fa-building'></i> <span>Clientes</span></a></li>
        <li class="treeview" id="menu-grafic">
          <a href="#"><i class='fa fa-line-chart'></i> <span>Estadísticas</span> <i class="fa fa-angle-left pull-right"></i></a>
          <ul class="treeview-menu">
            <li><a href="{{ url('connectlastweek') }}">Conexiones al Portal</a></li>
            <li><a href="{{ url('lastweekreg') }}">Registros por Período</a></li>
            <li><a href="{{ url('newlastweekreg') }}">Registros Usuarios Nuevos</a></li>
            <!-- <li><a href="{{ url('portalhookuserreg') }}">Usuarios PH vs Visitantes</a></li>
            <li><a href="{{ url('sexportalhookuserreg') }}">Registro Usuarios por Género</a></li> -->
            <li><a href="{{ url('recurrenciaporc') }}">Porcentaje de Recurrencia</a></li>
            <li><a href="{{ url('dispmasconect') }}">Dispositivos mas conectados</a></li>
          </ul>
        </li>
        <li class="treeview" id="menu-sesiones">
          <a href="#"><i class='fa fa-wifi'></i> <span>Sesiones</span> <i class="fa fa-angle-left pull-right"></i></a>
          <ul class="treeview-menu">
            <li><a href="{{ url('coneccfraudulentas') }}"><i class="fa fa-warning"></i>Conexiones Fraudulentas</a></li>
            <li><a href="{{ url('sesiones') }}"><i class="fa fa-users"></i>Usuarios Conectados</a></li>
            <li><a href="{{ url('gestion') }}"><i class="fa fa-eye"></i>Gestion de Dispositivos</a></li>
          </ul>
        </li>
        @if(Session::has('activo'))
        @if( $cliente->emailing_activo == 'V' )
        <li class="treeview"><a href="{{ url('e-mailing') }}"><i class='fa fa-envelope'></i> <span>E-mailing</span></a></li>
        @endif
        @endif
        @if( Auth::user()->id_usuario_web == '1' or Auth::user()->id_usuario_web == '29')
        <li class="treeview"><a href="{{ url('indicadores') }}"><i class='fa fa-bar-chart'></i> <span>Indicadores</span></span></a></li>
        @endif
        <li class="treeview" id="menu-config">
          <a href="#"><i class='fa fa-gear'></i> <span>Configuración</span> <i class="fa fa-angle-left pull-right"></i></a>
          <ul class="treeview-menu">
            <li><a href="{{ url('manejo_portal') }}"><i class='fa fa-gear'></i>Ajustes Portal</a></li>
            <li><a href="{{ url('portales') }}"><i class='fa fa-desktop'></i>Portales</a></li>
            @if( Auth::user()->id_usuario_web == '1' or Auth::user()->id_usuario_web == '29')
            <li><a href="{{ url('usuarios') }}"><i class='fa fa-users'></i>Tipo de Cliente</a></li>
            @else
            @if(isset($cliente))
            @if($cliente->privado == 'V')
            <li><a href="{{ url('usuarios') }}"><i class='fa fa-users'></i>Gestion de Usuarios</a></li>
            @endif
            @endif
            @endif
            <li class="treeview" id="menu-cuenta">
              <a href="#"><i class='fa fa-user'></i> <span>Cuenta</span><i class="fa fa-angle-left pull-right"></i></a>
              <ul class="treeview-menu">
                <li><a href="{{ url('changepass') }}">Cambiar Password</a></li>
                <li><a href="{{ url('cliente/logo') }}">Cambiar Imagen</a></li>
              </ul>
            </li>
            @if( Auth::user()->id_usuario_web == '1' or Auth::user()->id_usuario_web == '29')
            <li><a href="{{ url('verify-email') }}"><i class='fa fa-send'></i>Emailing Masivo</a></li>
            <li class="treeview"><a href="{{ url('emailcertification') }}"><i class='fa fa-check-square-o'></i><span>Certificación de Emails</span></span></a></li>
            @endif
          </ul>
        </li>
      </ul><!-- /.sidebar-menu -->
    </section>
    <!-- /.sidebar -->
  </aside>
