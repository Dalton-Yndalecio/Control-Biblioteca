@include('layout.nav')
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <section class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1>Alumnos</h1>
        </div>
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="{{ url('/home')}}">Home</a></li>
            <li class="breadcrumb-item active">Alumnos</li>
          </ol>
        </div>
      </div>
    </div><!-- /.container-fluid -->
  </section>
  
  <section class="content">
    <div class="container-fluid">
      <div class="row">
        <div class="col-12">
          <div class="card">
            <div class="card-header">
                <h3 class="card-title">Lista de Alumnos</h3>
            </div>
            <!-- /.card-header -->
            <div class="card-body">
              <div class="table-responsive">
                <table id="tbAlumnos" class="table table-bordered table-hover">
                  <thead>
                      <tr>
                        <th class="text-center" width="150">Nombres</th>
                        <th class="text-center" width="150">Apellidos</th>
                        <th class="text-center" width="30">Grado</th>
                        <th class="text-center" width="10">Seccion</th>
                        <th class="text-center" width="50" >Acciones</th>
                      </tr>
                  </thead>
                </table>
              </div>
            </div>
            <!-- /.card-body -->
          </div>
          <!-- /.card -->
        </div>
        <!-- /.col -->
      </div>
      <!-- /.row -->
    </div>
    <!-- /.container-fluid -->
  </section>
  <!-- MODAL  EDIATR ALUMNO  -->
  <div class="modal fade" id="modalAlumno" data-backdrop="static" data-keyboard="false" style="z-index: 1050;">
      <div class="modal-dialog modal-lg">
        <div class="modal-content">
          <div class="modal-header bg-primary">
            <h4 class="modal-title">Actualizar Alumno</h4>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close" id="close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
              <!-- general form elements disabled -->
                <div class="card-body">
                  <form id="formAlumno">
                    @csrf
                    <div class="row">
                      <div class="col-sm-6">
                        <div class="form-group">
                            <label>Nombres</label>
                            <input type="text" class="form-control" name="nombreA" autocomplete="off" id="nombreA">
                        </div>
                      </div>
                      <div class="col-sm-6">
                          <div class="form-group">
                              <label>Apellidos</label>
                              <input type="text" class="form-control" name="apellidosA" autocomplete="off" id="apellidosA">
                          </div>
                      </div>
                      <div class="col-sm-6">
                          <div class="form-group">
                              <label>Grado</label>
                              <select class="form-control" name="gradoA" id="gradoA">
                                <option value="" selected> --- SELECCIONAR ---</option>
                                <option value="PRIMERO">PRIMERO</option>
                                <option value="SEGUNDO">SEGUNDO</option>
                                <option value="TERCERO">TERCERO</option>
                                <option value="TERCERO">CUARTO</option>
                                <option value="QUINTO">QUINTO</option>
                              </select>
                          </div>
                      </div>
                      <div class="col-sm-6">
                          <div class="form-group">
                              <label>Sección</label>
                              <select class="form-control" name="seccionA" id="seccionA">
                                <option value="" selected> --- SELECCIONAR ---</option>
                                <option value="A">A</option>
                                <option value="B">B</option>
                                <option value="ÚNICA">ÚNICA</option>
                              </select>
                          </div>
                      </div>
                    </div>  
                  </form>
                </div>
                <div class="modal-footer">
                  <button type="button" class="btn btn-danger" data-dismiss="modal">Cerrar</button>
                  <button type="button" class="btn btn-success" id="btnEditarAlumno">Actualizar</button>
                </div>
          </div>
        </div>
        <!-- /.modal-content -->
      </div>
      <!-- /.modal-dialog -->
  </div>


@include('layout.footer') 