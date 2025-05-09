<link rel="stylesheet" href="{{ asset('css/forms/viewForm.css') }}">
<link rel="stylesheet" href="{{ asset('css/reporteView.css') }}">
<style>
    #mapView { height: 16rem;width: 100%; }
    /* Nuevo estilo para la sección de información del reporte */
    .container-report-info {
        padding: 20px;
        background-color: #f5f1ff; /* Color pastel que complementa los existentes */
        border: 1px solid #ccc;
        border-radius: 8px;
        box-shadow: 0px 4px 6px rgba(0, 0, 0, 0.1);
        margin: 20px auto;
    }
</style>

<form action="{{ route('admin.evaluar.store') }}" method="POST">
    @csrf
    <div id="modalView" class="modalView">
        <div class="modal-content">
            <span id="closeModalBtn" class="close-btn">&times;</span>
            <h2>Información del Reporte</h2>
            <input type="hidden" name="idReporte" id="idReporte">

            <!-- Nueva sección para la información del reporte -->
            <div class="container-report-info">
                <div class="form-group">
                    <label>Fotos:</label>
                    <div class="content-img" id="content-img"></div>
                </div>

                <div class="form-group">
                    <label>Descripción:</label>
                    <p id="decripcionView"></p>
                </div>

                <div class="profile-container">
                    <img src="http://via.placeholder.com/50" alt="Foto de perfil" class="profile-pic" id="profilePic">
                    <div class="profile-info">
                        <p class="profile-name" id="nombreView">Nombre del Usuario</p>
                        <p class="profile-date" id="fechaView">Fecha de creación:</p>
                        <p class="profile-date" id="correoView"></p>
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
            </div>

            <!-- Sección para avances (ya existente) -->
            <div class="form-group" id="avancesSection" style="display: none">
                <label>Avances:</label>
                <div id="avancesContent" class="cards-container"></div>
            </div>

            <br>
            <div class="container-asignar">
                <div class="custom-row">
                    <div class="custom-group">
                        <label for="asignacion">Asignación</label>
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
                    <button type="submit" class="asignar" id="asignar" disabled>Asignar Reporte</button>
                    <button type="button" onclick="finalizarReporte()" class="finalizar" id="finalizar" disabled>Finalizar Reporte</button>
                </div>
            </div>
        </div>
    </div>
</form>
