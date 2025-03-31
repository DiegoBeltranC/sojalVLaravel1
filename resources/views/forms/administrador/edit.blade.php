<!-- resources/views/forms/administrador/edit.blade.php -->
<link rel="stylesheet" href="{{ asset('css/forms/editForm.css') }}">

<div id="modalEdit" class="modal">
    <div class="modal-content">
        <span id="closeModalBtnEdit" class="close-btn">&times;</span>
        <h2>Editar Administrador</h2>
        <form id="trabajadorFormEdit" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <div class="form-group">
                <label for="nombreEdit">Nombres:</label>
                <input type="text" id="nombreEdit" name="nombre" required>
            </div>
            <div class="form-group">
                <label for="apellidoPEdit">Apellido Paterno:</label>
                <input type="text" id="apellidoPEdit" name="apellidoP" required>
            </div>
            <div class="form-group">
                <label for="apellidoMEdit">Apellido Materno:</label>
                <input type="text" id="apellidoMEdit" name="apellidoM" required>
            </div>
             <div class="form-group">
                <label>Foto de Perfil Actual:</label>
                <img id="profilePictureEdit" src="{{ asset('images/default_profile.png') }}" alt="Foto de Perfil" style="max-width: 150px;">
            </div>
            <div class="form-group">
                <label for="profile_picture_edit">Cambiar Foto de Perfil (opcional):</label>
                <input type="file" id="profile_picture_edit" name="profile_picture" accept="image/*">
            </div>
            <div class="form-group">
                <label for="fechaEdit">Fecha de Nacimiento:</label>
                <input type="date" id="fechaEdit" name="fechaNacimiento" required>
            </div>
            <div class="form-group">
                <label for="telefonoEdit">Número de Teléfono:</label>
                <input type="tel" id="telefonoEdit" name="telefono" required>
            </div>
            <div class="form-group">
                <label for="correoEdit">Correo Electrónico:</label>
                <input type="email" id="correoEdit" name="correo" placeholder="Ej. usuario@dominio.com" required>
            </div>
            <div class="form-group">
                <label for="curpEdit">CURP:</label>
                <input type="text" id="curpEdit" name="curp" placeholder="Ej. ABCD123456HDFRZZ01"
                    pattern="[A-Z]{4}[0-9]{6}[HM][A-Z]{5}[0-9]{2}"
                    title="Ingresa un CURP válido en mayúsculas, por ejemplo, ABCD123456HDFRZZ01" required>
            </div>
            <div class="form-group">
                <label for="rfcEdit">RFC:</label>
                <input type="text" id="rfcEdit" name="rfc" placeholder="Ej. ABCD123456XXX"
                    pattern="[A-Z]{4}[0-9]{6}[A-Z0-9]{3}"
                    title="Ingresa un RFC válido en mayúsculas, por ejemplo, ABCD123456XXX" required>
            </div>
            <input type="hidden" name="id" id="id">
            <button type="submit" class="register">Actualizar</button>
        </form>
    </div>
</div>


<script>


</script>
