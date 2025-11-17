<?php

namespace App\Http\Controllers;

use App\Models\compraventa;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class compraventaController extends Controller
{
    public function mostrarCompraventa()
    {
        $listaProductos = compraventa::all();

        return view('compraventa/compraventa', ['datosCompraventa' => $listaProductos]);
    }

    public function mostrarProductosCompraventa()
    {
        // Si es administrador (tipo_usuario = 1), mostrar todos los productos con información del propietario
        // Si es usuario normal, solo mostrar sus productos
        if (auth()->user()->tipo_usuario == 1) {
            $listaProductos = compraventa::with('user')->get();
        } else {
            $listaProductos = compraventa::where('id_user', auth()->user()->id)->get();
        }

        return view('compraventa/compraventa_administrar', ['datosCompraventa' => $listaProductos]);
    }

    public function menuNuevoCompraventa()
    {
        return view('compraventa/nuevoProdCompraventa');
    }

    public function nuevoProdCompraventa(Request $request)
    {
        $producto_compraventa = new compraventa;

        $id_user = auth()->user()->id;
        $producto_compraventa->id_user = $id_user;

        if ($request->hasFile('nueva_imagen')) {
            $file = $request->file("nueva_imagen");
            $nombre = bin2hex(random_bytes(5)) . "." . $file->guessExtension();
            $ruta = "img/compraventa/" . $nombre;
            $destino = public_path($ruta);

            copy($file, $destino);
            $producto_compraventa->imagen = $ruta;
        }

        $nombre_producto = $request->nombre_producto;
        $producto_compraventa->nombre_producto = $nombre_producto;

        $descripcion_producto = $request->descripcion_producto;
        $producto_compraventa->descripcion_producto = $descripcion_producto;

        $precio = $request->precio;
        $producto_compraventa->precio = $precio;

        $contacto = $request->contacto;
        $producto_compraventa->contacto = $contacto;

        $producto_compraventa->save();

        // Redirigir de vuelta a la página de administración usando el método correcto
        return redirect()->route('compraventa_administrar')->with('success', 'Producto creado exitosamente');
    }

    public function productoUnicoCompraventa($id)
    {
        $producto = compraventa::find($id);
        return view('compraventa/productoCompraventa', ["producto" => $producto]);
    }

    public function borrarProdCompraventa($id)
    {
        $producto = compraventa::find($id);
        
        if ($producto) {
            $producto->delete();
        }

        return redirect()->route('compraventa_administrar')->with('success', 'Producto eliminado exitosamente');
    }

    public function editarCompraventa($id)
    {
        $producto = compraventa::find($id);
        return view('compraventa/editarCompraventa', ["producto" => $producto]);
    }

    public function actualizarCompraventa(Request $request, $id)
    {
        $producto = compraventa::find($id);

        if ($request->hasFile('nueva_imagen')) {
            $file = $request->file("nueva_imagen");
            $nombre = bin2hex(random_bytes(5)) . "." . $file->guessExtension();
            $ruta = "img/compraventa/" . $nombre;
            $destino = public_path($ruta);

            copy($file, $destino);
            $producto->imagen = $ruta;
        }

        $producto->nombre_producto = $request->nombre_producto;
        $producto->descripcion_producto = $request->descripcion_producto;
        $producto->precio = $request->precio;
        $producto->contacto = $request->contacto;

        $producto->save();

        return redirect()->route('compraventa_administrar')->with('success', 'Producto actualizado exitosamente');
    }
}