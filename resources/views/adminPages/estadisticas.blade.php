@extends('layouts.admin-navbar')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<link rel="stylesheet" href="{{ asset('css/ViewEstadisticas.css') }}">

@section('content')
<div class="content" id="content">
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
            <a href="{{ route('estadisticas.report') }}" class="btn btn-info mt-2 mb-2">Reporte</a>

    <div class="content-data">


        <div class="data espera">
            <h3>En Espera</h3>
            <p><?php echo $espera?></p>
        </div>
        <div class="data progreso">
            <h3>En proceso</h3>
            <p><?php echo $proceso?></p>
        </div>
        <div class="data finalizado">
            <h3>Finalizados</h3>
            <p><?php echo $finalizado?></p>
        </div>
        <div class="data rechazado">
            <h3>Rechazado</h3>
            <p><?php echo $rechazado?></p>
        </div>
    </div>


    <div class="grid-container">

        <!--<div class="container-graph">
            <canvas id="myChart"></canvas>

           
        </div>-->
        <!-- Gráfico 1 -->
        <div class="container-graph">
            <h3>{{ $chart->options['chart_title'] }}</h3>
            {!! $chart->renderHtml() !!}
        </div>

        <!-- Gráfico 2 -->

        <div class="container-graph">
            <h3>{{ $chart2->options['chart_title'] }}</h3>
            {!! $chart2->renderHtml() !!}
        </div>

        <!-- Gráfico 3 -->
        <div class="container-graph">
            <h3>{{ $chart3->options['chart_title'] }}</h3>
            {!! $chart3->renderHtml() !!}
        </div>
        

      
    </div>
</div>


  
@endsection


@section('scripts')
{!! $chart->renderChartJsLibrary() !!}
{!! $chart->renderJs() !!}
{!! $chart2->renderJs() !!}
{!! $chart3->renderJs() !!}
@endsection
