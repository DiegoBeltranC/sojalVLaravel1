<?php

namespace App\Http\Controllers;

class TrabajadorController extends BaseUserController
{
    public function __construct()
    {
        $this->role = 'trabajador';
    }
}
