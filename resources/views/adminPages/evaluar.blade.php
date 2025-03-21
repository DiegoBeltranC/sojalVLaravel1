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
@endsection

@section('scripts')
    <script src="https://api.mapbox.com/mapbox-gl-js/v2.8.1/mapbox-gl.js" defer></script>

    <script>
        document.addEventListener('DOMContentLoaded', () => {
            mapboxgl.accessToken = 'pk.eyJ1IjoiYWxpc3RhcmRldiIsImEiOiJjbTFyOHlseXowOHRzMnhxMm9tdnBwcTR5In0.D5D_X4S6CB4FdAyeTIL0GQ';
            const map = new mapboxgl.Map({
                container: 'map', // ID del contenedor
                style: 'mapbox://styles/mapbox/streets-v11', // Estilo del mapa
                center: [-88.3094386, 18.5267782], // Coordenadas iniciales (longitud, latitud)
                zoom: 13 // Nivel de zoom
            });
        })

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

        async function cargarReportes() {
            try {
                const response = await fetch('/admin/reportes/getPoints');
                const reportes = await response.json();

                reportes.forEach(reporte => {
                    try {
                        // Convierte la cadena de texto JSON en un objeto (si es necesario)
                        let ubicacion = reporte.location;
                        ubicacion = JSON.parse(ubicacion); // Decodifica si viene como string JSON
                        // Extrae las coordenadas en formato [latitud, longitud]
                        const coordenadas = [parseFloat(ubicacion.longitud),parseFloat(ubicacion.latitud)];
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

                        const id = location.id; // ID del reporte
                        const creado = location.fechaCreacion; // Ejemplo: "2024-11-21 19:28:32"
                        const fecha = creado.split(' ')[0]; // Obtiene "2024-11-21"
                        const customElement = document.createElement('div');
                    }
                })
            }
        }
    </script>
@endsection


