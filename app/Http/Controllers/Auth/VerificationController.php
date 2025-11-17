<?php

/**
 * Controlador de Verificación de Email
 * Gestiona la verificación de correo electrónico de nuevos usuarios
 */

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\VerifiesEmails;

class VerificationController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Email Verification Controller
    |--------------------------------------------------------------------------
    |
    | Este controlador gestiona la verificación de email para usuarios que
    | se registraron recientemente. También permite reenviar el email de
    | verificación si el usuario no recibió el mensaje original.
    |
    */

    use VerifiesEmails;

    /**
     * Ruta de redirección después de verificar el email exitosamente
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::HOME;

    /**
     * Constructor del controlador
     * Aplica middleware de autenticación, firma y throttling
     */
    public function __construct()
    {
        // Requiere autenticación
        $this->middleware('auth');
        // Verifica que el enlace de verificación esté firmado
        $this->middleware('signed')->only('verify');
        // Limita intentos: máximo 6 intentos por minuto
        $this->middleware('throttle:6,1')->only('verify', 'resend');
    }
}
