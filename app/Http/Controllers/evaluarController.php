<?php

namespace App\Http\Controllers;

use MongoDB\BSON\ObjectId;
use Illuminate\Http\Request;
use App\Models\Reporte;
use App\Models\Asignacion;
use App\Models\User;
use Illuminate\Support\Facades\Mail;
use App\Mail\RechazoReporte;

class evaluarController extends Controller
{
    public function index()
    {
        return view('adminPages.evaluar');
    }

    public function store(Request $request){
        // Validar que se haya seleccionado una asignación

        // Buscar el reporte por ID
        $reporte = Reporte::findOrFail($request->idReporte);

        // Convertir el valor recibido a ObjectId y asignarlo al campo 'conjunto'
        $reporte->conjunto = new ObjectId($request->asignacion);

        // Cambiar el estado a "asignado"
        $reporte->status = 'asignado';

        // Guardar cambios
        $reporte->save();

        return redirect()->route('admin.evaluar.index')
                         ->with('reporteAsignado', 'Reporte asignado correctamente.');
    }


    public function cambiarProgreso($id){
        $reporte = Reporte::findOrFail($id);
        $reporte->status = 'enProgreso';
        $reporte->save();
        return response()->json(['success' => true, 'message' => 'Reporte en progreso correctamente.']);
    }

    public function destroy($idReporte){
        $reporte = Reporte::findOrFail($idReporte);
        $reporte->status = 'rechazado';
        $reporte->fechaRechazado = now(); // Agregamos la fecha y hora actual
        $reporte->save();

        return response()->json(['success' => true, 'message' => 'Reporte rechazado correctamente.']);
    }

    public function finalizarReporte($idReporte){
        $reporte = Reporte::findOrFail($idReporte);
        $reporte->fechaFinalizado = now();
        $reporte->status = 'finalizado';
        $reporte->save();
        return response()->json(['success' => true, 'message' => 'Reporte finalizado correctamente.']);
    }

    public function enviarCorreoRechazo(Request $request)
    {
        // Obtener el id del reporte y el motivo del formulario
        $idReporte = $request->input('idFormRechazo');
        $motivo = $request->input('motivo');

        // Buscar el reporte y obtener al usuario
        $reporte = Reporte::findOrFail($idReporte);
        $usuario = User::findOrFail($reporte->idUsuario);
        $correo = $usuario->correo;
        
        // Enviar el correo
        Mail::to($correo)->send(new RechazoReporte($motivo, $reporte));
        return redirect()->route('admin.evaluar.index')
                         ->with('formRechazado', 'Reporte rechazado correctamente.');
    }
}
