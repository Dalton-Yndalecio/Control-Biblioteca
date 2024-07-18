$(document).ready(function(){
     var tabla = $('#tbMoviliario').DataTable({
        processing: true,
        serverSide: true,
        ajax: '/moviliarios', 
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
            {data: 'objeto.Signatura'},
            {data: 'objeto.Cantidad'},
            {data: 'objeto.Estado'},
            {data: 'Observacion'},
            {data: 'action', orderable: false},
        ]
    });

    var tablaOcupaciones

    $("#dni").on("input", function() {
        // Remover caracteres no numéricos y mantener solo números
        var inputValue = $(this).val().replace(/[^0-9]/g, "");
        $(this).val(inputValue);
    });
    $("#celular").on("input", function() {
        // Remover caracteres no numéricos y mantener solo números
        var inputValue = $(this).val().replace(/[^0-9]/g, "");
        $(this).val(inputValue);
    });



    // ---- ACTIVA EL COMBO BOX DE SELECT 2 -----
    $('.select2').select2()


    
    // ---- modal para editar y agregar apoderado .off('click')------
    $(document).on('click', '.btn-modal', function(){
        var id = $(this).attr('data-id');
        var modal = $(this).attr('data-modal')
        $("#tituloMov").html(modal + " Moviliario");
        $("#btnformMoviliario").html(modal);
        $("#modalMoviliario").modal('toggle');
        // Desvincular eventos click anteriores para evitar duplicación
        $("#btnformMoviliario").off('click').on('click', function(){
            if ($('#formMoviliario').valid()) {
                var formMoviliario = $("#formMoviliario").serialize();
                if (modal === "Agregar") {
                    $.ajax({
                        url: "/moviliarios/create",
                        method: "POST",
                        data: formMoviliario,
                        success: function(response){
                            if (response.success) {
                                $("#modalMoviliario").modal('hide');
                                Swal.fire(
                                    'Correcto!',
                                    response.message,
                                    'success'
                                  )
                                $("#tbMoviliario").DataTable().ajax.reload();
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
                        url: "/moviliarios/actualizar/"+id,
                        method: "POST",
                        data: formMoviliario,
                        success: function(response){
                            if (response.success) {
                                $("#modalMoviliario").modal('hide');
                                Toast.fire({icon: 'success', title: response.message})
                                $("#tbMoviliario").DataTable().ajax.reload();
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
            $("#modalMoviliario .overlay").removeClass("d-none").show();
            setTimeout(function(){
                $("#modalMoviliario .overlay").hide();
            }, 800);
            $.get('/moviliarios/listar/'+id,function(Moviliario){
                console.log(Moviliario);
                $("#id").val(Moviliario[0].id);
                // $("#ocupacion_id option").each(function () {
                //     if ($(this).val() == apoderado[0].ocupacion_id) {
                //          $(this).prop("selected", true);
                //          $("#ocupacion_id").trigger('change');
                //          return false;
                //      }
                //  });
                $("#nombre").val(Moviliario[0].Nombre);
                $("#signatura").val(Moviliario[0].Signatura);
                $("#cantidad").val(Moviliario[0].Cantidad);
                $("#estado").val(Moviliario[0].Estado);
                $("#observacion").val(Moviliario[0].Observacion);
            })
        }
    })
    $(document).on('click', '.btn-delete-moviliario', function(){
        var id = $(this).attr('data-id');
        $.get('/moviliarios/listar/'+id,function(Moviliario){
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
                    $.get('/moviliarios/eliminar/'+id,function(success){
                        Swal.fire(
                            'Eliminado',
                            success.message,
                            'success'
                        )
                        $("#tbMoviliario").DataTable().ajax.reload();
                    })
                }
            })
        })
    });

    // limpiar datos cuando se cierre el modal
    $('#modalMoviliario').on('hidden.bs.modal', function () {
        // Resetear el formulario y eliminar mensajes de error
        $('#formMoviliario').validate().resetForm();
        $('#modalMoviliario :input').each(function () {
            $("#tituloMov").html("");
            $("#btnformMoviliario").html("");
            $("#formMoviliario")[0].reset();
            $(this).removeClass('is-invalid');
            $(this).next('.invalid-feedback').remove();
        });
       
        $('.select2').select2()
        
    });
    
    $('#formMoviliario').validate({
        ignore: [],
        rules: {
            /*ocupacion_id: {
                required: function() {
                var selectedValue = $('#ocupacion_id').val();
                return selectedValue === '' || selectedValue === '0';
                }
            },*/
            nombre: {
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

            
        },
        messages: {
            /*ocupacion_id: {
                required: "Por favor seleccione una ocupacion"
            },*/
            nombre: {
                required: "Por favor ingrese Nombre del Moviliario",
               
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
    
});