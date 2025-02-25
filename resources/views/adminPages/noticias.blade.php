@extends('layouts.admin-navbar')
<link rel="stylesheet" href="{{ asset('css/ViewNotifiacion.css') }}" />

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
  #content {
    padding-left: 0px;
    padding-right: 0px;
  }
 </style>
 <!-- Contenido-->
 <div class="content" id="content">
    <div class="content-button">
      <h2>NOTIFICACIONES</h2>
      <button class="add">
      <span class="button-text" id="Agregar-Notificacion">Agregar</span>
     <img src="../images/Icons/boton-mas.svg" alt="Icono" class="button-icon">
    </button>

      </div>
      <div class="container-cards">
    <div class="card">
        <img src="../images/RecolectorBasura.jpg" alt="Imagen de la noticia" class="news-image">
        <div class="card-content">
            <h2>Título de la Noticia</h2>
            <p class="mini-description">Esta es una breve descripción de la noticia que explica de qué trata.</p>
            <div class="dates">
                <p class="start-date">01/01/2024</p>
                <p class="end-date">07/01/2024</p>
            </div>
            <div class="creator-info">
                <img src="../package/image/photos/UserHunter.jpg" alt="Imagen de perfil" class="profile-image">
                <p>Jonathan Cherriz</p>
            </div>
            <div class="news-footer">
                <span class="likes">120 Likes</span>
                <div class="actions">
                    <button class="edit-btn">Editar</button>
                    <button class="details-btn">Ver Más</button>
                </div>
            </div>
        </div>
    </div>
    <div class="card">
        <img src="../images/RecolectorBasura.jpg" alt="Imagen de la noticia" class="news-image">
        <div class="card-content">
            <h2>Título de la Noticia</h2>
            <p class="mini-description">Esta es una breve descripción de la noticia que explica de qué trata.</p>
            <div class="dates">
                <p class="start-date">01/01/2024</p>
                <p class="end-date">07/01/2024</p>
            </div>
            <div class="creator-info">
                <img src="../package/image/photos/UserHunter.jpg" alt="Imagen de perfil" class="profile-image">
                <p>Jonathan Cherriz</p>
            </div>
            <div class="news-footer">
                <span class="likes">120 Likes</span>
                <div class="actions">
                    <button class="edit-btn">Editar</button>
                    <button class="details-btn">Ver Más</button>
                </div>
            </div>
        </div>
    </div>
    <div class="card">
        <img src="../images/RecolectorBasura.jpg" alt="Imagen de la noticia" class="news-image">
        <div class="card-content">
            <h2>Título de la Noticia</h2>
            <p class="mini-description">Esta es una breve descripción de la noticia que explica de qué trata.</p>
            <div class="dates">
                <p class="start-date">01/01/2024</p>
                <p class="end-date">07/01/2024</p>
            </div>
            <div class="creator-info">
                <img src="../package/image/photos/UserHunter.jpg" alt="Imagen de perfil" class="profile-image">
                <p>Jonathan Cherriz</p>
            </div>
            <div class="news-footer">
                <span class="likes">120 Likes</span>
                <div class="actions">
                    <button class="edit-btn">Editar</button>
                    <button class="details-btn">Ver Más</button>
                </div>
            </div>
        </div>
    </div>
</div>
    </div>
</div>

    </div>
  </div>
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
