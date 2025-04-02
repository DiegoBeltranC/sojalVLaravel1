const modal = document.getElementById('modal');
let map;
let mapAdd;
let rutaPuntos = [];       // Array global para almacenar los puntos de la nueva ruta
let polylineRuta = null;
let markersRuta = []
let colorRuta;


window.addEventListener('click', (e) => {
    if (e.target === modal) {
        modal.style.display = 'none';
    }
});

function nuevaRuta() {
    modal.style.display = 'flex';
    cargarMapaAdd();
    cargarRutasAdd();
    cargarReportesAdd()
}

document.addEventListener('DOMContentLoaded', async () => {
    $('#loading').show();
    cargarMapa();
    cargarRutas();
    cargarReportes()

});

async function cargarMapa (){
    map = L.map('map').setView([18.5267782, -88.3094386], 13);

    // Agregamos la capa de OpenStreetMap
    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        maxZoom: 19,
    }).addTo(map);

}

async function cargarMapaAdd() {
    // Inicializa el mapa del modal solo si no se ha inicializado aún
    mapAdd = L.map('mapAdd').setView([18.5267782, -88.3094386], 13);
    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        maxZoom: 19,
    }).addTo(mapAdd);

    // Agrega el evento click al mapa para capturar puntos
    mapAdd.on('click', function (e) {
        // Obtiene las coordenadas del click
        const latlng = [e.latlng.lat, e.latlng.lng];
        // Agrega el punto al array
        rutaPuntos.push(latlng);

        // Agrega un marcador en la posición del click
        const marker = L.marker(latlng).addTo(mapAdd);
        markersRuta.push(marker);

        // Si ya existe una polyline en el mapa, la elimina
        if (polylineRuta) {
            mapAdd.removeLayer(polylineRuta);
        }
        // Se usa el color seleccionado en el input con id "color"
        colorRuta = document.getElementById('color').value;
        // Dibuja la nueva polyline con los puntos actualizados
        polylineRuta = L.polyline(rutaPuntos, { color: colorRuta }).addTo(mapAdd);
    });

}

// Lógica para eliminar el último punto y su marcador
document.getElementById('deletePoint').addEventListener('click', function () {
    if (rutaPuntos.length > 0) {
        // Elimina el último punto del array
        rutaPuntos.pop();

        // Remueve el último marcador agregado
        const lastMarker = markersRuta.pop();
        if (lastMarker) {
            mapAdd.removeLayer(lastMarker);
        }

        // Remueve la polyline existente
        if (polylineRuta) {
            mapAdd.removeLayer(polylineRuta);
        }
        // Si aún hay puntos, vuelve a dibujar la polyline
        if (rutaPuntos.length > 0) {
            colorRuta = document.getElementById('color').value;
            polylineRuta = L.polyline(rutaPuntos, { color: colorRuta }).addTo(mapAdd);
        }
    }
});

function limpiarRutasModal() {
    mapAdd.eachLayer(layer => {
        // Evita eliminar la capa base (TileLayer)
        if (!(layer instanceof L.TileLayer) &&
            (layer instanceof L.Polyline || layer instanceof L.Marker)) {
            mapAdd.removeLayer(layer);
        }
    });
}

async function cargarReportes() {
    try {
        const response = await fetch('/admin/reportes/getPoints');
        const reportes = await response.json();

        // Filtrar solo reportes con status "sinAsignar"
        const reportesFiltrados = reportes.filter(reporte => reporte.status === "sinAsignar");

        reportesFiltrados.forEach(reporte => {
            try {
                // Asegurar que location es un objeto y no una cadena JSON
                let ubicacion = reporte.location;
                ubicacion = JSON.parse(ubicacion); // Decodifica si viene como string JSON

                // Extrae las coordenadas en formato [latitud, longitud]
                const coordenadas = [parseFloat(ubicacion.longitud), parseFloat(ubicacion.latitud)];

                // Crea un marcador con el icono predeterminado de Leaflet
                const circleMarker = L.circleMarker(coordenadas, {
                    color: 'red',
                    radius: 10
                }).addTo(map);

                // Agrega un popup con información del reporte
                circleMarker.bindPopup(`
                    <b>Reporte #${reporte.id}</b><br>
                    ${reporte.descripcion}<br>
                    Estado: ${reporte.status}
                `);

                $('#loading').hide();
            } catch (error) {
                console.error(`Error procesando el reporte ${reporte._id}:`, error);
                $('#loading').hide();
            }
        });

    } catch (error) {
        console.error("Error cargando reportes:", error);
        $('#loading').hide();
    }
}




async function cargarReportesAdd() {
    try {
        const response = await fetch('/admin/reportes/getPoints');
        const reportes = await response.json();
        const reportesFiltrados = reportes.filter(reporte => reporte.status === "sinAsignar");
        reportesFiltrados.forEach(reporte => {
            // Parsea la ubicación (si está como string)
            let ubicacion = reporte.location; // Ej: [18.53474, -88.29878]
            ubicacion = JSON.parse(ubicacion);
            // Crea un círculo en lugar de un marcador
            const coordenadas = [parseFloat(ubicacion.longitud),parseFloat(ubicacion.latitud)];

            // Crea un marcador con el icono predeterminado de Leaflet
            const circleMarker = L.circleMarker(coordenadas, {
                color: 'red',
                radius: 10
              }).addTo(mapAdd);


            // Agrega un popup con información del reporte
            circleMarker.bindPopup(`
                <b>Reporte #${reporte.id}</b><br>
                ${reporte.descripcion}<br>
                Estado: ${reporte.status}
            `);
        });
        $('#loading').hide();
    } catch (error) {
        console.error("Error cargando reportes:", error);
        $('#loading').hide();
    }
}
async function cargarRutasAdd() {
    try {
        $('#loading').show();
        limpiarRutasModal()
        const response = await fetch('/admin/rutas/api'); // Llamamos a la API de Laravel
        const rutas = await response.json();


        rutas.forEach(ruta => {
            const puntos = ruta.puntos // Convertimos los puntos en un formato usable por Leaflet

            // Dibujamos la línea de la ruta en el mapa
            L.polyline(puntos, { color: ruta.color }).addTo(mapAdd);

            // Marcamos el punto inicial y final
            if (puntos.length > 0) {
                L.marker(puntos[0]).addTo(mapAdd).bindPopup(`Inicio: ${ruta.nombre}`);
                L.marker(puntos[puntos.length - 1]).addTo(mapAdd).bindPopup(`Fin: ${ruta.nombre}`);
            }
        });

    } catch (error) {
        console.error("Error cargando las rutas:", error);

    }
}

async function cargarRutas() {
    try {
        //Recarga las rutas en dado caso que se elimine una ruta
        map.eachLayer(layer => {
            if (layer instanceof L.Polyline || layer instanceof L.Marker) {
                map.removeLayer(layer);
            }
        });
        const response = await fetch('/admin/rutas/api'); // Llamamos a la API de Laravel
        const rutas = await response.json();


        rutas.forEach(ruta => {
            const puntos = ruta.puntos // Convertimos los puntos en un formato usable por Leaflet

            // Dibujamos la línea de la ruta en el mapa
            L.polyline(puntos, { color: ruta.color }).addTo(map);

            // Marcamos el punto inicial y final
            if (puntos.length > 0) {
                const popupInicio = `
                    <div>
                        <strong>Inicio: ${ruta.nombre}</strong><br>
                        <button class="btn btn-link p-0" onclick="confirmarEliminacion('${ruta.id}')">
                            <i class="fa fa-trash text-danger"></i>
                        </button>
                    </div>
                `;
                // Contenido del popup para el marcador de fin
                const popupFin = `
                    <div>
                        <strong>Fin: ${ruta.nombre}</strong><br>
                        <button class="btn btn-link p-0" onclick="confirmarEliminacion('${ruta.id}')">
                            <i class="fa fa-trash text-danger"></i>
                        </button>
                    </div>
                `;
                // Agregar marcadores y asignar los popups
                L.marker(puntos[0]).addTo(map).bindPopup(popupInicio);
                L.marker(puntos[puntos.length - 1]).addTo(map).bindPopup(popupFin);
            }
        });

    } catch (error) {
        console.error("Error cargando las rutas:", error);
    }
}

document.getElementById('rutaForm').addEventListener('submit', function (e) {
    $('#loading').show();
    e.preventDefault(); // Evita el envío tradicional del formulario

    let nombre = document.getElementById('nombre').value;
    let color = document.getElementById('color').value;

    if (rutaPuntos.length < 2) {
        Swal.fire({
            icon: 'warning',
            title: 'Atención',
            text: 'Debes agregar al menos 2 puntos en el mapa.',
        });
    }

    fetch('/admin/rutas', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
        },
        body: JSON.stringify({
            nombre: nombre,
            color: color,
            puntos: rutaPuntos // Este es el arreglo de puntos que definiste en otro archivo
        })
    })
    .then(response => response.json())
    .then(data => {
        $('#loading').hide();
        Swal.fire({
            title: '¡Éxito!',
            text: "Ruta Guardada Exitosamente",
            icon: 'success',
            confirmButtonText: 'Aceptar'
        });

        modal.style.display = 'none';
        document.getElementById('rutaForm').reset();
        rutaPuntos = [];       // Limpiar los puntos de la ruta
        polylineRuta = null;
        markersRuta = [];
        colorRuta = '';
        setTimeout(() => {
            cargarRutas(); // Asegúrate de que esta función recargue correctamente las rutas en el mapa
        }, 1000);

    })
    .catch(error => {
        $('#loading').hide();
        Swal.fire({
            icon: 'error',
            title: 'Eror',
            text: 'No se pudo guardar, intentalo de nuevo',
        });
    });
});

function confirmarEliminacion(rutaId) {
    Swal.fire({
        title: '¿Estás seguro?',
        text: "Esta acción eliminará la ruta permanentemente.",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#d33',
        cancelButtonColor: '#3085d6',
        confirmButtonText: 'Sí, eliminar',
        cancelButtonText: 'Cancelar'
    }).then((result) => {
        if (result.isConfirmed) {
            $('#loading').show();
            // Realiza la solicitud DELETE a la API para eliminar la ruta
            fetch(`/admin/rutas/${rutaId}`, {
                method: 'DELETE',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                }
            })
            .then(response => response.json()) // Asegúrate de que se maneje la respuesta JSON
            .then(data => {
                $('#loading').hide();
                if (data.success) {
                    Swal.fire('Eliminada', data.message, 'success');
                    // Opcional: refrescar el mapa para quitar la ruta eliminada
                    setTimeout(() => {
                        cargarRutas(); // Asegúrate de que esta función recargue correctamente las rutas en el mapa
                    }, 1000);
                } else {
                    Swal.fire('Error', data.message, 'error');
                }
            })
            .catch(error => {
                $('#loading').hide();
                console.error('Error:', error);
                Swal.fire('Error', 'Ocurrió un error al eliminar la ruta.', 'error');
            });
        }
    });
}



