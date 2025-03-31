<link rel="stylesheet" href="{{ asset('css/forms/viewForm.css') }}">

<div id="modalView" class="modal">
    <div class="modal-content">
      <span id="closeModalBtnView" class="close-btn">&times;</span>
      <h2>Información del Camión</h2>
      <div id="workerInfo">
        <div class="form-group">
          <label>Placas:</label>
          <p id="placasView">N/A</p>
        </div>
        <div class="form-group">
          <label>Marca:</label>
          <p id="marcaView">N/A</p>
        </div>
        <div class="form-group">
          <label>Modelo:</label>
          <p id="modeloView">N/A</p>
        </div>
        <div class="form-group">
          <label>Año:</label>
          <p id="anoView">N/A</p>
        </div>
        <div class="form-group">
          <label>Estado:</label>
          <p id="estadoView">N/A</p>
        </div>
        <div class="form-group">
          <label>Imagen:</label>
          <img id="truckImageView" src="{{ asset('images/default.jpg') }}" alt="Imagen del camión" style="max-width: 150px;">
        </div>
      </div>
    </div>
</div>
