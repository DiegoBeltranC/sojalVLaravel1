<link rel="stylesheet" href="{{ asset('css/ViewNotifiacion.css') }}" />


@extends('layouts.admin-navbar')

@section('content')
  @if(session('success'))
    <script>
      Swal.fire({
        title: '¡Éxito!',
        text: "{{ session('success') }}",
        icon: 'success',
        confirmButtonText: 'Aceptar'
      });
    </script>
  @endif

  <!-- Contenedor principal de la sección de noticias -->
  <div class="content">
    <!-- Botón para abrir el formulario de nueva noticia -->
    <div class="content-button">
      <h2>NOTICIAS</h2>
      <button class="add" onclick="toggleForm()">
        <span class="button-text">Agregar</span>
        <img src="{{ asset('images/Icons/boton-mas.svg') }}" alt="Icono" class="button-icon">
      </button>
    </div>

    <!-- Contenedor de las cards de noticias -->
    <div class="container-cards">
      @foreach($noticias as $noticia)
        <div class="card">
          <img src="{{ $noticia->url_imagen ? asset('storage/' . $noticia->url_imagen) : asset('images/default.jpg') }}"
               alt="Imagen de la noticia"
               class="news-image">
          <div class="card-content">
            <h2>{{ $noticia->titulo }}</h2>
            <p class="mini-description" style="text-align: justify">{{ $noticia->descripcion }}</p>
            <div class="dates">
              <p class="start-date">
                {{ \Carbon\Carbon::parse($noticia->fecha_inicio)->format('d/m/Y') }}
              </p>
              <p class="end-date">
                {{ \Carbon\Carbon::parse($noticia->fecha_fin)->format('d/m/Y') }}
              </p>
            </div>
            <div class="creator-info">
              <img src="{{ $noticia->usuario && $noticia->usuario->profile_picture ? asset('storage/' . $noticia->usuario->profile_picture) : asset('images/default_profile.png') }}"
                  alt="Imagen de perfil"
                  class="profile-image">
              <p>{{ $noticia->usuario->nombre ?? 'Sin usuario' }}</p>
            </div>
            <div class="news-footer">
              <span class="likes">{{ $noticia->likes }} Likes</span>
              <div class="btn-container">
                <button class="btn btn-edit"
                        data-id="{{ $noticia->id }}"
                        data-titulo="{{ $noticia->titulo }}"
                        data-descripcion="{{ $noticia->descripcion }}"
                        data-url_imagen="{{ $noticia->url_imagen }}"
                        data-fecha_inicio="{{ \Carbon\Carbon::parse($noticia->fecha_inicio)->format('Y-m-d') }}"
                        data-hora_inicio="{{ \Carbon\Carbon::parse($noticia->fecha_inicio)->format('H:i') }}"
                        data-fecha_fin="{{ \Carbon\Carbon::parse($noticia->fecha_fin)->format('Y-m-d') }}"
                        data-hora_fin="{{ \Carbon\Carbon::parse($noticia->fecha_fin)->format('H:i') }}"
                        onclick="obtenerDatos(this)">
                  Editar
                </button>

                <button class="btn btn-details"
                        data-titulo="{{ $noticia->titulo }}"
                        data-descripcion="{{ $noticia->descripcion }}"
                        data-url_imagen="{{ $noticia->url_imagen }}"
                        data-fecha_inicio="{{ \Carbon\Carbon::parse($noticia->fecha_inicio)->format('Y-m-d') }}"
                        data-hora_inicio="{{ \Carbon\Carbon::parse($noticia->fecha_inicio)->format('H:i') }}"
                        data-fecha_fin="{{ \Carbon\Carbon::parse($noticia->fecha_fin)->format('Y-m-d') }}"
                        data-hora_fin="{{ \Carbon\Carbon::parse($noticia->fecha_fin)->format('H:i') }}"
                        onclick="verDatos(this)">
                  Ver Más
                </button>
                <form class="form-delete" action="{{ route('admin.noticias.destroy', $noticia->id) }}" method="POST" style="display: inline;">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-delete">Eliminar</button>
                </form>
              </div>
            </div>
          </div>
        </div>
      @endforeach
    </div>
  </div>

  <!-- Incluir los partials -->
  @include('forms.noticias.new')
  @include('forms.noticias.edit')
  @include('forms.noticias.view')
@endsection

@section('scripts')
  <script>
    // Función para abrir el modal de edición ya definida en el partial de edición (obtenerDatos la llamará)
    // Función para mostrar el modal de visualización (se asume toggleFormView() ya está definida en su partial)
    function verDatos(btn) {
      const titulo      = btn.getAttribute('data-titulo');
      const descripcion = btn.getAttribute('data-descripcion');
      const urlImagen   = btn.getAttribute('data-url_imagen');
      const fechaInicio = btn.getAttribute('data-fecha_inicio');
      const horaInicio  = btn.getAttribute('data-hora_inicio');
      const fechaFin    = btn.getAttribute('data-fecha_fin');
      const horaFin     = btn.getAttribute('data-hora_fin');

      document.getElementById('titulo_view').value = titulo;
      document.getElementById('descripcion_view').value = descripcion;
      document.getElementById('fecha_inicio_view').value = fechaInicio;
      document.getElementById('hora_inicio_view').value = horaInicio;
      document.getElementById('fecha_fin_view').value = fechaFin;
      document.getElementById('hora_fin_view').value = horaFin;

      const rutaImagen = urlImagen ? `/storage/${urlImagen}` : "{{ asset('images/default.jpg') }}";
      document.getElementById('imagen_view').src = rutaImagen;

      toggleFormView();
    }

    document.querySelectorAll('.form-delete').forEach(form => {
      form.addEventListener('submit', function(e) {
        e.preventDefault(); // Prevenir el envío inmediato
        Swal.fire({
          title: '¿Estás seguro?',
          text: "Esta acción no se puede deshacer",
          icon: 'warning',
          showCancelButton: true,
          confirmButtonColor: '#3085d6',
          cancelButtonColor: '#d33',
          confirmButtonText: 'Eliminar',
          cancelButtonText: 'Cancelar'
        }).then((result) => {
            $('#loading').show()
          if (result.isConfirmed) {
            // Si el usuario confirma, envía el formulario
            form.submit();
            setTimeout(() => {
                $('#loading').hide()
            }, 2000);
          }
        });
      });
    });

  </script>
@endsection
