<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use App\Mail\UserCreatedMail;


abstract class BaseUserController extends Controller
{
    // Esta propiedad se definirá en el controlador hijo (por ejemplo, 'administrador')
    protected $role;

    public function index()
    {
        if ($this->role == 'ciudadano') {
            return view('adminPages.ciudadanos');
        }
        return view('adminPages.' . $this->role . 'es');
    }

    public function data()
    {
        $users = User::where('rol', $this->role)->get()->map(function ($user) {
            return [
                'id'              => (string)$user->_id,
                'nombre'          => $user->nombre,
                'apellidos'       => $user->apellidos,
                'correo'          => $user->correo,
                'telefono'        => $user->telefono,
                'profile_picture' => $user->profile_picture, // Se incluye para mostrar la imagen
            ];
        });
        return response()->json(['data' => $users]);
    }

    public function store(Request $request)
    {
        $rules = [
            'nombre'          => 'required|string|max:255',
            'apellidoP'       => 'required|string|max:255',
            'apellidoM'       => 'required|string|max:255',
            'fechaNacimiento' => 'required|date',
            'telefono'        => 'required|string|max:15',
            'correo'          => 'required|email|unique:users,correo',
            'profile_picture' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ];

        // Reglas adicionales para ciertos roles
        if (in_array($this->role, ['trabajador', 'administrador'])) {
            $rules['curp'] = 'required|string|max:18|unique:users,curp';
            $rules['rfc']  = 'required|string|max:13|unique:users,rfc';
        }

        $validated = $request->validate($rules);

        // Sanitizar y normalizar datos
        $nombre    = ucwords(strtolower(strip_tags($request->nombre)));
        $apellidoP = ucwords(strtolower(trim(strip_tags($request->apellidoP))));
        $apellidoM = ucwords(strtolower(trim(strip_tags($request->apellidoM))));
        $telefono  = trim(strip_tags($request->telefono));
        $correo    = trim(strip_tags($request->correo));
        $curp      = in_array($this->role, ['trabajador', 'administrador']) ? strtoupper(trim(strip_tags($request->curp))) : null;
        $rfc       = in_array($this->role, ['trabajador', 'administrador']) ? strtoupper(trim(strip_tags($request->rfc))) : null;

        // Procesar la imagen de perfil
        if ($request->hasFile('profile_picture')) {
            $imagen = $request->file('profile_picture');
            $nombreArchivo = time() . '_' . $imagen->getClientOriginalName();
            $ruta = $imagen->storeAs('imagenes_admin', $nombreArchivo, 'public');
        } else {
            $ruta = null;
        }

        // Define la contraseña temporal (o genera una aleatoria)
        $plainPassword = 'admin123';
        // Si prefieres generar una contraseña aleatoria, puedes usar:
        // $plainPassword = \Illuminate\Support\Str::random(8);

        // Crear el usuario y asignarlo a una variable
        $user = User::create([
            'nombre'           => $nombre,
            'apellidos'        => [
                'paterno' => $apellidoP,
                'materno' => $apellidoM,
            ],
            'fecha_nacimiento' => $request->fechaNacimiento,
            'telefono'         => $telefono,
            'correo'           => $correo,
            'password'         => Hash::make($plainPassword), // Almacena la contraseña de forma segura
            'rol'              => $this->role,
            'curp'             => $curp,
            'rfc'              => $rfc,
            'profile_picture'  => $ruta,
            'fecha_creacion'   => now(),
        ]);

        // Enviar el correo de verificación o bienvenida con las credenciales
        Mail::to($user->correo)->send(new UserCreatedMail($user, $plainPassword));

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
                'nombre'          => $user->nombre,
                'apellidoP'       => $user->apellidos['paterno'],
                'apellidoM'       => $user->apellidos['materno'],
                'fecha_nacimiento'=> $user->fecha_nacimiento,
                'telefono'        => $user->telefono,
                'correo'          => $user->correo,
                'rfc'             => $user->rfc,
                'curp'            => $user->curp,
                'profile_picture' => $user->profile_picture,
            ]
        ]);
    }

    public function update(Request $request, $id)
    {
        $user = User::find($id);

        if (!$user || $user->rol !== $this->role) {
            return redirect()->back()->with('error', ucfirst($this->role) . ' no encontrado');
        }

        $rules = [
            'nombre'          => 'required|string|max:255',
            'apellidoP'       => 'required|string|max:255',
            'apellidoM'       => 'required|string|max:255',
            'fechaNacimiento' => 'required|date',
            'telefono'        => 'required|string|max:15',
            'correo'          => 'required|email|unique:users,correo,' . $id,
            'profile_picture' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
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

        // Procesar la imagen de perfil si se actualiza
        if ($request->hasFile('profile_picture')) {
            $imagen = $request->file('profile_picture');
            $nombreArchivo = time() . '_' . $imagen->getClientOriginalName();
            $ruta = $imagen->storeAs('imagenes_admin', $nombreArchivo, 'public');
        } else {
            $ruta = $user->profile_picture;
        }

        $user->update([
            'nombre'           => $nombre,
            'apellidos'        => [
                'paterno' => $apellidoP,
                'materno' => $apellidoM,
            ],
            'fecha_nacimiento' => $request->fechaNacimiento,
            'telefono'         => $telefono,
            'correo'           => $correo,
            'curp'             => $curp,
            'rfc'              => $rfc,
            'profile_picture'  => $ruta,
        ]);

        if ($user->rol == 'ciudadano') {
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

