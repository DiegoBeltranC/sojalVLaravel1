<link rel="stylesheet" href="{{ asset('css/forms/editForm.css') }}">

<div id="modalEdit" class="modal">
    <div class="modal-content">
        <span id="closeModalBtnEdit" class="close-btn">&times;</span>
        <h2>Editar camion</h2>
        <form id="camionFormEdit" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <div class="form-group">
                <label for="plates">Placas:</label>
                <input type="text" id="placasEdit" name="plates" required>
            </div>
            <div class="form-group">
                <label for="brand">Marca:</label>
                <input type="text" id="marcaEdit" name="brand" required>
            </div>
            <div class="form-group">
                <label for="model">Modelo:</label>
                <input type="text" id="modeloEdit" name="model" required>
            </div>
            <div class="form-group">
                <label for="year">Año:</label>
                <input type="text" id="anoEdit" name="year" required>
            </div>
            <div class="form-group">
                <label for="status">Estado:</label>
                <select id="estadoEdit" name="status" required>
                    <option value="">Selecciona un estado</option>
                    <option value="Activo">Activo</option>
                    <option value="Inactivo">Inactivo</option>
                </select>
            </div>
            
            <input type="hidden" name="id" id="id">
            <button type="submit"  class="register">Actualizar</button>

        </form>
    </div>
</div>
