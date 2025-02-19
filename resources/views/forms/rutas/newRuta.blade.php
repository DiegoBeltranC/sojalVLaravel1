<div class="modal" id="modal">
    <div class="modal-content">
        <!-- Contenedor para los campos de nombre y color -->
         <h2>Agregar Ruta</h2>
        <div class="form-container">
            <label for="routeName">Nombre de la Ruta:</label>
            <input type="text" id="nombre" placeholder="Nombre de la ruta" />
   <br>
            <label for="routeColor">Color de la Ruta:</label>
            <input type="color" id="color" value="#ff0000" /> <!-- Valor inicial -->
        </div>

        <!-- Mapa donde se agregarán los puntos -->
        <div id="mapAdd" ></div>

        <!-- Botones para eliminar o guardar la ruta -->
        <div class="button-container">
            <!-- Botón para eliminar un punto -->
            <button class="btn btn-danger" id="deletePoint">Eliminar Punto</button>

            <!-- Botón para guardar la ruta -->
            <button class="btn btn-success" id="addRuta">Guardar Ruta</button>
        </div>
    </div>
</div>
