<?php

namespace App\Http\Controllers;

use App\Models\DetallePedido;
use App\Models\User;
use App\Models\CarritoCompra;
use Illuminate\Http\Request;

class pedidosController extends Controller
{
    public function mostrarDetallesPago($precioTotal)
    {
        return view('comprar')->with('precioTotal', $precioTotal);
    }

    public function guardarDetallesPedido(Request $request, $precioTotal)
    {
        $id = auth()->user()->id;
        $usuario = User::find($id);

        $detallePedido = new DetallePedido();
        $detallePedido->user_id = $id;
        $detallePedido->nombre = $request->input('nombre');
        $detallePedido->apellidos = $request->input('apellidos');
        $detallePedido->direccion = $request->input('direccion');
        $detallePedido->codigo_postal = $request->input('codigo_postal');
        $detallePedido->provincia = $request->input('provincia');
        $detallePedido->localidad = $request->input('localidad');
        $detallePedido->telefono = $request->input('telefono');
        $detallePedido->precio_total = $precioTotal;
        $detallePedido->save();

        return redirect()->route('agradecimiento');
    }

    public function administrarPedidos()
    {
        $pedidos = DetallePedido::all();
        return view('detalles_pedidos')->with('pedidos', $pedidos);
    }

    public function verDetallePedido($id)
    {
        $pedido = DetallePedido::find($id);
        return view('detalle_pedido')->with('pedido', $pedido);
    }
}
