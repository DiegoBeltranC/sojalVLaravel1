<link rel="stylesheet" href="{{ asset('css/forms/editForm.css') }}">

<div id="modalEdit" class="modal">
    <div class="modal-content">
        <span id="closeModalBtnEdit" class="close-btn">&times;</span>
        <h2>Editar Trabajador</h2>
        <form id="trabajadorFormEdit" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <div class="form-group">
                <label for="name">Nombres:</label>
                <input type="text" id="nombreEdit" name="nombre" required>
            </div>
            <div class="form-group">
                <label for="name">Apellido Paterno:</label>
                <input type="text" id="apellidoPEdit" name="apellidoP" required>
            </div>
            <div class="form-group">
                <label for="name">Apellido Materno:</label>
                <input type="text" id="apellidoMEdit" name="apellidoM" required>
            </div>
            <div class="form-group">
                <label for="date">Fecha de Nacimiento:</label>
                <input type="date" id="fechaEdit" name="fechaNacimiento" required>
            </div>

            <div class="form-group">
                <label for="name">Número de Teléfono:</label>
                <input type="tel" id="telefonoEdit" name="telefono" required>
            </div>
            <div class="form-group">
                <label for="email">Correo Electrónico:</label>
                <input type="email" id="correoEdit" name="correo" placeholder="Ej. usuario@dominio.com" required>
            </div>

            <div class="form-group">
                <label for="curp">CURP:</label>
                <input type="text" id="curpEdit" name="curp" placeholder="Ej. ABCD123456HDFRZZ01">
            </div>
            <div class="form-group">
                <label for="rfc">RFC:</label>
                <input type="text" id="rfcEdit" name="rfc" placeholder="Ej. ABCD123456XXX" >
            </div>
            <input type="hidden" name="id" id="id">
            <button type="submit"  class="register">Actualizar</button>
        </form>
    </div>
</div>
