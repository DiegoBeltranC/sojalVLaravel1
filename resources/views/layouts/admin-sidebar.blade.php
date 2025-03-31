<link rel="stylesheet" href="{{ asset('css/ViewSidebar.css') }}" />
<div class="sidebar">
    <ol>
        <a href="{{ route('admin.estadisticas.index') }}">
            <li class="option {{ request()->routeIs('admin.estadisticas.index') ? 'active' : '' }}">
              <img class="mi-svg" src="{{ asset('images/Icons/grafico-circular.svg') }}" alt="icon"/>
              <p>Estadísticas</p>
            </li>
          </a>
      <a href="{{ route('admin.evaluar.index') }}">
        <li class="option {{ request()->routeIs('admin.evaluar.index') ? 'active' : '' }}">
          <img class="mi-svg" src="{{ asset('images/Icons/lista.svg') }}" alt="Mi SVG feliz"/>
          <p>Evaluar informes</p>
        </li>
      </a>
      <a href="{{ route('admin.noticias.index') }}">
          <li class="option {{ request()->routeIs('admin.noticias.index') ? 'active' : '' }}">
          <img class="mi-svg" src="{{ asset('images/Icons/mensajes.svg') }}" alt="Mi SVG feliz"/>
          <p>Noticias</p>
        </li>
      </a>
      <a href="{{ route('admin.rutas.index') }}">
        <li class="option {{ request()->routeIs('admin.rutas.index') ? 'active' : '' }}">
          <img class="mi-svg" src="{{ asset('images/Icons/RutaIcon.svg') }}" alt="Mi SVG feliz"/>
          <p>Rutas</p>
        </li>
      </a>
      <a href="{{ route('admin.ciudadanos.index') }}">
        <li class="option {{ request()->routeIs('admin.ciudadanos.index') ? 'active' : '' }}">
          <img class="mi-svg" src="{{ asset('images/Icons/usuarios.svg') }}" alt="Mi SVG feliz"/>
          <p>Ciudadanos</p>
        </li>
      </a>
      <a href="{{ route('admin.asignacion.index') }}">
        <li class="option {{ request()->routeIs('admin.asignacion.index') ? 'active' : '' }}">
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
      <a href="{{ route('admin.trucks.index') }}">
          <li class="option {{ request()->routeIs('admin.trucks.index') ? 'active' : '' }}">
            <img class="mi-svg" src="{{ asset('images/Icons/camion-de-la-basura.svg') }}" alt="Camión"/>
            <p>Camiones</p>
          </li>
      </a>
      <a href="{{ route('admin.administradores.index') }}">
        <li class="option {{ request()->routeIs('admin.administradores.index') ? 'active' : '' }}">
          <img class="mi-svg" src="{{ asset('images/Icons/ajustes.svg') }}" alt="icon"/>
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
</style>


