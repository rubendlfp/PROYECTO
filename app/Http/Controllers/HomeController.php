<?php

/**
 * Controlador Home
 * Gestiona el dashboard del usuario autenticado
 */

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Constructor del controlador
     * Aplica middleware 'auth' a todas las rutas
     */
    public function __construct()
    {
        // Requiere que el usuario esté autenticado
        $this->middleware('auth');
    }

    /**
     * Muestra el dashboard del usuario
     * Vista principal después del login
     */
    public function index()
    {
        return view('home');
    }
}
