@extends('layouts.admin-navbar')
<link rel="stylesheet" href="https://unpkg.com/leaflet/dist/leaflet.css" />
<link href="https://api.mapbox.com/mapbox-gl-js/v2.8.1/mapbox-gl.css" rel="stylesheet" />
<link rel="stylesheet" href="{{ asset('css/modalRuta.css') }}">
<style>
    #map { height: 40rem; width: 100%; z-index: 1; }
</style>
@section('content')
<div class="content">
    <h2>Trayectos</h2>
    <button class="add" onclick="nuevaRuta()">Nueva Ruta</button>
    <div id="map"></div>
</div>
@endsection
@include('forms.rutas.newRuta')
<script src="https://unpkg.com/leaflet/dist/leaflet.js" defer></script>
<script src="https://api.mapbox.com/mapbox-gl-js/v2.8.1/mapbox-gl.js" defer></script>
<script src="{{ asset('js/rutas.js') }}"></script>

