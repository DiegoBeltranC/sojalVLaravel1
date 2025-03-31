<?php

namespace App\Http\Controllers;
use App\Models\Configuracion;
use Illuminate\Http\Request;

class configuracionController extends Controller
{
    public function index()
    {
        return view('adminPages.configuracion');
    }
}