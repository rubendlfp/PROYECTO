<?php

namespace App\Http\Controllers;

use App\Models\carritoCompra;
use App\Models\producto;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class carritoController extends Controller
{
    public function guardarProductoCarrito(Request $request)
    {
        $request->validate([
            'id_producto' => 'required|exists:productos,id',
            'cantidad' => 'nullable|integer|min:1|max:10'
        ]);

        $userId = Auth::id();
        $productoId = $request->id_producto;
        $cantidad = $request->cantidad ?? 1;

        // Verificar si el producto ya está en el carrito
        $carritoExistente = carritoCompra::where('id_user', $userId)
            ->where('id_producto', $productoId)
            ->first();

        if ($carritoExistente) {
            // Si ya existe, incrementar la cantidad
            $carritoExistente->cantidad += $cantidad;
            $carritoExistente->save();
        } else {
            // Si no existe, crear nuevo registro
            carritoCompra::create([
                'id_user' => $userId,
                'id_producto' => $productoId,
                'cantidad' => $cantidad
            ]);
        }

        // Obtener el total de productos en el carrito
        $totalProductos = carritoCompra::where('id_user', $userId)->sum('cantidad');

        // Si es una petición AJAX, devolver JSON
        if ($request->ajax()) {
            return response()->json([
                'success' => true,
                'message' => 'Producto agregado al carrito',
                'totalProductos' => $totalProductos
            ]);
        }

        return redirect()->back()->with('success', 'Producto agregado al carrito');
    }

    public function mostrarProductoCarrito()
    {
        $userId = Auth::id();
        
        // Usar Eloquent relationships para obtener los datos del carrito
        $carrito = carritoCompra::with('producto')
            ->where('id_user', $userId)
            ->get();

        // Calcular el precio total
        $precioTotal = $carrito->sum(function($item) {
            return $item->producto->precio * $item->cantidad;
        });

        return view('carritoCompra')
            ->with('datosCarrito', $carrito)
            ->with('precioTotal', $precioTotal);
    }

    public function actualizarCantidad(Request $request, $id)
    {
        $request->validate([
            'cantidad' => 'required|integer|min:1|max:10'
        ]);

        $articulo = carritoCompra::where('id', $id)
            ->where('id_user', Auth::id())
            ->firstOrFail();

        $articulo->cantidad = $request->cantidad;
        $articulo->save();

        return redirect('/carritoCompra')->with('success', 'Cantidad actualizada');
    }

    public function eliminarProdCarrito(Request $request)
    {
        $request->validate([
            'id_borrar' => 'required|integer'
        ]);

        $id = $request->input('id_borrar');

        $articulo = carritoCompra::where('id', $id)
            ->where('id_user', Auth::id())
            ->firstOrFail();
            
        $articulo->delete();

        return redirect('/carritoCompra')->with('success', 'Producto eliminado del carrito');
    }
}