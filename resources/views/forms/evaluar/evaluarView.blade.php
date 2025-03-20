<link rel="stylesheet" href="{{ asset('css/forms/viewForm.css') }}">
<link rel="stylesheet" href="{{ asset('css/reporteView.css') }}">

<div id="modalView" class="modalView">
    <div class="modal-content">
      <h2>Información del Reporte</h2>
        <p id="descripcionView" hidden>id</p>

        <div class="form-group">
          <label>Fotos:</label>
          <div class="content-img" id="content-img"></div>
        </div>


        <div class="form-group">
          <label>Descripcion:</label>
          <p id="decripcionView"></p>
        </div>
        <div class="form-group">
          <label>Referencias:</label>
          <p id="referenciasView"></p>
        </div>
        <div class="form-group">
          <label>Colonia:</label>
          <p id="coloniaView"></p>
        </div>
        <div class="form-group">
          <label>Calle:</label>
          <p id="calleView"></p>
        </div>
        <div class="form-group">
          <label>Cruzamientos:</label>
          <p id="cruzamientosView"></p>
        </div>
        <div class="form-group">
          <label>No.Casa:</label>
          <p id="numeroView"></p>
        </div>

        <div class="profile-container">
      <img src="http://via.placeholder.com/50" alt="Foto de perfil" class="profile-pic" id="profilePic">
      <div class="profile-info">
          <p class="profile-name" id="nombreView">Nombre del Usuario</p>
          <p class="profile-date"  id="fechaView">Fecha de creación:</p>
      </div>

    </div>
        <div id="mapAsignar"></div>
        <div class="button-container">
            <button type="button" onclick="" class="asignar" id="asignar">Asignar Reporte</button>
            <button type="button" onclick="" class="avances"  id="avances">Visualizar Avances</button>
            <button type="button" onclick="" class="finalizar">Finalizar Reporte</button>
        </div>
    </div>

</div>
