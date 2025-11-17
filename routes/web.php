<?php

/**
 * ========================================
 * ARCHIVO: Web Routes (web.php)
 * ========================================
 * 
 * Propósito: Define todas las rutas web de la aplicación Laravel
 * Middleware: Grupo 'web' (sesiones, CSRF, cookies, autenticación)
 * 
 * Estructura de rutas:
 * 1. Rutas públicas (sin autenticación)
 * 2. Rutas de administrador (middleware: auth + admin)
 * 3. Rutas de usuario autenticado (middleware: auth)
 * 4. Rutas de autenticación (Auth::routes())
 * 
 * Controladores utilizados:
 * - productoController: Catálogo de productos y filtros
 * - carritoController: Gestión del carrito de compras
 * - adminController: Panel de administración de productos
 * - compraventaController: Sistema de compraventa entre usuarios
 * - pedidosController: Proceso de pago y gestión de pedidos
 * - favoritosController: Lista de favoritos del usuario
 */

use App\Http\Controllers\adminController;
use App\Http\Controllers\carritoController;
use App\Http\Controllers\compraventaController;
use App\Http\Controllers\pedidosController;
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

/**
 * ========================================
 * RUTAS PÚBLICAS (Sin autenticación)
 * ========================================
 * Accesibles para cualquier visitante
 */

/**
 * Ruta raíz: Página principal
 * GET /
 * Vista: principal.blade.php (landing page con categorías)
 */
Route::get('/', function () {
    return view('principal');
})->name('principal');

/**
 * Alias de la ruta principal
 * GET /inicio
 * Vista: principal.blade.php
 */
Route::get('/inicio', function () {
    return view('principal');
})->name('inicio');

/**
 * ========================================
 * RUTAS DE PRODUCTOS (Catálogo público)
 * ========================================
 * Permiten navegar por el catálogo de productos sin necesidad de login
 */

/**
 * GET /comprar
 * Muestra todos los productos con filtros opcionales
 * Controlador: productoController@mostrarProductos
 * Parámetros GET opcionales: search, categoria, genero, marca
 */
Route::get('/comprar', [productoController::class, 'mostrarProductos'])->name('comprar');

/**
 * GET /comprarRopa
 * Filtra productos de la categoría "Ropa deportiva"
 * Controlador: productoController@mostrarRopaDeportiva
 */
Route::get('/comprarRopa', [productoController::class, 'mostrarRopaDeportiva'])->name('comprarRopa');

/**
 * GET /comprarCalzado
 * Filtra productos de la categoría "Calzado deportivo"
 * Controlador: productoController@mostrarCalzadoDeportivo
 */
Route::get('/comprarCalzado', [productoController::class, 'mostrarCalzadoDeportivo'])->name('comprarCalzado');

/**
 * GET /comprarComplementos
 * Filtra productos de la categoría "Equipamiento"
 * Controlador: productoController@mostrarEquipamiento
 */
Route::get('/comprarComplementos', [productoController::class, 'mostrarEquipamiento'])->name('comprarComplementos');

/**
 * GET /comprarHombre
 * Filtra productos para género masculino
 * Controlador: productoController@mostrarHombre
 */
Route::get('/comprarHombre', [productoController::class, 'mostrarHombre'])->name('comprarHombre');

/**
 * GET /comprarMujer
 * Filtra productos para género femenino
 * Controlador: productoController@mostrarMujer
 */
Route::get('/comprarMujer', [productoController::class, 'mostrarMujer'])->name('comprarMujer');

/**
 * GET /porducto/{id}
 * Muestra detalles de un producto específico (carrusel, precio, descripción)
 * Controlador: productoController@mostrarProductoUnico
 * Parámetro: {id} - ID del producto
 * Nota: Hay un typo en la URL ("porducto" en lugar de "producto")
 */
Route::get('/porducto/{id}', [productoController::class, 'mostrarProductoUnico'])->name('mostrarProductoUnico');

/**
 * ========================================
 * RUTAS DE ADMINISTRADOR
 * ========================================
 * Middleware: ['auth', 'admin']
 * Requiere: Usuario autenticado con tipo_usuario = 1
 * 
 * Funcionalidades:
 * - Gestión CRUD de productos (crear, editar, borrar)
 * - Administración de compraventa
 * - Visualización de pedidos de clientes
 */
Route::group(['middleware' => ['auth', 'admin']], function () {
    
    /**
     * --- RUTA DE PRUEBA MIDDLEWARE ADMIN ---
     * GET /verificar-middleware-admin
     * Verifica que el middleware 'admin' funcione correctamente
     * Retorna JSON con información del usuario administrador
     */
    Route::get('/verificar-middleware-admin', function() {
        $user = auth()->user();
        return response()->json([
            'mensaje' => 'SUCCESS: Tienes acceso de administrador!',
            'usuario' => $user->name,
            'tipo_usuario' => $user->tipo_usuario,
            'timestamp' => now()
        ]);
    })->name('verificar-middleware-admin');
    
    /**
     * --- GESTIÓN DE PRODUCTOS ---
     */
    
    /**
     * POST /borrarProd/{id}
     * Elimina un producto de la base de datos
     * Controlador: adminController@borrar
     * Parámetro: {id} - ID del producto a eliminar
     */
    Route::post('/borrarProd/{id}', [adminController::class, 'borrar'])->name('borrar');
    
    /**
     * GET /menuNuevo
     * Muestra el formulario para crear un nuevo producto
     * Controlador: adminController@menuNuevo
     */
    Route::get('/menuNuevo', [adminController::class, 'menuNuevo'])->name('menuNuevo');
    
    /**
     * POST /nuevoProd
     * Guarda un nuevo producto en la base de datos
     * Controlador: adminController@nuevoProd
     * Campos: titulo, descripcion, precio, tipo, genero, marca, imagen, stock, etc.
     */
    Route::POST('/nuevoProd', [adminController::class, 'nuevoProd'])->name('nuevoProd');
    
    /**
     * POST /editarProd/{id}
     * Muestra el formulario de edición de un producto
     * Controlador: adminController@menuEditar
     * Parámetro: {id} - ID del producto a editar
     */
    Route::post('/editarProd/{id}', [adminController::class, 'menuEditar'])->name('menuEditar');
    
    /**
     * POST /confirmarCambios/{id}
     * Actualiza los datos de un producto existente
     * Controlador: adminController@confirmarCambios
     * Parámetro: {id} - ID del producto a actualizar
     */
    Route::post('/confirmarCambios/{id}', [adminController::class, 'confirmarCambios'])->name('confirmarCambios');
    
    /**
     * --- ADMINISTRACIÓN DE COMPRAVENTA ---
     */
    
    /**
     * GET /compraventa_administrar
     * Muestra todos los productos de compraventa para gestión administrativa
     * Controlador: compraventaController@mostrarProductosCompraventa
     */
    Route::get('/compraventa_administrar', [compraventaController::class, 'mostrarProductosCompraventa'])->name('compraventa_administrar');
    
    /**
     * GET /editarCompraventa/{id}
     * Muestra el formulario de edición de un producto de compraventa
     * Controlador: compraventaController@editarCompraventa
     * Parámetro: {id} - ID del producto de compraventa
     */
    Route::get('/editarCompraventa/{id}', [compraventaController::class, 'editarCompraventa'])->name('editarCompraventa');
    
    /**
     * POST /actualizarCompraventa/{id}
     * Actualiza los datos de un producto de compraventa
     * Controlador: compraventaController@actualizarCompraventa
     * Parámetro: {id} - ID del producto de compraventa
     */
    Route::post('/actualizarCompraventa/{id}', [compraventaController::class, 'actualizarCompraventa'])->name('actualizarCompraventa');
    
    /**
     * POST /borrarCompraventa/{id}
     * Elimina un producto de compraventa
     * Controlador: compraventaController@borrarProdCompraventa
     * Parámetro: {id} - ID del producto de compraventa
     */
    Route::post('/borrarCompraventa/{id}', [compraventaController::class, 'borrarProdCompraventa'])->name('borrarCompraventa');

    /**
     * --- ADMINISTRACIÓN DE PEDIDOS ---
     */
    
    /**
     * GET /administrar_pedidos
     * Muestra listado de todos los pedidos realizados por clientes
     * Controlador: pedidosController@administrarPedidos
     */
    Route::get('/administrar_pedidos', [pedidosController::class, 'administrarPedidos'])->name('administrarPedidos');
    
    /**
     * GET /pedido/{id}
     * Muestra detalles completos de un pedido específico
     * Controlador: pedidosController@verDetallePedido
     * Parámetro: {id} - ID del pedido
     */
    Route::get('/pedido/{id}', [pedidosController::class, 'verDetallePedido'])->name('verDetallePedido');
});

/**
 * ========================================
 * RUTAS DE USUARIO AUTENTICADO
 * ========================================
 * Middleware: 'auth'
 * Requiere: Usuario autenticado (cualquier tipo_usuario)
 * 
 * Funcionalidades:
 * - Carrito de compras
 * - Favoritos
 * - Proceso de pago
 * - Compraventa (vender productos usados)
 * - Panel de administración (si es admin)
 */
Route::group(['middleware' => 'auth'], function () {
    
    /**
     * --- RUTA DE PRUEBA AUTH ---
     * GET /verificar-admin
     * Verifica que la autenticación funcione y muestra datos del usuario
     * Retorna JSON con información del usuario autenticado
     */
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
    
    /**
     * --- CARRITO DE COMPRAS ---
     */
    
    /**
     * GET /carritoCompra
     * Muestra el carrito de compras del usuario con productos y total
     * Controlador: carritoController@mostrarProductoCarrito
     */
    Route::get('/carritoCompra', [carritoController::class, 'mostrarProductoCarrito'])->name('mostrarProductoCarrito');
    
    /**
     * POST /guardarProductoCarrito
     * Añade un producto al carrito del usuario
     * Controlador: carritoController@guardarProductoCarrito
     * Campos: id_producto (cantidad default: 1)
     * Retorna: JSON con mensaje de éxito y totalProductos (para AJAX)
     */
    Route::post('/guardarProductoCarrito', [carritoController::class, 'guardarProductoCarrito'])->name('guardarProductoCarrito');
    
    /**
     * POST /actualizarCantidad/{id}
     * Actualiza la cantidad de un producto en el carrito
     * Controlador: carritoController@actualizarCantidad
     * Parámetro: {id} - ID del registro en carrito
     * Campos: cantidad (nuevo valor)
     */
    Route::post('/actualizarCantidad/{id}', [carritoController::class, 'actualizarCantidad'])->name('actualizarCantidad');
    
    /**
     * GET /eliminarProdCarrito
     * Elimina un producto del carrito
     * Controlador: carritoController@eliminarProdCarrito
     * Parámetro GET: id_producto
     */
    Route::get('/eliminarProdCarrito', [carritoController::class, 'eliminarProdCarrito'])->name('eliminarProdCarrito');

    /**
     * --- PANEL DE ADMINISTRACIÓN (acceso desde menú) ---
     */
    
    /**
     * GET /administrar
     * Muestra el panel de administración de productos (solo para admins)
     * Controlador: adminController@mostrarProductos
     * Nota: Aunque está en el grupo 'auth', el controlador debe validar tipo_usuario
     */
    Route::get('/administrar', [adminController::class, 'mostrarProductos'])->name('administrar');

    /**
     * --- PROCESO DE PAGO Y PEDIDOS ---
     */
    
    /**
     * GET /pagar/{precioTotal}
     * Muestra el formulario de detalles de pago (nombre, dirección, país, ciudad)
     * Controlador: pedidosController@mostrarDetallesPago
     * Parámetro: {precioTotal} - Total del carrito
     */
    Route::get('/pagar/{precioTotal}', [pedidosController::class, 'mostrarDetallesPago'])->name('pagar');
    
    /**
     * POST /guardarDetallesPedido/{precioTotal}
     * Procesa el pago, guarda el pedido y vacía el carrito
     * Controlador: pedidosController@guardarDetallesPedido
     * Parámetro: {precioTotal} - Total del pedido
     * Campos: nombre, direccion, pais, ciudad
     * Lógica: Verifica saldo, descuenta del usuario, guarda pedidos
     */
    Route::post('/guardarDetallesPedido/{precioTotal}', [pedidosController::class, 'guardarDetallesPedido'])->name('guardarDetallesPedido');

    /**
     * --- FAVORITOS ---
     */
    
    /**
     * GET /favoritos
     * Muestra la lista de productos favoritos del usuario
     * Controlador: favoritosController@mostrarfavoritos
     */
    Route::get('/favoritos', [favoritosController::class, 'mostrarfavoritos'])->name('favoritos');
    
    /**
     * POST /añadirFavorito
     * Añade un producto a la lista de favoritos
     * Controlador: favoritosController@añadirFavorito
     * Campos: id_producto
     */
    Route::post('/añadirFavorito', [favoritosController::class, 'añadirFavorito'])->name('añadirFavorito');
    
    /**
     * POST /eliminarFavorito
     * Elimina un producto de la lista de favoritos
     * Controlador: favoritosController@eliminarFavorito
     * Campos: id_producto
     */
    Route::post('/eliminarFavorito', [favoritosController::class, 'eliminarFavorito'])->name('eliminarFavorito');

    /**
     * --- COMPRAVENTA (Marketplace de productos usados) ---
     */
    
    /**
     * GET /compraventa
     * Muestra el marketplace de productos de compraventa entre usuarios
     * Controlador: compraventaController@mostrarCompraventa
     */
    Route::get('/compraventa', [compraventaController::class, 'mostrarCompraventa'])->name('compraventa');
    
    /**
     * GET /menuNuevoCompraventa
     * Muestra el formulario para publicar un nuevo producto de compraventa
     * Controlador: compraventaController@menuNuevoCompraventa
     */
    Route::get('/menuNuevoCompraventa', [compraventaController::class, 'menuNuevoCompraventa'])->name('menuNuevoCompraventa');
    
    /**
     * POST /nuevoProdCompraventa
     * Guarda un nuevo producto de compraventa en la base de datos
     * Controlador: compraventaController@nuevoProdCompraventa
     * Campos: titulo, descripcion, precio, imagen, estado, etc.
     */
    Route::POST('/nuevoProdCompraventa', [compraventaController::class, 'nuevoProdCompraventa'])->name('nuevoProdCompraventa');
    
    /**
     * POST /productoCompraventa/{id}
     * Muestra detalles de un producto específico de compraventa
     * Controlador: compraventaController@productoUnicoCompraventa
     * Parámetro: {id} - ID del producto de compraventa
     */
    Route::post('/productoCompraventa/{id}', [compraventaController::class, 'productoUnicoCompraventa'])->name('productoCompraventa');
});

/**
 * ========================================
 * RUTAS DE AUTENTICACIÓN Y USUARIO
 * ========================================
 */

/**
 * GET /login
 * Muestra el formulario de login
 * Vista: login.blade.php
 * Nota: Laravel también tiene una ruta /login generada por Auth::routes()
 */
Route::get('/login', function () {
    return view('login');
});

/**
 * GET /home
 * Muestra el dashboard/perfil del usuario autenticado
 * Controlador: HomeController@index
 * Middleware: 'auth' (aplicado en el constructor del controlador)
 */
Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

/**
 * Auth::routes()
 * Genera automáticamente las rutas de autenticación:
 * - GET/POST /login (iniciar sesión)
 * - POST /logout (cerrar sesión)
 * - GET/POST /register (registro de usuarios)
 * - GET/POST /password/reset (recuperación de contraseña)
 * - GET/POST /password/email (envío de email de recuperación)
 * - GET/POST /email/verify (verificación de email)
 */
Auth::routes();