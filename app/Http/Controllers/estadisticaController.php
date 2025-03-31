<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Reporte;
use LaravelDaily\LaravelCharts\Classes\LaravelChart;
use Barryvdh\DomPDF\Facade\Pdf;

class estadisticaController extends Controller
{
    public function index()
    {
        $estadisticas = Reporte::all();

        /*$status = $estadisticas->pluck('status');

        return view('adminPages.estadisticas', compact('estadisticas'), [
            'status' => $status,
        ]);*/

        $chart_options = [
            'chart_title' => 'Reportes por semana',
            'report_type' => 'group_by_date',
            'model' => 'App\Models\Reporte',
            'group_by_field' => 'created_at',
            'group_by_period' => 'week',
            'chart_type' => 'pie',
        ];

        $chart = new LaravelChart($chart_options);

        $chart_options = [
            'chart_title' => 'Reportes por mes',
            'report_type' => 'group_by_date',
            'model' => 'App\Models\Reporte',
            'group_by_field' => 'created_at',
            'group_by_period' => 'month',
            'chart_type' => 'pie',
        ];

        $chart2 = new LaravelChart($chart_options);

        $chart_options = [
            'chart_title' => 'Reportes por año',
            'report_type' => 'group_by_date',
            'model' => 'App\Models\Reporte',
            'group_by_field' => 'created_at',
            'group_by_period' => 'year',
            'chart_type' => 'pie',
        ];
        
        $chart3 = new LaravelChart($chart_options);

        return view('adminPages.estadisticas', compact('chart', 'chart2', 'chart3','estadisticas'));
    }

    public function report()
    {
        $estadisticas = Reporte::all();
    
        

        $pdf = Pdf::loadView('adminPages.report', compact('estadisticas'))->setPaper('a4', 'landscape');
        return $pdf->stream('estadisticas_reportes.pdf');
    }

}
