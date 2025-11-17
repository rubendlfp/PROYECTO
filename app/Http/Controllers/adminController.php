<?php

/**
 * Controlador Admin
 * Gestiona el CRUD completo de productos (panel de administración)
 */

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Producto;
use Illuminate\Http\Request;

class adminController extends Controller
{
    // ----- MOSTRAR PRODUCTOS -----

    /**
     * Muestra todos los productos en el panel de administración
     */
    public function mostrarProductos()
    {
        // Obtiene todos los productos de la base de datos
        $listaProductos = Producto::all();

        return view('administrar/administrar', ['datosProductos' => $listaProductos]);
    }
    // ----- FIN MOSTRAR PRODUCTOS -----

    // ----- AÑADIR PRODUCTO -----
    
    /**
     * Muestra el formulario para crear un nuevo producto
     */
    public function menuNuevo()
    {
        return view('administrar/nuevoProd');
    }

    /**
     * Guarda un nuevo producto con hasta 4 imágenes
     * Crea un directorio específico para cada producto usando su ID
     */
    public function nuevoProd(Request $request)
    {
        // Crea nuevo producto
        $producto = new producto;

        // Asigna los datos básicos del producto
        $titulo = $request->titulo;
        $producto->titulo = $titulo;

        $descripcion = $request->descripcion;
        $producto->descripcion = $descripcion;

        $tipo = $request->tipo;
        $producto->tipo = $tipo;

        $marca = $request->marca;
        $producto->marca = $marca;

        $genero = $request->genero;
        $producto->genero = $genero;

        $categoria_prenda = $request->categoria_prenda;
        $producto->categoria_prenda = $categoria_prenda;

        $precio = $request->precio;
        $producto->precio = $precio;

        // Valoración opcional (por defecto 0)
        $valoracion = $request->valoracion ?? 0;
        $producto->valoracion = $valoracion;

        // Inicializa imágenes con valor por defecto
        $producto->imagen = 'img/productos/default.jpg';
        $producto->img2 = 'img/productos/default.jpg';
        $producto->img3 = 'img/productos/default.jpg';
        $producto->img4 = 'img/productos/default.jpg';

        // Guarda el producto para obtener su ID
        $producto->save();

        // Obtiene el ID del producto recién creado
        $id = $producto->id;

        // Crea directorio específico para las imágenes de este producto
        $directorio = public_path('img/productos/' . $id);
        if (!file_exists($directorio)) {
            mkdir($directorio, 0755, true);
        }

        // Procesa imagen principal si se subió
        if ($request->hasFile('nueva_imagen')) {
            $file = $request->file("nueva_imagen");
            $nombre = bin2hex(random_bytes(5)) . "." . $file->guessExtension();
            $ruta = "img/productos/" . $id . "/" . $nombre;
            $destino = public_path($ruta);

            copy($file, $destino);
            $producto->imagen = $ruta;
        }

        // Procesa imagen 2 si se subió
        if ($request->hasFile('img2')) {
            $file2 = $request->file("img2");
            $nombre2 = bin2hex(random_bytes(5)) . "." . $file2->guessExtension();
            $ruta2 = "img/productos/" . $id . "/" . $nombre2;
            $destino2 = public_path($ruta2);

            copy($file2, $destino2);
            $producto->img2 = $ruta2;
        }

        // Procesa imagen 3 si se subió
        if ($request->hasFile('img3')) {
            $file3 = $request->file("img3");
            $nombre3 = bin2hex(random_bytes(5)) . "." . $file3->guessExtension();
            $ruta3 = "img/productos/" . $id . "/" . $nombre3;
            $destino3 = public_path($ruta3);

            copy($file3, $destino3);
            $producto->img3 = $ruta3;
        }

        // Procesa imagen 4 si se subió
        if ($request->hasFile('img4')) {
            $file4 = $request->file("img4");
            $nombre4 = bin2hex(random_bytes(5)) . "." . $file4->guessExtension();
            $ruta4 = "img/productos/" . $id . "/" . $nombre4;
            $destino4 = public_path($ruta4);

            copy($file4, $destino4);
            $producto->img4 = $ruta4;
        }

        // Guarda las rutas de las imágenes
        $producto->save();

        return redirect('/administrar');
    }
    // ----- FIN AÑADIR PRODUCTO -----

    // ----- BORRAR PRODUCTO -----
    
    /**
     * Elimina un producto y todas sus imágenes
     */
    public function borrar($id)
    {
        // Busca el producto
        $producto = Producto::find($id);
        $producto->delete();

        // Elimina la imagen principal del servidor
        $ruta_img = public_path($producto->imagen);
        if ($ruta_img) {
            unlink($ruta_img);
        }

        // Elimina imagen 2
        $ruta_img2 = public_path($producto->img2);
        if ($ruta_img2) {
            unlink($ruta_img2);
        }

        // Elimina imagen 3
        $ruta_img3 = public_path($producto->img3);
        if ($ruta_img3) {
            unlink($ruta_img3);
        }

        // Elimina imagen 4
        $ruta_img4 = public_path($producto->img4);
        if ($ruta_img4) {
            unlink($ruta_img4);
        }

        return redirect('/administrar');
    }
    // ----- FIN BORRAR PRODUCTO -----

    // ----- EDITAR PRODUCTO -----
    
    /**
     * Muestra el formulario para editar un producto existente
     */
    public function menuEditar($id)
    {
        // Busca el producto a editar
        $producto = Producto::find($id);
        return view('administrar/editarProd', ["producto" => $producto]);
    }

    /**
     * Actualiza los datos de un producto existente
     * Permite cambiar todas las imágenes, eliminando las antiguas
     */
    public function confirmarCambios(Request $request, $id)
    {
        // Busca el producto a actualizar
        $producto = Producto::find($id);

        // Actualiza los campos del producto
        $titulo = $request->input('titulo');
        $producto->titulo = $titulo;

        $descripcion = $request->input('descripcion');
        $producto->descripcion = $descripcion;

        $marca = $request->input('marca');
        $producto->marca = $marca;

        $tipo = $request->input('tipo');
        $producto->tipo = $tipo;

        $genero = $request->input('genero');
        $producto->genero = $genero;

        $categoria_prenda = $request->input('categoria_prenda');
        $producto->categoria_prenda = $categoria_prenda;

        $precio = $request->input('precio');
        $producto->precio = $precio;

        // Actualiza imagen principal si se subió una nueva
        if ($request->hasFile('nueva_imagen')) {
            $file = $request->file("nueva_imagen");
            $nombre = bin2hex(random_bytes(5)) . "." . $file->guessExtension();
            $ruta = "img/productos/" . $id . "/" . $nombre;
            $destino = public_path($ruta);

            // Elimina la imagen anterior si no es la default
            if ($producto->imagen != 'img/productos/default.jpg') {
                $ruta_img = public_path($producto->imagen);
                if ($ruta_img) {
                    unlink($ruta_img);
                }
            }

            // Guarda la nueva imagen
            copy($file, $destino);
            $producto->imagen = $ruta;
        }

        // Actualiza imagen 2 si se subió una nueva
        if ($request->hasFile('img2')) {
            $file2 = $request->file("img2");
            $nombre2 = bin2hex(random_bytes(5)) . "." . $file2->guessExtension();
            $ruta2 = "img/productos/" . $id . "/" . $nombre2;
            $destino2 = public_path($ruta2);

            // Elimina imagen anterior
            if ($producto->img2 != 'img/productos/default.jpg') {
                $ruta_img2 = public_path($producto->img2);
                if ($ruta_img2) {
                    unlink($ruta_img2);
                }
            }

            copy($file2, $destino2);
            $producto->img2 = $ruta2;
        }

        // Actualiza imagen 3 si se subió una nueva
        if ($request->hasFile('img3')) {
            $file3 = $request->file("img3");
            $nombre3 = bin2hex(random_bytes(5)) . "." . $file3->guessExtension();
            $ruta3 = "img/productos/" . $id . "/" . $nombre3;
            $destino3 = public_path($ruta3);

            // Elimina imagen anterior
            if ($producto->img3 != 'img/productos/default.jpg') {
                $ruta_img3 = public_path($producto->img3);
                if ($ruta_img3) {
                    unlink($ruta_img3);
                }
            }

            copy($file3, $destino3);
            $producto->img3 = $ruta3;
        }

        // Actualiza imagen 4 si se subió una nueva
        if ($request->hasFile('img4')) {
            $file4 = $request->file("img4");
            $nombre4 = bin2hex(random_bytes(5)) . "." . $file4->guessExtension();
            $ruta4 = "img/productos/" . $id . "/" . $nombre4;
            $destino4 = public_path($ruta4);

            // Elimina imagen anterior
            if ($producto->img4 != 'img/productos/default.jpg') {
                $ruta_img4 = public_path($producto->img4);
                if ($ruta_img4) {
                    unlink($ruta_img4);
                }
            }

            copy($file4, $destino4);
            $producto->img4 = $ruta4;
        }

        // Guarda todos los cambios
        $producto->save();

        return redirect('/administrar');
    }
    // ----- FIN EDITAR PRODUCTO -----
}