<?php

namespace App\Http\Controllers;

use App\Models\DetallePedido;
use App\Models\User;
use App\Models\CarritoCompra;
use Illuminate\Http\Request;

class detalles_pedidoController extends Controller
{
    public function mostrarDetallesPago($precioTotal)
    {
        return view('pedidoss')->with('precioTotal', $precioTotal);
    }

    public function guardarDetallesPedido(Request $request, $precioTotal)
    {
        $id = auth()->user()->id;
        $usuario = User::find($id);

        if ($usuario->saldo <= $precioTotal) {
            return view('error_saldo');
        }

        $usuario->saldo = $usuario->saldo - $precioTotal;

        $usuario->save();

        $pedidos = new DetallePedido();

        $id_user = auth()->user()->id;
        $pedidos->id_user = $id_user;

        $pedidos->precio_total = $precioTotal;

        $pais = $request->input('pais');
        $pedidos->pais = $pais;

        $ciudad = $request->input('ciudad');
        $pedidos->ciudad = $ciudad;

        $direccion = $request->input('direccion');
        $pedidos->direccion = $direccion;

        $pedidos->save();

        // Eliminar todos los artículos del carrito del usuario después del pago exitoso
        CarritoCompra::where('id_user', $id_user)->delete();

        return view('agradecimiento');
    }

    /**
     * Mostrar todos los pedidos para administradores
     */
    public function administrarPedidos()
    {
        // Solo los administradores pueden ver todos los pedidos
        if (auth()->user()->tipo_usuario == 1) {
            $pedidos = DetallePedido::with('user')->orderBy('created_at', 'desc')->get();
        } else {
            // Los usuarios normales solo ven sus propios pedidos
            $pedidos = DetallePedido::where('id_user', auth()->user()->id)->orderBy('created_at', 'desc')->get();
        }

        return view('administrar.pedidos_administrar', ['pedidos' => $pedidos]);
    }

    /**
     * Ver detalles de un pedido específico
     */
    public function verDetallePedido($id)
    {
        $pedido = DetallePedido::with('user')->findOrFail($id);
        
        // Verificar permisos: admin puede ver todos, usuario solo sus propios pedidos
        if (auth()->user()->tipo_usuario != 1 && $pedido->id_user != auth()->user()->id) {
            abort(403, 'No tienes permisos para ver este pedido');
        }

        return view('administrar.detalle_pedido', ['pedido' => $pedido]);
    }
}