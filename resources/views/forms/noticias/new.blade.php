<link rel="stylesheet" href="{{ asset('css/forms/newForm.css') }}">
<!-- Se agrega el estilo inline para asegurar que inicie oculto -->
<div id="content-form" class="modal" style="display: none;">
  <div id="modal-container" class="modal-content">
    <span id="close-modal" class="close-btn" onclick="toggleForm()">&times;</span>
    <form id="formulario" action="{{ route('admin.noticias.store') }}" method="POST" enctype="multipart/form-data">
      @csrf
      <h1>Nueva Noticia</h1>

      <div class="form-group">
        <label for="titulo">Título:</label>
        <input type="text" id="titulo" name="titulo" required>
      </div>

      <div class="form-group">
        <label for="id_user">ID Usuario:</label>
        <input type="text" id="id_user" name="id_user" value="{{ auth()->user()->id }}" readonly>
      </div>

      <div class="form-group">
        <label for="descripcion">Descripción:</label>
        <textarea id="descripcion" name="descripcion" required></textarea>
      </div>

      <div class="form-group">
        <label for="url_imagen">Imagen:</label>
        <input type="file" id="url_imagen" name="url_imagen" accept="image/*" required>
      </div>
      <!-- Elemento de vista previa para la imagen del formulario nuevo -->
      <div class="form-group">
        <img id="imagen_preview_new" src="{{ asset('images/default.jpg') }}" alt="Preview de la imagen" style="max-width:100%; height:auto;">
      </div>

      <div class="form-group">
        <label for="fecha_inicio">Fecha de Inicio:</label>
        <input type="date" id="fecha_inicio" name="fecha_inicio" required>
      </div>

      <div class="form-group">
        <label for="hora_inicio">Hora de Inicio:</label>
        <input type="time" id="hora_inicio" name="hora_inicio" required>
      </div>

      <div class="form-group">
        <label for="fecha_fin">Fecha de Cierre:</label>
        <input type="date" id="fecha_fin" name="fecha_fin" required>
      </div>

      <div class="form-group">
        <label for="hora_fin">Hora de Cierre:</label>
        <input type="time" id="hora_fin" name="hora_fin" required>
      </div>

      <button type="submit" class="register">Crear Noticia</button>
    </form>
  </div>
</div>

<script>
  // Previene envíos múltiples
  document.getElementById('formulario').addEventListener('submit', function(e) {
    this.querySelector('button[type="submit"]').disabled = true;
  });

  // Función de toggle para mostrar/ocultar el formulario nuevo
  function toggleForm() {
    var formulario = document.getElementById('content-form');
    var currentDisplay = window.getComputedStyle(formulario).display;
    formulario.style.display = (currentDisplay === "none") ? "flex" : "none";
  }

    // Actualiza el atributo "min" de la fecha de cierre en función de la fecha de inicio seleccionada
    document.getElementById('fecha_inicio').addEventListener('change', function() {
    document.getElementById('fecha_fin').min = this.value;
  });

  // De igual forma, para la hora, ya lo tenías implementado:
  document.getElementById('hora_inicio').addEventListener('change', function() {
    document.getElementById('hora_fin').min = this.value;
  });
  
  // Actualiza la vista previa para el formulario nuevo cuando se seleccione una imagen
  document.getElementById('url_imagen').addEventListener('change', function(event) {
    const [file] = this.files;
    if (file) {
      document.getElementById('imagen_preview_new').src = URL.createObjectURL(file);
    }
  });
</script>
