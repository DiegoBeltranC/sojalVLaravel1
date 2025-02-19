const modal = document.getElementById('modal');

window.addEventListener('click', (e) => {
    if (e.target === modal) {
        modal.style.display = 'none';
    }
});

function nuevaRuta() {
    modal.style.display = 'flex';
}

document.addEventListener('DOMContentLoaded', () => {
    // Inicializamos el mapa en el contenedor con id 'map'
    const map = L.map('map').setView([18.5267782, -88.3094386], 13);

    // Agregamos la capa de OpenStreetMap
    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        maxZoom: 19,
    }).addTo(map);

    // Aquí puedes agregar más lógica, por ejemplo, cargar rutas existentes, etc.
});


