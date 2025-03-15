<?php

namespace App\Http\Controllers;

use App\Models\Asignacion;
use App\Http\Controllers\TrabajadorController;
use Illuminate\Http\Request;

class AsignacionController extends Controller
{
    public function index()
    {
        return view('adminPages.asignacion');
    }

    public function data()
    {
        $asignaciones = Asignacion::get()->map(function ($asignacion) {
            return [
                'id'        => (string)$asignacion->_id,
                'idUsuario'    => (string)$asignacion->idUsuario,
                'idRuta' => (string)$asignacion->idRuta,
                'idCamion'    => (string)$asignacion->idCamion,
                'nombreUsuario'  => $asignacion->nombreUsuario,
                'apellidoPaterno'  => $asignacion->apellidoPaterno,
                'apellidoMaterno'  => $asignacion->apellidoMaterno,
                'nombreRuta' => $asignacion->nombreRuta,
                'placasCamion' =>$asignacion->placasCamion,
                'nombre' => $asignacion->nombre
                // Agrega más campos si lo requieres
            ];
        });
        return response()->json(['data' => $asignaciones]);
    }

    public function store(Request $request)
    {
        // Validamos que se hayan enviado los id correspondientes.

        $validatedData = $request->validate([
            'trabajador' => 'required',
            'camion'     => 'required',
            'ruta'       => 'required',
        ]);

        // Creamos la asignación asignando los valores de cada select a los campos correspondientes.
        // Nota: el modelo Asignacion, mediante su método boot, se encargará de buscar
        // la información del usuario, ruta y camión para asignar los datos redundantes y
        // construir el nombre en el formato "primerNombreUsuario-nombreRuta-placasCamion".

        $asignacion = Asignacion::create([
            'idUsuario' => $validatedData['trabajador'],
            'idRuta'    => $validatedData['ruta'],
            'idCamion'  => $validatedData['camion'],
        ]);

        // Se redirige a la página anterior con un mensaje de éxito.
        return redirect()->back()->with('asignacionGuardada', 'Asignación creada con éxito.');
    }
    public function show($id)
    {
        $asignacion = Asignacion::find($id);

        return response()->json([
                'id' => (string)$asignacion->_id,
                'nombreUsuario'  => $asignacion->nombreUsuario,
                'apellidoPaterno' => $asignacion->apellidoPaterno,
                'apellidoMaterno'  => $asignacion->apellidoMaterno,
                'telefono'  => $asignacion->telefono,
                'nombreRuta' => $asignacion->nombreRuta,
                'placasCamion' =>$asignacion->placasCamion,
                'nombre' => $asignacion->nombre,
                'idRuta' => $asignacion->idRuta,
                'idUsuario' => $asignacion->idUsuario,
                'idCamion' => $asignacion->idCamion
        ]);
    }

    public function update(Request $request, $id)
    {
        // Validamos que se hayan enviado los datos requeridos con los nombres del formulario de edición.
        $validatedData = $request->validate([
            'trabajadorEdit' => 'required',
            'camionEdit'     => 'required',
            'rutaEdit'       => 'required',
        ]);

        // Buscamos la asignación a actualizar usando el ID recibido.
        $asignacion = Asignacion::find($id);

        if (!$asignacion) {
            return redirect()->back()->with('error', 'Asignación no encontrada.');
        }

        // Actualizamos los campos correspondientes.
        $asignacion->idUsuario = $validatedData['trabajadorEdit'];
        $asignacion->idCamion  = $validatedData['camionEdit'];
        $asignacion->idRuta    = $validatedData['rutaEdit'];

        // Al guardar se ejecutará el método boot del modelo, que se encarga de actualizar los datos redundantes
        // y generar el nombre con el formato: "primerNombreUsuario-nombreRuta-placasCamion".
        $asignacion->save();

        return redirect()->back()->with('asignacionActualizada', 'Asignación actualizada con éxito.');
    }


    public function destroy($id)
    {
        $asignacion = Asignacion::find($id);


        $asignacion->delete();

        return response()->json(['success' => true, 'message' =>'Asignacion eliminada correctamente']);
    }

}
