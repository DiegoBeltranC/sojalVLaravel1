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

@if(session('truckUpdated'))
    <script>
        Swal.fire({
            title: '¡Éxito!',
            text: "{{ session('truckUpdated') }}",
            icon: 'success',
            confirmButtonText: 'Aceptar'
        });
    </script>
@endif

@if(session('truckStored'))
    <script>
        Swal.fire({
            title: '¡Éxito!',
            text: "{{ session('truckStored') }}",
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
    <table id="camionesTable" style="width: 100%;">
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
    document.addEventListener("DOMContentLoaded", function() {
        // Referencias a modales de Camiones
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

        // Inicializar DataTable para Camiones
        $('#camionesTable').DataTable({
            "ajax": "{{ route('admin.trucks.data') }}",
            "columns": [
                { "data": "id" },
                { "data": "plates" },
                { "data": "brand" },
                { "data": "model" },
                { "data": "year" },
                { "data": "status" },
                {
                    "data": null,
                    "render": function(data, type, row) {
                        return `
                            <div class="action-buttons">
                                <button class="btn btn-info" title="Visualizar" onclick="viewCamion('${row.id}')">
                                    <i class="fas fa-eye"></i>
                                </button>
                                <button class="btn btn-warning" title="Editar" onclick="editCamion('${row.id}')">
                                    <i class="fas fa-edit"></i>
                                </button>
                                <button class="btn btn-danger" title="Eliminar" onclick="deleteCamion('${row.id}')">
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
                var nuevoCamion = $('<button>', {
                    text: 'Nuevo Camión',
                    class: 'add-form',
                    id: 'openModalBtn',
                    click: function () {
                        modal.style.display = 'flex';
                    }
                });
                $('#camionesTable').before(nuevoCamion);
            }
        });
    });

    // Visualizar Camión
    function viewCamion(truckId) {
        $('#loading').show();
        $.ajax({
            url: 'trucks/' + truckId,
            type: 'GET',
            dataType: 'json',
            success: function(response) {
                if(response.error) {
                    alert('Error: ' + response.error);
                    $('#loading').hide();
                } else {
                    $('#placasView').text(response.data.plates);
                    $('#marcaView').text(response.data.brand);
                    $('#modeloView').text(response.data.model);
                    $('#anoView').text(response.data.year);
                    $('#estadoView').text(response.data.status);
                    const rutaImagen = response.data.image
                        ? "{{ asset('storage') }}/" + response.data.image
                        : "{{ asset('images/default.jpg') }}";
                    $('#truckImageView').attr('src', rutaImagen);
                    modalView.style.display = 'flex';
                    $('#loading').hide();
                }
            },
            error: function() {
                alert('Ocurrió un error al cargar los datos.');
                $('#loading').hide();
            }
        });
    }

    // Editar Camión
    function editCamion(truckId) {
        $('#loading').show();
        $.ajax({
            url: 'trucks/' + truckId,
            type: 'GET',
            dataType: 'json',
            success: function(response) {
                if(response.error) {
                    alert('Error: ' + response.error);
                    $('#loading').hide();
                } else {
                    $('#placasEdit').val(response.data.plates);
                    $('#marcaEdit').val(response.data.brand);
                    $('#modeloEdit').val(response.data.model);
                    $('#anoEdit').val(response.data.year);
                    $('#estadoEdit').val(response.data.status);
                    $('#id').val(response.data.id);

                    // Actualizar la imagen del camión
                    if(response.data.image){
                        $('#truckImageEdit').attr('src', '/storage/' + response.data.image);
                    } else {
                        $('#truckImageEdit').attr('src', '{{ asset("images/default.jpg") }}');
                    }

                    modalEdit.style.display = 'flex';
                    $('#camionFormEdit').attr('action', 'trucks/' + truckId);
                    $('#loading').hide();
                }
            },
            error: function() {
                alert('Ocurrió un error al cargar los datos.');
                $('#loading').hide();
            }
        });
    }

    // Eliminar Camión
    function deleteCamion(truckId) {
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
                    url: 'trucks/' + truckId,
                    type: 'DELETE',
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function(response) {
                        $('#loading').hide();
                        if (response.success) {
                            Swal.fire('¡Eliminado!', response.message, 'success');
                            $('#camionesTable').DataTable().ajax.reload();
                        } else {
                            Swal.fire('¡Error!', response.message, 'error');
                        }
                    },
                    error: function(xhr) {
                        let errorMessage = 'No se pudo eliminar el camión.';
                        if (xhr.responseJSON && xhr.responseJSON.message) {
                            errorMessage = xhr.responseJSON.message;
                        }
                        Swal.fire('¡Error!', errorMessage, 'error');
                        $('#loading').hide();
                    }
                });
            }
        });
    }

</script>
@endsection





