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
    <script src="https://code.jquery.com/jquery-3.5.1.js"></script>
    <script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>


    <script>

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
        $('#trabajadoresTable').DataTable({
            "ajax": "{{ route('admin.trabajadores.data') }}", // Llama a la ruta que retorna los datos
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
                var nuevoTrabajador = $('<button>', {
                    text: 'Nuevo Trabajador',
                    class: 'add-form',
                    id: 'openModalBtn',
                    click: function () {
                        // Aquí puedes abrir un modal o redirigir a una ruta para crear un nuevo trabajador
                        modal.style.display = 'flex';
                    }
                });
                $('#trabajadoresTable').before(nuevoTrabajador);
            }
        });
    }

    // Funciones para las acciones (debes implementarlas según tus necesidades)
    function ver(userId) {
        $.ajax({
            url: 'trabajadores/' + userId, // Usamos la ruta de Laravel con el ID
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
    function verEdit(userId) {
        $.ajax({
            url: 'trabajadores/' + userId,
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
                    $('#trabajadorFormEdit').attr('action', 'trabajadores/' + userId);
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
                    url: `trabajadores/${id}`,  // Laravel ya genera esta ruta
                    type: "DELETE",
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')  // Token CSRF
                    },
                    success: function (response) {
                        if (response.success) {
                            Swal.fire('¡Eliminado!', response.message, 'success');
                            $('#trabajadoresTable').DataTable().ajax.reload();  // Recargar tabla
                        } else {
                            Swal.fire('¡Error!', response.message, 'error');
                        }
                    },
                    error: function () {
                        Swal.fire('¡Error!', 'No se pudo eliminar el trabajador.', 'error');
                    }
                });
            }
        });
    }


    </script>



@endsection

