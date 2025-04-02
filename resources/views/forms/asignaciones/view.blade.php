<link rel="stylesheet" href="{{ asset('css/forms/newForm.css') }}">

<style>

    #map1View { height: 16rem;width: 100%;}


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
<div id="modalView" class="modal">
    <div class="modal-content">
        <span id="closeModalBtnView" class="close-btn">&times;</span>
        <h2>Asignación</h2>
        <form id="CamionForm">
            @csrf
            <div class="profile-container">
                <img src="" alt="Foto de perfil" class="profile-pic" id="profilePicView">
                <div class="profile-info">
                    <p class="profile-name" id="nombreView">Nombre del trabajador</p>
                    <p class="profile-date" id="telefonoView">Teléfono:</p>
                </div>
            </div>

            <div class="profile-container">
                <div class="profile-info">
                    <p class="profile-name" id="camionView">Camion: </p>
                </div>
            </div>

            <div class="profile-container">
                <div class="profile-info">
                    <p class="profile-name" id="rutaView">Ruta: </p>
                </div>
                <div id="map1View" ></div>
            </div>


        </form>
    </div>
</div>
