<!-- resources/views/forms/trabajadores/view.blade.php -->
<link rel="stylesheet" href="{{ asset('css/forms/viewForm.css') }}">

<div id="modalView" class="modal">
    <div class="modal-content">
      <span id="closeModalBtnView" class="close-btn">&times;</span>
      <h2>Información del Trabajador</h2>
      <div id="workerInfo">
        <!-- Bloque para mostrar la foto de perfil -->
        <div class="form-group">
          <label>Foto de Perfil:</label>
          <img id="profileImageView" src="{{ asset('images/default_profile.png') }}" alt="Foto de Perfil" style="max-width: 150px;">
        </div>
        <div class="form-group">
          <label>Nombre:</label>
          <p id="nombreView">Juan Pérez</p>
        </div>
        <div class="form-group">
          <label>Fecha de Nacimiento:</label>
          <p id="fechaView">2005/10/11</p>
        </div>
        <div class="form-group">
          <label>Teléfono:</label>
          <p id="telefonoView">+52 123 456 7890</p>
        </div>
        <div class="form-group">
          <label>Correo Electrónico:</label>
          <p id="correoView">juan.perez@example.com</p>
        </div>
        <div class="form-group">
          <label>RFC:</label>
          <p id="rfcView">Vacío</p>
        </div>
        <div class="form-group">
          <label>CURP:</label>
          <p id="curpView">Vacío</p>
        </div>
      </div>
    </div>
</div>

