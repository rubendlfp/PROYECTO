<?php

/**
 * Controlador de Restablecimiento de Contraseña
 * Gestiona el proceso de cambio de contraseña después del enlace de recuperación
 */

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\ResetsPasswords;

class ResetPasswordController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Password Reset Controller
    |--------------------------------------------------------------------------
    |
    | Este controlador gestiona las peticiones de restablecimiento de contraseña
    | después de que el usuario recibe el email de recuperación. Usa el trait
    | ResetsPasswords que proporciona toda la funcionalidad necesaria.
    |
    */

    use ResetsPasswords;

    /**
     * Ruta de redirección después de restablecer la contraseña exitosamente
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::HOME;
}
