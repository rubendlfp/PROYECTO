<?php

namespace App\Http\Controllers;

use App\Models\detallesPedido;
use App\Models\User;
use App\Models\carritoCompra;
use Illuminate\Http\Request;

class detalles_pedidoController extends Controller
{
    public function mostrarDetallesPago($precioTotal)
    {
        return view('detalles_pedidos')->with('precioTotal', $precioTotal);
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

        $detalles_pedido = new detallesPedido();

        $id_user = auth()->user()->id;
        $detalles_pedido->id_user = $id_user;

        $detalles_pedido->precio_total = $precioTotal;

        $pais = $request->input('pais');
        $detalles_pedido->pais = $pais;

        $ciudad = $request->input('ciudad');
        $detalles_pedido->ciudad = $ciudad;

        $direccion = $request->input('direccion');
        $detalles_pedido->direccion = $direccion;

        $detalles_pedido->save();

        // Eliminar todos los artículos del carrito del usuario después del pago exitoso
        carritoCompra::where('id_user', $id_user)->delete();

        return view('agradecimiento');
    }

    /**
     * Mostrar todos los pedidos para administradores
     */
    public function administrarPedidos()
    {
        // Solo los administradores pueden ver todos los pedidos
        if (auth()->user()->tipo_usuario == 1) {
            $pedidos = detallesPedido::with('user')->orderBy('created_at', 'desc')->get();
        } else {
            // Los usuarios normales solo ven sus propios pedidos
            $pedidos = detallesPedido::where('id_user', auth()->user()->id)->orderBy('created_at', 'desc')->get();
        }

        return view('administrar.pedidos_administrar', ['pedidos' => $pedidos]);
    }

    /**
     * Ver detalles de un pedido específico
     */
    public function verDetallePedido($id)
    {
        $pedido = detallesPedido::with('user')->findOrFail($id);
        
        // Verificar permisos: admin puede ver todos, usuario solo sus propios pedidos
        if (auth()->user()->tipo_usuario != 1 && $pedido->id_user != auth()->user()->id) {
            abort(403, 'No tienes permisos para ver este pedido');
        }

        return view('administrar.detalle_pedido', ['pedido' => $pedido]);
    }
}