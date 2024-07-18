@include('layout.nav')
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <section class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1>Moviliarios</h1>
        </div>
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="{{ url('/home')}}">Home</a></li>
            <li class="breadcrumb-item active">Moviliarios</li>
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
                <h3 class="card-title">Lista de Moviliarios</h3>
                <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                  <a  class="btn btn-outline-primary btn-sm mr-2 btn-modal" data-modal="Agregar"><i class="fas fa-toolbox"></i> Nuevo Moviliario</a>          
                </div>
            </div>
            <!-- /.card-header -->
            <div class="card-body">
              <div class="table-responsive">
                <table id="tbMoviliario" class="table table-bordered table-hover">
                  <thead>
                      <tr>
                        <th class="text-center" width="150">Nombre</th>
                        <th class="text-center" width="20" >Signatura</th>
                        <th class="text-center" width="20" >Cantidad</th>
                        <th class="text-center" width="50" >Estado</th>
                        <th class="text-center" width="150" >Observacion</th>
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
  <!-- MODAL  APODERADO  -->
<div class="modal fade" id="modalMoviliario" data-backdrop="static" data-keyboard="false" style="z-index: 1050;">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
        <div class="overlay d-none">
          <i class="fas fa-2x fa-spinner fa-spin"></i>
        </div>
        <div class="modal-header bg-primary">
          <h4 class="modal-title" id="tituloMov"></h4>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close" id="close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
            <!-- general form elements disabled -->
              <div class="card-body">
                <form id="formMoviliario">
                  @csrf
                  <div class="row">
                    {{--  <div class="col-sm-9">
                        <div class="form-horizontal">
                          <div class="form-group row">
                            <label class="col-sm-2 mt-2">OCUPACION</label>
                            <div class="col-sm-10">
                              <select class="form-control select2" style="width: 65%;" name="ocupacion_id"  id="ocupacion_id"> </select>
                            </div>
                          </div>
                        </div>
                    </div>
                    <div class="col-sm-3">
                      <div class="form-group">
                        <label></label>
                        <button type="button" class="btn btn-warning modal-ocupacion" data-ocupacion="Agregar"><i class="fas fa-plus"></i> Nueva Ocupacion</button>             
                      </div>
                    </div>  --}}
                    <div class="col-sm-6">
                      <div class="form-group">
                          <label>Nombre</label>
                          <input type="text" class="form-control" name="nombre" autocomplete="off" id="nombre">
                      </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="form-group">
                            <label>Signatura</label>
                            <input type="text" class="form-control" name="signatura" autocomplete="off" id="signatura">
                        </div>
                    </div>
                    <div class="col-sm-6">
                      <div class="form-group">
                          <label>Cantidad</label>
                          <input type="number" class="form-control" name="cantidad" autocomplete="off" id="cantidad">
                      </div>
                    </div>
                    <div class="col-sm-6">
                      <div class="form-group">
                          <label>Estado del moviliario</label>
                          <select class="form-control" name="estado" id="estado">
                            <option value="B" selected >Bueno</option>
                            <option value="R">Regular</option>
                            <option value="M">Malo</option>
                          </select>
                      </div>
                    </div>
                    <div class="col-sm-12">
                        <div class="form-group">
                          <label>OBSERVACIONES :</label>
                          <textarea class="form-control" placeholder="observacion ..." name="observacion" id="observacion"></textarea>
                        </div>  
                      </div>
                  </div>  
                </form>
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-danger" data-dismiss="modal">Cerrar</button>
                <button type="button" class="btn btn-success" id="btnformMoviliario"></button>
              </div>
        </div>
      </div>
      <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>

<!-- MODAL NUEVA OCUPACION -->
<div class="modal fade" id="modalocupacion" data-backdrop="static" style="z-index: 1051;" data-keyboard="false">
  <div class="modal-dialog modal-sm modal-dialog-centered">
    <div class="modal-content">
      <div class="overlay d-none">
        <i class="fas fa-2x fa-spinner fa-spin"></i>
      </div>
      <div class="modal-header bg-warning">
        <h4 class="modal-title" id="tituloOcupacion"></h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close" id="close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
            <form id="formOcupacion">
              @csrf
                <div class="mb-3">
                    <label for="nombre" class="form-label">Ocupacion</label>
                    <input type="text" class="form-control" id="nombre" name="nombre"  autocomplete="off">
                </div>
          </form>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-danger" data-dismiss="modal">Cerrar</button>
          <button type="button" class="btn btn-success" id="btn-ocupacion">Guardar</button>
      </div>
      </div>
    </div>
    <!-- /.modal-content -->
  </div>
  <!-- /.modal-dialog -->
</div>
@include('layout.footer') 