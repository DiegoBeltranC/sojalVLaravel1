<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class TrabajadorController extends Controller
{
    public function index()
    {
        return view('adminPages.trabajadores');
    }

    public function data()
    {
        // Filtra los usuarios cuyo rol sea 'trabajador'
        $trabajadores = User::where('rol', 'trabajador')->get()->map(function($user) {
            return [
                // Convertimos el _id a string para facilitar su uso en la vista
                'id'       => (string)$user->_id,
                'nombre'   => $user->nombre,
                // Suponiendo que el campo 'apellidos' es un objeto con 'paterno' y 'materno'
                'apellidos'=> $user->apellidos,
                'correo'   => $user->correo,
                'telefono' => $user->telefono,
                // Agrega otros campos si lo requieres
            ];
        });

        return response()->json(['data' => $trabajadores]);
    }

    public function store(Request $request)
    {
        // Validar los datos (incluyendo la unicidad)
        $validated = $request->validate([
            'nombre' => 'required|string|max:255',
            'apellidoP' => 'required|string|max:255',
            'apellidoM' => 'required|string|max:255',
            'fechaNacimiento' => 'required|date',
            'telefono' => 'required|string|max:15',
            'correo' => 'required|email|unique:users,correo',
            'curp' => 'string|max:18|unique:users,curp',
            'rfc' => 'string|max:13|unique:users,rfc',
        ]);

        // Sanitizar y normalizar los datos
        $nombre = ucwords(strtolower(strip_tags($request->nombre)));
        $apellidoP = ucwords(strtolower(trim(strip_tags($request->apellidoP))));
        $apellidoM = ucwords(strtolower(trim(strip_tags($request->apellidoM))));
        $telefono = trim(strip_tags($request->telefono));
        $correo = trim(strip_tags($request->correo));
        $curp = $request->curp ? strtoupper(trim(strip_tags($request->curp))) : null;
        $rfc = $request->rfc ? strtoupper(trim(strip_tags($request->rfc))) : null;

        // Crear el trabajador
        User::create([
            'nombre' => $nombre,
            'apellidos' => [
                'paterno' => $apellidoP,
                'materno' => $apellidoM,
            ],
            'fecha_nacimiento' => $request->fechaNacimiento,
            'telefono' => $telefono,
            'correo' => $correo,
            'password' => Hash::make('123'), // Asigna una contraseña temporal
            'rol' => 'trabajador', // Asigna el rol correspondiente
            'curp' => $curp,
            'rfc' => $rfc,
            'fecha_creacion' => now(),
        ]);

        // Redirigir con mensaje de éxito
        return redirect()->route('admin.trabajadores.index')
                         ->with('trabajadorGuardado', 'Trabajador registrado exitosamente.');
    }


    public function destroy($id)
    {
        $trabajador = User::find($id);

        if (!$trabajador) {
            return response()->json(['success' => false, 'message' => 'Trabajador no encontrado'], 404);
        }

        $trabajador->delete();

        return response()->json(['success' => true, 'message' => 'Trabajador eliminado correctamente']);
    }

    public function show($id)  // Aquí tomamos el id desde la ruta
    {
        // Obtener los datos del trabajador por el ID
        $trabajador = User::find($id);

        // Si no se encuentra el trabajador, devolver un error
        if (!$trabajador) {
            return response()->json(['error' => 'Trabajador no encontrado'], 404);
        }

        // Devolver los datos en formato JSON
        return response()->json([
            'data' => [
                'nombre' => $trabajador->nombre,
                'apellidoP' => $trabajador->apellidos['paterno'],
                'apellidoM' => $trabajador->apellidos['materno'],
                'fecha_nacimiento' => $trabajador->fecha_nacimiento,
                'telefono' => $trabajador->telefono,
                'correo' => $trabajador->correo,
                'rfc' => $trabajador->rfc,
                'curp' => $trabajador->curp,
            ]
        ]);
    }
    public function update(Request $request, $id)
    {
        // Buscar el trabajador por ID
        $trabajador = User::find($id);
        if (!$trabajador) {
            return redirect()->back()->with('error', 'Trabajador no encontrado');
        }

        // Validar los datos recibidos (para los campos únicos se excluye el registro actual)
        $validated = $request->validate([
            'nombre' => 'required|string|max:255',
            'apellidoP' => 'required|string|max:255',
            'apellidoM' => 'required|string|max:255',
            'fechaNacimiento' => 'required|date',
            'telefono' => 'required|string|max:15',
            'correo' => 'required|email|unique:users,correo,' . $id,
            'curp' => 'nullable|string|max:18|unique:users,curp,' . $id,
            'rfc' => 'nullable|string|max:13|unique:users,rfc,' . $id,
        ]);

        // Sanitizar y normalizar los datos (aplicando las mismas transformaciones que en store)
        $nombre = ucwords(strtolower(trim(strip_tags($request->nombre))));
        $apellidoP = ucwords(strtolower(trim(strip_tags($request->apellidoP))));
        $apellidoM = ucwords(strtolower(trim(strip_tags($request->apellidoM))));
        $telefono = trim(strip_tags($request->telefono));
        $correo = trim(strip_tags($request->correo));
        $curp = $request->curp ? strtoupper(trim(strip_tags($request->curp))) : null;
        $rfc = $request->rfc ? strtoupper(trim(strip_tags($request->rfc))) : null;

        // Actualizar el trabajador con los datos sanitizados
        $trabajador->nombre = $nombre;
        $trabajador->apellidos = [
            'paterno' => $apellidoP,
            'materno' => $apellidoM,
        ];
        // Asegúrate de que el nombre del campo en la base de datos sea consistente. Por ejemplo:
        $trabajador->fecha_nacimiento = $request->fechaNacimiento;
        $trabajador->telefono = $telefono;
        $trabajador->correo = $correo;
        $trabajador->curp = $curp;
        $trabajador->rfc = $rfc;

        // Guardar los cambios
        $trabajador->save();

        // Redirigir a la lista de trabajadores con un mensaje de éxito
        return redirect()->route('admin.trabajadores.index')
                         ->with('trabajadorActualizado', 'Trabajador actualizado correctamente.');
    }



}
