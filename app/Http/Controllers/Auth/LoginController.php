<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\Auth;
use App\Models\User;


class LoginController extends Controller
{
    public function logout()
    {
        Auth::logout();  // Cierra la sesión

        return redirect()->route('login');  // Redirige a la ruta 'login'
    }

}
