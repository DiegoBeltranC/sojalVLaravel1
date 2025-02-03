@extends('layouts.admin-navbar')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<link rel="stylesheet" href="{{ asset('css/ViewEstadisticas.css') }}">

@section('content')
<div class="content" id="content">
    <h2>ESTADÍSTICAS</h2>

    <div class="content-data">
        <div class="data espera">
            <h3>En Espera</h3>
            <p>15</p>
        </div>
        <div class="data progreso">
            <h3>En Proceso</h3>
            <p>6</p>
        </div>
        <div class="data finalizado">
            <h3>Finalizados</h3>
            <p>10</p>
        </div>
    </div>

    <div class="grid-container">
        <!-- Gráfico 1 -->
        <div class="container-graph">
            <h3>Gráfico 1</h3>
            <canvas id="myChart1"></canvas>
        </div>

        <!-- Gráfico 2 -->
        <div class="container-graph">
            <h3>Gráfico 2</h3>
            <canvas id="myChart2"></canvas>
        </div>

        <!-- Gráfico 3 -->
        <div class="container-graph">
            <h3>Gráfico 3</h3>
            <canvas id="myChart3"></canvas>
        </div>

        <!-- Gráfico 4 -->
        <div class="container-graph">
            <h3>Gráfico 4</h3>
            <canvas id="myChart4"></canvas>
        </div>
    </div>
</div>
@endsection

