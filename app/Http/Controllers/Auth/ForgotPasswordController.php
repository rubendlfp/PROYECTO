<?php

/**
 * Controlador de Recuperación de Contraseña
 * Gestiona el envío de emails para restablecer contraseñas olvidadas
 */

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\SendsPasswordResetEmails;

class ForgotPasswordController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Password Reset Controller
    |--------------------------------------------------------------------------
    |
    | Este controlador gestiona el envío de emails de recuperación de contraseña.
    | Usa el trait SendsPasswordResetEmails que incluye toda la funcionalidad
    | necesaria para enviar notificaciones de restablecimiento de contraseña
    | desde la aplicación al usuario.
    |
    */

    use SendsPasswordResetEmails;
}
