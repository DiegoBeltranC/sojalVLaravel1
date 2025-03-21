<?php

namespace App\Http\Controllers\API;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Reporte;


class ReporteControllerApi extends Controller
{
    public function index()
    {
        $reporte = Reporte::all();
        return response()->json($reporte);
    }

    public function store(Request $request)
    {
        $rules = [
            'idUsuario' => 'required',
            'descripcion' => 'required',
            'longitud' => 'required',
            'latitud' => 'required',
            'idCalle' => 'required',
            'nombre' => 'required',
            'idColonia' => 'required',
            'colonia' => 'required',
            'status' => 'required',
            'conjunto' => 'required',
            'calle1' => 'required',
            'calle2' => 'required',
         ];
 
 
         $validated = $request->validate($rules);

         $idUsuario    = $request->idUsuario;
         $descripcion = $request->descripcion;
         //location
         $longitud = $request->longitud;
         $latitud = $request->latitud;

         //calles
         $idCalle = $request->idCalle;
         $nombre = $request->nombre;

         //colonias
         $idColonia = $request->idColonia;
         $colonia = $request->colonia;

         $status = $request->status;
         $conjunto = $request->conjunto;

         //cruzamientos
         $calle1 = $request->calle1;
         $calle2 = $request->calle2;

         
         

         $reportes = Reporte::create([
            'idUsuario' => $idUsuario,
            'descripcion' => $descripcion,
            'location' => [
                'longitud' => $longitud,
                'latitud' => $latitud
            ],
            'calles' => [array(
                'idCalle' => $idCalle,
                'nombre' => $nombre
                )   
            ],
            'colonias' => [
                'idColonia' => $idColonia,
                'colonia' => $colonia
            ],
            'status' => $status,
            'conjunto' => $conjunto,
            'cruzamientos' => [
                'calle1' => $calle1,
                'calle2' => $calle2,
            ]
        ]);

        return response()->json($reportes, 201);
    }

    public function show($id)
    {
        $reporte = Reporte::find($id);

        return response()->json([
            'data' => [
                'idUsuario'        => $reporte->idUsuario,
                'descripcion' => $reporte->descripcion,
                'location'      => $reporte->location,
                'calles'        => $reporte->calles,
                'colonias'        => $reporte->colonias,
                'status' => $reporte->status,
                'conjunto' => $reporte->conjunto,
                'cruzamientos' => $reporte->cruzamientos,
                'updated_at' => $reporte->updated_at,
                'created_at' => $reporte->created_at,
                'id' => $reporte->id

            ]
        ]);
    }

    public function update(Request $request, $id)
    {
        $reportes = Reporte::find($id);

        $rules = [
            'idUsuario' => 'required',
            'descripcion' => 'required',
            'longitud' => 'required',
            'latitud' => 'required',
            'idCalle' => 'required',
            'nombre' => 'required',
            'idColonia' => 'required',
            'colonia' => 'required',
            'status' => 'required',
            'conjunto' => 'required',
            'calle1' => 'required',
            'calle2' => 'required',
         ];
 
 
         $validated = $request->validate($rules);

         $idUsuario    = $request->idUsuario;
         $descripcion = $request->descripcion;
         //location
         $longitud = $request->longitud;
         $latitud = $request->latitud;

         //calles
         $idCalle = $request->idCalle;
         $nombre = $request->nombre;

         //colonias
         $idColonia = $request->idColonia;
         $colonia = $request->colonia;

         $status = $request->status;
         $conjunto = $request->conjunto;

         //cruzamientos
         $calle1 = $request->calle1;
         $calle2 = $request->calle2;

        $reportes->idUsuario = $idUsuario;       
        $reportes->descripcion = $descripcion;
        $reportes->location = ['longitud' => $longitud, 'latitud' => $latitud];
        $reportes->calles= ['idCalle'=>$idCalle,'nombre'=>$nombre];
        $reportes->colonias= ['idColonia'=>$idColonia,'colonia'=>$colonia];
        $reportes->status = $status;
        $reportes->conjunto = $conjunto;
        $reportes->cruzamientos= ['calle1'=>$calle1,'calle2'=>$calle2];



        $reportes->save();
        
        return response()->json($reportes);
    }

    public function destroy($id)
    {
        $reportes = Reporte::find($id);

        $reportes->delete();

        return response()->json(['success' => true, 'message' => ' eliminado correctamente']);
    }
}
