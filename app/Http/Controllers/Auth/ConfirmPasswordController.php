<?php

/**
 * Controlador de Confirmación de Contraseña
 * Gestiona la confirmación de contraseña para operaciones sensibles
 */

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\ConfirmsPasswords;

class ConfirmPasswordController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Confirm Password Controller
    |--------------------------------------------------------------------------
    |
    | Este controlador gestiona la confirmación de contraseña para acciones
    | sensibles. Usa el trait ConfirmsPasswords que incluye la funcionalidad
    | básica. Puedes sobrescribir los métodos del trait si necesitas
    | personalizar el comportamiento.
    |
    */

    use ConfirmsPasswords;

    /**
     * Ruta de redirección cuando la URL prevista falla
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::HOME;

    /**
     * Constructor del controlador
     * Requiere que el usuario esté autenticado
     */
    public function __construct()
    {
        // Solo usuarios autenticados pueden confirmar su contraseña
        $this->middleware('auth');
    }
}
