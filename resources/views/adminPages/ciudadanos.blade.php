@extends('layouts.admin-navbar')

@section('content')

@if(session('ciudadanoActualizado'))
    <script>
        Swal.fire({
            title: '¡Éxito!',
            text: "{{ session('ciudadanoActualizado') }}",
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
    <h2>CIUDADANOS</h2>

    <!-- Tabla de administradores -->
    <table id="ciudadanosTable" style="width: 100%;">
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
@include('forms.administrador.new') <!--Esta linea solo existe por un bug, si se quita, el flujo de las vistas se pierde-->
@include('forms.ciudadanos.view')
@include('forms.ciudadanos.edit')

@endsection

@section('scripts')
<script>
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
        $('#searchInput').on('keyup', function() {
            table.search(this.value).draw();
        });
    });

    function cargarTabla() {
        $('#ciudadanosTable').DataTable({
            "ajax": "{{ route('admin.ciudadanos.data') }}", // Llama a la ruta que retorna los datos
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
            }});
    }

    function ver(userId) {
        $.ajax({
            url: 'ciudadanos/' + userId, // Usamos la ruta de Laravel con el ID
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
                    url: `ciudadanos/${id}`,  // Laravel ya genera esta ruta
                    type: "DELETE",
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')  // Token CSRF
                    },
                    success: function (response) {
                        if (response.success) {
                            Swal.fire('¡Eliminado!', response.message, 'success');
                            $('#ciudadanosTable').DataTable().ajax.reload();  // Recargar tabla
                        } else {
                            Swal.fire('¡Error!', response.message, 'error');
                        }
                    },
                    error: function () {
                        Swal.fire('¡Error!', 'No se pudo eliminar el ciudadano.', 'error');
                    }
                });
            }
        });
    }

    function verEdit(userId) {
        $.ajax({
            url: 'ciudadanos/' + userId,
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
                    $('#id').val(response.data.id);
                    modalEdit.style.display = 'flex';
                    $('#trabajadorFormEdit').attr('action', 'ciudadanos/' + userId);
                }
            },
            error: function() {
                alert('Ocurrió un error al cargar los datos.');
            }
        });
    }


</script>



@endsection
