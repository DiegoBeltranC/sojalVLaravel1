<!DOCTYPE html>
<html lang="es-MX">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>SOJAL</title>
    <link rel="icon" href="{{ asset('images/logo.ico') }}" />
    <link rel="stylesheet" href="{{ asset('css/navbar.css') }}" />
    <link rel="stylesheet" href="{{ asset('css/ViewHome.css') }}" />
    <link rel="stylesheet" href="{{ asset('css/ViewLogin.css') }}" />
    <script src="https://cdn.jsdelivr.net/npm/alpinejs@2.8.2/dist/alpine.min.js" defer></script>
  </head>
  <body>

    <livewire:login-form />

    <nav>
      <div class="left">
        <img src="{{ asset('images/Icons/logo.png') }}" alt="sojal.ico" />
        <h2>SOJAL</h2>
        <a href="#inicio">Inicio</a>
        <a href="#quienesSomos">¿Quiénes somos?</a>
        <a href="#descargarApp">Descargar App</a>
      </div>
      <div class="right">
        <input id="btnFormulario" type="button" value="Iniciar Sesión">
      </div>
    </nav>

    @yield('content')

    <script>
        // JavaScript para manejar el evento de clic en el botón abrir el modal
        document.getElementById('btnFormulario').addEventListener('click', function() {
            let div = document.querySelector('.body');
            document.querySelector('.body').style.display = 'block';
            div.classList.add('animated');
        });

        document.getElementById('btnCancelar').addEventListener('click', function () {
            var div = document.querySelector('.body');
            div.style.display = 'none';
        });
    </script>

    @livewireScripts
  </body>
</html>

