<link rel="stylesheet" href="{{ asset('css/forms/newForm.css') }}">

<div id="modal" class="modal">
    <div class="modal-content">
        <span id="closeModalBtn" class="close-btn">&times;</span>
        <h2>Registrar camion</h2>
        <form id="camionesForm" method="POST" action="{{ route('admin.trucks.store') }}" enctype="multipart/form-data">
            @csrf
            <div class="form-group">
                <label for="plates">Placas:</label>
                <input type="text" id="plates" name="plates" required>
            </div>
            <div class="form-group">
                <label for="brand">Marca:</label>
                <input type="text" id="brand" name="brand" required>
            </div>
            <div class="form-group">
                <label for="model">Modelo:</label>
                <input type="text" id="model" name="model" required>
            </div>
            <div class="form-group">
                <label for="year">Año:</label>
                <input type="text" id="year" name="year" required>
            </div>
            <div class="form-group">
                <label for="status">Estado:</label>
                <select id="status" name="status" required>
                    <option value="">Selecciona un estado</option> <!-- Opción por defecto -->
                    <option value="Activo">Activo</option>
                    <option value="Inactivo">Inactivo</option>
                </select>
            </div>

            <button type="submit" class="register">Registrar</button>

        </form>
    </div>
</div>
