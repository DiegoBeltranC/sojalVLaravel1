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
    </script>
@endsection


