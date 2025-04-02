<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="{{ asset('css/PageNavBar.css') }}">
    <link rel="stylesheet" href="{{ asset('css/buttons.css') }}">
    <link rel="stylesheet" href="{{ asset('css/Page.css') }}">
    <link rel="stylesheet" href="{{ asset('css/PageTables.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://code.jquery.com/jquery-3.5.1.js"></script>
    <script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
</head>
<body>
    <div class="navbar-content">
        <img class="menu-icon" src="{{ asset('images/Icons/menu.png') }}" alt="Menu Icon" id="menu-toggle"/>
        <img class="logo" src="{{ asset('images/Icons/logo.png') }}" alt="Logo"/>
        <h2 class="title">SOJAL</h2>
        <div class="notification"  id="notification"></div>
        <!-- Se reemplaza la imagen estática por la foto de perfil del usuario -->
        <img class="photo" src="{{ Auth::user()->profile_picture ? asset('storage/' . Auth::user()->profile_picture) : asset('images/default_profile.png') }}" alt="Perfil" id="photo"/>
    </div>

    <div class="profile-content">
        <!-- Se actualiza la foto de perfil -->
        <img class="photo-profile" src="{{ Auth::user()->profile_picture ? asset('storage/' . Auth::user()->profile_picture) : asset('images/default_profile.png') }}" alt="Perfil"/>
        <div class="content-info">
            <strong>{{ Auth::user()->nombre }}</strong>
            <p>{{ Auth::user()->correo }}</p>
            <hr>
        </div>

        <a href="{{ route('admin.configuracion') }}" class="enlace-button">
            <button class="settings">Configuración</button>
        </a>

        <form action="{{ route('logout') }}" method="POST" class="enlace-button">
            @csrf  <!-- Token CSRF para seguridad -->
            <button type="submit" class="button-red">Cerrar sesión</button>
        </form>
    </div>

    <div class="home-container">
        @include('adminPages.carga')
        @include('layouts.admin-sidebar')
        @yield('content')
    </div>
    @yield('scripts')
</body>
</html>
