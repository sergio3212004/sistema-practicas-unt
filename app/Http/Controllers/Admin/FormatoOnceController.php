<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\FormatoOnce;
use Illuminate\Http\Request;

class FormatoOnceController extends Controller
{
    //
    public function index() {
        $formatos = FormatoOnce::all();
    }
}
