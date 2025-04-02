<link rel="stylesheet" href="{{ asset('css/forms/viewForm.css') }}">
<link rel="stylesheet" href="{{ asset('css/reporteView.css') }}">
<style>
    #mapRechazado { height: 16rem;width: 100%;}
</style>
<form >
<div id="modalRechazado" class="modalView">
    <div class="modal-content">
    <span id="closeModalBtnRechazado" class="close-btn">&times;</span>
      <h2 style="color: red;">Información del Reporte</h2>
        <input type="hidden" name="idReporte" id="idReporteRechazado" value="">
        <div class="form-group">
          <label>Fotos:</label>
          <div class="content-img" id="content-imgRechazado"></div>
        </div>
        <div class="form-group">
          <label>Descripcion:</label>
          <p id="decripcionRechazado"></p>
        </div>
        <div class="profile-container">
            <img src="http://via.placeholder.com/50" alt="Foto de perfil" class="profile-pic" id="profilePicRechazado">
            <div class="profile-info">
                <p class="profile-name" id="nombreRechazado">Nombre del Usuario</p>
                <p class="profile-date" id="telefonoRechazado"></p>
                <p class="profile-date" id="correoRechazado"></p>
            </div>
          </div>
        <div class="form-group">
          <label>Referencias:</label>
          <p id="referenciasRechazado"></p>
        </div>
        <div class="form-group">
          <label>Colonia:</label>
          <p id="coloniaRechazado"></p>
        </div>
        <div class="form-group">
          <label>Calle:</label>
          <p id="calleRechazado"></p>
        </div>
        <div class="form-group">
          <label>Cruzamientos:</label>
          <p id="cruzamientosRechazado"></p>
        </div>
        <div class="form-group">
          <label>Fecha de rechazo:</label>
          <p id="fechaRechazado"></p>
        </div>
        <br>
        <div id="mapRechazado"></div>
</div>
</form>