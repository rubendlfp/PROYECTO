<?php

/**
 * ========================================
 * CONTROLADOR: carritoController
 * ========================================
 * 
 * Propósito: Gestionar el carrito de compras del usuario
 * 
 * Responsabilidades:
 * - Añadir productos al carrito (con soporte AJAX)
 * - Mostrar contenido del carrito con precio total
 * - Actualizar cantidades de productos
 * - Eliminar productos del carrito
 * - Calcular totales automáticamente
 * 
 * Vistas utilizadas:
 * - carritoCompra.blade.php (listado del carrito con productos y total)
 * 
 * Modelos utilizados:
 * - CarritoCompra (tabla: carrito)
 * - Producto (relación con CarritoCompra)
 * 
 * Seguridad:
 * - Todos los métodos requieren autenticación (middleware 'auth' en routes/web.php)
 * - Las operaciones están limitadas al usuario autenticado (Auth::id())
 * - Validación de datos en todos los métodos
 */

namespace App\Http\Controllers;

use App\Models\CarritoCompra;
use App\Models\Producto;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class carritoController extends Controller
{
    /**
     * ========================================
     * MÉTODO: guardarProductoCarrito
     * ========================================
     * 
     * Ruta: POST /guardarProductoCarrito
     * Middleware: auth
     * 
     * Descripción:
     * Añade un producto al carrito del usuario autenticado.
     * Si el producto ya existe en el carrito, incrementa su cantidad.
     * Soporta peticiones AJAX para actualización dinámica del contador.
     * 
     * Validación:
     * @param int $id_producto - (required) ID del producto, debe existir en tabla productos
     * @param int $cantidad - (optional) Cantidad a añadir, entre 1-10, default: 1
     * 
     * Lógica:
     * 1. Valida los datos de entrada
     * 2. Verifica si el producto ya está en el carrito del usuario
     * 3. Si existe: incrementa la cantidad
     * 4. Si no existe: crea un nuevo registro
     * 5. Calcula el total de productos en el carrito
     * 
     * Respuestas:
     * - AJAX: JSON con { success, message, totalProductos }
     * - Normal: Redirect back con mensaje de éxito
     * 
     * Uso desde JavaScript:
     * El método producto.blade.php usa AJAX para actualizar el contador
     * del carrito en el navbar sin recargar la página.
     */
    public function guardarProductoCarrito(Request $request)
    {
        // === VALIDACIÓN DE DATOS ===
        $request->validate([
            'id_producto' => 'required|exists:productos,id', // Debe existir en BD
            'cantidad' => 'nullable|integer|min:1|max:10'    // Límite de 10 unidades
        ]);

        // Obtiene el ID del usuario autenticado
        $userId = Auth::id();
        $productoId = $request->id_producto;
        $cantidad = $request->cantidad ?? 1; // Default: 1 unidad

        // === VERIFICAR SI YA EXISTE EN EL CARRITO ===
        $carritoExistente = CarritoCompra::where('id_user', $userId)
            ->where('id_producto', $productoId)
            ->first();

        if ($carritoExistente) {
            // Si ya existe, incrementar la cantidad
            $carritoExistente->cantidad += $cantidad;
            $carritoExistente->save();
        } else {
            // Si no existe, crear nuevo registro en carrito
            CarritoCompra::create([
                'id_user' => $userId,
                'id_producto' => $productoId,
                'cantidad' => $cantidad
            ]);
        }

        // === CALCULAR TOTAL DE PRODUCTOS ===
        // Suma todas las cantidades del carrito (para el badge del navbar)
        $totalProductos = CarritoCompra::where('id_user', $userId)->sum('cantidad');

        // === RESPUESTA SEGÚN TIPO DE PETICIÓN ===
        // Si es AJAX (desde producto.blade.php), devolver JSON
        if ($request->ajax()) {
            return response()->json([
                'success' => true,
                'message' => 'Producto agregado al carrito',
                'totalProductos' => $totalProductos // Para actualizar badge
            ]);
        }

        // Si es petición normal, redirigir con mensaje flash
        return redirect()->back()->with('success', 'Producto agregado al carrito');
    }

    /**
     * ========================================
     * MÉTODO: mostrarProductoCarrito
     * ========================================
     * 
     * Ruta: GET /carritoCompra
     * Vista: carritoCompra.blade.php
     * Middleware: auth
     * 
     * Descripción:
     * Muestra el contenido completo del carrito de compras del usuario.
     * Incluye imagen, título, precio unitario, cantidad y subtotal de cada producto.
     * Calcula el precio total de todos los productos.
     * 
     * Variables enviadas a la vista:
     * @return Collection $datosCarrito - Carrito con relación 'producto' cargada (eager loading)
     *   Cada item incluye:
     *   - id (carrito.id)
     *   - cantidad
     *   - producto (objeto completo: titulo, precio, img1, etc.)
     * 
     * @return float $precioTotal - Suma total: (precio × cantidad) de todos los items
     * 
     * Cálculo del total:
     * Usa la función sum() con callback para multiplicar precio × cantidad de cada item.
     */
    public function mostrarProductoCarrito()
    {
        // ID del usuario autenticado
        $userId = Auth::id();
        
        // === OBTENER CARRITO CON PRODUCTOS (EAGER LOADING) ===
        // with('producto') carga la relación para evitar N+1 queries
        $carrito = CarritoCompra::with('producto')
            ->where('id_user', $userId)
            ->get();

        // === CALCULAR PRECIO TOTAL ===
        // Sum con callback: multiplica precio × cantidad de cada item
        $precioTotal = $carrito->sum(function($item) {
            return $item->producto->precio * $item->cantidad;
        });

        // Retorna vista con los datos del carrito y el total
        return view('carritoCompra')
            ->with('datosCarrito', $carrito)
            ->with('precioTotal', $precioTotal);
    }

    /**
     * ========================================
     * MÉTODO: actualizarCantidad
     * ========================================
     * 
     * Ruta: POST /actualizarCantidad/{id}
     * Middleware: auth
     * 
     * Descripción:
     * Actualiza la cantidad de un producto específico en el carrito.
     * Usado desde los inputs numéricos en carritoCompra.blade.php.
     * 
     * Validación:
     * @param int $cantidad - (required) Nueva cantidad, entre 1-10
     * 
     * Parámetros de ruta:
     * @param int $id - ID del registro en tabla carrito (no id_producto)
     * 
     * Seguridad:
     * Verifica que el registro pertenezca al usuario autenticado (where id_user).
     * Usa firstOrFail() para lanzar 404 si no existe o no pertenece al usuario.
     * 
     * @return Redirect a /carritoCompra con mensaje de éxito
     */
    public function actualizarCantidad(Request $request, $id)
    {
        // === VALIDACIÓN ===
        $request->validate([
            'cantidad' => 'required|integer|min:1|max:10' // Límite de 10 unidades
        ]);

        // === BUSCAR REGISTRO DEL CARRITO ===
        // Verifica que pertenezca al usuario actual
        $articulo = CarritoCompra::where('id', $id)
            ->where('id_user', Auth::id())
            ->firstOrFail(); // 404 si no existe o no es del usuario

        // Actualiza la cantidad
        $articulo->cantidad = $request->cantidad;
        $articulo->save();

        // Redirige al carrito con mensaje de confirmación
        return redirect('/carritoCompra')->with('success', 'Cantidad actualizada');
    }

    /**
     * ========================================
     * MÉTODO: eliminarProdCarrito
     * ========================================
     * 
     * Ruta: GET /eliminarProdCarrito
     * Middleware: auth
     * 
     * Descripción:
     * Elimina un producto del carrito de compras.
     * Usado desde los botones de "Eliminar" en carritoCompra.blade.php.
     * 
     * Validación:
     * @param int $id_borrar - (required) ID del registro en carrito
     * 
     * Parámetros GET:
     * ?id_borrar=123
     * 
     * Seguridad:
     * Verifica que el registro pertenezca al usuario autenticado.
     * Usa firstOrFail() para proteger contra acceso no autorizado.
     * 
     * @return Redirect a /carritoCompra con mensaje de éxito
     * 
     * Nota: Considera cambiar a método DELETE en lugar de GET para seguir
     * las convenciones RESTful.
     */
    public function eliminarProdCarrito(Request $request)
    {
        // === VALIDACIÓN ===
        $request->validate([
            'id_borrar' => 'required|integer'
        ]);

        // Obtiene el ID del parámetro GET
        $id = $request->input('id_borrar');

        // === BUSCAR Y VERIFICAR PROPIEDAD ===
        $articulo = CarritoCompra::where('id', $id)
            ->where('id_user', Auth::id()) // Solo del usuario actual
            ->firstOrFail(); // 404 si no existe o no es del usuario
            
        // Elimina el registro
        $articulo->delete();

        // Redirige al carrito con mensaje de confirmación
        return redirect('/carritoCompra')->with('success', 'Producto eliminado del carrito');
    }
}