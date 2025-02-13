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
    <h2>USUARIOS</h2>

    <!-- Tabla de administradores -->
    <table id="usuariosTable" style="width: 100%;">
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

@endsection

@section('scripts')
<script>

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



</script>



@endsection
