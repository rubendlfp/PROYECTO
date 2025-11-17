<?php

/**
 * Controlador de Compraventa
 * Gestiona el marketplace de productos de segunda mano entre usuarios
 */

namespace App\Http\Controllers;

use App\Models\Compraventa;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class compraventaController extends Controller
{
    /**
     * Muestra todos los productos del marketplace
     * Vista pública para todos los usuarios
     */
    public function mostrarCompraventa()
    {
        // Obtiene todos los productos de compraventa
        $listaProductos = Compraventa::all();

        return view('compraventa/compraventa', ['datosCompraventa' => $listaProductos]);
    }

    /**
     * Muestra productos según el tipo de usuario
     * Admin: ve todos los productos con información del propietario
     * Usuario normal: ve solo sus propios productos
     */
    public function mostrarProductosCompraventa()
    {
        // Si es administrador (tipo_usuario = 1), mostrar todos los productos con información del propietario
        // Si es usuario normal, solo mostrar sus productos
        if (auth()->user()->tipo_usuario == 1) {
            // Admin: carga todos los productos con relación de usuario
            $listaProductos = Compraventa::with('user')->get();
        } else {
            // Usuario: solo sus productos
            $listaProductos = Compraventa::where('id_user', auth()->user()->id)->get();
        }

        return view('compraventa/compraventa_administrar', ['datosCompraventa' => $listaProductos]);
    }

    /**
     * Muestra el formulario para crear un nuevo producto
     */
    public function menuNuevoCompraventa()
    {
        return view('compraventa/nuevoProdCompraventa');
    }

    /**
     * Guarda un nuevo producto de compraventa
     * Permite subir imagen y asigna el usuario actual como propietario
     */
    public function nuevoProdCompraventa(Request $request)
    {
        // Crea nuevo producto
        $producto_compraventa = new Compraventa;

        // Asigna el usuario actual como propietario
        $id_user = auth()->user()->id;
        $producto_compraventa->id_user = $id_user;

        // Procesa la imagen si se subió
        if ($request->hasFile('nueva_imagen')) {
            $file = $request->file("nueva_imagen");
            // Genera nombre único para la imagen
            $nombre = bin2hex(random_bytes(5)) . "." . $file->guessExtension();
            $ruta = "img/compraventa/" . $nombre;
            $destino = public_path($ruta);

            // Copia la imagen al directorio público
            copy($file, $destino);
            $producto_compraventa->imagen = $ruta;
        }

        // Asigna los datos del producto
        $nombre_producto = $request->nombre_producto;
        $producto_compraventa->nombre_producto = $nombre_producto;

        $descripcion_producto = $request->descripcion_producto;
        $producto_compraventa->descripcion_producto = $descripcion_producto;

        $precio = $request->precio;
        $producto_compraventa->precio = $precio;

        $contacto = $request->contacto;
        $producto_compraventa->contacto = $contacto;

        // Guarda en base de datos
        $producto_compraventa->save();

        // Redirigir de vuelta a la página de administración usando el método correcto
        return redirect()->route('compraventa_administrar')->with('success', 'Producto creado exitosamente');
    }

    /**
     * Muestra la vista detalle de un producto específico
     */
    public function productoUnicoCompraventa($id)
    {
        // Busca el producto por ID
        $producto = Compraventa::find($id);
        return view('compraventa/productoCompraventa', ["producto" => $producto]);
    }

    /**
     * Elimina un producto de compraventa
     */
    public function borrarProdCompraventa($id)
    {
        // Busca el producto
        $producto = Compraventa::find($id);
        
        // Si existe, lo elimina
        if ($producto) {
            $producto->delete();
        }

        return redirect()->route('compraventa_administrar')->with('success', 'Producto eliminado exitosamente');
    }

    /**
     * Muestra el formulario para editar un producto
     */
    public function editarCompraventa($id)
    {
        // Busca el producto a editar
        $producto = Compraventa::find($id);
        return view('compraventa/editarCompraventa', ["producto" => $producto]);
    }

    /**
     * Actualiza los datos de un producto existente
     * Permite cambiar imagen y todos los campos del producto
     */
    public function actualizarCompraventa(Request $request, $id)
    {
        // Busca el producto a actualizar
        $producto = Compraventa::find($id);

        // Si se subió nueva imagen, la procesa
        if ($request->hasFile('nueva_imagen')) {
            $file = $request->file("nueva_imagen");
            // Genera nombre único
            $nombre = bin2hex(random_bytes(5)) . "." . $file->guessExtension();
            $ruta = "img/compraventa/" . $nombre;
            $destino = public_path($ruta);

            // Guarda la nueva imagen
            copy($file, $destino);
            $producto->imagen = $ruta;
        }

        // Actualiza los campos del producto
        $producto->nombre_producto = $request->nombre_producto;
        $producto->descripcion_producto = $request->descripcion_producto;
        $producto->precio = $request->precio;
        $producto->contacto = $request->contacto;

        // Guarda los cambios
        $producto->save();

        return redirect()->route('compraventa_administrar')->with('success', 'Producto actualizado exitosamente');
    }
}