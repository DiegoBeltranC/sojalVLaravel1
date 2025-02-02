<?php

namespace App\Livewire;
use Illuminate\Support\Facades\Log;

use Livewire\Component;

use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class LoginForm extends Component
{
    public $correo;
    public $password;

    protected $rules = [
        'correo' => 'required|email',
        'password' => 'required|min:6',
    ];

// En App\Livewire\LoginForm

public function login()
{
    $this->validate();
    $user = User::where('correo', $this->correo)->first();
    // Verificar que el usuario fue encontrado y sus dato
    if ($user && $user->rol === 'admin' && Hash::check($this->password, $user->password)) {
        Auth::login($user);
        session()->flash('success', 'Inicio de sesión exitoso.');
        return redirect()->route('estadisticas');  // Redirigir a /estadisticas
    }

    $this->dispatch('loginError');
}




    public function render()
    {
        return view('livewire.login-form');
    }
}
