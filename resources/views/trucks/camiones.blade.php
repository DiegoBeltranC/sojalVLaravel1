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
    <h2>Camiones</h2>

    <!-- Tabla de camiones -->
    <table id="administradoresTable" style="width: 100%;">
        <thead>
            <tr>
                <th>ID</th>
                <th>Placas</th>
                <th>Marca</th>
                <th>Modelo</th>
                <th>Año</th>
                <th>Estatus</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
        </tbody>
    </table>
</div>
@include('forms.camiones.new')
@include('forms.camiones.view')
@include('forms.camiones.edit')
@endsection

@section('scripts')
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
        $('#administradoresTable').DataTable({
            "ajax": "{{ route('admin.trucks.data') }}", // Llama a la ruta que retorna los datos
            "columns": [
                { "data": "id" },
                { "data": "plates" },
                { "data": "brand" },
                { "data": "model" },
                { "data": "year" },
                { "data": "status" },
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
                var nuevoCamion = $('<button>', {
                    text: 'Nuevo camion',
                    class: 'add-form',
                    id: 'openModalBtn',
                    click: function () {
                        // Aquí puedes abrir un modal o redirigir a una ruta para crear un nuevo trabajador
                        modal.style.display = 'flex';
                    }
                });
                $('#administradoresTable').before(nuevoCamion);
            }
        });
    }

    function ver(truckId) {
        $.ajax({
            url: 'trucks/' + truckId, // Usamos la ruta de Laravel con el ID
            type: 'GET',
            dataType: 'json',
            success: function(response) {
                if (response.error) {
                    alert('Error: ' + response.error);
                } else {
                    // Actualizar el modal con los datos del trabajador
                    $('#placasView').text(response.data.plates);
                    $('#marcaView').text(response.data.brand);
                    $('#modeloView').text(response.data.model);
                    $('#anoView').text(response.data.year);
                    $('#estadoView').text(response.data.status);

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
                    url: `trucks/${id}`,  // Laravel ya genera esta ruta
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

    function verEdit(truckId) {
        $.ajax({
            url: 'trucks/' + truckId,
            type: 'GET',
            dataType: 'json',
            success: function(response) {
                if (response.error) {
                    alert('Error: ' + response.error);
                } else {
                    $('#placasEdit').val(response.data.plates);
                    $('#marcaEdit').val(response.data.brand);
                    $('#modeloEdit').val(response.data.model);
                    $('#anoEdit').val(response.data.year);
                    $('#estadoEdit').val(response.data.status);
                    $('#id').val(response.data.id);
                    modalEdit.style.display = 'flex';
                    $('#camionFormEdit').attr('action', 'trucks/' + truckId);
                }
            },
            error: function() {
                alert('Ocurrió un error al cargar los datos.');
            }
        });
    }



</script>



@endsection
