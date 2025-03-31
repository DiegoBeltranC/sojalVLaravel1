<!doctype html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <title>Reporte de estadisticas</title>
  </head>
  <body>
    <h2>ESTADÍSTICAS</h2>

        <?php
            $espera = 0;
            $proceso = 0;
            $finalizado = 0;
            $rechazado = 0;
        
            foreach ($estadisticas as $estadistica){
                if($estadistica->status == "sinAsignar") {
                    $espera++;
                }else if($estadistica->status == "asignado" OR $estadistica->status == "enProgreso"){
                    $proceso++; 
                }else if($estadistica->status == "finalizado"){
                    $finalizado++; 
                }else if ($estadistica->status == "rechazado") {
                    $rechazado++; 
                }
            }
        ?>
        <div class="contenedor-flexbox">
            <div class="data espera" style="width:20%; display:inline-block; border:solid;">
                <h3>En Espera</h3>
                <p><?php echo $espera?></p>
            </div>
            <div class="data progreso" style="width:20%; display:inline-block; border:solid;">
                <h3>En proceso</h3>
                <p><?php echo $proceso?></p>
            </div>
            <div class="data finalizado" style="width:20%; display:inline-block; border:solid;">
                <h3>Finalizados</h3>
                <p><?php echo $finalizado?></p>
            </div>
            <div class="data rechazado" style="width:20%; display:inline-block; border:solid;">
                <h3>Rechazado</h3>
                <p><?php echo $rechazado?></p>
            </div>
        </div>

        
        <div class="content">
           
            <h2>Reporte</h2>
        
            <table id="reportesTable" style="width: 100%;">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>IdUsuario</th>
                        <th>Descripción</th>
                        <th>Colonia</th>
                        <th>Fecha Creacion</th>
                        <th>Estatus</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($estadisticas as $estadistica)
                    <tr>
                        <td>{{ $estadistica->id }}</td>
                        <td>{{ $estadistica->idUsuario }}</td>
                        <td>{{ $estadistica->descripcion }}</td>
                        <td>{{ $estadistica->colonia }}</td>
                        <td>{{ $estadistica->fechaCreacion }}</td>
                        <td>{{ $estadistica->status }}</td>
                    </tr>
                    @endforeach
                    
                </tbody>
            </table>
        </div>

    </body>
</html>

<style>
    /* Estilos generales de la tabla */
    table {
        width: 100%;
        border-collapse: collapse;
        font-family: Arial, sans-serif;
    }

    /* Encabezado de la tabla */
    th {
        background-color: #4c59af;
        color: white;
        padding: 10px;
        text-align: left;
    }

    /* Filas de la tabla */
    td {
        padding: 8px;
        text-align: left;
        border-bottom: 1px solid #ddd;
    }

     /* Estilos para la tabla cuando tiene contenido */
     tbody tr:nth-child(even) {
        background-color: #f9f9f9;
    }

    /* Estilos de borde en las celdas */
    td,
    th {
        border: 1px solid #ddd;
    }


    /* //////////////////////////////////////////////////////////////////////////////////7 */

    /*Estilos de las cards*/
    .contenedor-flexbox {
        display: flex; /*Convertimos al menú en flexbox*/
        justify-content: space-between; /*Con esto le indicamos que margine todos los items que se encuentra adentro hacia la derecha e izquierda*/
        align-items: center; /*con esto alineamos de manera vertical*/
        padding: 1rem;
        width: 100%;
        box-sizing: border-box;
    }

    .data {

        color: white;
        text-align: center;
        padding: 1rem;
        border-radius: 0.5rem;
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1); 
    }

    .data h3 {
        margin: 0;
        font-size: 1.2rem;
        font-weight: bold;
    }

    .data p {
        margin: 0;
        font-size: 1.5rem;
        font-weight: bold;
    }

    .espera {
        background-color: #5d6d7e ;
    }

    .progreso {
        background-color: #e67e22;
    }

    .finalizado {
        background-color: #28b463;
    }

    .rechazado {
        background-color: #ec0d0d;
    }
</style>

