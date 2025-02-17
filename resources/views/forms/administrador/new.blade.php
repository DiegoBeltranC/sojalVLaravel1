<link rel="stylesheet" href="{{ asset('css/forms/newForm.css') }}">
<style>
    .error-message {
    color: red;
    font-size: 0.9em;
    margin-top: 5px;
    display: block;
}

</style>
<div id="modal" class="modal">
    <div class="modal-content">
        <span id="closeModalBtn" class="close-btn">&times;</span>
        <h2>Registrar Administrador</h2>
        <form id="administradorForm" method="POST" action="{{ route('admin.administradores.store') }}" enctype="multipart/form-data">
            @csrf
            @csrf
            <div class="form-group">
                <label for="name">Nombres:</label>
                <input type="text" id="name" name="nombre" required value="{{ old('nombre') }}">
                @error('nombre')
                    <small class="error-message">{{ $message }}</small>
                @enderror
            </div>
            <div class="form-group">
                <label for="apellidoP">Apellido Paterno:</label>
                <input type="text" id="apellidoP" name="apellidoP" required value="{{ old('apellidoP') }}">
                @error('apellidoP')
                    <small class="error-message">{{ $message }}</small>
                @enderror
            </div>
            <div class="form-group">
                <label for="apellidoM">Apellido Materno:</label>
                <input type="text" id="apellidoM" name="apellidoM" required value="{{ old('apellidoM') }}">
                @error('apellidoM')
                    <small class="error-message">{{ $message }}</small>
                @enderror
            </div>
            <div class="form-group">
                <label for="date">Fecha de Nacimiento:</label>
                <input type="date" id="date" name="fechaNacimiento" required value="{{ old('fechaNacimiento', '2000-01-01') }}">
                @error('fechaNacimiento')
                    <small class="error-message">{{ $message }}</small>
                @enderror
            </div>
            <div class="form-group">
                <label for="telefono">Número de Teléfono:</label>
                <input type="tel" id="telefono" name="telefono" required value="{{ old('telefono') }}">
                @error('telefono')
                    <small class="error-message">{{ $message }}</small>
                @enderror
            </div>
            <div class="form-group">
                <label for="email">Correo Electrónico:</label>
                <input type="email" id="email" name="correo" placeholder="Ej. usuario@dominio.com" required value="{{ old('correo') }}">
                @error('correo')
                    <small class="error-message">{{ $message }}</small>
                @enderror
            </div>
            <div class="form-group">
                <label for="curp">CURP:</label>
                <input type="text" id="curp" name="curp" placeholder="Ej. ABCD123456HDFRZZ01"
                    pattern="[A-Z]{4}[0-9]{6}[HM][A-Z]{5}[0-9]{2}"
                    title="Ingresa un CURP válido en mayúsculas, por ejemplo, ABCD123456HDFRZZ01"
                    value="{{ old('curp') }}">
                @error('curp')
                    <small class="error-message">{{ $message }}</small>
                @enderror
            </div>
            <div class="form-group">
                <label for="rfc">RFC:</label>
                <input type="text" id="rfc" name="rfc" placeholder="Ej. ABCD123456XXX"
                    pattern="[A-Z]{4}[0-9]{6}[A-Z0-9]{3}"
                    title="Ingresa un RFC válido en mayúsculas, por ejemplo, ABCD123456XXX"
                    value="{{ old('rfc') }}">
                @error('rfc')
                    <small class="error-message">{{ $message }}</small>
                @enderror
            </div>
            <button type="submit" class="register">Registrar</button>

        </form>
    </div>
</div>
