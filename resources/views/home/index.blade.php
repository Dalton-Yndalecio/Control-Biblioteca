@include('layout.nav')
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <section class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
        </div>
      </div>
    </div><!-- /.container-fluid -->
  </section>
  <!-- Main content -->
  <div class="content">
    <div class="container-fluid">

      <div class="row">
        <div class="col-lg-3 col-6">
          <!-- small box -->
          <div class="small-box bg-info">
            <div class="inner">
              <h3><i class="fas fa-folder"></i> {{ $cantidadLibros }}</h3>

              <p>Libros</p>
            </div>
            <div class="icon">
                <i class="fas fa-book"></i>
            </div>
            <a href="{{ url('/libros')}}" class="small-box-footer">Ver Lista <i class="fas fa-arrow-circle-right"></i></a>
          </div>
        </div>
        <!-- ./col -->
        <div class="col-lg-3 col-6">
          <!-- small box -->
          <div class="small-box bg-success">
            <div class="inner">
              <h3><i class="fas fa-folder"></i> {{ $totalMobiliarios }} </h3>

              <p>Mobiliarios</p>
            </div>
            <div class="icon">
                <i class="fas fa-toolbox"></i>
            </div>
            <a href="{{ url('/moviliarios')}}" class="small-box-footer">Ver Lista <i class="fas fa-arrow-circle-right"></i></a>
          </div>
        </div>
        <!-- ./col -->
        <div class="col-lg-3 col-6">
          <!-- small box -->
          <div class="small-box bg-warning">
            <div class="inner">
              <h3><i class="fas fa-folder"></i> {{ $totalPrestamos }}</h3>

              <p>Prestamos</p>
            </div>
            <div class="icon">
                <i class="fas fa-clipboard-list"></i>
            </div>
            <a href="{{ url('/prestamos')}}" class="small-box-footer">Ver Lista <i class="fas fa-arrow-circle-right"></i></a>
          </div>
        </div>
        <!-- ./col -->
        <div class="col-lg-3 col-6">
          <!-- small box -->
          <div class="small-box bg-primary">
            <div class="inner">
              <h3><i class="fas fa-folder"></i> {{ $totalAlumnos }}</h3>

              <p>Alumnos</p>
            </div>
            <div class="icon">
                <i class="fas fa-user-graduate"></i>
            </div>
            <a href="{{ url('/alumnos')}}" class="small-box-footer">Ver Lista <i class="fas fa-arrow-circle-right"></i></a>
          </div>
        </div>
        <!-- ./col -->
        <div class="col-lg-3 col-6">
            <!-- small box -->
            <div class="small-box bg-primary">
              <div class="inner">
                <h3><i class="fas fa-folder"></i> {{ $totalPersonal }}</h3>
  
                <p>Personales</p>
              </div>
              <div class="icon">
                <i class="fas fa-user-friends"></i>
              </div>
              <a href="{{ url('/personal')}}" class="small-box-footer">Ver Lista <i class="fas fa-arrow-circle-right"></i></a>
            </div>
          </div>
          <!-- ./col -->
      </div>
      <!-- /.row -->


     
    </div>
    <!-- /.container-fluid -->
  </div>
  <!-- /.content -->
</div>



@include('layout.footer')

