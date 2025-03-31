<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Reporte;
class ReporteController extends Controller
{
    public function getPoints(){
        $reportes = Reporte::all();
        return response()->json($reportes);
    }
    public function show($id){
        $reporte = Reporte::find($id);
        return response()->json($reporte);
    }
}
