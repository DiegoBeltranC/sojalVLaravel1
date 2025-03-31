<link rel="stylesheet" href="{{ asset('css/forms/newForm.css') }}">

<div id="modal" class="modal">
    <div class="modal-content">
        <span id="closeModalBtn" class="close-btn">&times;</span>
        <h2>Registrar Administrador</h2>
        <form id="administradorForm" method="POST" action="{{ route('admin.administradores.store') }}" enctype="multipart/form-data">
            @csrf
            <div class="form-group">
                <label for="name">Nombres:</label>
                <input type="text" id="name" name="nombre" required>
            </div>
            <div class="form-group">
                <label for="name">Apellido Paterno:</label>
                <input type="text" id="name" name="apellidoP" required>
            </div>
            <div class="form-group">
                <label for="name">Apellido Materno:</label>
                <input type="text" id="name" name="apellidoM" required>
            </div>
            <div class="form-group">
                <label for="profile_picture">Foto de Perfil:</label>
                <input type="file" id="profile_picture" name="profile_picture" accept="image/*">
            </div>
            <div class="form-group">
                <label for="date">Fecha de Nacimiento:</label>
                <input type="date" id="date" name="fechaNacimiento" required>
            </div>
            <div class="form-group">
                <label for="name">Número de Teléfono:</label>
                <input type="tel" id="name" name="telefono" required>
            </div>
            <div class="form-group">
                <label for="email">Correo Electrónico:</label>
                <input type="email" id="email" name="correo" placeholder="Ej. usuario@dominio.com" required>
            </div>
            <div class="form-group">
                <label for="curp">CURP:</label>
                <input type="text" id="curp" name="curp" placeholder="Ej. ABCD123456HDFRZZ01"
                    pattern="[A-Z]{4}[0-9]{6}[HM][A-Z]{5}[0-9]{2}"
                    title="Ingresa un CURP válido en mayúsculas, por ejemplo, ABCD123456HDFRZZ01" required>
            </div>
            <div class="form-group">
                <label for="rfc">RFC:</label>
                <input type="text" id="rfc" name="rfc" placeholder="Ej. ABCD123456XXX"
                    pattern="[A-Z]{4}[0-9]{6}[A-Z0-9]{3}"
                    title="Ingresa un RFC válido en mayúsculas, por ejemplo, ABCD123456XXX" required>
            </div>

            <button type="submit" class="register">Registrar</button>

        </form>
    </div>
</div>
