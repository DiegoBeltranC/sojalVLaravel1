<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class configuracionController extends Controller
{
    public function index()
    {
        return view('adminPages.configuracion');
    }

}