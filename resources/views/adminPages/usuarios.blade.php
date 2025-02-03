@extends('layouts.admin-navbar')
<link rel="stylesheet" href="{{ asset('css/ViewEstadisticas.css') }}">

@section('content')
<div class="content">
    <h2>USUARIOS</h2>

    <!-- Tabla de usuarios -->
    <table id="userTable" style="width: 100%;">
        <thead>
            <tr>
                <th>ID</th>
                <th>Nombre</th>
                <th>Correo</th>
                <th>Teléfono</th>
                <th>Edad</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
        </tbody>
    </table>
</div>
@endsection
