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
    try {
        $this->validate(); // Realiza la validación

        $user = User::where('correo', $this->correo)->first();

        if ($user && $user->rol === 'admin' && Hash::check($this->password, $user->password)) {
            Auth::login($user);

            return redirect()->to(route('admin.estadisticas'));
        }
            session()->flash('error', 'Credenciales incorrectas o no eres admin.');
            $this->dispatch('loginError'); // Emitir evento si las credenciales no son correctas
    } catch (\Illuminate\Validation\ValidationException $e) {
        $this->dispatch('loginError'); // Emitir evento si falla la validación
        throw $e;
    }
}





    public function render()
    {
        return view('livewire.login-form');
    }
}
