
$(document).ready(function(){
     var tabla = $('#tbPrestamos').DataTable({
        processing: true,
        serverSide: true,
        ajax: '/prestamos', 
        language: {
            "decimal": "",
            "emptyTable": "No hay información",
            "info": "Mostrando _START_ a _END_ de _TOTAL_ Registros",
            "infoEmpty": "Mostrando 0 a 0 de 0 Registros",
            "infoFiltered": "(Filtrado de _MAX_ total Registros)",
            "infoPostFix": "",
            "thousands": ",",
            "lengthMenu": "Mostrar _MENU_ Registros",   
            "loadingRecords": "Cargando...",
            "processing": "Cargando...",
            "search": "Buscar:",
            "zeroRecords": "Sin resultados encontrados",
            "paginate": {
                "first": "Primero",
                "last": "Ultimo",
                "next": "Siguiente",
                "previous": "Anterior"
            }
        },
        columns: [
            {data: 'personas'},
            {data: 'mensajeNuevo'},
            {data: 'FSalida'},
            {data: 'EstadoP',
                render: function(data) {
                    if (data === 'Pendiente') {
                        return '<span class="badge badge-warning">' + data + '</span>';
                    } else if (data === 'Entregado') {
                        return '<span class="badge badge-success">' + data + '</span>';
                    }
                    else if (data === 'Vencido') {
                        return '<span class="badge badge-danger">' + data + '</span>';
                    }
                    return data;
                },
            },
            {data: 'action', orderable: false},
        ]
    });

    $(".cantidadA").on("input", function() {
        // Remover caracteres no numéricos y mantener solo números
        var inputValue = $(this).val().replace(/[^0-9]/g, "");
        $(this).val(inputValue);
    });
       // ---- ACTIVA EL COMBO BOX DE SELECT 2 -----
    $('.LibrosA').select2()
    

    // Función para llenar el combo idobjeto
    function llenarComboIdObjeto(selectedTipo) {
        // Realizar una solicitud AJAX al servidor para obtener objetos relevantes
        $.get('/prestamos/selectLibrosN', { tipoObjeto: selectedTipo }, function(data) {
            // Limpiar el combo idobjeto
            $("#idobjeto").empty();
            // Agregar una opción predeterminada
            $("#idobjeto").append('<option value="">--------- SELECCIONAR ---------</option>');
            // Llenar el combo idobjeto con los datos recibidos
            $.each(data, function() {
                $("#idobjeto").append('<option value="' + this.id + '">' + this.Nombre + ' ['+this.Signatura+' ]'+ '</option>');
            });
        });
    }
    // Función para llenar el combo idobjeto

    $('.LibrosP').select2()
    function llenarComboIdObjetoP(selectedTipoP) {
        // Realizar una solicitud AJAX al servidor para obtener objetos relevantes
        $.get('/prestamos/selectLibrosNP', { tipoObjeto: selectedTipoP }, function(data) {
            // Limpiar el combo idobjeto
            $("#idobjetoP").empty();
            // Agregar una opción predeterminada
            $("#idobjetoP").append('<option value="">--------- SELECCIONAR ---------</option>');
            // Llenar el combo idobjeto con los datos recibidos
            $.each(data, function() {
                $("#idobjetoP").append('<option value="' + this.id + '">' + this.Nombre + ' ['+this.Signatura+' ]'+ '</option>');
            });
        });
    }

    $('.MobiliariosP').select2()

    function llenarComboMobiliarios(){
        $.get('/prestamos/mobiliarios', { tipoObjeto: selectedTipoP }, function(data) {
            // Limpiar el combo idobjeto
            $("#MobiliarioId").empty();
            // Agregar una opción predeterminada
            $("#MobiliarioId").append('<option value="">--------- SELECCIONAR ---------</option>');
            // Llenar el combo idobjeto con los datos recibidos
            $.each(data, function() {
                $("#MobiliarioId").append('<option value="' + this.id + '">' + this.Nombre + ' ['+this.Signatura+' ]'+ '</option>');
            });
        });
    }
    llenarComboMobiliarios();

    // Llena el combo idobjeto al cargar la página con el valor predeterminado seleccionado
    var selectedTipo = $("#tipoObjetoA").val();
    if (selectedTipo) {
        llenarComboIdObjeto(selectedTipo);
    }
        // Evento de cambio en el combo tipoObjeto
    $("#tipoObjetoA").change(function() {
        var selectedTipo = $(this).val();
        llenarComboIdObjeto(selectedTipo);
    });
    // Llena el combo idobjeto al cargar la página con el valor predeterminado seleccionado
    var selectedTipoP = $("#tipoObjeto").val();
    if (selectedTipoP) {
        llenarComboIdObjetoP(selectedTipoP);
    }
        // Evento de cambio en el combo tipoObjeto
    $("#tipoObjeto").change(function() {
        var selectedTipoP = $(this).val();
        llenarComboIdObjetoP(selectedTipoP);
    });
    //--- INPUT EN MAYUSCULA ---//
    $("#formDatosAlumnoP input[type='text']").on('input', function() {
        var valorActual = $(this).val().toLowerCase()
        var valorEnMayusculas = valorActual.toUpperCase();
        $(this).val(valorEnMayusculas);
       
    });
    $("#formPLibrosP input[type='text']").on('input', function() {
        var valorActual = $(this).val().toLowerCase()
        var valorEnMayusculas = valorActual.toUpperCase();
        $(this).val(valorEnMayusculas);
       
    });
    $(document).on('click', '.btn-prestamos-alumno', function(){
        var modal = $(this).attr('data-modal')
        $("#tituloPA").html(modal + " Préstamo a Alumno");
        $("#btnformPrestamoAlumno").html(modal);
        $("#modalPrestamoAlumno").modal('toggle');
        $("#tbTempObjetos tbody").empty();
        $("#btnAPLPT").on('click', function(){
            if ($('#addListaPrestamoA').valid()) {
                var idObjeto = $("#idobjeto option:selected").val();
                
                var NombreObjeto  = $("#idobjeto option:selected").text();
                //var cantidad  = $("#cantidad").val();
                var EstadoA  = $("#estadoA option:selected").val();
                var FRetornoA = $("#FRetornoA").val();
                
                // Agregar una nueva fila a la tabla
                var fila = "<tr><td>" + idObjeto + "</td><td>" + NombreObjeto + "</td><td><input type='number' class='form-control cantidadA' value='1'></td><td>" + EstadoA + "</td><td>" + FRetornoA + "</td><td><button class='btn btn-danger btn-sm btn-eliminar'>Eliminar</button></td></tr>";

                $("#tbTempObjetos").append(fila);
        
                // Limpiar los campos del formulario
                $("#tipoObjeto").val("Ministerio");
                //$("#idobjeto").val("");
                $("#idobjeto").select2('destroy').empty();
                // ---- ACTIVA EL COMBO BOX DE SELECT 2 -----
                $('.LibrosA').select2()
                llenarComboIdObjeto(selectedTipoP);
                
                $("#cantidadA").val(1);
                $("#estadoA").val("B");
                $("#FRetornoA").val("");
            }
        })
        $("#tbTempObjetos").on("click", ".btn-eliminar", function() {
            $(this).closest("tr").remove();
        });
        
        // Desvincular eventos click anteriores para evitar duplicación
        $("#btnformPrestamoAlumno").off('click').on('click', function(){
            if ($('#formDatosAlumnoP').valid()) {
                var idObjetoA = [];
                var NombreObjetoA = [];
                var cantidadA = [];
                var estadoA = [];
                var FRetornoA = [];
                $("#tbTempObjetos tr:gt(0)").each(function() {
                    var fila = $(this);
                    idObjetoA.push(fila.find('td:eq(0)').text());
                    NombreObjetoA.push(fila.find('td:eq(1)').text());
                    cantidadA.push(fila.find('.cantidadA').val());
                    estadoA.push(fila.find('td:eq(3)').text());
                    FRetornoA.push(fila.find('td:eq(4)').text());
                });

                if (idObjetoA.length === 0) {
                    Toast.fire({icon: 'warning', title: 'Debe registrar el menos un prestamo'})
                    return;
                }
                var detallesPrestamoA = {
                    idObjeto: idObjetoA,
                    cantidad: cantidadA,
                    estado: estadoA,
                    FRetorno: FRetornoA
                };
                var formPrestamoAlumno = $("#formDatosAlumnoP").serialize();
                formPrestamoAlumno += "&detallesPrestamo=" + JSON.stringify(detallesPrestamoA);
                $.ajax({
                    url: "/prestamos/createA", 
                    method: "POST",
                    data: formPrestamoAlumno,
                    success: function(response){
                        if (response.success) {
                            $("#modalPrestamoAlumno").modal('hide');
                            //Toast.fire({icon: 'success', title: response.message})
                            Swal.fire(
                                'Correcto!',
                                response.message,
                                'success'
                              )
                            $("#tbPrestamos").DataTable().ajax.reload();
                        } else {
                            Toast.fire({icon: 'warning', title: response.message})
                        }
                    },
                    error: function(){
                        $(document).Toasts('create', {
                            class: 'bg-danger',
                            title: 'ERROR!',
                            subtitle: 'Cerrar',
                            body: 'No se pudo agregar registro, ocurrió algo inseperado'
                        })
                    }
                })
                
            } else {
               return; 
            }
        })
    });
    $(document).on('click', '.btn-ver-detalles', function(){
        var id = $(this).attr('data-id');
        var  tableDetalles = $('#tbDetallesAlumno tbody');
        $("#verDetallesAlumno").modal('toggle');
        function verDetallesPrestamo(){
            tableDetalles.empty();
            $.get('/prestamos/verDetallesPA/' + id, function (detalles) {
                detalles.forEach(function (detalle) {
                    var estadoClass = '';
                        if (detalle.PEstado === 'Pendiente') {
                            estadoClass = 'badge badge-warning';
                        } else if (detalle.PEstado === 'Entregado') {
                            estadoClass = 'badge badge-success';
                        } else if (detalle.PEstado === 'Vencido') {
                            estadoClass = 'badge badge-danger';
                        }
    
                        if(detalle.FEntrega === null){
                            FEntrega = "";
                        }
                        else{
                            FEntrega = detalle.FEntrega;
                        }
                    var fila = '<tr>';
                    fila += '<td width="300">' + detalle.Nombre+ '</td>'; 
                    // fila += '<td>' + detalle.Autor + '</td>'; 
                    // fila += '<td>' + detalle.Editorial + '</td>'; 
                    // fila += '<td>' + detalle.AñoEdicion + '</td>'; 
                    // fila += '<td>' + detalle.TipoLibro + '</td>'; 
                    fila += '<td>' + detalle.Signatura + '</td>'; 
                    fila += '<td width="200">' + detalle.Ubicacion + '</td>'; 
                    fila += '<td>' + detalle.cantidad + '</td>'; 
                    fila += '<td>' + detalle.OEstado + '</td>'; 
                    fila += '<td><span class="' + estadoClass + '">' + detalle.PEstado + '</span></td>';
                    fila += '<td width="200">' + detalle.FRetorno + '</td>'; 
                    fila += '<td width="200">' + FEntrega + '</td>'; 
                    fila += '<td><button class="btn btn-warning btn-sm btn-devolvioPrestamoA" data-idDetalles="' + detalle.id + '" data-idObjeto="' + detalle.Id_objeto + '" type="button" ' + (detalle.PEstado === 'Entregado' ? 'disabled' : '') + '> Devolvió</button></td>'; 
                    // Agrega más columnas según tus datos
                    fila += '</tr>';
                    tableDetalles.append(fila);
                });
            });
        
        }
        verDetallesPrestamo();
        
        $(document).on("click", ".btn-devolvioPrestamoA",function() {
            var idDetalles = $(this).attr('data-idDetalles');
            var idObjeto = $(this).attr('data-idObjeto'); 
            Swal.fire({
                title: 'Estado del libro a devolver',
                input: 'select',
                inputOptions: {
                    'estado': {
                        Bueno: 'Bueno',
                        Regular: 'Regular',
                        Malo: 'Malo',
                    },
                },
                inputPlaceholder: 'seleccionar estado',
                showCancelButton: true,
                inputValidator: (value) => {
                    var data = {
                        idObjeto :idObjeto, //$(this).attr('data-idObjeto'),
                        estado : value,
                    }
                    return new Promise((resolve) => {
                        if (value === '') {
                            resolve('Seleccione un estado porfavor')
                        } else {
                            resolve()
                            $.get('/prestamos/devolverPrestamoA/'+ idDetalles, data, function(detalles){
                                Swal.fire(
                                    'Correcto!',
                                    detalles.message,
                                    'success'
                                  )
                                verDetallesPrestamo();
                                $("#tbPrestamos").DataTable().ajax.reload();
                            })
                        }
                    })
                }
            })
        });
    });

    // limpiar datos cuando se cierre el modal
    $('#modalPrestamoAlumno').on('hidden.bs.modal', function () {
        // Resetear el formulario y eliminar mensajes de error
        $('#formDatosAlumnoP').validate().resetForm();
        $('#modalPrestamoAlumno :input').each(function () {
            $("#formDatosAlumnoP")[0].reset();
            $("#addListaPrestamoA")[0].reset();
            $(this).removeClass('is-invalid');
            $(this).next('.invalid-feedback').remove();
        });
        $("#idobjeto").select2('destroy').empty();
        // ---- ACTIVA EL COMBO BOX DE SELECT 2 -----
        $('.LibrosA').select2()
        llenarComboIdObjeto(selectedTipo);
    });
    // limpiar datos cuando se cierre el modal
    $('#modalPrestamoLibroPersonal').on('hidden.bs.modal', function () {
        // Resetear el formulario y eliminar mensajes de error
        $('#formPLibrosP').validate().resetForm();
        $('#modalPrestamoLibroPersonal :input').each(function () {
            $("#formPLibrosP")[0].reset();
            $("#addListaPrestamoA")[0].reset();
            $(this).removeClass('is-invalid');
            $(this).next('.invalid-feedback').remove();
        });
        $("#idobjetoP").select2('destroy').empty();
        // ---- ACTIVA EL COMBO BOX DE SELECT 2 -----
        $('.LibrosP').select2()
        llenarComboIdObjetoP(selectedTipoP);

        $("#cboTipoObjeto").val('Libros').change();
    });
    

    // validacion del selectd --/
    $('#grado').on('change', function() {
        $('#formDatosAlumnoP').validate().element('#grado');
    });
    // validacion del selectd --/
    $('#seccion').on('change', function() {
        $('#formDatosAlumnoP').validate().element('#seccion');
    });
    $('#formDatosAlumnoP').validate({
        ignore: [],
        rules: {
            nombres: {
                required: true,
            },
            apellidos: {
                required: true,
            },
            grado: {
                required: function() {
                var selectedValue = $('#grado').val();
                return selectedValue === '' || selectedValue === '0';
                }
            },
            seccion: {
                required: function() {
                var selectedValue = $('#seccion').val();
                return selectedValue === '' || selectedValue === '0';
                }
            },
        },
        messages: {
            grado: {
                required: "Por favor seleccione un grado"
            },
            seccion: {
                required: "Por favor seleccione una seccion"
            },
            nombres: {
                required: "Por favor ingrese nombre del alumno",
               
            },
            apellidos: {
                required: "Por favor ingrese apellidos del alumno",
            },
        },
        errorElement: 'span',
        errorPlacement: function (error, element) {
            error.addClass('invalid-feedback');
            element.closest('.form-group').append(error);
        },
        highlight: function (element, errorClass, validClass) {
            $(element).addClass('is-invalid');
        },
        unhighlight: function (element, errorClass, validClass) {
            $(element).removeClass('is-invalid');
        }
    });
    $('#formPLibrosP').validate({
        ignore: [],
        rules: {
            nombresPL: {
                required: true,
            },
            apellidosPL: {
                required: true,
            },
            cargoPL: {
                required: true,
                
            },
            especialidadPL: {
                required: true,
            },
            condicionPL: {
                required: true,
            },
        },
        messages: {
            cargoPL: {
                required: "Por favor ingrese el cargo"
            },
            especialidadPL: {
                required: "Por favor ingrese la especialidad"
            },
            condicionPL: {
                required: "Por favor ingrese la condición"
            },
            nombresPL: {
                required: "Por favor ingrese nombre del alumno",
               
            },
            apellidosPL: {
                required: "Por favor ingrese apellidos del alumno",
            },
        },
        errorElement: 'span',
        errorPlacement: function (error, element) {
            error.addClass('invalid-feedback');
            element.closest('.form-group').append(error);
        },
        highlight: function (element, errorClass, validClass) {
            $(element).addClass('is-invalid');
        },
        unhighlight: function (element, errorClass, validClass) {
            $(element).removeClass('is-invalid');
        }
    });
    
    var Toast = Swal.mixin({
        toast: true,
        position: 'top-end',
        showConfirmButton: false,
        timer: 3000
    });
    $('#idobjeto').on('change', function() {
        $('#addListaPrestamoA').validate().element('#idobjeto');
    });
    $('#addListaPrestamoA').validate({
        ignore: [],
        rules: {
            idobjeto: {
                required: function() {
                var selectedValue = $('#idobjeto').val();
                return selectedValue === '' || selectedValue === '0';
                }
            },
            cantidad: {
                required: true,
            },
            FRetornoA: {
                required: true,
            },
           
        },
        messages: {
            idobjeto: {
                required: "Por favor seleccione unn Libro"
            },
            tituloPAL: {
                required: "Por favor ingrese titulo del Libro",
               
            },
            cantidad: {
                required: "Por favor ingrese una cantidad",
            },
            FRetornoA: {
                required: "Por favor ingrese una Fecha",
            },
        },
        errorElement: 'span',
        errorPlacement: function (error, element) {
            error.addClass('invalid-feedback');
            element.closest('.form-group').append(error);
        },
        highlight: function (element, errorClass, validClass) {
            $(element).addClass('is-invalid');
        },
        unhighlight: function (element, errorClass, validClass) {
            $(element).removeClass('is-invalid');
        }
    });
    $('#idobjetoP').on('change', function() {
        $('#addListaPrestamoP').validate().element('#idobjetoP');
    });
    $('#MobiliarioId').on('change', function() {
        $('#addListaPrestamoP').validate().element('#MobiliarioId');
    });
    $('#addListaPrestamoP').validate({
        ignore: [],
        rules: {
            idobjetoP: {
                required: function() {
                    var selectedValue = $('#idobjetoP').val();
                    return selectedValue === '' || selectedValue === '0';
                }
            },
            MobiliarioId: {
                required: function() {
                    var selectedValue = $('#MobiliarioId').val();
                    return selectedValue === '' || selectedValue === '0';
                }
            },
            cantidad: {
                required: true,
            },
            FRetorno: {
                required: true,
            },
           
        },
        messages: {
            idobjetoP: {
                required: "Por favor seleccione unn Libro"
            },
            MobiliarioId: {
                required: "Por favor seleccione unn mobiliario"
            },
            tituloPAL: {
                required: "Por favor ingrese titulo del Libro",
               
            },
            cantidad: {
                required: "Por favor ingrese una cantidad",
            },
            FRetorno: {
                required: "Por favor ingrese una Fecha",
            },
        },
        errorElement: 'span',
        errorPlacement: function (error, element) {
            error.addClass('invalid-feedback');
            element.closest('.form-group').append(error);
        },
        highlight: function (element, errorClass, validClass) {
            $(element).addClass('is-invalid');
        },
        unhighlight: function (element, errorClass, validClass) {
            $(element).removeClass('is-invalid');
        }
    });
    $('.btn-reportes').on('click', function(){
        $.get('/prestamos/reportesPdf',function(){

            window.location.href = '/prestamos/reportesPdf';
        })
        
    })
    
    // ---- modal para registrar prestamo a Personal------
    $('.btn-prestamos-PLP').on('click',function(){
        $("#modalPrestamoLibroPersonal").modal('toggle');
        var objetoSeleccionado;
        $("#cboTipoObjeto").change(function() {
            objetoSeleccionado = $(this).val();
            if (objetoSeleccionado === "Libros") {
                $("#divtipoLibros").removeClass('d-none');
                $("#divLibros").removeClass('d-none');
                $("#divMobiliarios").addClass('d-none');
                 // Habilitar la validación para los campos visibles
                $('#divLibros select').prop('disabled', false);
                $('#divMobiliarios select').prop('disabled', true);
            } else if (objetoSeleccionado === "Mobiliarios") {
                $("#divtipoLibros").addClass('d-none');
                $("#divLibros").addClass('d-none');
                $("#divMobiliarios").removeClass('d-none');
                // Habilitar la validación para los campos visibles
                $('#divLibros select').prop('disabled', true);
                $('#divMobiliarios select').prop('disabled', false);
            }
        });
        $("#cboTipoObjeto").val('Libros').change();
        
        $("#tbListaLibrosPP tbody").empty();
        $("#btnAddLisTemPLP").off('click').on('click', function(){
            if ($('#addListaPrestamoP').valid()) {
                var idObjeto;
                var NombreObjeto;

                if (objetoSeleccionado === 'Mobiliarios') {
                    idObjeto = $("#MobiliarioId option:selected").val();
                    NombreObjeto = $("#MobiliarioId option:selected").text();
                } else if (objetoSeleccionado === 'Libros') {
                    idObjeto = $("#idobjetoP option:selected").val();
                    NombreObjeto = $("#idobjetoP option:selected").text();
                    
                }
                
                var Estado  = $("#estado option:selected").val();
                var FRetorno = $("#FRetorno").val();
                
             // Agregar una nueva fila a la tabla
                var fila = "<tr><td>" + idObjeto + "</td><td>" + NombreObjeto + "</td><td><input type='number' class='form-control cantidad' value='1'></td><td name='"+Estado+idObjeto+"'>" + Estado + "</td><td name='"+FRetorno+idObjeto+"'>" + FRetorno + "</td><td><button class='btn btn-danger btn-sm btn-eliminar'>Eliminar</button></td></tr>";

             $("#tbListaLibrosPP").append(fila);
    
             // Limpiar los campos del formulario
            $("#tipoObjeto").val("Ministerio");
            //$("#idobjeto").val("");
            $("#idobjetoP").select2('destroy').empty();
            $("#MobiliarioId").select2('destroy').empty();
            // ---- ACTIVA EL COMBO BOX DE SELECT 2 -----
            $('.LibrosA').select2()
            llenarComboIdObjetoP(selectedTipo);
            $('.MobiliariosP').select2()
            llenarComboMobiliarios();
            $("#cantidad").val(1);
            $("#estado").val("B");
            $("#FRetorno").val("");
            }
        })
        $("#tbListaLibrosPP").on("click", ".btn-eliminar", function() {
            $(this).closest("tr").remove();
        });
        
        // Desvincular eventos click anteriores para evitar duplicación
        $("#btnRegistrarPLP").off('click').on('click', function(){
            if ($('#formPLibrosP').valid()) {
                var idObjeto = [];
                var NombreObjeto = [];
                var cantidad = [];
                var estado = [];
                var FRetorno = [];
                $("#tbListaLibrosPP tr:gt(0)").each(function() {
                    var fila = $(this);
                    idObjeto.push(fila.find('td:eq(0)').text());
                    NombreObjeto.push(fila.find('td:eq(1)').text());
                    cantidad.push(fila.find('.cantidad').val());
                    estado.push(fila.find('td:eq(3)').text());
                    FRetorno.push(fila.find('td:eq(4)').text());
                });

                if (idObjeto.length === 0) {
                    Toast.fire({icon: 'warning', title: 'Debe registrar el menos un prestamo'})
                    return;
                }
                var detallesPrestamo = {
                    idObjeto: idObjeto,
                    cantidad: cantidad,
                    estado: estado,
                    FRetorno: FRetorno
                };
                var formPLibrosP = $("#formPLibrosP").serialize();
                formPLibrosP += "&detallesPrestamo=" + JSON.stringify(detallesPrestamo);
                $.ajax({
                    url: "/prestamos/createPL", 
                    method: "POST",
                    data: formPLibrosP,
                    success: function(response){
                        if (response.success) {
                            $("#modalPrestamoLibroPersonal").modal('hide');
                            //Toast.fire({icon: 'success', title: response.message})
                            Swal.fire(
                                'Correcto!',
                                response.message,
                                'success'
                              )
                            $("#tbPrestamos").DataTable().ajax.reload();
                        } else {
                            Toast.fire({icon: 'warning', title: response.message})
                        }
                    },
                    error: function(){
                        $(document).Toasts('create', {
                            class: 'bg-danger',
                            title: 'ERROR!',
                            subtitle: 'Cerrar',
                            body: 'No se pudo agregar registro, ocurrió algo inseperado'
                        })
                    }
                })
                
            } else {
               return; 
            }
        })
    });
});
