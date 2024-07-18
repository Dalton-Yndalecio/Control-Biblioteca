@include('layout.nav')
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <section class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1>Préstamos</h1>
        </div>
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="{{ url('/home')}}">Home</a></li>
            <li class="breadcrumb-item active">Préstamos</li>
          </ol>
        </div>
      </div>
    </div><!-- /.container-fluid -->
  </section>
  
  <section class="content">
    <div class="container-fluid">
      <!-- /.card -->
        <div class="card card-primary card-outline">
          <div class="card-body">
           
            <div class="card-header">
              <h3 class="card-title mt-5">Lista de Préstamos</h3>
              <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                <a  class="btn btn-outline-danger btn-sm mr-2 btn-reportes" ><i class="fas fa-file"></i>Reporte PDF</a>
                <a  class="btn btn-outline-primary btn-sm mr-2 btn-prestamos-alumno" data-modal="Agregar"><i class="fas fa-book"></i> Nuevo P.L Alumno</a>
                <a  class="btn btn-outline-success btn-sm mr-2 btn-prestamos-PLP"><i class="fas fa-book"></i> Nuevo P. L. Personal</a>      
 
              </div>
            </div>
            <!-- /.card-header -->
              <div class="card-body">
                <div class="table-responsive">
                  <table id="tbPrestamos" class="table table-bordered table-hover">
                    <thead>
                        <tr>
                          <th class="text-center" width="150">Persona</th>
                          <th class="text-center" width="50">Prestado</th>
                          <th class="text-center" width="50">Fecha salida</th>
                          <th class="text-center" width="30">Estado</th>
                          <th class="text-center" width="30" >Acciones</th>
                        </tr>
                    </thead>
                  </table>
                </div>
              </div>
              <!-- /.card-body -->
            </div>
          </div>
        </div>
      
    </div>
    <!-- /.container-fluid -->
  </section>


  <!-- MODAL  HACER PRESTAMO DE LIBROS A PERSONAL  -->
<div class="modal fade" id="modalPrestamoLibroPersonal" data-backdrop="static" data-keyboard="false" style="z-index: 1050;">
    <div class="modal-dialog modal-xl modal-dialog-scrollable">
      <div class="modal-content">
        <div class="overlay d-none">
          <i class="fas fa-2x fa-spinner fa-spin"></i>
        </div>
        <div class="modal-header bg-primary">
          <h4 class="modal-title">Préstamo de Libro a Personal</h4>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close" id="close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
            
            <!-- general form elements disabled -->
              <div class="card-body">
                <form id="formPLibrosP">
                  @csrf
                  <section class="content">
                    <div class="container-fluid">
                        <div class="row">
                          <div class="col-lg-3 col-6">
                              <div class="form-group">
                                  <label>Nombres</label>
                                  <input type="text" class="form-control" name="nombresPL" autocomplete="off" id="nombresPL">
                              </div>
                            </div>
                            <!-- ./col -->
                            <div class="col-lg-3 col-6">
                              <div class="form-group">
                                  <label>Apelldios</label>
                                  <input type="text" class="form-control" name="apellidosPL" autocomplete="off" id="apellidosPL">
                              </div>
                            </div>
                            <!-- ./col -->
                            <div class="col-lg-3 col-6">
                              <div class="form-group">
                                  <label>Cargo</label>
                                  <input type="text" class="form-control" name="cargoPL" autocomplete="off" id="cargoPL">
                              </div>
                            </div>
                            <!-- ./col -->
                            <div class="col-lg-3 col-6">
                              <div class="form-group">
                                  <label>Especialidad</label>
                                  <input type="text" class="form-control" name="especialidadPL" autocomplete="off" id="especialidadPL">
                              </div>
                            </div>
                            <!-- ./col -->
                            <div class="col-lg-3 col-6">
                              <div class="form-group">
                                  <label>Condición</label>
                                  <input type="text" class="form-control" name="condicionPL" autocomplete="off" id="condicionPL">
                              </div>
                            </div>
                            <div class="col-lg-3 col-6">
                              <div class="form-group">
                                  <label>Tipo Objeto</label>
                                  <select id="cboTipoObjeto" class="form-control">
                                    <option value="Libros" selected>Libros</option>
                                    <option value="Mobiliarios">Mobiliarios</option>
                                  </select>
                              </div>
                            </div>
                        </div>
                    </div>
                  </section>
                </form>
                <form id="addListaPrestamoP">
                <section class="content">
                  <div class="container-fluid">
                    <div class="row">
                      <div class="col-lg-3 col-6" id="divtipoLibros">
                          <div class="form-group">
                              <label>Tipo Libro</label>
                              <select class="form-control" name="tipoObjeto" id="tipoObjeto">
                                  <option value="Ministerio" selected>Ministerio</option>
                                  <option value="Canje">Canje</option>
                                  <option value="Compra">Compra</option>
                                  <option value="Donación">Donación</option>
                              </select>
                          </div>
                      </div> 
                        <div class="col-lg-6 col-12" id="divLibros">
                            <div class="form-group">
                                <label>Libro</label>
                                <select class="form-control LibrosP" name="idobjetoP" id="idobjetoP"></select>
                            </div>
                        </div>
                        <div class="col-lg-6 col-12 d-none" id="divMobiliarios">
                          <div class="form-group">
                              <label>Mobiliario</label>
                              <select class="form-control MobiliariosP" name="MobiliarioId" id="MobiliarioId"></select>
                          </div>
                      </div>
                        <div class="col-lg-3 col-6">
                            <div class="form-group">
                                <label>Estado</label>
                                <select class="form-control" name="estado" id="estado">
                                    <option value="B" selected >Bueno</option>
                                    <option value="R">Regular</option>
                                    <option value="M">Malo</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-lg-3 col-6">
                            <div class="form-group">
                                <label>Fecha Retorno</label>
                                <input type="date" class="form-control" name="FRetorno" autocomplete="off" id="FRetorno">
                            </div>
                        </div>
                        <div class="col-lg-3 col-6 d-flex align-self-center">
                          <button class="btn btn-primary" type="button" id="btnAddLisTemPLP" style="flex-grow:1;"><i class="fas fa-folder-plus"></i>  Agregar a Lista</button>
                      </div>
                    </div>
                  </div>
                </section>
                
                </form>
                  <section class="content">
                    <div class="container-fluid">
                        <div class="table-responsive">
                            <table id="tbListaLibrosPP" class="table table-bordered table-hover">
                              <thead>
                                  <tr>
                                    <th class="text-center" width="20">Id</th>
                                    <th class="text-center" width="150">Nombre</th>
                                    <th class="text-center" width="30">Cantidad</th>
                                    <th class="text-center" width="50">Estado</th>
                                    <th class="text-center" width="50">fecha Retorno</th>
                                    <th class="text-center" width="50" >Acciones</th>
                                  </tr>
                              </thead>
                              <tbody></tbody>
                            </table>
                          </div>
                    </div>
                  </section>
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-danger" data-dismiss="modal">Cerrar</button>
                <button type="button" class="btn btn-success" id="btnRegistrarPLP">Registrar</button>
              </div>
        </div>
      </div>
      <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
<!-- MODAL  HACER PRESTAMO A ALUMNO  -->
<div class="modal fade" id="modalPrestamoAlumno" data-backdrop="static" data-keyboard="false" style="z-index: 1050;">
    <div class="modal-dialog modal-xl modal-dialog-scrollable">
      <div class="modal-content">
        <div class="overlay d-none">
          <i class="fas fa-2x fa-spinner fa-spin"></i>
        </div>
        <div class="modal-header bg-primary">
          <h4 class="modal-title" id="tituloPA"></h4>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close" id="close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
            
            <!-- general form elements disabled -->
              <div class="card-body">
                <form id="formDatosAlumnoP">
                  @csrf
                  <section class="content">
                    <div class="container-fluid">
                        <div class="row">
                          <div class="col-lg-3 col-6">
                              <div class="form-group">
                                  <label>Nombres</label>
                                  <input type="text" class="form-control" name="nombres" autocomplete="off" id="nombres">
                              </div>
                            </div>
                            <!-- ./col -->
                            <div class="col-lg-3 col-6">
                              <div class="form-group">
                                  <label>Apelldios</label>
                                  <input type="text" class="form-control" name="apellidos" autocomplete="off" id="apellidos">
                              </div>
                            </div>
                            <!-- ./col -->
                            <div class="col-lg-3 col-6">
                              <div class="form-group">
                                  <label>Grado</label>
                                  <select class="form-control" name="grado" id="grado">
                                      <option value="">-- ELEGIR--</option>
                                      <option value="PRIMERO" >PRIMERO</option>
                                      <option value="SEGUNDO">SEGUNDO</option>
                                      <option value="TERCERO">TERCERO</option>
                                      <option value="CUARTO">CUARTO</option>
                                      <option value="QUINTO">QUINTO</option>
                                  </select>
                              </div>
                            </div>
                            <!-- ./col -->
                            <div class="col-lg-3 col-6">
                              <div class="form-group">
                                  <label>Seccion</label>
                                  <select class="form-control" name="seccion" id="seccion">
                                      <option value="">-- ELEGIR--</option>
                                      <option value="A" >A</option>
                                      <option value="B">B</option>
                                      <option value="ÚNICA">ÚNICA</option>
                                  </select>
                              </div>
                            </div>
                        </div>
                    </div>
                  </section>
                </form>
                <form id="addListaPrestamoA">
                <section class="content">
                  <div class="container-fluid">
                    <div class="row">
                      <div class="col-lg-3 col-6">
                          <div class="form-group">
                              <label>Tipo Libro</label>
                              <select class="form-control" name="tipoObjetoA" id="tipoObjetoA">
                                  <option value="Ministerio" selected>Ministerio</option>
                                  <option value="Canje">Canje</option>
                                  <option value="Compra">Compra</option>
                                  <option value="Donación">Donación</option>
                              </select>
                          </div>
                      </div> 
                        <div class="col-lg-6 col-12">
                            <div class="form-group">
                                <label>Libro</label>
                                <select class="form-control LibrosA" name="idobjeto" id="idobjeto"></select>
                            </div>
                        </div>
                        {{--  <div class="col-lg-3 col-6">
                            <div class="form-group">
                                <label>Cantidad</label>
                                <input type="number" class="form-control" name="cantidad" autocomplete="off" id="cantidad" value="1">
                            </div>
                        </div>  --}}
                        <div class="col-lg-3 col-6">
                            <div class="form-group">
                                <label>Estado</label>
                                <select class="form-control" name="estadoA" id="estadoA">
                                    <option value="B" selected >Bueno</option>
                                    <option value="R">Regular</option>
                                    <option value="M">Malo</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-lg-3 col-6">
                            <div class="form-group">
                                <label>Fecha Retorno</label>
                                <input type="date" class="form-control" name="FRetornoA" autocomplete="off" id="FRetornoA">
                            </div>
                        </div>
                        <div class="col-lg-3 col-6 d-flex align-self-center">
                          <button class="btn btn-primary" type="button" id="btnAPLPT" style="flex-grow:1;"><i class="fas fa-folder-plus"></i>  Agregar a Lista</button>
                      </div>
                    </div>
                  </div>
                </section>
                
                </form>
                  <section class="content">
                    <div class="container-fluid">
                        <div class="table-responsive">
                            <table id="tbTempObjetos" class="table table-bordered table-hover">
                              <thead>
                                  <tr>
                                    <th class="text-center" width="20">Id</th>
                                    <th class="text-center" width="150">Nombre</th>
                                    <th class="text-center" width="30">Cantidad</th>
                                    <th class="text-center" width="50">Estado</th>
                                    <th class="text-center" width="50">fecha Retorno</th>
                                    <th class="text-center" width="50" >Acciones</th>
                                  </tr>
                              </thead>
                              <tbody></tbody>
                            </table>
                          </div>
                    </div>
                  </section>
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-danger" data-dismiss="modal">Cerrar</button>
                <button type="button" class="btn btn-success" id="btnformPrestamoAlumno"></button>
              </div>
        </div>
      </div>
      <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>


<!-- MODAL VER DETALLES DE PRESTAMOS ALUMNOS -->
<div class="modal fade" id="verDetallesAlumno" data-backdrop="static" style="z-index: 1051;" data-keyboard="false">
  <div class="modal-dialog modal-xl">
    <div class="modal-content">
      <div class="overlay d-none">
        <i class="fas fa-2x fa-spinner fa-spin"></i>
      </div>
      <div class="modal-header bg-info">
        <h4 class="modal-title">Detalles de Prestamo</h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close" id="close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <div class="table-responsive">
          <table id="tbDetallesAlumno" class="table table-bordered table-hover">
            <thead>
                <tr>
                  <th class="text-center" width="200" >Nombre</th>
                  {{--  <th class="text-center" width="200">Autor</th>
                  <th class="text-center" width="200">Editorial</th>
                  <th class="text-center" width="200">Año Edicion</th>
                  <th class="text-center" width="100">Tipo Libro</th>  --}}
                  <th class="text-center" width="200">Signatura</th>
                  <th class="text-center" width="100">Ubicación</th>
                  <th class="text-center" width="20">Cantidad</th>
                  <th class="text-center" width="20">Estado del Objeto</th>
                  <th class="text-center" width="100">Esatdo Prestamo</th>
                  <th class="text-center" width="100">Fecha Retorno</th>
                  <th class="text-center" width="100">Fecha Entrega</th>
                  <th class="text-center" width="100">Acciones</th>
                </tr>
            </thead>
            <tbody></tbody>

            
          </table>
        </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-danger" data-dismiss="modal">Cerrar</button>
      </div>
      </div>
    </div>
    <!-- /.modal-content -->
  </div>
  <!-- /.modal-dialog -->
</div>
@include('layout.footer') 