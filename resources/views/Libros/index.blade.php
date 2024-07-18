@include('layout.nav')
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <section class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1>Libros</h1>
        </div>
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="{{ url('/home')}}">Home</a></li>
            <li class="breadcrumb-item active">Libros</li>
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
                <h3 class="card-title">Lista de Libros</h3>
                <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                  <a  class="btn btn-outline-primary btn-sm mr-2 btn-modal" data-modal="Agregar"><i class="fas fa-book"></i> Nuevo Libro</a>          
                </div>
            </div>
            <!-- /.card-header -->
            <div class="card-body">
              <div class="table-responsive">
                <table id="tbLibros" class="table table-bordered table-hover">
                  <thead>
                      <tr>
                        <th class="text-center" width="150">Nombre</th>
                        <th class="text-center" width="150">Autor</th>
                        <th class="text-center" width="30">Editorial</th>
                        <th class="text-center" width="10">Año Edición</th>
                        <th class="text-center" width="50">Tipo Libro</th>
                        <th class="text-center" width="10">Estante</th>
                        <th class="text-center" width="10">Division</th>
                        <th class="text-center" width="20" >Signatura</th>
                        <th class="text-center" width="20" >Cantidad</th>
                        <th class="text-center" width="20" >Estado</th>
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
<div class="modal fade" id="modalLibro" data-backdrop="static" data-keyboard="false" style="z-index: 1050;">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
        <div class="overlay d-none">
          <i class="fas fa-2x fa-spinner fa-spin"></i>
        </div>
        <div class="modal-header bg-primary">
          <h4 class="modal-title" id="titulo"></h4>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close" id="close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
            <!-- general form elements disabled -->
              <div class="card-body">
                <form id="formLibro">
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
                          <label>Título</label>
                          <input type="text" class="form-control" name="tituloL" autocomplete="off" id="tituloL">
                      </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="form-group">
                            <label>Autor</label>
                            <input type="text" class="form-control" name="autor" autocomplete="off" id="autor">
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="form-group">
                            <label>Editorial</label>
                            <input type="text" class="form-control" name="editorial" autocomplete="off" id="editorial">
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="form-group">
                            <label>Año Edicion</label>
                            <input type="number" class="form-control" name="añoEdicion" autocomplete="off" id="añoEdicion">
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="form-group">
                            <label>Tipo Libro</label>
                            <select class="form-control" name="tipoLibro" id="tipoLibro">
                              <option value="Ministerio" selected>Ministerio</option>
                              <option value="Canje">Canje</option>
                              <option value="Compra">Compra</option>
                              <option value="Donación">Donación</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-sm-6">
                      <div class="form-group">
                          <label>Signatura</label>
                          <input type="text" class="form-control" name="signatura" autocomplete="off" id="signatura">
                      </div>
                  </div>
                    <div class="col-sm-9">
                        <div class="form-horizontal">
                          <div class="form-group row">
                            <label class="col-sm-2 mt-2">Estante</label>
                            <div class="col-sm-10">
                              <select class="form-control selecEtestante" style="width: 65%;" name="estante"  id="estante"> </select>
                            </div>
                          </div>
                        </div>
                    </div>
                    <div class="col-sm-3">
                      <div class="form-group">
                        <label></label>
                        <button type="button" class="btn btn-info modal-estante" data-ocupacion="Agregar"><i class="fas fa-plus"></i> Nuevo estante</button>             
                      </div>
                    </div>
                    <div class="col-sm-9">
                      <div class="form-horizontal">
                        <div class="form-group row">
                          <label class="col-sm-2 mt-2">División</label>
                          <div class="col-sm-10">
                            <select class="form-control selectDivision" style="width: 65%;" name="division"  id="division"> </select>
                          </div>
                        </div>
                      </div>
                  </div>
                  <div class="col-sm-3">
                    <div class="form-group">
                      <label></label>
                      <button type="button" class="btn btn-warning modal-division" data-ocupacion="Agregar"><i class="fas fa-plus"></i> Nueva división</button>             
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
                          <label>Estado del Libro</label>
                          <select class="form-control" name="estado" id="estado">
                            <option value="B" selected >Bueno</option>
                            <option value="R">Regular</option>
                            <option value="M">Malo</option>
                          </select>
                      </div>
                    </div>
                  </div>  
                </form>
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-danger" data-dismiss="modal">Cerrar</button>
                <button type="button" class="btn btn-success" id="btnFormLibro"></button>
              </div>
        </div>
      </div>
      <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>

<!-- MODAL NUEVA ESTANTE -->
<div class="modal fade" id="modalEstante" data-backdrop="static" style="z-index: 1051;" data-keyboard="false">
  <div class="modal-dialog modal-sm modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header bg-info">
        <h4 class="modal-title">Registrar nuevo estante</h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close" id="close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
            <form id="formEstante">
              @csrf
                <div class="mb-3">
                    <label for="nombre" class="form-label">Estante</label>
                    <input type="text" class="form-control" id="codEstante" name="codEstante"  autocomplete="off">
                </div>
          </form>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-danger" data-dismiss="modal">Cerrar</button>
          <button type="button" class="btn btn-success" id="btn-estante">Guardar</button>
      </div>
      </div>
    </div>
    <!-- /.modal-content -->
  </div>
  <!-- /.modal-dialog -->
</div>
<!-- MODAL NUEVA DIVISION -->
<div class="modal fade" id="modalDivision" data-backdrop="static" style="z-index: 1051;" data-keyboard="false">
  <div class="modal-dialog modal-sm modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header bg-warning">
        <h4 class="modal-title">Registrar nueva división</h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close" id="close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
            <form id="formDivision">
              @csrf
                <div class="mb-3">
                    <label for="nombre" class="form-label">División</label>
                    <input type="text" class="form-control" id="CodDivision" name="CodDivision"  autocomplete="off">
                </div>
          </form>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-danger" data-dismiss="modal">Cerrar</button>
          <button type="button" class="btn btn-success" id="btn-division">Guardar</button>
      </div>
      </div>
    </div>
    <!-- /.modal-content -->
  </div>
  <!-- /.modal-dialog -->
</div>
@include('layout.footer') 