<?php

/**
 * Controlador de Favoritos
 * Gestiona la lista de productos favoritos del usuario
 */

namespace App\Http\Controllers;

use App\Models\Favorito;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class favoritosController extends Controller
{
    /**
     * Muestra todos los favoritos del usuario
     * Obtiene los datos mediante JOIN de favoritos, productos y users
     */
    public function mostrarFavoritos()
    {
        // Consulta SQL que obtiene favoritos del usuario actual
        $favoritos = DB::select('SELECT favoritos.id, productos.titulo, productos.precio, productos.descripcion, productos.imagen FROM favoritos JOIN productos ON favoritos.id_producto = productos.id JOIN users ON favoritos.id_user= users.id WHERE favoritos.id_user =' . auth()->user()->id . '');

        // Retorna vista con los datos de favoritos
        return view('favoritos')->with('datosFavoritos', $favoritos);
    }

    /**
     * Añade un producto a la lista de favoritos
     * Recibe el id_producto desde el formulario
     */
    public function añadirFavorito(Request $request)
    {
        // Crea nuevo registro de favorito
        $carrito = new Favorito();

        // Asigna el producto a añadir
        $id_producto = $request->id_producto;
        $carrito->id_producto = $id_producto;

        // Asigna el usuario actual
        $id_user = auth()->user()->id;
        $carrito->id_user = $id_user;

        // Guarda en base de datos
        $carrito->save();

        return redirect('/');
    }

    /**
     * Elimina un producto de favoritos
     * Recibe el id del registro a borrar
     */
    public function eliminarFavorito(Request $request)
    {
        // Obtiene el ID del favorito a eliminar
        $id = (int) $request->input('id_borrar');

        // Busca y elimina el favorito
        $articulo = Favorito::find($id);
        $articulo->delete();

        return redirect('/favoritos');
    }
}