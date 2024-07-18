$(document).ready(function(){
     var tabla = $('#tbLibros').DataTable({
        processing: true,
        serverSide: true,
        ajax: '/libros', 
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
            {data: 'objeto.Nombre'},
            {data: 'Autor'},
            {data: 'Editorial'},
            {data: 'AñoEdicion'},
            {data: 'TipoLibro'},
            {data: 'Estante'},
            {data: 'Division'},
            {data: 'objeto.Signatura'},
            {data: 'objeto.Cantidad'},
            {data: 'objeto.Estado'},
            {data: 'action', orderable: false},
        ]
    });
    
       
    $("#estante").append('<option value="">--------- SELECCIONAR ---------</option>');
    $.get('/libros/selectEstante',function(estante){
        $.each(estante, function () {
            $("#estante").append('<option value="' + this.id + '">' + this.CodEstante + '</option>');
            
        });
        $('.selecEtestante').select2()
    })

    $("#division").append('<option value="">--------- SELECCIONAR ---------</option>');
    $.get('/libros/selectDivision',function(division){
        $.each(division, function () {
            $("#division").append('<option value="' + this.CodDivision + '">' + this.CodDivision + '</option>');
            
        });
        $('.selectDivision').select2()
    })
    

    // ---- INPUT EN MAYUSCULA ---//
    $("#formLibro input[type='text']").on('input', function() {
        var valorActual = $(this).val().toLowerCase()
        var valorEnMayusculas = valorActual.toUpperCase();
        $(this).val(valorEnMayusculas);
       
    });
    $("#formEstante input[type='text']").on('input', function() {
        var valorActual = $(this).val().toLowerCase()
        var valorEnMayusculas = valorActual.toUpperCase();
        $(this).val(valorEnMayusculas);
    });
    $("#formDivision input[type='text']").on('input', function() {
        var valorActual = $(this).val().toLowerCase()
        var valorEnMayusculas = valorActual.toUpperCase();
        $(this).val(valorEnMayusculas);
    });

    // ------ modal para agregar ocupcion ---- //
    $(".modal-estante").on('click', function(){
        $("#modalEstante").modal('toggle');
        $("#btn-estante").off('click').on('click', function(){
            if ($('#formEstante').valid()) {
                var formEstante = $("#formEstante").serialize();
                $.ajax({
                    url: "/libros/registrarEstante",
                    method: "POST",
                    data : formEstante,
                    success: function(response){
                        if (response.success) {
                            $("#modalEstante").modal('hide');
                            Toast.fire({icon: 'success', title: response.message})
                            $("#estante").select2('destroy').empty();
                            $('.selecEtestante').select2()
                            $("#estante").append('<option value="">--------- SELECCIONAR ---------</option>');
                            $.get('/libros/selectEstante',function(estante){
                                $.each(estante, function () {
                                    $("#estante").append('<option value="' + this.CodEstante + '">' + this.CodEstante + '</option>');
                                    
                                });
                            })
                            
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
            }
        })
    })
    $(".modal-division").on('click', function(){
        $("#modalDivision").modal('toggle');
        $("#btn-division").off('click').on('click', function(){
            if ($('#formDivision').valid()) {
                var formDivision = $("#formDivision").serialize();
                $.ajax({
                    url: "/libros/registrarDivision",
                    method: "POST",
                    data : formDivision,
                    success: function(response){
                        if (response.success) {
                            $("#modalDivision").modal('hide');
                            Toast.fire({icon: 'success', title: response.message})
                            $("#division").select2('destroy').empty();
                            $('.selectDivision').select2()
                            $("#division").append('<option value="">--------- SELECCIONAR ---------</option>');
                            $.get('/libros/selectDivision',function(division){
                                $.each(division, function () {
                                    $("#division").append('<option value="' + this.CodDivision + '">' + this.CodDivision + '</option>');
                                    
                                });
                            })
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
            }
        })
    })


    
    // ---- modal para editar y agregar apoderado .off('click')------
    $(document).on('click', '.btn-modal', function(){
        var id = $(this).attr('data-id');
        var modal = $(this).attr('data-modal')
        $("#titulo").html(modal + " Libro");
        $("#btnFormLibro").html(modal);
        $("#modalLibro").modal('toggle');
        // Desvincular eventos click anteriores para evitar duplicación
        $("#btnFormLibro").off('click').on('click', function(){
            if ($('#formLibro').valid()) {
                var formLibro = $("#formLibro").serialize();
                if (modal === "Agregar") {
                    $.ajax({
                        url: "/libros/create",
                        method: "POST",
                        data: formLibro,
                        success: function(response){
                            if (response.success) {
                                $("#modalLibro").modal('hide');
                                Toast.fire({icon: 'success', title: response.message})
                                $("#tbLibros").DataTable().ajax.reload();
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
                }
                else if (modal === "Editar"){
                    $.ajax({
                        url: "/libros/actualizar/"+id,
                        method: "POST",
                        data: formLibro,
                        success: function(response){
                            if (response.success) {
                                $("#modalLibro").modal('hide');
                                Toast.fire({icon: 'success', title: response.message})
                                $("#tbLibros").DataTable().ajax.reload();
                            } else {
                                Toast.fire({icon: 'warning', title: response.message})
                            }
                        },
                        error: function(error){
                            $(document).Toasts('create', {
                                class: 'bg-danger',
                                title: 'ERROR!',
                                subtitle: 'Cerrar',
                                body: 'No se pudo agregar registro, ocurrió algo inseperado'
                            })
                        }
                    })
                }
            } else {
               return; 
            }
        })
        if (modal === "Editar") {
            $("#modalLibro .overlay").removeClass("d-none").show();
            setTimeout(function(){
                $("#modalLibro .overlay").hide();
            }, 800);
            $.get('/libros/editar/'+id,function(libro){

                $("#id").val(libro[0].id);
                // $("#ocupacion_id option").each(function () {
                //     if ($(this).val() == apoderado[0].ocupacion_id) {
                //          $(this).prop("selected", true);
                //          $("#ocupacion_id").trigger('change');
                //          return false;
                //      }
                //  });
                $("#tituloL").val(libro[0].Nombre);
                $("#autor").val(libro[0].Autor);
                $("#editorial").val(libro[0].Editorial);
                $("#añoEdicion").val(libro[0].AñoEdicion);
                $("#tipoLibro").val(libro[0].TipoLibro);
                $("#estante").val(libro[0].Estante);
                $("#division").val(libro[0].Division);
                $("#signatura").val(libro[0].Signatura);
                $("#cantidad").val(libro[0].Cantidad);
                $("#estado").val(libro[0].Estado);
            })
        }
    });
    $(document).on('click', '.btn-delete-libro', function(){
        var id = $(this).attr('data-id');
        $.get('/libros/editar/'+id,function(Moviliario){
            Swal.fire({
                title: '¿Estas seguro?',
                text: "Deseas eliminar" + ' "'  +Moviliario[0].Nombre + '"',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Si, eliminar'
            }).then((result) => {
                if (result.isConfirmed) {
                    $.get('/libros/eliminar/'+id,function(success){
                        Swal.fire(
                            'Eliminado',
                            success.message,
                            'success'
                        )
                        $("#tbLibros").DataTable().ajax.reload();
                        id = val("");
                    })
                }
            })
        })
    });

    // limpiar datos cuando se cierre el modal
    $('#modalLibro').on('hidden.bs.modal', function () {
        // Resetear el formulario y eliminar mensajes de error
        $('#formLibro').validate().resetForm();
        $('#modalLibro :input').each(function () {
            $("#titulo").html("");
            $("#btnformLibro").html("");
            $("#formLibro")[0].reset();
            $(this).removeClass('is-invalid');
            $(this).next('.invalid-feedback').remove();
        });
        $("#estante").select2('destroy').empty();
        // ---- ACTIVA EL COMBO BOX DE SELECT 2 -----
        $('.selecEtestante').select2()
        $("#estante").append('<option value="">--------- SELECCIONAR ---------</option>');
        $.get('/libros/selectEstante',function(estante){
            $.each(estante, function () {
                $("#estante").append('<option value="' + this.CodEstante + '">' + this.CodEstante + '</option>');
                
            });
        })
    });
    $('#modalEstante').on('hidden.bs.modal', function () {
        $('#modalEstante :input').each(function () {
            $("#formEstante")[0].reset();
            $(this).removeClass('is-invalid');
            $(this).next('.invalid-feedback').remove();
            
        });
    });
   
    // validacion del selectd --/
    $('#ocupacion_id').on('change', function() {
        $('#formApoderado').validate().element('#ocupacion_id');
    });
    $('#formLibro').validate({
        ignore: [],
        rules: {
            /*ocupacion_id: {
                required: function() {
                var selectedValue = $('#ocupacion_id').val();
                return selectedValue === '' || selectedValue === '0';
                }
            },*/
            tituloL: {
                required: true,
            },
            signatura: {
                required: true,
            },
            cantidad: {
                required: true,
            },
            estado: {
                required: true,
            },
            autor: {
                required: true,
                
            },
            editorial: {
                required: true,
            },
            añoEdicion: {
                required: true,
                minlength: 4,
                maxlength: 4,
            },
            tipoLibro: {
                required: true,
            },
            estante: {
                required: true,
            },
            division: {
                required: true,
            },

            
        },
        messages: {
            /*ocupacion_id: {
                required: "Por favor seleccione una ocupacion"
            },*/
            tituloL: {
                required: "Por favor ingrese titulo del Libro",
               
            },
            signatura: {
                required: "Por favor ingrese uan signatura",
            },
            cantidad: {
                required: "Por favor ingrese una cantidad",
            },
            estado: {
                required: "Por favor seleccione el estado del libro",
            },
            autor: {
                required: "Por favor ingrese el nombre del autor",
                minlength: "El número de celular debe tener 9 digitos",
                maxlength: "El número de celular debe tener solo 9 digitos",
                
            },
            editorial: {
                required: "Por favor ingrese la editorial",
            },
            añoEdicion: {
                required: "Por favor ingrese año de edición",
                minlength: "El años de edición debe tener 4 digitos",
                maxlength: "El años de edición debe tener solo 4 digitos",
                
            },
            tipoLibro: {
                required: "Por favor seleccione el tipo de libro",
            },
            estante: {
                required: "Por favor elija un estante",
            },
            division: {
                required: "Por favor seleccione una división",
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
    $('#formEstante').validate({
        ignore: [],
        rules: {
            codEstante: {
                required: true,
            }
        },
        messages: {
            codEstante: {
                required: "Por favor ingrese un estante",
            }
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
});