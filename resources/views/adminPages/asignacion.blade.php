@extends('layouts.admin-navbar')

@section('content')

<style>
    .content {
        height: 91.5vh;
    }
</style>

<div class="content">
    <h2>ASIGNACIÓN</h2>

    <table id="asignacionTable" style="width: 100%;">
       <thead>
           <tr>
               <th>ID Asignación</th>
               <th>Usuario</th>
               <th>Ruta</th>
               <th>Camión</th>
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
    <script src="https://api.mapbox.com/mapbox-gl-js/v2.10.0/mapbox-gl.js"></script>


    <script>
        $(document).ready(function () {
            cargarTabla();
        });

        function cargarTabla() {
            $('#asignacionTable').DataTable({
                "ajax": "{{ route('admin.asignacion.data') }}", // Llama a la ruta que retorna los datos
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
                    var nuevaAsignacion = $('<button>', {
                        text: 'Nuevo Trabajador',
                        class: 'add-form',
                        id: 'openModalBtn',
                        click: function () {
                            // Aquí puedes abrir un modal o redirigir a una ruta para crear un nuevo trabajador
                            modal.style.display = 'flex';
                        }
                    });
                    $('#asignacionTable').before(nuevaAsignacion);
                }
            });
        }

    </script>



@endsection
