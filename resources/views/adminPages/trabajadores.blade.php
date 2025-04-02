@extends('layouts.admin-navbar')

@section('content')
@if(session('trabajadorGuardado'))
    <script>
        Swal.fire({
            title: '¡Éxito!',
            text: "{{ session('trabajadorGuardado') }}",
            icon: 'success',
            confirmButtonText: 'Aceptar'
        });
    </script>
@endif
@if(session('trabajadorActualizado'))
    <script>
        Swal.fire({
            title: '¡Éxito!',
            text: "{{ session('trabajadorActualizado') }}",
            icon: 'success',
            confirmButtonText: 'Aceptar'
        });
    </script>
@endif

<style>
    .content {
        height: 91.5vh;
    }
</style>

<div class="content">
@if ($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif
    <h2>TRABAJADORES</h2>

    <!-- Tabla de trabajadores -->
    <table id="trabajadoresTable" style="width: 100%;">
        <thead>
            <tr>
                <th>ID</th>
                <th>Nombre</th>
                <th>Correo</th>
                <th>Teléfono</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
        </tbody>
    </table>
</div>
@include('forms.trabajadores.new')
@include('forms.trabajadores.view')
@include('forms.trabajadores.edit')
@endsection

@section('scripts')
    <!-- Cargar jQuery y DataTables -->



@section('scripts')
<script>
    document.addEventListener("DOMContentLoaded", function() {
    // Referencias a modales de Trabajadores
    const modal = document.getElementById('modal');
    const modalView = document.getElementById('modalView');
    const modalEdit = document.getElementById('modalEdit');

    if(document.getElementById('closeModalBtn')){
        document.getElementById('closeModalBtn').addEventListener('click', () => {
            modal.style.display = 'none';
        });
    }
    if(document.getElementById('closeModalBtnView')){
        document.getElementById('closeModalBtnView').addEventListener('click', () => {
            modalView.style.display = 'none';
        });
    }
    if(document.getElementById('closeModalBtnEdit')){
        document.getElementById('closeModalBtnEdit').addEventListener('click', () => {
            modalEdit.style.display = 'none';
        });
    }

    // Inicializar DataTable para Trabajadores
    $('#trabajadoresTable').DataTable({
        "ajax": "{{ route('admin.trabajadores.data') }}",
        "columns": [
            { "data": "id" },
            {
                "data": null,
                "render": function(data, type, row) {
                    return `${row.nombre} ${row.apellidos.paterno} ${row.apellidos.materno}`;
                }
            },
            { "data": "correo" },
            { "data": "telefono" },
            {
                "data": null,
                "render": function(data, type, row) {
                    return `
                        <div class="action-buttons">
                            <button class="btn btn-info" title="Visualizar" onclick="viewTrabajador('${row.id}')">
                                <i class="fas fa-eye"></i>
                            </button>
                            <button class="btn btn-warning" title="Editar" onclick="editTrabajador('${row.id}')">
                                <i class="fas fa-edit"></i>
                            </button>
                            <button class="btn btn-danger" title="Eliminar" onclick="deleteTrabajador('${row.id}')">
                                <i class="fas fa-trash-alt"></i>
                            </button>
                        </div>`;
                }
            }
        ],
        "pageLength": 8,
        "language": {
            "paginate": {
                "next": "Siguiente",
                "previous": "Anterior"
            },
            "search": "Buscar: "
        },
        "dom": '<"top"f>rt<"bottom"p><"clear">',
        "initComplete": function(settings, json) {
            var nuevoTrabajador = $('<button>', {
                text: 'Nuevo Trabajador',
                class: 'add-form',
                id: 'openModalBtn',
                click: function () {
                    modal.style.display = 'flex';
                }
            });
            $('#trabajadoresTable').before(nuevoTrabajador);
        }
    });
    });

    // Visualizar Trabajador
    function viewTrabajador(userId) {
        $('#loading').show();
        $.ajax({
            url: 'trabajadores/' + userId,
            type: 'GET',
            dataType: 'json',
            success: function(response) {
                if(response.error){
                    alert('Error: ' + response.error);
                    $('#loading').hide();
                } else {
                    $('#nombreView').text(response.data.nombre + ' ' + response.data.apellidoP + ' ' + response.data.apellidoM);
                    $('#fechaView').text(response.data.fecha_nacimiento);
                    $('#telefonoView').text(response.data.telefono);
                    $('#correoView').text(response.data.correo);
                    $('#rfcView').text(response.data.rfc);
                    $('#curpView').text(response.data.curp);

                    // Actualizar imagen de perfil
                    const rutaImagen = response.data.profile_picture
                        ? "{{ asset('storage') }}/" + response.data.profile_picture
                        : "{{ asset('images/default_profile.png') }}";
                    $('#profileImageView').attr('src', rutaImagen);
                    modalView.style.display = 'flex';
                    $('#loading').hide();
                }
            },
            error: function(){
                alert('Ocurrió un error al cargar los datos.');
                $('#loading').hide();
            }
        });
    }

    // Editar Trabajador
    function editTrabajador(userId) {
        $('#loading').show();
        $.ajax({
            url: 'trabajadores/' + userId,
            type: 'GET',
            dataType: 'json',
            success: function(response) {
                if(response.error){
                    alert('Error: ' + response.error);
                    $('#loading').hide();
                } else {
                    $('#nombreEdit').val(response.data.nombre);
                    $('#apellidoPEdit').val(response.data.apellidoP);
                    $('#apellidoMEdit').val(response.data.apellidoM);
                    $('#fechaEdit').val(response.data.fecha_nacimiento);
                    $('#telefonoEdit').val(response.data.telefono);
                    $('#correoEdit').val(response.data.correo);
                    $('#rfcEdit').val(response.data.rfc);
                    $('#curpEdit').val(response.data.curp);
                    $('#id').val(response.data.id);

                    const rutaImagen = response.data.profile_picture
                        ? "{{ asset('storage') }}/" + response.data.profile_picture
                        : "{{ asset('images/default_profile.png') }}";
                    document.getElementById('profileImageEdit').src = rutaImagen;

                    modalEdit.style.display = 'flex';
                    $('#trabajadorFormEdit').attr('action', 'trabajadores/' + userId);
                    $('#loading').hide();
                }
            },
            error: function(){
                alert('Ocurrió un error al cargar los datos.');
                $('#loading').hide();
            }
        });
    }

    // Eliminar Trabajador
    function deleteTrabajador(userId) {
        Swal.fire({
            title: '¿Estás seguro?',
            text: 'Esta acción no se puede deshacer.',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Sí, eliminar',
            cancelButtonText: 'Cancelar'
        }).then((result) => {
            if (result.isConfirmed) {
                $('#loading').show();
                $.ajax({
                    url: 'trabajadores/' + userId,
                    type: 'DELETE',
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function(response) {
                        $('#loading').hide();
                        if (response.success) {
                            Swal.fire('¡Eliminado!', response.message, 'success');
                            $('#trabajadoresTable').DataTable().ajax.reload();
                        } else {
                            Swal.fire('¡Error!', response.message, 'error');
                        }
                    },
                    error: function(xhr) {
                        $('#loading').hide();
                        let errorMessage = 'No se pudo eliminar el trabajador.';
                        if (xhr.responseJSON && xhr.responseJSON.message) {
                            errorMessage = xhr.responseJSON.message;
                        }
                        Swal.fire('¡Error!', errorMessage, 'error');
                    }
                });
            }
        });
    }

</script>
@endsection






