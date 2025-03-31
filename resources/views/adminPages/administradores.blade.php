@extends('layouts.admin-navbar')

@section('content')
@if(session('administradorGuardado'))
    <script>
        Swal.fire({
            title: '¡Éxito!',
            text: "{{ session('administradorGuardado') }}",
            icon: 'success',
            confirmButtonText: 'Aceptar'
        });
    </script>
@endif
@if(session('administradorActualizado'))
    <script>
        Swal.fire({
            title: '¡Éxito!',
            text: "{{ session('administradorActualizado') }}",
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
    <h2>ADMINISTRADORES</h2>

    <!-- Tabla de administradores -->
    <table id="administradoresTable" style="width: 100%;">
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
@include('forms.administrador.new')
@include('forms.administrador.view')
@include('forms.administrador.edit')
@endsection

@section('scripts')
<script>
document.addEventListener("DOMContentLoaded", function() {
    // Referencias a modales
    const modal = document.getElementById('modal');
    const modalView = document.getElementById('modalView');
    const modalEdit = document.getElementById('modalEdit');

    // Asignar eventos si los elementos existen
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

    // Cargar DataTable para Administradores
    $('#administradoresTable').DataTable({
        "ajax": "{{ route('admin.administradores.data') }}",
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
                            <button class="btn btn-info" title="Visualizar" onclick="viewAdministrador('${row.id}')">
                                <i class="fas fa-eye"></i>
                            </button>
                            <button class="btn btn-warning" title="Editar" onclick="editAdministrador('${row.id}')">
                                <i class="fas fa-edit"></i>
                            </button>
                            <button class="btn btn-danger" title="Eliminar" onclick="deleteAdministrador('${row.id}')">
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
        "initComplete": function (settings, json) {
            var nuevoAdministrador = $('<button>', {
                text: 'Nuevo Administrador',
                class: 'add-form',
                id: 'openModalBtn',
                click: function () {
                    // Muestra el modal (puedes adaptar la lógica según corresponda)
                    modal.style.display = 'flex';
                }
            });
            $('#administradoresTable').before(nuevoAdministrador);
        }
    });
});

// Función para visualizar datos de un administrador
function viewAdministrador(userId) {
    $.ajax({
        url: 'administradores/' + userId,
        type: 'GET',
        dataType: 'json',
        success: function(response) {
            if(response.error) {
                alert('Error: ' + response.error);
            } else {
                $('#nombreView').text(response.data.nombre + ' ' + response.data.apellidoP + ' ' + response.data.apellidoM);
                $('#fechaView').text(response.data.fecha_nacimiento);
                $('#telefonoView').text(response.data.telefono);
                $('#correoView').text(response.data.correo);
                $('#rfcView').text(response.data.rfc ? response.data.rfc : 'Vacio');
                $('#curpView').text(response.data.curp ? response.data.curp : 'Vacio');

                // Actualiza la imagen de perfil
                if(response.data.profile_picture) {
                    $('#profilePictureView').attr('src', '/storage/' + response.data.profile_picture);
                } else {
                    $('#profilePictureView').attr('src', '/images/default_profile.png');
                }
                $('#modalView').css('display', 'flex');
            }
        },
        error: function() {
            alert('Ocurrió un error al cargar los datos.');
        }
    });
}

// Función para editar datos de un administrador
function editAdministrador(userId) {
    $.ajax({
        url: 'administradores/' + userId,
        type: 'GET',
        dataType: 'json',
        success: function(response) {
            if(response.error) {
                alert('Error: ' + response.error);
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

                if(response.data.profile_picture){
                    $('#profilePictureEdit').attr('src', '/storage/' + response.data.profile_picture);
                } else {
                    $('#profilePictureEdit').attr('src', '/images/default_profile.png');
                }
                $('#modalEdit').css('display', 'flex');
                $('#trabajadorFormEdit').attr('action', 'administradores/' + userId);
            }
        },
        error: function() {
            alert('Ocurrió un error al cargar los datos.');
        }
    });
}

// Función para eliminar un administrador
function deleteAdministrador(userId) {
    Swal.fire({
        title: '¿Estás seguro?',
        text: 'Esta acción no se puede deshacer.',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonText: 'Sí, eliminar',
        cancelButtonText: 'Cancelar',
    }).then((result) => {
        if(result.isConfirmed) {
            $.ajax({
                url: 'administradores/' + userId,
                type: 'DELETE',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                success: function(response) {
                    if(response.success) {
                        Swal.fire('¡Eliminado!', response.message, 'success');
                        $('#administradoresTable').DataTable().ajax.reload();
                    } else {
                        Swal.fire('¡Error!', response.message, 'error');
                    }
                },
                error: function() {
                    Swal.fire('¡Error!', 'No se pudo eliminar el administrador.', 'error');
                }
            });
        }
    });
}
</script>
@endsection





