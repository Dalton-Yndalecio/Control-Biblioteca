@include('layout.nav')
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <section class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1>Personal</h1>
        </div>
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="{{ url('/home')}}">Home</a></li>
            <li class="breadcrumb-item active">Personal</li>
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
                <h3 class="card-title">Lista de Personal</h3>
            </div>
            <!-- /.card-header -->
            <div class="card-body">
              <div class="table-responsive">
                <table id="tbPersonal" class="table table-bordered table-hover">
                  <thead>
                      <tr>
                        <th class="text-center" width="150">Nombres</th>
                        <th class="text-center" width="150">Apellidos</th>
                        <th class="text-center" width="30">Cargo</th>
                        <th class="text-center" width="100">Especialidad</th>
                        <th class="text-center" width="50">Condición</th>
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
  <div class="modal fade" id="modalPersonal" data-backdrop="static" data-keyboard="false" style="z-index: 1050;">
      <div class="modal-dialog modal-lg">
        <div class="modal-content">
          <div class="modal-header bg-primary">
            <h4 class="modal-title">Actualizar Personal</h4>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close" id="close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
              <!-- general form elements disabled -->
                <div class="card-body">
                  <form id="formPersonal">
                    @csrf
                    <div class="row">
                      <div class="col-sm-6">
                        <div class="form-group">
                            <label>Nombres</label>
                            <input type="text" class="form-control" name="nombreP" autocomplete="off" id="nombreP">
                        </div>
                      </div>
                      <div class="col-sm-6">
                          <div class="form-group">
                              <label>Apellidos</label>
                              <input type="text" class="form-control" name="apellidosP" autocomplete="off" id="apellidosP">
                          </div>
                      </div>
                      <div class="col-sm-6">
                        <div class="form-group">
                            <label>Cargo</label>
                            <input type="text" class="form-control" name="cargoP" autocomplete="off" id="cargoP">
                        </div>
                      </div>
                      <div class="col-sm-6">
                        <div class="form-group">
                            <label>Especialidad</label>
                            <input type="text" class="form-control" name="especialidadP" autocomplete="off" id="especialidadP">
                        </div>
                      </div>
                        <div class="col-sm-6">
                          <div class="form-group">
                              <label>Condición</label>
                              <input type="text" class="form-control" name="condicionP" autocomplete="off" id="condicionP">
                          </div>
                        </div>
                      </div>
                    </div>  
                  </form>
                </div>
                <div class="modal-footer">
                  <button type="button" class="btn btn-danger" data-dismiss="modal">Cerrar</button>
                  <button type="button" class="btn btn-success" id="btnEditarPersonal">Actualizar</button>
                </div>
          </div>
        </div>
        <!-- /.modal-content -->
      </div>
      <!-- /.modal-dialog -->
  </div>


@include('layout.footer') 