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
    @if (session('typeFormErrors') == 'update')
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
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
            @if ($errors->any())
                @if (session('typeFormErrors') == 'store')
                    document.getElementById("modal").style.display = "flex";
                @endif
            @endif
    });

    const modal = document.getElementById('modal');
    const closeModalBtn = document.getElementById('closeModalBtn');
    closeModalBtn.addEventListener('click', () => {
        modal.style.display = 'none';
    });

    const modalView = document.getElementById('modalView');
    const modalViewclose = document.getElementById('closeModalBtnView');
    modalViewclose.addEventListener('click', () => {
        modalView.style.display = 'none';
    });

    const modalEdit = document.getElementById('modalEdit');
    const modalEditclose = document.getElementById('closeModalBtnEdit')
    modalEditclose.addEventListener('click', () => {
        modalEdit.style.display = 'none';
    });

    $(document).ready(function () {
        cargarTabla();
    });

    function cargarTabla() {
        $('#administradoresTable').DataTable({
            "ajax": "{{ route('admin.administradores.data') }}", // Llama a la ruta que retorna los datos
            "columns": [
                { "data": "id" },
                {
                    "data": null,
                    "render": function (data, type, row) {
                        // Combina el nombre con los apellidos
                        return `${row.nombre} ${row.apellidos.paterno} ${row.apellidos.materno}`;
                    }
                },
                { "data": "correo" },
                { "data": "telefono" },
                {
                    "data": null,
                    "render": function (data, type, row) {
                        return `
                            <div class="action-buttons">
                                <button class="btn btn-info" title="Visualizar" onclick="ver('${row.id}');"><i class="fas fa-eye"></i></button>
                                <button class="btn btn-warning" title="Editar" onclick="verEdit('${row.id}');"><i class="fas fa-edit"></i></button>
                                <button class="btn btn-danger" title="Eliminar" onclick="eliminar('${row.id}');"><i class="fas fa-trash-alt"></i></button>
                            </div>
                        `;
                    }
                }
            ],
            "pageLength": 8,
            "language": {
                "lengthMenu": "",
                "info": "",
                "infoEmpty": "",
                "infoFiltered": "",
                "paginate": {
                    "next": "Siguiente",
                    "previous": "Anterior"
                },
                "search": "Buscar: "
            },
            "dom": '<"top"f>rt<"bottom"p><"clear">',
            "initComplete": function (settings, json) {
                // Agrega un botón "Nuevo Trabajador" antes de la tabla
                var nuevoAdministrador = $('<button>', {
                    text: 'Nuevo Administrador',
                    class: 'add-form',
                    id: 'openModalBtn',
                    click: function () {
                        // Aquí puedes abrir un modal o redirigir a una ruta para crear un nuevo trabajador
                        modal.style.display = 'flex';
                    }
                });
                $('#administradoresTable').before(nuevoAdministrador);
            }
        });
    }

    function ver(userId) {
        $.ajax({
            url: 'administradores/' + userId, // Usamos la ruta de Laravel con el ID
            type: 'GET',
            dataType: 'json',
            success: function(response) {
                if (response.error) {
                    alert('Error: ' + response.error);
                } else {
                    // Actualizar el modal con los datos del trabajador
                    $('#nombreView').text(response.data.nombre + ' ' + response.data.apellidoP + ' ' + response.data.apellidoM);
                    $('#fechaView').text(response.data.fechaNacimiento);
                    $('#telefonoView').text(response.data.telefono);
                    $('#correoView').text(response.data.correo);
                    $('#rfcView').text(response.data.rfc);
                    $('#fechaView').text(response.data.fecha_nacimiento);
                    $('#curpView').text(response.data.curp);

                    // Mostrar el modal
                    modalView.style.display = 'flex';
                }
            },
            error: function() {

                alert('Ocurrió un error al cargar los datos.');
            }
        });
    }

    function eliminar(id) {
        Swal.fire({
            title: '¿Estás seguro?',
            text: 'Esta acción no se puede deshacer.',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Sí, eliminar',
            cancelButtonText: 'Cancelar',
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: `administradores/${id}`,  // Laravel ya genera esta ruta
                    type: "DELETE",
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')  // Token CSRF
                    },
                    success: function (response) {
                        if (response.success) {
                            Swal.fire('¡Eliminado!', response.message, 'success');
                            $('#administradoresTable').DataTable().ajax.reload();  // Recargar tabla
                        } else {
                            Swal.fire('¡Error!', response.message, 'error');
                        }
                    },
                    error: function () {
                        Swal.fire('¡Error!', 'No se pudo eliminar el administrador.', 'error');
                    }
                });
            }
        });
    }

    function verEdit(userId) {
        $.ajax({
            url: 'administradores/' + userId,
            type: 'GET',
            dataType: 'json',
            success: function(response) {
                if (response.error) {
                    alert('Error: ' + response.error);
                } else {
                    $('#nombreEdit').val(response.data.nombre);
                    $('#apellidoPEdit').val(response.data.apellidoP);
                    $('#apellidoMEdit').val(response.data.apellidoM);
                    $('#fechaEdit').val(response.data.fecha_nacimiento);
                    $('#telefonoEdit').val(response.data.telefono);
                    $('#correoEdit').val(response.data.correo);
                    $('#rfcEdit').val(response.data.rfc);
                    $('#id').val(response.data.id);
                    $('#curpEdit').val(response.data.curp);
                    modalEdit.style.display = 'flex';
                    $('#trabajadorFormEdit').attr('action', 'administradores/' + userId);
                }
            },
            error: function() {
                alert('Ocurrió un error al cargar los datos.');
            }
        });
    }



</script>



@endsection
