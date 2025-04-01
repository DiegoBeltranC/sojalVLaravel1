<link rel="stylesheet" href="{{ asset('css/forms/editForm.css') }}">

<!-- Modal de edición con display inicial oculto -->
<div id="content-form-update" class="modal" style="display: none;">
  <div id="modal-container-update" class="modal-content">
    <span id="close-modal-update" class="close-btn" onclick="closeEditModal()">&times;</span>
    <form id="formulario-update" action="" method="POST" enctype="multipart/form-data">
      @csrf
      @method('PUT')
      <h1>Actualizar</h1>
      <input type="hidden" id="id_update" name="id_update">
      
      <div class="form-group">
        <label for="titulo_update">Título:</label>
        <input type="text" id="titulo_update" name="titulo_update" required>
      </div>
      
      <div class="form-group">
        <label for="descripcion_update">Descripción:</label>
        <textarea id="descripcion_update" name="descripcion_update" required></textarea>
      </div>
      
      <!-- Campo para subir imagen y vista previa -->
      <div class="form-group">
        <label for="url_imagen_update">Imagen:</label>
        <input type="file" id="url_imagen_update" name="url_imagen_update" accept="image/*">
      </div>
      <div class="form-group">
        <img id="imagen_preview_update" src="{{ asset('images/default.jpg') }}" alt="Preview de la imagen" style="max-width:100%; height:auto;">
      </div>
      
      <div class="form-group">
        <label for="fecha_inicio_update">Fecha de Inicio:</label>
        <input type="date" id="fecha_inicio_update" name="fecha_inicio_update" required>
      </div>
      
      <div class="form-group">
        <label for="hora_inicio_update">Hora de Inicio:</label>
        <input type="time" id="hora_inicio_update" name="hora_inicio_update" required>
      </div>
      
      <div class="form-group">
        <label for="fecha_fin_update">Fecha de Cierre:</label>
        <input type="date" id="fecha_fin_update" name="fecha_fin_update" required>
      </div>
      
      <div class="form-group">
        <label for="hora_fin_update">Hora de Cierre:</label>
        <input type="time" id="hora_fin_update" name="hora_fin_update" required>
      </div>
      
      <button type="submit" class="register">Actualizar</button>
    </form>
  </div>
</div>

<script>
  // Función para abrir el modal de edición
  function openEditModal() {
    document.getElementById('content-form-update').style.display = "flex";
  }

  // Función para cerrar el modal de edición
  function closeEditModal() {
    document.getElementById('content-form-update').style.display = "none";
  }

    // Actualiza el atributo "min" de la fecha de cierre en función de la fecha de inicio seleccionada
    document.getElementById('fecha_inicio_update').addEventListener('change', function() {
    document.getElementById('fecha_fin_update').min = this.value;
  });

  // Para la hora:
  document.getElementById('hora_inicio_update').addEventListener('change', function() {
    document.getElementById('hora_fin_update').min = this.value;
  });
  
  // Actualiza la vista previa cuando se selecciona una nueva imagen en el input de edición.
  document.getElementById('url_imagen_update').addEventListener('change', function(event) {
    const [file] = this.files;
    if (file) {
      document.getElementById('imagen_preview_update').src = URL.createObjectURL(file);
    }
  });
  
  // Función para obtener datos de la noticia y rellenar el formulario de edición.
  function obtenerDatos(btn) {
    const id          = btn.getAttribute('data-id');
    const titulo      = btn.getAttribute('data-titulo');
    const descripcion = btn.getAttribute('data-descripcion');
    const urlImagen   = btn.getAttribute('data-url_imagen');
    const fechaInicio = btn.getAttribute('data-fecha_inicio');
    const horaInicio  = btn.getAttribute('data-hora_inicio');
    const fechaFin    = btn.getAttribute('data-fecha_fin');
    const horaFin     = btn.getAttribute('data-hora_fin');
    
    document.getElementById('titulo_update').value = titulo;
    document.getElementById('descripcion_update').value = descripcion;
    
    // Se establece la imagen de vista previa usando la URL almacenada.
    const rutaImagen = urlImagen ? `/storage/${urlImagen}` : "{{ asset('images/default.jpg') }}";
    document.getElementById('imagen_preview_update').src = rutaImagen;
    
    document.getElementById('fecha_inicio_update').value = fechaInicio;
    document.getElementById('hora_inicio_update').value = horaInicio;
    document.getElementById('fecha_fin_update').value = fechaFin;
    document.getElementById('hora_fin_update').value = horaFin;
    
    // Configura la acción del formulario de actualización
    document.getElementById('formulario-update').action = `/admin/noticias/${id}`;
    
    // Abre el modal de edición.
    openEditModal();
  }
</script>

