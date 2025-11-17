<?php

use App\Http\Controllers\adminController;
use App\Http\Controllers\carritoController;
use App\Http\Controllers\compraventaController;
use App\Http\Controllers\detalles_pedidoController;
use App\Http\Controllers\favoritosController;
use App\Http\Controllers\productoController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
 */

Route::get('/', function () {
    return view('principal');
})->name('principal');

// Alias para la ruta de inicio
Route::get('/inicio', function () {
    return view('principal');
})->name('inicio');

// --- RUTAS COMPRAR ---
Route::get('/comprar', [productoController::class, 'mostrarProductos'])->name('comprar');
Route::get('/comprarRopa', [productoController::class, 'mostrarRopaDeportiva'])->name('comprarRopa');
Route::get('/comprarCalzado', [productoController::class, 'mostrarCalzadoDeportivo'])->name('comprarCalzado');
Route::get('/comprarComplementos', [productoController::class, 'mostrarEquipamiento'])->name('comprarComplementos');
Route::get('/comprarHombre', [productoController::class, 'mostrarHombre'])->name('comprarHombre');
Route::get('/comprarMujer', [productoController::class, 'mostrarMujer'])->name('comprarMujer');
Route::get('/porducto/{id}', [productoController::class, 'mostrarProductoUnico'])->name('mostrarProductoUnico');
// --- FIN RUTAS COMPRAR ---

// --- RUTAS ADMINISTRAR ---
Route::group(['middleware' => ['auth', 'admin']], function () {
    // --- RUTA DE PRUEBA MIDDLEWARE ADMIN ---
    Route::get('/verificar-middleware-admin', function() {
        $user = auth()->user();
        return response()->json([
            'mensaje' => 'SUCCESS: Tienes acceso de administrador!',
            'usuario' => $user->name,
            'tipo_usuario' => $user->tipo_usuario,
            'timestamp' => now()
        ]);
    })->name('verificar-middleware-admin');
    
    Route::post('/borrarProd/{id}', [adminController::class, 'borrar'])->name('borrar');
    Route::get('/menuNuevo', [adminController::class, 'menuNuevo'])->name('menuNuevo');
    Route::POST('/nuevoProd', [adminController::class, 'nuevoProd'])->name('nuevoProd');
    Route::post('/editarProd/{id}', [adminController::class, 'menuEditar'])->name('menuEditar');
    Route::post('/confirmarCambios/{id}', [adminController::class, 'confirmarCambios'])->name('confirmarCambios');
    
    // --- RUTAS ADMINISTRAR COMPRAVENTA ---
    Route::get('/compraventa_administrar', [compraventaController::class, 'mostrarProductosCompraventa'])->name('compraventa_administrar');
    Route::get('/editarCompraventa/{id}', [compraventaController::class, 'editarCompraventa'])->name('editarCompraventa');
    Route::post('/actualizarCompraventa/{id}', [compraventaController::class, 'actualizarCompraventa'])->name('actualizarCompraventa');
    Route::post('/borrarCompraventa/{id}', [compraventaController::class, 'borrarProdCompraventa'])->name('borrarCompraventa');
    // --- FIN RUTAS ADMINISTRAR COMPRAVENTA ---

    // --- RUTAS ADMINISTRAR PEDIDOS ---
    Route::get('/administrar_pedidos', [detalles_pedidoController::class, 'administrarPedidos'])->name('administrarPedidos');
    Route::get('/pedido/{id}', [detalles_pedidoController::class, 'verDetallePedido'])->name('verDetallePedido');
    // --- FIN RUTAS ADMINISTRAR PEDIDOS ---
});
// --- FIN RUTAS ADMINISTRAR ---

// --- RUTAS NECESARIO LOGEARSE ---
Route::group(['middleware' => 'auth'], function () {
    // --- RUTA DE PRUEBA ADMIN ---
    Route::get('/verificar-admin', function() {
        $user = auth()->user();
        return response()->json([
            'id' => $user->id,
            'name' => $user->name,
            'email' => $user->email,
            'tipo_usuario' => $user->tipo_usuario,
            'es_admin' => $user->tipo_usuario == 1,
            'middleware_admin_ok' => 'Si ves esto, puedes acceder a rutas auth'
        ]);
    })->name('verificar-admin');
    
    // --- RUTAS CARRITO ---
    Route::get('/carritoCompra', [carritoController::class, 'mostrarProductoCarrito'])->name('mostrarProductoCarrito');
    Route::post('/guardarProductoCarrito', [carritoController::class, 'guardarProductoCarrito'])->name('guardarProductoCarrito');
    Route::post('/actualizarCantidad/{id}', [carritoController::class, 'actualizarCantidad'])->name('actualizarCantidad');
    Route::get('/eliminarProdCarrito', [carritoController::class, 'eliminarProdCarrito'])->name('eliminarProdCarrito');
    // --- FIN RUTAS CARRITO ---

    // --- RUTA ADMINISTRAR PRODUCTOS (ACCESIBLE DESDE MENÚ) ---
    Route::get('/administrar', [adminController::class, 'mostrarProductos'])->name('administrar');

    // --- RUTAS DETALLES PEDIDOS ---
    Route::get('/pagar/{precioTotal}', [detalles_pedidoController::class, 'mostrarDetallesPago'])->name('pagar');
    Route::post('/guardarDetallesPedido/{precioTotal}', [detalles_pedidoController::class, 'guardarDetallesPedido'])->name('guardarDetallesPedido');
    // --- FIN RUTAS DETALLES PEDIDOS ---

    // --- RUTAS FAVORITOS ---
    Route::get('/favoritos', [favoritosController::class, 'mostrarfavoritos'])->name('favoritos');
    Route::post('/añadirFavorito', [favoritosController::class, 'añadirFavorito'])->name('añadirFavorito');
    Route::post('/eliminarFavorito', [favoritosController::class, 'eliminarFavorito'])->name('eliminarFavorito');
    // --- FIN RUTAS FAVORITOS ---

    // --- RUTAS COMPRAVENTA ---
    Route::get('/compraventa', [compraventaController::class, 'mostrarCompraventa'])->name('compraventa');
    Route::get('/menuNuevoCompraventa', [compraventaController::class, 'menuNuevoCompraventa'])->name('menuNuevoCompraventa');
    Route::POST('/nuevoProdCompraventa', [compraventaController::class, 'nuevoProdCompraventa'])->name('nuevoProdCompraventa');
    Route::post('/productoCompraventa/{id}', [compraventaController::class, 'productoUnicoCompraventa'])->name('productoCompraventa');
    // --- FIN RUTAS COMPRAVENTA ---
});
// --- FIN RUTAS NECESARIO LOGEARSE ---

// --- OTRAS RUTAS ---
Route::get('/login', function () {
    return view('login');
});
Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
// --- FIN OTRAS RUTAS ---

Auth::routes();