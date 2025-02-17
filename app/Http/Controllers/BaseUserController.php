<?php

namespace App\Http\Controllers;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

abstract class BaseUserController extends Controller
{
    // Esta propiedad se definirá en el controlador hijo.
    protected $role;

    public function index()
    {
        if($this->role == 'ciudadano'){
            return view('adminPages.ciudadanos');
        }
        return view('adminPages.' . $this->role . 'es');
    }

    public function data()
    {
        $users = User::where('rol', $this->role)->get()->map(function ($user) {
            return [
                'id'        => (string)$user->_id,
                'nombre'    => $user->nombre,
                'apellidos' => $user->apellidos,
                'correo'    => $user->correo,
                'telefono'  => $user->telefono,
                // Agrega más campos si lo requieres
            ];
        });
        return response()->json(['data' => $users]);
    }

    public function store(Request $request)
    {
        session(['typeFormErrors' => 'store']);

        // Validación. Nota: si en algún caso (por ejemplo, en ciudadanos) no se requieren
        // ciertos campos, puedes ajustar la validación según el rol.
        $rules = [
            'nombre' => 'required|string|max:255|regex:/^[\pL\s\-]+$/u',
            'apellidoP' => 'required|string|max:255|regex:/^[\pL\s\-]+$/u',
            'apellidoM' => 'required|string|max:255|regex:/^[\pL\s\-]+$/u',
            'fechaNacimiento' => 'required|date',
            'telefono' => 'required|digits_between:8,15',
            'correo'        => 'required|email|unique:users,correo',
        ];

        // En este ejemplo, tanto trabajadores como administradores usan RFC y CURP.
        if (in_array($this->role, ['trabajador', 'administrador'])) {
            $rules['curp'] = 'required|string|max:18|unique:users,curp';
            $rules['rfc']  = 'required|string|max:13|unique:users,rfc';
        }

        $validated = $request->validate($rules);

        // Sanitizar y normalizar los datos
        $nombre    = ucwords(strtolower(strip_tags($request->nombre)));
        $apellidoP = ucwords(strtolower(trim(strip_tags($request->apellidoP))));
        $apellidoM = ucwords(strtolower(trim(strip_tags($request->apellidoM))));
        $telefono  = trim(strip_tags($request->telefono));
        $correo    = trim(strip_tags($request->correo));
        $curp      = in_array($this->role, ['trabajador', 'administrador']) ? strtoupper(trim(strip_tags($request->curp))) : null;
        $rfc       = in_array($this->role, ['trabajador', 'administrador']) ? strtoupper(trim(strip_tags($request->rfc))) : null;

        User::create([
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

        return redirect()->route('admin.' . $this->role . 'es.index')
        ->with($this->role . 'Guardado', ucfirst($this->role) . ' registrado exitosamente.');
    }

    public function show($id)
    {
        $user = User::find($id);

        if (!$user || $user->rol !== $this->role) {
            return response()->json(['error' => ucfirst($this->role) . ' no encontrado'], 404);
        }

        return response()->json([
            'data' => [
                'nombre'        => $user->nombre,
                'apellidoP'     => $user->apellidos['paterno'],
                'apellidoM'     => $user->apellidos['materno'],
                'fecha_nacimiento' => $user->fecha_nacimiento,
                'telefono'      => $user->telefono,
                'correo'        => $user->correo,
                'rfc'           => $user->rfc,
                'curp'          => $user->curp,
            ]
        ]);
    }

    public function update(Request $request, $id)
    {
        session(['typeFormErrors' => 'update']);

        $user = User::find($id);

        if (!$user || $user->rol !== $this->role) {
            return redirect()->back()->with('error', ucfirst($this->role) . ' no encontrado');
        }

        $rules = [
            'nombre' => 'required|string|max:255|regex:/^[\pL\s\-]+$/u',
            'apellidoP' => 'required|string|max:255|regex:/^[\pL\s\-]+$/u',
            'apellidoM' => 'required|string|max:255|regex:/^[\pL\s\-]+$/u',
            'fechaNacimiento' => 'required|date',
            'telefono' => 'required|digits_between:8,15',
            'correo'        => 'required|email|unique:users,correo,' . $id,
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
        if($user->rol== 'ciudadano' ){
            return redirect()->route('admin.ciudadanos.index')
            ->with($this->role . 'Actualizado', ucfirst($this->role) . ' actualizado correctamente.');
        }
        return redirect()->route('admin.' . $this->role . 'es.index')
                         ->with($this->role . 'Actualizado', ucfirst($this->role) . ' actualizado correctamente.');
    }

    public function destroy($id)
    {
        $user = User::find($id);

        if (!$user || $user->rol !== $this->role) {
            return response()->json(['success' => false, 'message' => ucfirst($this->role) . ' no encontrado'], 404);
        }

        $user->delete();

        return response()->json(['success' => true, 'message' => ucfirst($this->role) . ' eliminado correctamente']);
    }
}

