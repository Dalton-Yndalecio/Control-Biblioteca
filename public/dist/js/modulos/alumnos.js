$(document).ready(function(){
     var tabla = $('#tbAlumnos').DataTable({
        processing: true,
        serverSide: true,
        ajax: '/alumnos', 
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
            {data: 'grado'},
            {data: 'seccion'},
            {data: 'action', orderable: false},
        ]
    });

    // ---- INPUT EN MAYUSCULA ---//
    $("#formAlumno input[type='text']").on('input', function() {
        var valorActual = $(this).val().toLowerCase()
        var valorEnMayusculas = valorActual.toUpperCase();
        $(this).val(valorEnMayusculas);
       
    });
   

    $(document).on('click', '.btn-editar-alumno', function(){
        var id = $(this).attr('data-id');
        $.get('/alumnos/editar/'+id,function(alumno){
            $("#nombreA").val(alumno[0].nombre);
            $("#apellidosA").val(alumno[0].apellidos);
            $("#gradoA").val(alumno[0].grado);
            $("#seccionA").val(alumno[0].seccion);
        })
        $("#modalAlumno").modal('toggle');
        $("#btnEditarAlumno").off('click').on('click', function(){
            if ($('#formAlumno').valid()) {
                var formAlumno = $("#formAlumno").serialize();
                $.ajax({
                    url: "/alumnos/actualizar/"+id,
                    method: "POST",
                    data: formAlumno,
                    success: function(response){
                        if (response.success) {
                            $("#modalAlumno").modal('hide');
                            Toast.fire({icon: 'success', title: response.message})
                            $("#tbAlumnos").DataTable().ajax.reload();
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
    $(document).on('click', '.btn-eliminar-alumno', function(){
        var id = $(this).attr('data-id');
        $.get('/alumnos/editar/'+id,function(alumno){
            Swal.fire({
                title: '¿Estas seguro?',
                text: "Deseas eliminar al alumno " + ' "'  +alumno[0].nombre + '", al hacerlo se eliminará todos los regitros de prestamos que este tenga.',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Si, eliminar'
            }).then((result) => {
                if (result.isConfirmed) {
                    $.get('/alumnos/eliminar/'+id,function(response){
                        if(response.success === true){
                            Swal.fire({
                                icon: "success",
                                title: "Eliminado",
                                text: response.message,
                            });
                            $("#tbAlumnos").DataTable().ajax.reload();
                        }else{
                            Swal.fire({
                                icon: "error",
                                title: "Oops...",
                                text: response.message,
                            });
                        }
                    })
                }
            })
        })
    });
    $('#modalAlumno').on('hidden.bs.modal', function () {
        // Resetear el formulario y eliminar mensajes de error
        $('#formAlumno').validate().resetForm();
        $('#modalAlumno :input').each(function () {
            $("#formAlumno")[0].reset();
            $(this).removeClass('is-invalid');
            $(this).next('.invalid-feedback').remove();
        });
    });
    
    

    // validacion del selectd --/
    $('#gradoA').on('change', function() {
        $('#formAlumno').validate().element('#gradoA');
    });
    $('#seccionA').on('change', function() {
        $('#formAlumno').validate().element('#seccionA');
    });
    $('#formAlumno').validate({
        ignore: [],
        rules: {
            gradoA: {
                required: function() {
                var selectedValue = $('#gradoA').val();
                return selectedValue === '' || selectedValue === '0';
                }
            },
            seccionA: {
                required: function() {
                var selectedValue = $('#seccionA').val();
                return selectedValue === '' || selectedValue === '0';
                }
            },
            nombresA: {
                required: true,
            },
            apellidosA: {
                required: true,
            },
        },
        messages: {
            gradoA: {
                required: "Por favor seleccione un grado"
            },
            seccionA: {
                required: "Por favor seleccione una sección"
            },
            nombresA: {
                required: "Por favor ingrese nombres",
               
            },
            apellidosA: {
                required: "Por favor ingrese apellidos",
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