<link rel="stylesheet" href="{{ asset('css/forms/newForm.css') }}">
<style>
/* Estilo para el fondo oscuro del modal */
.modal {
    display: none; /* Inicialmente oculto */
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background-color: rgba(0,0,0,0.5);
    z-index: 1000; /* Asegura que esté por encima de todo */
}

/* Contenido del modal centrado */
.modal-contentRechazo {
    position: fixed;
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%);
    background-color: white;
    padding: 20px;
    border-radius: 8px;
    min-width: 400px;
    max-width: 90%;
    z-index: 1001; /* Mayor que el fondo */
    box-shadow: 0 4px 6px rgba(0,0,0,0.1);
}

/* Asegurar que el textarea ocupe el ancho completo */
.modal-content textarea {
    width: 100%;
    min-height: 100px;
}
</style>
<div id="formRechazo" class="modal" style="">
        <div class="modal-contentRechazo modal-content" \>
            <h2>Rechazar Reporte</h2>
            <form id="rechazoForm" method="POST" action="{{ route('admin.evaluar.enviarCorreoRechazo') }}" enctype="multipart/form-data">
                @csrf
                <input type="hidden" name="idFormRechazo" id="idFormRechazo" value="">
                <div class="form-group">
                    <label for="name">Motivo:</label>
                    <textarea id="motivo" name="motivo" required></textarea>
                </div>
                <button type="submit" class="register">Rechazar</button>
            </form>
        </div>
</div>
