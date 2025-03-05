<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

abstract class BaseUserControllerAPI extends Controller
{
    // Esta propiedad se definirá en el controlador hijo (ej. 'ciudadano', 'trabajador', 'administrador')
    protected $role;

    /**
     * Devuelve todos los usuarios del rol especificado.
     */
    public function index()
    {
        $users = User::where('rol', $this->role)->get()->map(function ($user) {
            return [
                'id'        => (string)$user->_id,
                'nombre'    => $user->nombre,
                'apellidos' => $user->apellidos,
                'correo'    => $user->correo,
                'telefono'  => $user->telefono,
                // Agrega más campos si es necesario
            ];
        });
        return response()->json(['data' => $users]);
    }

    /**
     * Registra un nuevo usuario del rol especificado.
     */
    public function store(Request $request)
    {
        $rules = [
            'nombre'          => 'required|string|max:255',
            'apellidoP'       => 'required|string|max:255',
            'apellidoM'       => 'required|string|max:255',
            'fechaNacimiento' => 'required|date',
            'telefono'        => 'required|string|max:15',
            'correo'          => 'required|email|unique:users,correo',
        ];

        // Para trabajadores y administradores se requieren RFC y CURP
        if (in_array($this->role, ['trabajador', 'administrador'])) {
            $rules['curp'] = 'required|string|max:18|unique:users,curp';
            $rules['rfc']  = 'required|string|max:13|unique:users,rfc';
        }

        $validated = $request->validate($rules);

        // Sanitización y normalización de datos
        $nombre    = ucwords(strtolower(strip_tags($request->nombre)));
        $apellidoP = ucwords(strtolower(trim(strip_tags($request->apellidoP))));
        $apellidoM = ucwords(strtolower(trim(strip_tags($request->apellidoM))));
        $telefono  = trim(strip_tags($request->telefono));
        $correo    = trim(strip_tags($request->correo));
        $curp      = in_array($this->role, ['trabajador', 'administrador']) ? strtoupper(trim(strip_tags($request->curp))) : null;
        $rfc       = in_array($this->role, ['trabajador', 'administrador']) ? strtoupper(trim(strip_tags($request->rfc))) : null;

        $user = User::create([
            'nombre'           => $nombre,
            'apellidos'        => [
                'paterno' => $apellidoP,
                'materno' => $apellidoM,
            ],
            'fecha_nacimiento' => $request->fechaNacimiento,
            'telefono'         => $telefono,
            'correo'           => $correo,
            'password'         => Hash::make('123'), // Contraseña temporal
            'rol'              => $this->role,
            'curp'             => $curp,
            'rfc'              => $rfc,
            'fecha_creacion'   => now(),
        ]);

        return response()->json([
            'success' => true,
            'message' => ucfirst($this->role) . ' registrado exitosamente.',
            'data'    => $user
        ], 201);
    }

    /**
     * Muestra un usuario en específico.
     */
    public function show($id)
    {
        $user = User::find($id);

        if (!$user || $user->rol !== $this->role) {
            return response()->json(['error' => ucfirst($this->role) . ' no encontrado'], 404);
        }

        return response()->json([
            'data' => [
                'nombre'          => $user->nombre,
                'apellidoP'       => $user->apellidos['paterno'] ?? null,
                'apellidoM'       => $user->apellidos['materno'] ?? null,
                'fecha_nacimiento'=> $user->fecha_nacimiento,
                'telefono'        => $user->telefono,
                'correo'          => $user->correo,
                'rfc'             => $user->rfc,
                'curp'            => $user->curp,
            ]
        ]);
    }

    /**
     * Actualiza los datos de un usuario específico.
     */
    public function update(Request $request, $id)
    {
        $user = User::find($id);

        if (!$user || $user->rol !== $this->role) {
            return response()->json(['error' => ucfirst($this->role) . ' no encontrado'], 404);
        }

        $rules = [
            'nombre'          => 'required|string|max:255',
            'apellidoP'       => 'required|string|max:255',
            'apellidoM'       => 'required|string|max:255',
            'fechaNacimiento' => 'required|date',
            'telefono'        => 'required|string|max:15',
            'correo'          => 'required|email|unique:users,correo,' . $id,
        ];

        if (in_array($this->role, ['trabajador', 'administrador'])) {
            $rules['curp'] = 'required|string|max:18|unique:users,curp,' . $id;
            $rules['rfc']  = 'required|string|max:13|unique:users,rfc,' . $id;
        }

        $validated = $request->validate($rules);

        $nombre    = ucwords(strtolower(trim(strip_tags($request->nombre))));
        $apellidoP = ucwords(strtolower(trim(strip_tags($request->apellidoP))));
        $apellidoM = ucwords(strtolower(trim(strip_tags($request->apellidoM))));
        $telefono  = trim(strip_tags($request->telefono));
        $correo    = trim(strip_tags($request->correo));
        $curp      = in_array($this->role, ['trabajador', 'administrador']) ? strtoupper(trim(strip_tags($request->curp))) : null;
        $rfc       = in_array($this->role, ['trabajador', 'administrador']) ? strtoupper(trim(strip_tags($request->rfc))) : null;

        $user->nombre = $nombre;
        $user->apellidos = [
            'paterno' => $apellidoP,
            'materno' => $apellidoM,
        ];
        $user->fecha_nacimiento = $request->fechaNacimiento;
        $user->telefono = $telefono;
        $user->correo = $correo;
        $user->curp = $curp;
        $user->rfc = $rfc;

        $user->save();

        return response()->json([
            'success' => true,
            'message' => ucfirst($this->role) . ' actualizado correctamente.',
            'data'    => $user
        ]);
    }

    /**
     * Elimina un usuario en específico.
     */
    public function destroy($id)
    {
        $user = User::find($id);

        if (!$user || $user->rol !== $this->role) {
            return response()->json([
                'success' => false,
                'message' => ucfirst($this->role) . ' no encontrado'
            ], 404);
        }

        $user->delete();

        return response()->json([
            'success' => true,
            'message' => ucfirst($this->role) . ' eliminado correctamente'
        ]);
    }
}

