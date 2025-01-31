<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="{{ asset('css/PageNavBar.css') }}">
    <link rel="stylesheet" href="{{ asset('css/buttons.css') }}">
</head>
<body>
    <div class="navbar-content">
        <img class="menu-icon" src="{{ asset('images/Icons/menu.png') }}" alt="Menu Icon" id="menu-toggle"/>
        <img class="logo" src="{{ asset('images/Icons/logo.png') }}" alt="Logo"/>
        <h2 class="title">SOJAL</h2>
        <img class="notification" src="{{ asset('images/Icons/notification.svg') }}" alt="Perfil" id="notification"/>
    </div>

    <div class="profile-content">
        <img class="photo-profile" src="" alt="Perfil"/>
        <div class="content-info">
            <strong></strong>
            <p></p>
            <hr>
        </div>

        <a href="" class="enlace-button">
            <button class="settings">Configuración</button>
        </a>
        <button class="button-red" onclick="window.location.href=''">Cerrar sesión</button>
    </div>

    <div class="home-container">
        @include('layouts.admin-sidebar')
        @yield('content')
    </div>
</body>
</html>
