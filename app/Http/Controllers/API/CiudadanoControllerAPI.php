<?php

namespace App\Http\Controllers\API;


class CiudadanoControllerAPI extends BaseUserControllerAPI
{
    public function __construct()
    {
        $this->role = 'ciudadano';
    }
}


