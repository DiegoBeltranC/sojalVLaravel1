@extends('layouts.admin-navbar')

@section('content')
@if(session('asignacionGuardada'))
    <script>
        Swal.fire({
            title: '¡Éxito!',
            text: "{{ session('asignacionGuardada') }}",
            icon: 'success',
            confirmButtonText: 'Aceptar'
        });
    </script>
@endif

@if(session('asignacionActualizada'))
    <script>
        Swal.fire({
            title: '¡Éxito!',
            text: "{{ session('asignacionActualizada') }}",
            icon: 'success',
            confirmButtonText: 'Aceptar'
        });
    </script>
@endif
<link rel="stylesheet" href="https://unpkg.com/leaflet/dist/leaflet.css" />
<link href="https://api.mapbox.com/mapbox-gl-js/v2.8.1/mapbox-gl.css" rel="stylesheet" />
<style>
    .content {
        height: 91.5vh;
    }
</style>

<div class="content">
    <h2>ASIGNACIÓN</h2>

    <table id="asignacionTable" style="width: 100%;">
        <thead>
            <tr>
                <th>ID Asignación</th>
                <th>Nombre Asignacion</th> <!-- Nueva columna -->
                <th>Trabajador</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
        </tbody>
     </table>

</div>
@include('forms.asignaciones.new')
@include('forms.asignaciones.view')
@include('forms.asignaciones.edit')
@endsection

@section('scripts')
    <!-- Cargar jQuery y DataTables -->

    <script src="https://unpkg.com/leaflet/dist/leaflet.js" defer></script>
    <script src="https://api.mapbox.com/mapbox-gl-js/v2.8.1/mapbox-gl.js" defer></script>
    <script>
        const modal = document.getElementById('modal');
        const closeModalBtn = document.getElementById('closeModalBtn');
        closeModalBtn.addEventListener('click', () => {
            modal.style.display = 'none';
        });

        const modalView = document.getElementById('modalView');
        const modalViewclose = document.getElementById('closeModalBtnView');
        modalViewclose.addEventListener('click', () => {
            modalView.style.display = 'none';
        });

        const modalEdit = document.getElementById('modalEdit');
        const modalEditclose = document.getElementById('closeModalBtnEdit')
        modalEditclose.addEventListener('click', () => {
            modalEdit.style.display = 'none';
        });
        let map;
        let mapView;
        let mapEdit;

        let routeLayer;
        let routeLayerView;
        let routeLayerEdit;

        $(document).ready(function () {
            cargarTabla();

        });

        function cargarTabla() {
            $('#asignacionTable').DataTable({
    "ajax": "{{ route('admin.asignaciones.data') }}", // Ruta que retorna las asignaciones en JSON
    "columns": [
        { "data": "id" },
        { "data": "nombre" },
        {
            "data": null,
            "render": function (data, type, row) {
                return row.nombreUsuario + ' ' + row.apellidoPaterno + ' ' + row.apellidoMaterno;
            }
        },
        {
            "data": null,
            "render": function (data, type, row) {
                return `
                    <div class="action-buttons">
                        <button class="btn btn-info" title="Visualizar" onclick="ver('${row.id}');"><i class="fas fa-eye"></i></button>
                        <button class="btn btn-warning" title="Editar" onclick="verEdit('${row.id}');"><i class="fas fa-edit"></i></button>
                        <button class="btn btn-danger" title="Eliminar" onclick="eliminar('${row.id}');"><i class="fas fa-trash-alt"></i></button>
                    </div>
                `;
            }
        }
    ],
    "pageLength": 8,
    "language": {
        "lengthMenu": "",
        "info": "",
        "infoEmpty": "",
        "infoFiltered": "",
        "emptyTable": "No hay asignaciones disponibles", // Mensaje para cuando no hay datos
        "paginate": {
            "next": "Siguiente",
            "previous": "Anterior"
        },
        "search": "Buscar: "
    },
    "dom": '<"top"f>rt<"bottom"p><"clear">',
    "initComplete": function (settings, json) {
        // Agrega un botón "Nueva Asignación" antes de la tabla
        var nuevaAsignacion = $('<button>', {
            text: 'Nueva Asignación',
            class: 'add-form',
            id: 'openModalBtn',
            click: function () {
                $('#loading').show();
                // Aquí puedes abrir un modal o redirigir para crear una nueva asignación
                modal.style.display = 'flex';
                cargarTrabajadores('#trabajador');
                cargarCamiones('#camion');
                cargarRutas('#ruta');
                cargarMapa();
                limpiarPerfil('#nombreNew','#telefonoNew');
            }
        });
        $('#asignacionTable').before(nuevaAsignacion);
    }
});

        }

        function cargarTrabajadores(section, defaultValue = '') {
            $.ajax({
                url: '{{ route('admin.trabajadores.data') }}',
                method: 'GET',
                dataType: 'json',
                success: function (data) {
                    $(section).empty();
                    $(section).append('<option value="">Selecciona un Trabajador</option>');
                    $.each(data.data, function (index, trabajador) {
                        $(section).append(
                            `<option value="${trabajador.id}">${trabajador.nombre} ${trabajador.apellidos.paterno} ${trabajador.apellidos.materno} </option>`
                        );
                    });
                    if(defaultValue){
                        $(section).val(defaultValue);
                    }
                },
                error: function () {
                    alert('Error al cargar los trabajadores.');
                }
            });
        }

        // Función para cargar las rutas en el select
    function cargarCamiones(section, defaultValue = '') {
            $.ajax({
                url: '{{ route('admin.trucks.camionesActivos') }}',
                method: 'GET',
                dataType: 'json',
                success: function (data) {
                    $(section).empty();
                    $(section).append('<option value="">Selecciona un camion</option>');
                    $.each(data.data, function (index,camion) {
                        $(section).append(
                            `<option value="${camion.id}">${camion.plates}</option>`
                        );
                    });
                    if(defaultValue){
                        $(section).val(defaultValue)
                    }
                },
                error: function () {
                    alert('Error al cargar las camion.');
                }
            });
        }

        // Función para cargar las rutas en el select
        function cargarRutas(section, defaultValue = '') {
            $('#loading').show();
            $.ajax({
                url: '{{ route('admin.rutas.getRutas') }}',
                method: 'GET',
                dataType: 'json',
                success: function (data) {
                    $(section).empty();
                    $(section).append('<option value="">Selecciona una Ruta</option>');
                    data.forEach((ruta) => {
                        $(section).append(
                            `<option value="${ruta.id}">${ruta.nombre}</option>`
                        );
                    });
                    if(defaultValue){
                        $(section).val(defaultValue)
                    }
                    $('#loading').hide();
                },
                error: function () {
                    alert('Error al cargar las rutas.');
                    $('#loading').hide();
                }
            });
        }

        function cargarMapa() {
            // Verificar si el mapa ya está inicializado, si no lo inicializamos
            if (!map) {
                map = L.map('map1').setView([18.5267782, -88.3094386], 13);  // Coordenadas y zoom inicial

                // Cargar el mapa de OpenStreetMap
                L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                    maxZoom: 19,
                }).addTo(map);
            }
        }

        function cargarMapaView() {
            // Verificar si el mapa ya está inicializado, si no lo inicializamos
            if (!mapView) {
                mapView = L.map('map1View').setView([18.5267782, -88.3094386], 13);  // Coordenadas y zoom inicial
                // Cargar el mapa de OpenStreetMap
                L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                    maxZoom: 19,
                }).addTo(mapView);
            }
        }

        function cargarMapaEdit() {
            // Verificar si el mapa ya está inicializado, si no lo inicializamos
            if (!mapEdit) {
                mapEdit = L.map('map1Edit').setView([18.5267782, -88.3094386], 13);  // Coordenadas y zoom inicial
                // Cargar el mapa de OpenStreetMap
                L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                    maxZoom: 19,
                }).addTo(mapEdit);
            }
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

        function cargarRuta(idRuta) {
            $('#loading').show();
            $.ajax({
                url: `rutas/${idRuta}`,
                method: 'GET',
                dataType: 'json',
                success: function (data) {
                    // Verificar si el mapa ya está inicializado
                    if (!map) {
                        cargarMapa();  // Si el mapa no está creado, lo inicializamos
                    }

                    // Eliminar la ruta anterior si existe
                    if (routeLayer) {
                        map.removeLayer(routeLayer);  // Eliminar la capa anterior
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
                    }).addTo(map);

                    // Ajustar el mapa para que se vea la ruta completa
                    map.fitBounds(routeLayer.getBounds());
                    $('#loading').hide();
                },
                error: function () {
                    alert('Error al cargar la ruta.');
                    $('#loading').hide();
                }
            });
        }

        function cargarRutaView(idRuta) {
            $.ajax({
                url: `rutas/${idRuta}`,
                method: 'GET',
                dataType: 'json',
                success: function (data) {
                    if (!mapView) {
                        cargarMapaView();
                    }
                    if (routeLayerView) {
                        mapView.removeLayer(routeLayerView);
                    }

                    const ruta = data;
                    const puntos = ruta.puntos;
                    const latLngs = puntos.map(function (point) {
                        return [point[0], point[1]];
                    });

                    routeLayerView = L.polyline(latLngs, {
                        color: ruta.color,
                        weight: 5
                    }).addTo(mapView);

                    // Si el modal ya está visible, centra el mapa en la ruta
                    if (modalView.style.display === 'flex') {
                        mapView.fitBounds(routeLayerView.getBounds());
                    }
                },
                error: function () {
                    alert('Error al cargar la ruta.');
                }
            });
        }

        function cargarRutaEdit(idRuta) {
            $('#loading').show();
            $.ajax({

                url: `rutas/${idRuta}`,
                method: 'GET',
                dataType: 'json',
                success: function (data) {
                    // Verificar si el mapa ya está inicializado
                    if (!mapEdit) {
                        cargarMapaView();  // Si el mapa no está creado, lo inicializamos
                    }

                    // Eliminar la ruta anterior si existe
                    if (routeLayerEdit) {
                        mapEdit.removeLayer(routeLayerEdit);  // Eliminar la capa anterior
                    }

                    // Extraer la ruta seleccionada
                    const ruta = data // Asumiendo que la respuesta es un solo objeto
                    const puntos = ruta.puntos; // Convertir la cadena JSON de puntos a un array

                    // Crear una nueva capa de línea para la ruta
                    const latLngs = puntos.map(function (point) {
                        return [point[0], point[1]]; // Convertir cada punto en una coordenada [lat, lng]
                    });

                    // Crear una capa de línea para la ruta
                    routeLayerEdit = L.polyline(latLngs, {
                        color: ruta.color,  // Usar el color de la ruta
                        weight: 5
                    }).addTo(mapEdit);

                    // Ajustar el mapa para que se vea la ruta completa
                    mapEdit.fitBounds(routeLayerEdit.getBounds());
                    $('#loading').hide();
                },
                error: function () {
                    alert('Error al cargar la ruta.');
                    $('#loading').hide();
                }
            });
        }

        function cargarPerfilTrabajador(id,section1,section2,section3) {
            $('#loading').show();
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
                        document.getElementById(`${section3}`).src = rutaImagen;
                        $('#loading').hide();
                    } else {
                        alert('No se encontraron datos del trabajador.');
                        $('#loading').hide();
                    }
                },
                error: function () {
                    alert('Error al cargar el perfil del trabajador.');
                }
            });
        }

        async function ver(userId) {
            $('#loading').show();
            try {
                const res = await fetch('asignacion/' + userId, {
                    method: 'GET',
                    headers: {
                        'Content-Type': 'application/json'
                    }
                });
                const response = await res.json();

                if (response.error) {
                    alert('Error: ' + response.error);
                } else {
                    // Inicializa el mapa de vista solo si aún no existe
                    if (!mapView) {
                        cargarMapaView();
                    }
                    // Carga la ruta
                    cargarRutaView(response.idRuta);

                    $('#nombreView').text(response.nombreUsuario + ' ' + response.apellidoPaterno + ' ' + response.apellidoMaterno);
                    $('#telefonoView').text('Teléfono: ' + response.telefono);
                    $('#camionView').text('Camion: ' + response.placasCamion);
                    const trabajador = await consultaTrabajador(response.idUsuario);
                    const rutaImagen = "{{ asset('storage') }}/" + trabajador.data.profile_picture;
                    document.getElementById('profilePicView').src = rutaImagen;

                    // Muestra el modal
                    modalView.style.display = 'flex';

                    // Después de que el modal se muestre, recalcula el tamaño y centra el mapa
                    setTimeout(function() {
                        mapView.invalidateSize();
                        if (routeLayerView) {
                            mapView.fitBounds(routeLayerView.getBounds());
                        }
                    }, 1000); // El tiempo puede necesitar ajustes según tu implementación

                    $('#loading').hide();
                }
            } catch (error) {
                alert('Ocurrió un error al cargar los datos.');
                $('#loading').hide();
            }
        }


        function verEdit(userId) {
            $('#loading').show();
            $.ajax({
                url: 'asignacion/' + userId, // Ruta de Laravel con el ID
                type: 'GET',
                dataType: 'json',
                success: function(response) {
                    if (response.error) {
                        alert('Error: ' + response.error);
                    } else {
                        modalEdit.style.display = 'flex';
                        cargarTrabajadores('#trabajadorEdit', response.idUsuario)
                        cargarCamiones('#camionEdit', response.idCamion)
                        cargarRutas('#rutaEdit',response.idRuta)
                        cargarMapaEdit();
                        cargarRutaEdit(response.idRuta)
                        cargarPerfilTrabajador(response.idUsuario,'#nombreEdit','#telefonoEdit','profilePicEdit');
                        // Dentro de la función verEdit() después de recibir la respuesta AJAX:
                        $('#CamionFormEdit').attr('action', 'asignacion/' + response.id);
                    }
                },
                error: function() {
                    alert('Ocurrió un error al cargar los datos.');
                    $('#loading').hide();
                }
            });
        }


        function eliminar(id) {
        Swal.fire({
            title: '¿Estás seguro?',
            text: 'Esta acción no se puede deshacer.',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Sí, eliminar',
            cancelButtonText: 'Cancelar',
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: `asignacion/${id}`,  // Laravel ya genera esta ruta
                    type: "DELETE",
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')  // Token CSRF
                    },
                    success: function (response) {
                        if (response.success) {
                            Swal.fire('¡Eliminado!', response.message, 'success');
                            $('#asignacionTable').DataTable().ajax.reload();  // Recargar tabla
                        } else {
                            Swal.fire('¡Error!', response.message, 'error');
                        }
                    },
                    error: function () {
                        Swal.fire('¡Error!', 'No se pudo eliminar la asignacion. Hay asignaciones activas', 'error');
                    }
                });
            }
        });
    }


        $('#ruta').change(function () {
            var idRuta = $(this).val();
            if (idRuta) {
                cargarRuta(idRuta); // Cargar la ruta seleccionada
            }
        });

        $('#trabajador').change(function () {
            var trabajadorId = $(this).val();
            if (trabajadorId) {
                cargarPerfilTrabajador(trabajadorId,'#nombreNew','#telefonoNew','profilePic');
            } else {
                limpiarPerfil('#nombreNew','#telefonoNew');
            }
        });


        $('#rutaEdit').change(function () {
            var idRuta = $(this).val();
            if (idRuta) {
                cargarRutaEdit(idRuta); // Cargar la ruta seleccionada
            }
        });

        $('#trabajadorEdit').change(function () {
            var trabajadorId = $(this).val();
            if (trabajadorId) {
                cargarPerfilTrabajador(trabajadorId,'#nombreEdit','#telefonoEdit','profilePicEdit');
            } else {
                limpiarPerfil('#nombreEdit', '#telefonoEdit');
            }
        });

        function limpiarPerfil(section1,section2) {
            $(section1).text('Nombre del trabajador');
            $(section2).text('Teléfono:');
        }
    </script>




@endsection
