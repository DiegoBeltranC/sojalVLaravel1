<link rel="stylesheet" href="{{ asset('css/forms/viewForm.css') }}">

<div id="modalView" class="modal">
    <div class="modal-content">
      <span id="closeModalBtnView" class="close-btn">&times;</span>
      <h2>Información del Administrador</h2>
      <div id="workerInfo">

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
          <p id="rfcView">Vacio</p>
        </div>
        <div class="form-group">
          <label>CURP:</label>
          <p id="curpView">Vacio</p>
        </div>
      </div>
    </div>
  </div>
