@extends('layouts.admin-navbar')
<link rel="stylesheet" href="https://unpkg.com/leaflet/dist/leaflet.css" />
<link href="https://api.mapbox.com/mapbox-gl-js/v2.8.1/mapbox-gl.css" rel="stylesheet" />


@section('content')
<style>
    #map {
        width: 100%;
        height: 500px; /* Ajusta la altura según lo necesites */
    }
</style>
<div class="content">
    <h2>EVALUAR INFORMES</h2>
    <div id="map"></div>
</div>
@include('forms.evaluar.evaluarView')
@endsection
@section('scripts')
    <script src="https://unpkg.com/leaflet/dist/leaflet.js" defer></script>
    <script src="https://api.mapbox.com/mapbox-gl-js/v2.8.1/mapbox-gl.js" defer></script>

    <script>
        mapboxgl.accessToken = 'pk.eyJ1IjoiYWxpc3RhcmRldiIsImEiOiJjbTFyOHlseXowOHRzMnhxMm9tdnBwcTR5In0.D5D_X4S6CB4FdAyeTIL0GQ';

        const modal = document.getElementById('modal');

        const map = new mapboxgl.Map({
            container: 'map', // ID del contenedor
            style: 'mapbox://styles/mapbox/streets-v11', // Estilo del mapa
            center: [-88.3094386, 18.5267782], // Coordenadas iniciales (longitud, latitud)
            zoom: 13 // Nivel de zoom
        });

        // Función para agregar el marcador al mapa
        function addMarker(lngLat, popupContent, options = {}) {
            const { customElement = null } = options;

            let marker;
            if (customElement) {
                marker = new mapboxgl.Marker({ element: customElement });
            } else {
                marker = new mapboxgl.Marker();
            }

            marker
                .setLngLat(lngLat)
                .setPopup(new mapboxgl.Popup().setHTML(popupContent)) // Usamos setHTML para interpretar el contenido como HTML
                .addTo(map);
        }
        fetch('http://localhost/API_SOJAL/consult_reportes.php') // Reemplaza con tu endpoint
            .then(response => response.json())
            .then(data => {
                data.forEach(location => {
                    let color;

                    if (location.estado === 2) {
                        color = '#3b3b3b'; // Color gris
                    } else if (location.estado === 1) {
                        color = '#008000'; // Color verde
                    }
                    else if (location.estado === 3) {
                        color = '#f59622'; // Color verde
                    }
                    else {
                        color = '#FF0000'; // Color rojo
                    }

                    const lngLat = [parseFloat(location.longitud), parseFloat(location.latitud)];
                    const id = location.id; // ID del reporte
                    const creado = location.fechaCreacion; // Ejemplo: "2024-11-21 19:28:32"
                    const fecha = creado.split(' ')[0]; // Obtiene "2024-11-21"
                    const customElement = document.createElement('div');

                    customElement.style.width = '20px';
                    customElement.style.height = '20px';
                    customElement.style.backgroundColor = color;
                    customElement.style.borderRadius = '50%'; // Hacerlo circular
                    customElement.style.border = '2px solid white';

                    // Realizar la segunda solicitud AJAX
                    $.ajax({
                        url: 'http://localhost/API_SOJAL/CRUD/users_crud.php',
                        type: 'POST',
                        data: { id: location.idUsuario, opcion: 2 },
                        dataType: 'json', // Especifica el tipo de datos esperado del servidor
                        success: function (result) {
                            // Asegúrate de que "result" tiene datos antes de intentar acceder
                            if (result.data && result.data.length > 0) {
                                const img = result.data[0].fotoPerfil;
                                const nombre = result.data[0].nombre + ' '+ result.data[0].apellidoP + ' ' + result.data[0].apellidoM;

                                const popupContent = `
                                <div style="display: flex; flex-direction: column; gap: 10px; font-family: Arial, sans-serif; font-size: 14px; color: #333;">
                                <!-- Contenedor superior -->
                                <div style="display: flex; align-items: center; gap: 10px;">
                                    <img src="../package/image/photos/${img}" alt="Foto de perfil"
                                    style="width: 50px; height: 50px; border-radius: 50%; border: 1px solid #ccc;" />
                                <div style="display: flex; flex-direction: column;">
                                    <span style="font-weight: bold;">${nombre}</span>
                                    <span style="font-size: 12px; color: #777;">${fecha}</span>
                                </div>
                                </div>
                                <!-- Descripción -->
                                    <p id="idReporte" hidden>${location.id}</p>
                                <div>
                                    <strong>Descripción:</strong>
                                    <p style="margin: 5px 0;">${location.descripcion}</p>
                                </div>
                                <!-- Botón -->
                                <button class="ver-mas" style="
                                background-color: #007bff;
                                color: white;
                                border: none;
                                padding: 8px 12px;
                                border-radius: 5px;
                                cursor: pointer;
                                font-size: 14px;
                                ">
                                Ver más
                                </button>
                            </div>
                            `;

                                // Agregar marcador al mapa con la información actualizada
                                addMarker(lngLat, popupContent, { customElement });
                            } else {
                                console.error('No se encontró información del usuario en la respuesta.');
                            }
                        },
                        error: function (xhr, status, error) {
                            console.error('Error en la solicitud:', error);
                        }
                    });
                });
            })
            .catch(error => console.error('Error al cargar las ubicaciones:', error));

        // Mostrar el modal al hacer clic en "Ver más"
        document.addEventListener('click', function(event) {
            if (event.target && event.target.classList.contains('ver-mas')) {


                const descripcionView = document.getElementById('descripcionView');


                const id =document.getElementById('idReporte').textContent;

                document.getElementById('modalView').style.display = 'flex';

                descripcionView.textContent = id;
            }
        });

    </script>
@endsection
