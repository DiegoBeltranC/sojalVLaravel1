<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Reporte;
class ReporteController extends Controller
{
    public function getPoints(){
        $reportes = Reporte::where('status', 'sinAsignar')->get();
        return response()->json($reportes);
    }
}
