<?php

namespace App\Livewire;

use Livewire\Component;

class LoginForm extends Component
{
    public $correo;
    public $password;

    protected $rules = [
        'correo' => 'required|email',
        'password' => 'required|min:6',
    ];

    public function render()
    {
        return view('livewire.login-form');
    }
}
