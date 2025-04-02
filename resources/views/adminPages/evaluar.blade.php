@extends('layouts.admin-navbar')
<link rel="stylesheet" href="https://unpkg.com/leaflet/dist/leaflet.css" />
<link href="https://api.mapbox.com/mapbox-gl-js/v2.8.1/mapbox-gl.css" rel="stylesheet" />

@section('content')
@if(session('reporteAsignado'))
    <script>
        Swal.fire({
            title: '¡Éxito!',
            text: "{{ session('reporteAsignado') }}",
            icon: 'success',
            confirmButtonText: 'Aceptar'
        });
    </script>
@endif
<style>
    #map {
        width: 100%;
        height: 500px; /* Ajusta la altura según lo necesites */
    }
</style>
<div class="content">
    <h2>EVALUAR INFORMES</h2>
    <div id="map"></div>
</div>
@include('forms.evaluar.formRechazo')
@include('forms.evaluar.evaluarView')
@include('forms.evaluar.evaluarRechazado')

@endsection




@section('scripts')
    <script src="https://api.mapbox.com/mapbox-gl-js/v2.8.1/mapbox-gl.js" defer></script>
    <script src="https://unpkg.com/leaflet/dist/leaflet.js" defer></script>
    <script>
        let map; // Declare map variable in global scope
        let puntoMarcador;
        let routeLayer;

        let mapView;

        let mapRechazado;
        let puntoMarcadorRechazado;

        let defaultAsignacion = '';

        const formRechazo = document.getElementById('formRechazo');

        const modal = document.getElementById('modalView');
        const closeModalBtn = document.getElementById('closeModalBtn');
        closeModalBtn.addEventListener('click', () => {
            defaultAsignacion = ''
            $('#asignar').prop('disabled', true);
            modal.style.display = 'none';
        });

        const modalRechazado = document.getElementById('modalRechazado');
        const closeModalBtnRechazado = document.getElementById('closeModalBtnRechazado');
        closeModalBtnRechazado.addEventListener('click', () => {
            modalRechazado.style.display = 'none';
        });

        document.addEventListener('DOMContentLoaded', () => {
            formRechazo.style.display = 'none';
            $('#loading').show();
            mapboxgl.accessToken = 'pk.eyJ1IjoiYWxpc3RhcmRldiIsImEiOiJjbTFyOHlseXowOHRzMnhxMm9tdnBwcTR5In0.D5D_X4S6CB4FdAyeTIL0GQ';
            cargarMapa();
            // Wait for map to load before adding markers
            map.on('load', () => {
                cargarReportes();
            });
        });

        function cargarMapa(){
                map = new mapboxgl.Map({
                    container: 'map',
                    style: 'mapbox://styles/mapbox/streets-v11',
                    center: [-88.3094386, 18.5267782],
                    zoom: 13
            });
        }

        async function getUserInfo(idCiudadano) {
            const token = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
            try {
                const response = await fetch(`/admin/ciudadanos/${idCiudadano}`,{
                    method: 'GET',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': token
                    },
                });
                return await response.json();
            } catch (error) {
                console.error('Error al obtener la información del usuario:', error);
                return null;
            }
        }

        async function addMarker(lngLat, popupContent, options = {}) {
            if (!map) {
                console.error('Map not initialized');
                return;
            }

            const { customElement = null } = options;

            try {
                let marker;
                if (customElement) {
                    marker = new mapboxgl.Marker({
                        element: customElement,
                        anchor: 'bottom' // This ensures the marker is properly positioned
                    });
                } else {
                    marker = new mapboxgl.Marker();
                }

                // Add console.log to debug coordinates
                console.log('Adding marker at coordinates:', lngLat);

                marker
                    .setLngLat(lngLat)
                    .setPopup(new mapboxgl.Popup({ offset: 25 }).setHTML(popupContent))
                    .addTo(map);

                // Verify marker was added
                console.log('Marker added successfully');
                } catch (error) {
                    console.error('Error adding marker:', error);
                }
            }


        async function cargarReportes() {
            $('#loading').show();
            try {
                const response = await fetch('/admin/reportes/getPoints');
                const reportes = await response.json();

                console.log('Received reports:', reportes); // Debug log

                for (const reporte of reportes) {
                    try {
                        let ubicacion = reporte.location;
                        console.log('Raw location:', ubicacion); // Debug log

                        if (typeof ubicacion === 'string') {
                            ubicacion = JSON.parse(ubicacion);
                        }

                        console.log('Parsed location:', ubicacion); // Debug log

                        if (!ubicacion || !ubicacion.longitud || !ubicacion.latitud) {
                            console.error('Invalid location data for reporte:', reporte);
                            continue;
                        }

                        const coordenadas = [parseFloat(ubicacion.latitud),
                            parseFloat(ubicacion.longitud)
                        ];

                        console.log('Coordinates:', coordenadas); // Debug log

                        if (isNaN(coordenadas[0]) || isNaN(coordenadas[1])) {
                            console.error('Invalid coordinates for reporte:', reporte);
                            continue;
                        }




                        let color;
                        if (reporte.status === 'sinAsignar') {
                            color = 'gray'; // Naranja fuerte para indicar que requiere atención
                        } else if (reporte.status === 'asignado') {
                            color = '#1E90FF'; // Azul para indicar que ya tiene un responsable
                        } else if (reporte.status === 'enProgreso') {
                            color = '#FFD700'; // Amarillo/dorado para reflejar que está en curso
                        } else if (reporte.status === 'finalizado') {
                            color = '#008000'; // Verde oscuro para indicar que ya se completó
                        } else if (reporte.status === 'rechazado') {
                            color = '#DC143C'; // Rojo intenso para mostrar que fue rechazado
                        }


                        const id = reporte.id; // ID del reporte
                        const creado = reporte.created_at; // Ejemplo: "2024-11-21 19:28:32"

                        const customElement = document.createElement('div');

                        customElement.style.width = '20px';
                        customElement.style.height = '20px';
                        customElement.style.backgroundColor = color;
                        customElement.style.borderRadius = '50%'; // Hacerlo circular
                        customElement.style.border = '2px solid white';

                        const userInfo = await getUserInfo(reporte.idUsuario);
                        if (userInfo ) {
                            const user = userInfo.data;
                            console.log(user)
                            const nombre = `${user.nombre} ${user.apellidoP} ${user.apellidoM}`;
                            const foto = user.profile_picture;
                            let popupContent;
                            if (reporte.status == 'sinAsignar') {
                                popupContent = `
                                <div style="display: flex; flex-direction: column; gap: 10px; font-family: Arial, sans-serif; font-size: 14px; color: #333;">
                                    <div style="display: flex; align-items: center; gap: 10px;">

                                        <img src="https://sojalut.com/storage/${foto}" alt="Foto de perfil" style="width: 50px; height: 50px; border-radius: 50%; border: 1px solid #ccc;" />
                                        <div style="display: flex; flex-direction: column;">
                                            <span style="font-weight: bold;">${nombre}</span>
                                        </div>
                                    </div>
                                    <p id="idReporteVisual" hidden>${reporte.id}</p>
                                    <div>
                                        <strong>Descripción:</strong>
                                        <p style="margin: 5px 0;">${reporte.descripcion}</p>
                                        <p><strong>Estado:</strong> <span style="color: ${color}; text-transform: capitalize;">${reporte.status}</span></p>
                                    </div>
                                    <button class="ver-mas" onClick="visualizarReporte('${reporte.id}')" style="background-color: ${color}; color: white; border: none; padding: 8px 12px; border-radius: 5px; cursor: pointer; font-size: 14px;">
                                        Ver más
                                    </button>
                                </div>
                                `;
                            }else if (reporte.status == 'rechazado'){
                                popupContent = `
                                <div style="display: flex; flex-direction: column; gap: 10px; font-family: Arial, sans-serif; font-size: 14px; color: #333;">
                                    <div style="display: flex; align-items: center; gap: 10px;">
                                        <img src="https://sojalut.com/storage/${foto}" alt="Foto de perfil" style="width: 50px; height: 50px; border-radius: 50%; border: 1px solid #ccc;" />
                                        <div style="display: flex; flex-direction: column;">
                                            <span style="font-weight: bold;">${nombre}</span>
                                        </div>
                                    </div>
                                    <p id="idReporteVisual" hidden>${reporte.id}</p>
                                    <div>
                                        <strong>Descripción:</strong>
                                        <p style="margin: 5px 0;">${reporte.descripcion}</p>
                                        <p><strong>Estado:</strong> <span style="color: ${color}; text-transform: capitalize;">${reporte.status}</span></p>

                                    </div>
                                    <button class="ver-mas" onClick="visualizarReporteRechazado('${reporte.id}')" style="background-color: ${color}; color: white; border: none; padding: 8px 12px; border-radius: 5px; cursor: pointer; font-size: 14px;">
                                        Ver más
                                    </button>
                                </div>
                                `;
                            }else{
                                popupContent = `
                                <div style="display: flex; flex-direction: column; gap: 10px; font-family: Arial, sans-serif; font-size: 14px; color: #333;">
                                    <div style="display: flex; align-items: center; gap: 10px;">
                                        <img src="https://sojalut.com/storage/${foto}" alt="Foto de perfil" style="width: 50px; height: 50px; border-radius: 50%; border: 1px solid #ccc;" />
                                        <div style="display: flex; flex-direction: column;">
                                            <span style="font-weight: bold;">${nombre}</span>
                                        </div>
                                    </div>
                                    <p id="idReporteVisual" hidden>${reporte.id}</p>
                                    <div>
                                        <strong>Descripción:</strong>
                                        <p style="margin: 5px 0;">${reporte.descripcion}</p>
                                        <p><strong>Estado:</strong> <span style="color: ${color}; text-transform: capitalize;">${reporte.status}</span></p>

                                    </div>
                                    <button class="ver-mas" onClick="editarReporte('${reporte.id}')" style="background-color: ${color}; color: white; border: none; padding: 8px 12px; border-radius: 5px; cursor: pointer; font-size: 14px;">
                                        Ver más
                                    </button>
                                </div>
                                `;
                            }
                            addMarker(coordenadas, popupContent, { customElement });

                        } else {
                            console.error('No se encontró información del usuario para el reporte:', reporte.idUsuario);
                            $('#loading').hide();
                        }
                    } catch (error) {
                        console.error('Error processing reporte:', error, reporte);
                        $('#loading').hide();
                    }
                }
                $('#loading').hide();
            } catch (error) {
                console.error('Error fetching reports:', error);
                $('#loading').hide();
            }
        }

        function visualizarReporte(idReporte) {
    $.ajax({
        url: `reportes/${idReporte}`,
        method: 'GET',
        dataType: 'json',
        success: function (data) {
            if (data) {
                modal.style.display = 'flex';
                console.log(data);
                $('#decripcionView').text(data.descripcion);
                $('#coloniaView').text(data.colonia);
                $('#calleView').text(data.calle);
                $('#referenciasView').text(data.referencias);
                let calles = JSON.parse(data.cruzamientos);
                $('#cruzamientosView').text(calles.calle1 + ' y ' + calles.calle2);
                $('#idReporte').val(data.id);
                cargarMapaView();
                cargarPunto(data.id);
                cargarPerfilCiudadano(data.idUsuario);
                cargarAsignaciones();
                limpiarPerfil('#nombreNew', '#telefonoNew');
                $('#avancesSection').hide();
                $('#asignacion').prop('disabled', false);
                $('#rechazar').prop('disabled', false);
                $('.alert-finalizado').remove();

                // Procesar las imágenes
                if(data.imagenes) {
                    // Convertir el string JSON a un array
                    let imagenesArray = JSON.parse(data.imagenes);
                    let contentImg = $('#content-img');
                    contentImg.empty(); // Limpiar el contenedor
                    // Suponiendo que las rutas son relativas y necesitas el asset base, puedes hacerlo así:
                    let baseURL = "{{ asset('') }}";
                    imagenesArray.forEach(function(img) {
                        // Agrega una imagen al contenedor
                        contentImg.append('<img src="' + baseURL + img + '" alt="Foto del reporte" style="width:100px; margin-right:10px;">');
                    });
                }

            } else {
                alert('No se encontraron datos del trabajador.');
                $('#loading').hide();
            }
        },
        error: function () {
            alert('Error al cargar el perfil del trabajador.');
            $('#loading').hide();
        }
    });
}


        async function editarReporte(idReporte) {
            try {
                $('#loading').show();
                // Usamos await en la llamada ajax (se asume que $.ajax se resuelve como una promesa)
                const data = await $.ajax({
                    url: `reportes/${idReporte}`,
                    method: 'GET',
                    dataType: 'json'
                });

                if (data) {
                    modal.style.display = 'flex';
                    console.log(data);
                    $('#decripcionView').text(data.descripcion);
                    $('#coloniaView').text(data.colonia);
                    $('#calleView').text(data.calle);
                    $('#referenciasView').text(data.referencias);
                    let calles = JSON.parse(data.cruzamientos);
                    $('#cruzamientosView').text(calles.calle1 + ' y ' + calles.calle2);
                    $('#idReporte').val(data.id);
                    cargarMapaView();
                    cargarPunto(data.id);
                    cargarPerfilCiudadano(data.idUsuario);
                    cargarAsignaciones(data.conjunto);
                    limpiarPerfil('#nombreNew','#telefonoNew');
                    defaultAsignacion = data.conjunto;
                    // Esperamos a que la función asíncrona retorne la asignación
                    const asignacion = await consultaAsignacionId(data.conjunto);
                    cargarRutaNew(asignacion.idRuta);
                    cargarPerfilTrabajador(asignacion.idUsuario, '#nombreNew', '#telefonoNew');
                    let trabajador = await consultaTrabajador(asignacion.idUsuario);
                    trabajador = trabajador.data;

                    // Sección Avances:
                    if (data.status !== 'sinAsignar') {
                        $('#avancesSection').show(); // Muestra la sección de avances
                        // Si existen avances, se muestran en cards; de lo contrario, se muestra un mensaje
                        if (data.avances && data.avances.length > 0) {
                            let avancesHTML = '';
                            data.avances.forEach(function(avance) {
                                avancesHTML += `
                                    <div class="card" style="padding: 16px;">
                                        <p style="margin-bottom: 14px;"><strong>Descripciónavanc:</strong> ${avance.descripcion}</p>
                                        <p style="margin-bottom: 14px;"><strong>Fecha de subida:</strong> ${new Date(avance.fecha_subida).toLocaleString()}</p>
                                        <div class="imagenes-avance" style="margin-bottom: 14px;">
                                            ${ avance.imagenes && avance.imagenes.length > 0
                                                ? avance.imagenes.map(img => `<img src="https://sojalut.com/storage/${img}" alt="Imagen avance" style="width: 100px; margin-right: 5px;">`).join('')
                                                : '<p>No hay imágenes</p>'
                                            }
                                        </div>
                                        <p><strong>Trabajador:</strong> ${trabajador.nombre} ${trabajador.apellidoP} ${trabajador.apellidoM}</p>
                                    </div>
                                `;
                            });
                            $('#avancesContent').html(avancesHTML);
                            $('#finalizar').prop('disabled', false);

                        } else {
                            // Si el arreglo de avances está vacío
                            $('#avancesContent').html('<p>No hay avances disponibles</p>');
                            $('#finalizar').prop('disabled', true);

                        }
                    }

                    // Si el estado es "finalizado", desactivar el select y los botones, y mostrar mensaje
                    if (data.status === 'finalizado') {
                        $('#rechazar').prop('disabled', true);
                        $('#asignar').prop('disabled', true);
                        $('#asignacion').prop('disabled', true);
                        $('#finalizar').prop('disabled', true);
                        if ($('.alert-finalizado').length === 0) {
                            $('.container-asignar').prepend(`
                                <div class="alert-finalizado" style="color: red; margin-bottom: 10px; font-weight: bold;">
                                    Este reporte ya está finalizado y no se puede modificar.<br>
                                    Finalizado el: ${data.fechaFinalizado}
                                </div>
                            `);
                        }
                    } else {
                        // Para estados distintos de "finalizado", aseguramos que el select esté habilitado y eliminamos el mensaje si existe
                        $('#asignacion').prop('disabled', false);
                        $('.alert-finalizado').remove();
                        $('#rechazar').prop('disabled', false);
                    }
                    $('#loading').hide();
                } else {
                    alert('No se encontraron datos del trabajador.');
                    $('#loading').hide();
                }
            } catch (error) {
                console.error(error);
                alert('Error al cargar el perfil del trabajador.');
                $('#loading').hide();
            }
        }




        function visualizarReporteRechazado(idReporte) {
            $('#loading').show()
            $.ajax({
                url: `reportes/${idReporte}`,
                method: 'GET',
                dataType: 'json',
                success: function (data) {
                    if (data) {
                        modalRechazado.style.display = 'flex';
                        console.log(data);
                        $('#decripcionRechazado').text(data.descripcion);
                        $('#coloniaRechazado').text(data.colonia);
                        $('#calleRechazado').text(data.calle);
                        $('#referenciasRechazado').text(data.referencias);
                        let calles = JSON.parse(data.cruzamientos);
                        $('#cruzamientosRechazado').text(calles.calle1 + ' y ' + calles.calle2);
                        $('#idReporteRechazado').val(data.id);
                        $('#fechaRechazado').text(data.fechaRechazado);
                        cargarPerfilCiudadanoRechazado(data.idUsuario)
                        cargarMapaRechazado()
                        cargarPuntoRechazado(data.id)
                    } else {
                        alert('No se encontraron datos del trabajador.');
                    }
                },
                error: function () {
                    alert('Error al cargar el perfil del trabajador.');
                }
            });
        }



        async function cargarMapaView() {
            // Verificar si el mapa ya está inicializado, si no lo inicializamos
            if (!mapView) {
                mapView = L.map('mapView').setView([18.5267782, -88.3094386], 13);  // Coordenadas y zoom inicial
                // Cargar el mapa de OpenStreetMap
                L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                    maxZoom: 19,
                }).addTo(mapView);
            }
        }

        async function cargarMapaRechazado() {
            // Verificar si el mapa ya está inicializado, si no lo inicializamos
            if (!mapRechazado) {
                mapRechazado = L.map('mapRechazado').setView([18.5267782, -88.3094386], 13);  // Coordenadas y zoom inicial
                // Cargar el mapa de OpenStreetMap
                L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                    maxZoom: 19,
                }).addTo(mapRechazado);
            }
        }

        async function cargarPunto(idPunto) {
            $.ajax({
                url: `reportes/${idPunto}`,  // Suponiendo que la URL devuelve un solo punto
                method: 'GET',
                dataType: 'json',
                success: function (data) {
                    // Verificar si el mapa ya está inicializado
                    if (!mapView) {
                        cargarMapaView();  // Si el mapa no está creado, lo inicializamos
                    }
                    if (routeLayer) {
                        mapView.removeLayer(routeLayer);  // Eliminar la capa anterior
                    }
                    // Eliminar cualquier marcador anterior si existe
                    if (puntoMarcador) {
                        mapView.removeLayer(puntoMarcador);
                    }
                    let ubicacion = data.location;
                    ubicacion = JSON.parse(ubicacion);

                    const coordenadas = [parseFloat(ubicacion.longitud),parseFloat(ubicacion.latitud)];
                    console.log(coordenadas)
                    // Crear un marcador para el punto
                    puntoMarcador = L.marker(coordenadas).addTo(mapView)

                    // Ajustar la vista al nuevo punto con zoom adecuado
                    mapView.setView(coordenadas, 15);
                },
                        error: function () {
                            alert('Error al cargar el punto.');
                        }
                    });
        }

        async function cargarPuntoRechazado(idPunto) {
            $.ajax({
                url: `reportes/${idPunto}`,  // Suponiendo que la URL devuelve un solo punto
                method: 'GET',
                dataType: 'json',
                success: function (data) {
                    // Verificar si el mapa ya está inicializado
                    if (!mapRechazado) {
                        cargarMapaRechazado();  // Si el mapa no está creado, lo inicializamos
                    }

                    // Eliminar cualquier marcador anterior si existe
                    if (puntoMarcadorRechazado) {
                        mapRechazado.removeLayer(puntoMarcadorRechazado);
                    }
                    let ubicacion = data.location;
                    ubicacion = JSON.parse(ubicacion);

                    const coordenadas = [parseFloat(ubicacion.longitud),parseFloat(ubicacion.latitud)];
                    console.log(coordenadas)
                    // Crear un marcador para el punto
                    puntoMarcadorRechazado = L.marker(coordenadas).addTo(mapRechazado)

                    // Ajustar la vista al nuevo punto con zoom adecuado
                    mapRechazado.setView(coordenadas, 15);
                    $('#loading').hide()
                },
                        error: function () {
                            alert('Error al cargar el punto.');
                            $('#loading').hide()
                        }
                    });
                    $('#loading').hide()
        }

        async function cargarPerfilCiudadano(idCiudadano) {
            let ciudadano = idCiudadano.toString();
            $.ajax({
                url: `ciudadanos/${ciudadano}`,
                method: 'GET',
                dataType: 'json',
                success: function (data) {
                    if (data) {
                        var ciudadano = data.data;
                        $('#nombreView').text(ciudadano.nombre + ' ' + ciudadano.apellidoP + ' ' + ciudadano.apellidoM);
                        $('#fechaView').text('Telefono: ' + ciudadano.telefono);
                        $('#profilePic').attr('src', 'https://sojalut.com/storage/' + ciudadano.profile_picture);
                        $('#correoView').text('Correo: ' + ciudadano.correo);
                    } else {
                        alert('No se encontraron datos del ciudadano.');
                    }
                },
                error: function () {
                    alert('Error al cargar el perfil del ciudadano.');
                }
            });
        }

        async function cargarPerfilCiudadanoRechazado(idUsuario) {
            let usuario = idUsuario.toString();
            $.ajax({
                url: `ciudadanos/${usuario}`,
                method: 'GET',
                dataType: 'json',
                success: function (data) {
                    if (data) {
                        var trabajador = data.data;
                        $('#nombreRechazado').text(trabajador.nombre + ' ' + trabajador.apellidoP + ' ' + trabajador.apellidoM);
                        $('#telefonoRechazado').text('Telefono: ' + trabajador.telefono);
                        $('#correoRechazado').text('Correo: ' + trabajador.correo);

                    } else {
                        alert('No se encontraron datos del trabajador.');
                    }
                },
                error: function () {
                    alert('Error al cargar el perfil del trabajador.');
                }
            });
        }

        function cargarAsignaciones(defaultValue='') {
            $('#loading').show();
            $.ajax({
                url: '{{ route('admin.asignaciones.data') }}',
                method: 'GET',
                dataType: 'json',
                success: function (data) {
                    $('#asignacion').empty();
                    $('#asignacion').append('<option value="" disabled selected>Selecciona una asignacion</option>');
                    $.each(data.data, function (index, asignacion) {
                        $('#asignacion').append(
                            `<option value="${asignacion.id}">${asignacion.nombre}</option>`
                        );
                    });
                    if(defaultValue){
                        $('#asignacion').val(defaultValue);
                    }
                    $('#loading').hide();
                },
                error: function () {
                    alert('Error al cargar las asignaciones.');
                    $('#loading').hide();
                }
            });
        }

        $('#asignacion').change(async function () {
            var idAsignacion = $(this).val();
            if (idAsignacion) {
                try {
                    $('#loading').show();
                    const asignacion = await consultaAsignacionId(idAsignacion);
                    cargarRutaNew(asignacion.idRuta)
                    cargarPerfilTrabajador(asignacion.idUsuario, '#nombreNew', '#telefonoNew')
                    if(idAsignacion == defaultAsignacion){
                        $('#asignar').prop('disabled', true);
                    }else{
                        $('#asignar').prop('disabled', false);
                    }
                } catch (error) {
                    limpiarPerfil('#nombreNew','#telefonoNew');
                    alert('Error al cargar la asignacion.');
                    $('#loading').hide();
                }
            }
        });
        function finalizarReporte() {
            let idReporte = $('#idReporte').val();
            Swal.fire({
                title: '¿Estás seguro de confirmar el reporte?',
                text: 'Una vez confirmado, no podrá ser modificado.',
                icon: 'info',
                showCancelButton: true,
                confirmButtonText: 'Sí, confirmar',
                cancelButtonText: 'Cancelar',
            }).then((result) => {
                if (result.isConfirmed) {
                    $('#loading').show();
                    $.ajax({

                        url: `evaluar/finalizarReporte/${idReporte}`,  // Ajusta la ruta según Laravel
                        type: "POST",
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        success: function (response) {
                            if (response.success) {
                                modal.style.display = 'none';
                                cargarReportes();
                                Swal.fire('Reporte confirmado!', response.message, 'success');
                            } else {
                                Swal.fire('¡Error!', response.message, 'error');
                            }
                            $('#loading').hide();
                        },
                        error: function () {
                            Swal.fire('¡Error!', 'No se pudo confirmar el reporte.', 'error');
                            $('#loading').hide();
                        }
                    });
                }
            });
        }

        function rechazarReporte() {
            let idReporte = $('#idReporte').val();
            Swal.fire({
                title: '¿Estás seguro que quieres rechazar el reporte?',
                text: 'Esta acción no se puede deshacer.',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Sí, rechazar',
                cancelButtonText: 'Cancelar',
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: `evaluar/${idReporte}`,  // Laravel ya genera esta ruta
                        type: "DELETE",
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')  // Token CSRF
                        },
                        success: function (response) {
                            if (response.success) {
                                $('#idFormRechazo').val(idReporte);
                                modal.style.display = 'none';
                                formRechazo.style.display = 'block';  // Recargar la página
                                Swal.fire('Reporte rechazado!', response.message, 'success');
                            } else {
                                Swal.fire('¡Error!', response.message, 'error');
                            }
                        },
                        error: function () {
                            Swal.fire('¡Error!', 'No se pudo rechazar el reporte.', 'error');
                        }
                    });
                }
            });
        }

        function cargarRutaNew(idRuta) {
            $.ajax({
                url: `rutas/${idRuta}`,
                method: 'GET',
                dataType: 'json',
                success: function (data) {
                    // Verificar si el mapa ya está inicializado
                    if (!mapView) {
                        cargarMapaView();  // Si el mapa no está creado, lo inicializamos
                    }

                    // Eliminar la ruta anterior si existe
                    if (routeLayer) {
                        mapView.removeLayer(routeLayer);  // Eliminar la capa anterior
                    }

                    // Extraer la ruta seleccionada
                    const ruta = data // Asumiendo que la respuesta es un solo objeto
                    const puntos = ruta.puntos; // Convertir la cadena JSON de puntos a un array

                    // Crear una nueva capa de línea para la ruta
                    const latLngs = puntos.map(function (point) {
                        return [point[0], point[1]]; // Convertir cada punto en una coordenada [lat, lng]
                    });

                    // Crear una capa de línea para la ruta
                    routeLayer = L.polyline(latLngs, {
                        color: ruta.color,  // Usar el color de la ruta
                        weight: 5
                    }).addTo(mapView);

                    // Ajustar el mapa para que se vea la ruta completa
                    mapView.fitBounds(routeLayer.getBounds());
                },
                error: function () {
                    alert('Error al cargar la ruta.');
                }
            });
        }

        async function consultaAsignacionId(idAsignacion) {
            const response = await fetch(`asignacion/${idAsignacion}`, {
                method: 'GET',
                headers: {
                    'Content-Type': 'application/json'
                }
            });

            if (!response.ok) {
                throw new Error('Error al cargar la asignacion');
            }

            const data = await response.json();
            return data;
        }

        async function consultaTrabajador(trabajador) {
            const response = await fetch(`trabajadores/${trabajador}`, {
                method: 'GET',
                headers: {
                    'Content-Type': 'application/json'
                }
            });

            if (!response.ok) {
                throw new Error('Error al cargar la asignacion');
            }
            return response.json();
        }

        function cargarPerfilTrabajador(id,section1,section2) {

            $.ajax({
                url: `trabajadores/${id}`,
                method: 'GET',
                dataType: 'json',
                success: function (data) {
                    if (data) {
                        var trabajador = data.data;
                        $(section1).text(trabajador.nombre + ' ' + trabajador.apellidoP + ' ' + trabajador.apellidoM);
                        $(section2).text('Teléfono: ' + trabajador.telefono);
                        const rutaImagen = "{{ asset('storage') }}/" + trabajador.profile_picture
                        document.getElementById('profilePicTrabajador').src = rutaImagen;

                        $('#loading').hide();
                    } else {
                        alert('No se encontraron datos del trabajador.');
                        $('#loading').hide();
                    }
                },
                error: function () {
                    alert('Error al cargar el perfil del trabajador.');
                    $('#loading').hide();
                }
            });
        }

        function limpiarPerfil(section1,section2) {
            $(section1).text('Nombre del trabajador');
            $(section2).text('Teléfono:');
            document.getElementById('profilePicTrabajador').src = "{{ asset('images/profile.png') }}";
        }

    </script>
@endsection


