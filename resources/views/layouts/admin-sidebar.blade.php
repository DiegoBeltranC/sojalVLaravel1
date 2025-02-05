<link rel="stylesheet" href="{{ asset('css/ViewSidebar.css') }}" />
<div class="sidebar">
    <ol>
        <a href="{{ route('admin.estadisticas') }}">
            <li class="option {{ request()->routeIs('admin.estadisticas') ? 'active' : '' }}">
              <img class="mi-svg" src="{{ asset('images/Icons/grafico-circular.svg') }}" alt="icon"/>
              <p>Estadísticas</p>
            </li>
          </a>
      <a href="#">
        <li class="option">
          <img class="mi-svg" src="{{ asset('images/Icons/lista.svg') }}" alt="Mi SVG feliz"/>
          <p>Evaluar informes</p>
        </li>
      </a>
      <a href="#">
        <li class="option">
          <img class="mi-svg" src="{{ asset('images/Icons/mensajes.svg') }}" alt="Mi SVG feliz"/>
          <p>Notificaciones</p>
        </li>
      </a>
      <a href="#">
        <li class="option">
          <img class="mi-svg" src="{{ asset('images/Icons/RutaIcon.svg') }}" alt="Mi SVG feliz"/>
          <p>Trayectos</p>
        </li>
      </a>
      <a href="{{ route('admin.usuarios') }}">
        <li class="option">
          <img class="mi-svg" src="{{ asset('images/Icons/usuarios.svg') }}" alt="Mi SVG feliz"/>
          <p>Usuarios</p>
        </li>
      </a>
      <a href="#">
        <li class="option">
          <img class="mi-svg" src="{{ asset('images/Icons/conjunto-de-habilidades.svg') }}" alt="Mi SVG feliz"/>
          <p>Asignación</p>
        </li>
      </a>
      <a href="{{ route('admin.trabajadores.index') }}">
        <li class="option {{ request()->routeIs('admin.trabajadores.index') ? 'active' : '' }}">
          <img class="mi-svg" src="{{ asset('images/Icons/trabajador.svg') }}" alt="icon"/>
          <p>Trabajadores</p>
        </li>
      </a>
      <a href="#">
        <li class="option">
          <img class="mi-svg" src="{{ asset('images/Icons/camion-de-la-basura.svg') }}" alt="Mi SVG feliz"/>
          <p>Camiones</p>
        </li>
      </a>
      <a href="#">
        <li class="option">
          <img class="mi-svg" src="{{ asset('images/Icons/ajustes.svg') }}" alt="Mi SVG feliz"/>
          <p>Administradores</p>
        </li>
      </a>
    </ol>
</div>
<script src=" {{ asset('js/ViewSideBar.js') }}"></script>
<style>
    .option.active {
      background-color: #26776d;
      color: white;
    }
</style>p


