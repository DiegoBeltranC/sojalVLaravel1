<?php

namespace App\Http\Controllers;

class CiudadanoController extends BaseUserController
{
    public function __construct()
    {
        $this->role = 'ciudadano';
    }
}
