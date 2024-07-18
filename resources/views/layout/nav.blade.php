@include('layout.header')
<body class="hold-transition sidebar-mini sidebar-collapse layout-fixed layout-navbar-fixed">
<div class="wrapper">
  <!-- Navbar -->
  <nav class="main-header navbar  navbar-expand navbar-white navbar-light">
    <!-- Left navbar links -->
    <ul class="navbar-nav">
      <li class="nav-item">
        <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
      </li>
    </ul>
    

    <!-- Right navbar links -->
    <ul class="navbar-nav ml-auto">
      <!-- Notifications Dropdown Menu -->
      <li class="nav-item dropdown">
        <a class="nav-link" data-toggle="dropdown" href="#">
          {{ Auth::user()->name }}
        </a>
        <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
          <a  class="dropdown-item">
            <a class="dropdown-item" href="{{ route('logout') }}"
                onclick="event.preventDefault();
                              document.getElementById('logout-form').submit();"><i class="fas fa-sign-out-alt"></i>
                {{ __('Cerrar Sesión') }}
            </a>

            <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                @csrf
            </form>
          </a>  
          <div class="dropdown-divider"></div>
          <a class="dropdown-item dropdown-footer">Configuración</a>
        </div>
      </li>
      <li class="nav-item">
        <a class="nav-link" data-widget="fullscreen" href="#" role="button">
          <i class="fas fa-expand-arrows-alt"></i>
        </a>
      </li>
    </ul>
  </nav>
  <!-- /.navbar -->

  <!-- Main Sidebar Container -->
  <aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="{{ url('/home')}}" class="brand-link">
      <img src="dist/img/logoCole.png" alt="César Vallejo Logo" class="brand-image  elevation-3" style="opacity: .8">
      <span class="brand-text font-weight-light"><strong>César </strong> Vallejo</span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
      <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column" hidden data-widget="treeview" role="menu" data-accordion="false">
          <!-- Add icons to the links using the .nav-icon class
          with font-awesome or any other icon font library -->
          <li class="nav-header">CONFIGURACIONES</li>
            <li class="nav-item">
            <a href="{{ url('/usuarios')}}" class="nav-link">
              <i class="fas fa-sort-amount-down"></i>
              <p>Vacantes</p>
            </a>
            </li>
            
          </li>
        </ul>
        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
          <!-- Add icons to the links using the .nav-icon class
          with font-awesome or any other icon font library -->
          <li class="nav-header"><i class="fas fa-folder-open"></i> MODULO BIBLIOTECA</li>
            <li class="nav-item">
            <a href="{{ url('/libros')}}" class="nav-link">
              <i class="fas fa-book"></i>
              <p>Libros</p>
            </a>
            </li>
            <li class="nav-item">
              <a href="{{ url('/moviliarios')}}" class="nav-link">
                <i class="fas fa-toolbox"></i>
                <p>Moviliarios</p>
              </a>
            </li>
            <li class="nav-item">
              <a href="{{ url('/alumnos')}}" class="nav-link">
                <i class="fas fa-user-graduate"></i>
                <p>Alumnos</p>
              </a>
            </li>
            <li class="nav-item">
              <a href="{{ url('/personal')}}" class="nav-link">
                <i class="fas fa-address-book"></i>
                <p>Personal</p>
              </a>
            </li>
            <li class="nav-item">
              <a href="{{ url('/prestamos')}}" class="nav-link">
                <i class="fas fa-clipboard-list"></i>
                <p>Prestamos</p>
              </a>
            </li>
          </li>
        </ul>
      </nav>
      <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
  </aside>

