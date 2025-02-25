<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class noticiasController extends Controller
{
    public function index()
    {
        return view('adminPages.noticias');
    }

}

