<?php

/**
 * ========================================
 * ARCHIVO: API Routes (api.php)
 * ========================================
 * 
 * Propósito: Define las rutas de la API REST de la aplicación
 * Prefijo: Todas las rutas tienen el prefijo '/api' automáticamente
 * Middleware: Las rutas están en el grupo 'api' middleware por defecto
 * 
 * Funcionamiento:
 * - Rutas accesibles vía HTTP (GET, POST, PUT, DELETE, etc.)
 * - URL de ejemplo: http://dominio.com/api/user
 * - Respuestas en formato JSON para consumo por clientes API
 * - Autenticación vía Laravel Sanctum (tokens de API)
 * 
 * Nota: A diferencia de routes/web.php, estas rutas no tienen:
 *   - Sesiones web
 *   - Protección CSRF (usan tokens de API en su lugar)
 *   - Middleware 'web' por defecto
 */

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

/**
 * ========================================
 * RUTA: Obtener Usuario Autenticado
 * ========================================
 * 
 * Método: GET
 * URL: /api/user
 * Middleware: auth:sanctum (requiere autenticación con Laravel Sanctum)
 * 
 * Descripción:
 * Devuelve la información del usuario actualmente autenticado
 * mediante un token de API de Sanctum.
 * 
 * Uso:
 * - El cliente debe enviar el token en el header: Authorization: Bearer {token}
 * - Sanctum valida el token y carga el usuario asociado
 * - La respuesta incluye todos los datos del modelo User
 * 
 * Respuesta exitosa (200):
 * {
 *   "id": 1,
 *   "name": "Juan Pérez",
 *   "email": "juan@example.com",
 *   "tipo_usuario": 0,
 *   "saldo": 1000.00,
 *   ...
 * }
 * 
 * Error (401 Unauthorized):
 * {
 *   "message": "Unauthenticated."
 * }
 */
Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    // $request->user() retorna el modelo User autenticado vía Sanctum
    return $request->user();
});

/**
 * ========================================
 * RUTAS ADICIONALES DE LA API
 * ========================================
 * 
 * Aquí puedes agregar más rutas de API según las necesidades de la aplicación:
 * 
 * Ejemplos:
 * 
 * // Obtener lista de productos
 * Route::get('/productos', [ProductoController::class, 'apiIndex']);
 * 
 * // Obtener un producto específico
 * Route::get('/productos/{id}', [ProductoController::class, 'apiShow']);
 * 
 * // Rutas protegidas con autenticación
 * Route::middleware('auth:sanctum')->group(function () {
 *     Route::get('/carrito', [CarritoController::class, 'apiIndex']);
 *     Route::post('/carrito', [CarritoController::class, 'apiStore']);
 *     Route::delete('/carrito/{id}', [CarritoController::class, 'apiDestroy']);
 * });
 * 
 * // Rutas solo para administradores
 * Route::middleware(['auth:sanctum', 'admin'])->group(function () {
 *     Route::post('/productos', [ProductoController::class, 'apiStore']);
 *     Route::put('/productos/{id}', [ProductoController::class, 'apiUpdate']);
 *     Route::delete('/productos/{id}', [ProductoController::class, 'apiDestroy']);
 * });
 */
