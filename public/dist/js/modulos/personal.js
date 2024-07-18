$(document).ready(function(){
     var tabla = $('#tbPersonal').DataTable({
        processing: true,
        serverSide: true,
        ajax: '/personal', 
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
            {data: 'nombre'},
            {data: 'apellidos'},
            {data: 'Cargo'},
            {data: 'Especialidad'},
            {data: 'Condición'},
            {data: 'action', orderable: false},
        ]
    });

    // ---- INPUT EN MAYUSCULA ---//
    $("#formPersonal input[type='text']").on('input', function() {
        var valorActual = $(this).val().toLowerCase()
        var valorEnMayusculas = valorActual.toUpperCase();
        $(this).val(valorEnMayusculas);
       
    });
   

    $(document).on('click', '.btn-editar-personal', function(){
        var id = $(this).attr('data-id');
        $.get('/personal/editar/'+id,function(personal){
            $("#nombreP").val(personal[0].nombre);
            $("#apellidosP").val(personal[0].apellidos);
            $("#cargoP").val(personal[0].Cargo);
            $("#especialidadP").val(personal[0].Especialidad);
            $("#condicionP").val(personal[0].Condición);
        })
        $("#modalPersonal").modal('toggle');
        $("#btnEditarPersonal").off('click').on('click', function(){
            if ($('#formPersonal').valid()) {
                var formPersonal = $("#formPersonal").serialize();
                $.ajax({
                    url: "/personal/actualizar/"+id,
                    method: "POST",
                    data: formPersonal,
                    success: function(response){
                        if (response.success) {
                            $("#modalPersonal").modal('hide');
                            Toast.fire({icon: 'success', title: response.message})
                            $("#tbPersonal").DataTable().ajax.reload();
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
                });
            }
        })
    });
    $('#modalPersonal').on('hidden.bs.modal', function () {
        // Resetear el formulario y eliminar mensajes de error
        $('#formPersonal').validate().resetForm();
        $('#modalPersonal :input').each(function () {
            $("#formPersonal")[0].reset();
            $(this).removeClass('is-invalid');
            $(this).next('.invalid-feedback').remove();
        });
    });
    $('#formPersonal').validate({
        ignore: [],
        rules: {
            nombresP: {
                required: true,
            },
            apellidosP: {
                required: true,
            },
            cargoP: {
                required: true,
            },
            especialidadP: {
                required: true,
            },
            condicionP: {
                required: true,
            },
        },
        messages: {
            nombresA: {
                required: "Por favor ingrese nombres",
               
            },
            apellidosA: {
                required: "Por favor ingrese apellidos",
            },
            cargoP: {
                required: "Por favor ingrese un cargo",
            },
            especialidadP: {
                required: "Por favor ingrese especialidad",
            },
            condicionP: {
                required: "Por favor ingrese condición",
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
});