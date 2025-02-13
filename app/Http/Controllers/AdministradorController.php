<?php

namespace App\Http\Controllers;

class AdministradorController extends BaseUserController
{
    public function __construct()
    {
        // Define el rol específico para este controlador
        $this->role = 'administrador';
    }
}

