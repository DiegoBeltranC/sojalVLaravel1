<style>
    #loading {
        position: fixed; /* Asegura que ocupe toda la pantalla */
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background-color: rgba(0, 0, 0, 0.7); /* Fondo negro con transparencia */
        display: none; /* Inicialmente oculto */
        z-index: 9999; /* Asegura que se muestre por encima de otros elementos */
    }

    #loading .overlay {
        position: absolute;
        top: 50%; /* Centrado vertical */
        left: 50%; /* Centrado horizontal */
        transform: translate(-50%, -50%); /* Ajusta la posición para centrar completamente */
        background-color: transparent; /* Sin fondo en el overlay */
    }

    #loading img {
        display: block;
        margin: 0 auto;
        max-width: 250px; /* Ajusta el tamaño del GIF según sea necesario */
    }

</style>

<body>
    <div id="loading" style="display:none;">
        <div class="overlay">
            <img src="{{ asset('images/Icons/cargando.gif') }}" alt="Cargando..." />
        </div>
    </div>
</body>
