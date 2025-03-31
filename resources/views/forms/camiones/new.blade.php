<link rel="stylesheet" href="{{ asset('css/forms/newForm.css') }}">

<div id="modal" class="modal">
    <div class="modal-content">
        <span id="closeModalBtn" class="close-btn">&times;</span>
        <h2>Registrar Camión</h2>
        <form id="camionesForm" method="POST" action="{{ route('admin.trucks.store') }}" enctype="multipart/form-data">
            @csrf
            <div class="form-group">
                <label for="plates">Placas:</label>
                <!-- Se permite el formato: 3 letras y 3 o 4 dígitos, con guion opcional -->
                <input type="text" id="plates" name="plates" required
                    pattern="[A-Za-z]{3}-?\d{3,4}"
                    title="Ingresa 3 letras seguidas de 3 o 4 dígitos (ej: ABC123 o ABC-1234)">
            </div>
            <div class="form-group">
                <label for="brand">Marca:</label>
                <!-- Solo letras y espacios, máximo 15 caracteres -->
                <input type="text" id="brand" name="brand" required maxlength="15"
                    pattern="[A-Za-z\s]+"
                    title="Solo se permiten letras y espacios. Máximo 15 caracteres.">
            </div>
            <div class="form-group">
                <label for="model">Modelo:</label>
                <!-- Solo letras y espacios, máximo 15 caracteres -->
                <input type="text" id="model" name="model" required maxlength="15"
                    pattern="[A-Za-z\s]+"
                    title="Solo se permiten letras y espacios. Máximo 15 caracteres.">
            </div>
            <div class="form-group">
                <label for="year">Año:</label>
                <input type="number" id="year" name="year" required>
            </div>
            <div class="form-group">
                <label for="status">Estado:</label>
                <select id="status" name="status" required>
                    <option value="">Selecciona un estado</option>
                    <option value="Activo">Activo</option>
                    <option value="Inactivo">Inactivo</option>
                </select>
            </div>
            <div class="form-group">
                <label for="image">Imagen del Camión:</label>
                <input type="file" id="image" name="image" accept="image/*" required>
            </div>
            <button type="submit" class="register">Registrar</button>
        </form>
    </div>
</div>

