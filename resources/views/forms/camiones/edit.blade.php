<link rel="stylesheet" href="{{ asset('css/forms/editForm.css') }}">

<div id="modalEdit" class="modal">
    <div class="modal-content">
        <span id="closeModalBtnEdit" class="close-btn">&times;</span>
        <h2>Editar Camión</h2>
        <form id="camionFormEdit" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <div class="form-group">
                <label for="plates">Placas:</label>
                <!-- Se permite el formato: 3 letras y 3 o 4 dígitos, con guion opcional -->
                <input type="text" id="placasEdit" name="plates" required
                    pattern="[A-Za-z]{3}-?\d{3,4}" 
                    title="Ingresa 3 letras seguidas de 3 o 4 dígitos (ej: ABC123 o ABC-1234)">
            </div>
            <div class="form-group">
                <label for="brand">Marca:</label>
                <!-- Solo letras y espacios, máximo 15 caracteres -->
                <input type="text" id="marcaEdit" name="brand" required maxlength="15"
                    pattern="[A-Za-z\s]+"
                    title="Solo se permiten letras y espacios. Máximo 15 caracteres.">
            </div>
            <div class="form-group">
                <label for="model">Modelo:</label>
                <!-- Solo letras y espacios, máximo 15 caracteres -->
                <input type="text" id="modeloEdit" name="model" required maxlength="15"
                    pattern="[A-Za-z\s]+"
                    title="Solo se permiten letras y espacios. Máximo 15 caracteres.">
            </div>
            <div class="form-group">
                <label for="year">Año:</label>
                <input type="number" id="anoEdit" name="year" required>
            </div>
            <div class="form-group">
                <label for="status">Estado:</label>
                <select id="estadoEdit" name="status" required>
                    <option value="">Selecciona un estado</option>
                    <option value="Activo">Activo</option>
                    <option value="Inactivo">Inactivo</option>
                </select>
            </div>
            <!-- Mostrar imagen actual -->
            <div class="form-group">
                <label>Imagen Actual:</label>
                <img id="truckImageEdit" src="{{ asset('images/default.jpg') }}" alt="Imagen del camión" style="max-width: 150px;">
            </div>
            <div class="form-group">
                <label for="image_edit">Cambiar Imagen (opcional):</label>
                <input type="file" id="image_edit" name="image" accept="image/*" require>
            </div>
            <input type="hidden" name="id" id="id">
            <button type="submit" class="register">Actualizar</button>
        </form>
    </div>
</div>

