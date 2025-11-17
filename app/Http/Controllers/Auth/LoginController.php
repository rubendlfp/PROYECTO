<?php

/**
 * Controlador de Login
 * Gestiona la autenticación de usuarios y el cierre de sesión
 */

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | Este controlador gestiona la autenticación de usuarios en la aplicación
    | y la redirección después del login. Usa el trait AuthenticatesUsers
    | que proporciona toda la funcionalidad de inicio de sesión.
    |
    */

    use AuthenticatesUsers;

    /**
     * Ruta de redirección después del login exitoso
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::HOME;

    /**
     * Constructor del controlador
     * Aplica middleware 'guest' excepto para logout
     */
    public function __construct()
    {
        // Solo usuarios no autenticados pueden acceder, excepto para cerrar sesión
        $this->middleware('guest')->except('logout');
    }
}
