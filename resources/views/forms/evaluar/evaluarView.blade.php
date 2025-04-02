<link rel="stylesheet" href="{{ asset('css/forms/viewForm.css') }}">
<link rel="stylesheet" href="{{ asset('css/reporteView.css') }}">
<style>
    #mapView { height: 16rem;width: 100%;}
</style>
<form action="{{ route('admin.evaluar.store') }}" method="POST">
    @csrf
<div id="modalView" class="modalView">
    <div class="modal-content">
    <span id="closeModalBtn" class="close-btn">&times;</span>
      <h2>Información del Reporte</h2>
        <input type="hidden" name="idReporte" id="idReporte">
        <div class="form-group">
          <label>Fotos:</label>
          <div class="content-img" id="content-img"></div>
        </div>


        <div class="form-group">
          <label>Descripcion:</label>
          <p id="decripcionView"></p>
        </div>
        <div class="profile-container">
            <img src="http://via.placeholder.com/50" alt="Foto de perfil" class="profile-pic" id="profilePic">
            <div class="profile-info">
                <p class="profile-name" id="nombreView">Nombre del Usuario</p>
                <p class="profile-date"  id="fechaView">Fecha de creación:</p>
                <p class="profile-date"  id="correoView"></p>
            </div>
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
        <div class="form-group" id="avancesSection" style="display: none">
            <label>Avances:</label>
            <div id="avancesContent" class="cards-container"></div>
        </div>

    <br>
    <div class="container-asignar">
        <div class="custom-row">
            <div class="custom-group">
                <label for="asignacion">Asignacion</label>
                <select id="asignacion" class="custom-select" name="asignacion" required></select>
            </div>
        </div>
        <div class="profile-container">
            <img src="{{ asset('images/profile.png') }}" alt="Foto de perfil" class="profile-pic" id="profilePicTrabajador">
            <div class="profile-info">
                <p class="profile-name" id="nombreNew">Nombre del trabajador</p>
                <p class="profile-date" id="telefonoNew">Teléfono:</p>
            </div>
        </div>
        <br>
        <div id="mapView"></div>


        <div class="button-container">
            <button type="button" onclick="rechazarReporte()" class="rechazar" id="rechazar" disabled>Rechazar Reporte</button>
            <button type="submit"  class="asignar" id="asignar" disabled>Asignar Reporte</button>
            <button type="button" onclick="finalizarReporte()" class="finalizar" disabled id="finalizar">Finalizar Reporte</button>
        </div>


        </div>

    </div>

</div>
</form>
