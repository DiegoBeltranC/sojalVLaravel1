@extends('layouts.admin-navbar')

@section('content')
<style>
    .content {
        height: 91.5vh;
    }
</style>

<div class="content">
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
@endsection

@section('scripts')
    <!-- Cargar jQuery y DataTables -->
    <script src="https://code.jquery.com/jquery-3.5.1.js"></script>
    <script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>

    <script>
    $(document).ready(function () {
        cargarTabla();
    });

    function cargarTabla() {
        $('#trabajadoresTable').DataTable({
            "ajax": "{{ route('trabajadores.data') }}", // Llama a la ruta que retorna los datos
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
                                <button class="btn btn-warning" title="Editar" onclick="editar('${row.id}');"><i class="fas fa-edit"></i></button>
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
                var nuevoTrabajador = $('<button>', {
                    text: 'Nuevo Trabajador',
                    class: 'add-form',
                    id: 'openModalBtn',
                    click: function () {
                        // Aquí puedes abrir un modal o redirigir a una ruta para crear un nuevo trabajador
                        $('#modalTrabajador').css('display', 'flex');
                    }
                });
                $('#trabajadoresTable').before(nuevoTrabajador);
            }
        });
    }

    // Funciones para las acciones (debes implementarlas según tus necesidades)
    function ver(id) {
        // Lógica para visualizar un trabajador
    }

    function editar(id) {
        // Lógica para editar un trabajador
    }

    function eliminar(id) {
        // Lógica para eliminar un trabajador
    }
    </script>
@endsection

