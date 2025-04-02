<link rel="stylesheet" href="{{ asset('css/forms/newForm.css') }}">

<style>

    #map1 { height: 16rem;width: 100%;}


    .custom-row {
        display: flex;
        justify-content: space-between;
        gap: 15px;
        /* Espacio entre los select */
    }

    .custom-group {
        flex: 1;
        /* Hace que los select ocupen el mismo espacio */
        min-width: 180px;
        /* Puedes ajustar el tamaño mínimo */
    }

    .custom-group select {
        width: 100%;
        /* Asegura que los select llenen el espacio */
    }

    .modal-content {

        max-width: 650px;
        height: 70%;


    }

    .profile-container {
        display: flex;
        align-items: center;
        padding: 10px;
        border: 1px solid #ccc;
        border-radius: 8px;
        background-color: #f9f9f9;
        max-width: 100%;
    }

    .profile-pic {
        width: 50px;
        height: 50px;
        border-radius: 50%;
        object-fit: cover;
        margin-right: 15px;
        border: 2px solid #ccc;
    }

    .profile-info {
        display: flex;
        flex-direction: column;
    }

    .profile-name {
        font-size: 16px;
        font-weight: bold;
        margin: 0;
        color: #333;
    }

    .profile-date {
        font-size: 14px;
        color: #666;
        margin: 5px 0 0 0;
    }
</style>
</head>

<!-- Modal -->
<div id="modal" class="modal">
    <div class="modal-content">
        <span id="closeModalBtn" class="close-btn">&times;</span>
        <h2>Nueva Asignación</h2>
        <form id="CamionForm" method="POST" action="{{ route('admin.asignacion.store') }}">
            @csrf
            <div class="custom-row">
                <div class="custom-group">
                    <label for="ruta">Trabajador</label>
                    <select id="trabajador" class="custom-select" name="trabajador"></select>
                </div>
                <div class="custom-group">
                    <label for="camion">Camiones</label>
                    <select id="camion" class="custom-select" name="camion"></select>
                </div>

                <div class="custom-group">
                    <label for="ruta">Rutas</label>
                    <select id="ruta" class="custom-select" name="ruta"></select>
                </div>
            </div>

            <div class="profile-container">
                <img src="{{ asset('images/profile.png') }}" alt="Foto de perfil" class="profile-pic" id="profilePic">
                <div class="profile-info">
                    <p class="profile-name" id="nombreNew">Nombre del trabajador</p>
                    <p class="profile-date" id="telefonoNew">Teléfono:</p>
                </div>
            </div>

            <div id="map1" ></div>

            <button type="submit" class="register">Registrar</button>
        </form>
    </div>
</div>
