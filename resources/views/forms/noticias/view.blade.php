<link rel="stylesheet" href="{{ asset('css/forms/viewForm.css') }}">
<div id="content-form-view" class="modalView" style="display: none;">
  <div id="modal-container-view" class="modal-content">
    <span id="close-modal-view" class="close-btn" onclick="toggleFormView()">&times;</span>
    <h1>Noticia</h1>
    
    <input type="hidden" id="id_view" name="id_view" disabled>

    <div class="form-group">
      <label for="titulo_view">Título:</label>
      <input type="text" id="titulo_view" name="titulo_view" disabled>
    </div>

    <div class="form-group">
      <label for="descripcion_view">Descripción:</label>
      <textarea id="descripcion_view" name="descripcion_view" disabled></textarea>
    </div>

    <div class="form-group">
      <label>Imagen:</label>
      <img id="imagen_view" src="{{ asset('images/default.jpg') }}" alt="Imagen de la noticia" style="max-width:100%; height:auto;">
    </div>

    <div class="form-group">
      <label for="fecha_inicio_view">Fecha de Inicio:</label>
      <input type="date" id="fecha_inicio_view" name="fecha_inicio_view" disabled>
    </div>

    <div class="form-group">
      <label for="hora_inicio_view">Hora de Inicio:</label>
      <input type="time" id="hora_inicio_view" name="hora_inicio_view" disabled>
    </div>

    <div class="form-group">
      <label for="fecha_fin_view">Fecha de Cierre:</label>
      <input type="date" id="fecha_fin_view" name="fecha_fin_view" disabled>
    </div>

    <div class="form-group">
      <label for="hora_fin_view">Hora de Cierre:</label>
      <input type="time" id="hora_fin_view" name="hora_fin_view" disabled>
    </div>
  </div>
</div>

<script>
  function toggleFormView() {
    var formulario = document.getElementById('content-form-view');
    var currentDisplay = window.getComputedStyle(formulario).display;
    formulario.style.display = (currentDisplay === "none" || currentDisplay === "") ? "flex" : "none";
  }
</script>

