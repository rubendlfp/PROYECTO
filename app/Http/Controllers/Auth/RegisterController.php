<?php

/**
 * Controlador de Registro
 * Gestiona el registro de nuevos usuarios, validación y creación de cuentas
 */

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use App\Models\User;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | Este controlador gestiona el registro de nuevos usuarios, incluyendo
    | la validación de los datos y la creación de cuentas. Usa el trait
    | RegistersUsers que proporciona toda la funcionalidad necesaria.
    |
    */

    use RegistersUsers;

    /**
     * Ruta de redirección después del registro exitoso
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::HOME;

    /**
     * Constructor del controlador
     * Solo usuarios no autenticados pueden registrarse
     */
    public function __construct()
    {
        // Middleware 'guest': solo usuarios no autenticados
        $this->middleware('guest');
    }

    /**
     * Valida los datos del formulario de registro
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        // Reglas de validación para el registro
        return Validator::make($data, [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);
    }

    /**
     * Crea un nuevo usuario después de una validación exitosa
     * Encripta la contraseña con Hash
     *
     * @param  array  $data
     * @return \App\Models\User
     */
    protected function create(array $data)
    {
        // Crea el usuario con los datos validados
        return User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']), // Encripta la contraseña
        ]);
    }
}
