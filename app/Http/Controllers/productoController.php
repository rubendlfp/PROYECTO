<?php

namespace App\Http\Controllers;

use App\Models\Producto;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class productoController extends Controller
{
    // --- Mostrar todos los productos ---
    public function mostrarProductos(Request $request)
    {
        $query = Producto::query();

        // Filtro por categoría (tipo)
        if ($request->filled('categoria')) {
            $categoria = strtolower($request->categoria);
            if (in_array($categoria, ['ropa', 'calzado', 'complementos'])) {
                $query->where('tipo', $categoria);
            }
        }

        // Filtro por género (lo usaremos para "color" temporalmente)
        if ($request->filled('color')) {
            // Como no hay columna color, podemos filtrar por género o marca
            $query->where('genero', $request->color);
        }

        // Filtro por marca (lo usaremos para "talla" temporalmente)
        if ($request->filled('talla')) {
            // Como no hay columna talla, podemos filtrar por marca
            $query->where('marca', $request->talla);
        }

        // Filtro por búsqueda de texto
        if ($request->filled('search')) {
            $query->where(function($q) use ($request) {
                $q->where('titulo', 'LIKE', '%' . $request->search . '%')
                  ->orWhere('descripcion', 'LIKE', '%' . $request->search . '%')
                  ->orWhere('marca', 'LIKE', '%' . $request->search . '%');
            });
        }

        $listaProductos = $query->get();
        $categoria = $request->categoria ?? 'PRODUCTOS';

        return view('comprar', ['datosProductos' => $listaProductos, 'categoria' => $categoria]);
    }

    // --- Mostrar ropa ---
    public function mostrarRopa()
    {
        $listaProductos = DB::select('SELECT * FROM productos WHERE tipo = ?', ['ropa']);

        return view('comprar', ['datosProductos' => $listaProductos, 'categoria' => 'ROPA']);
    }

    // --- Mostrar ropa deportiva (método requerido por las rutas) ---
    public function mostrarRopaDeportiva()
    {
        $listaProductos = Producto::where('tipo', 'ropa')->get();
        return view('comprar', ['datosProductos' => $listaProductos, 'categoria' => 'ROPA DEPORTIVA']);
    }

    // --- Mostrar calzado ---
    public function mostrarCalzado()
    {
        $listaProductos = DB::select('SELECT * FROM productos WHERE tipo = ?', ['calzado']);

        return view('comprar', ['datosProductos' => $listaProductos, 'categoria' => 'CALZADO']);
    }

    // --- Mostrar calzado deportivo (método requerido por las rutas) ---
    public function mostrarCalzadoDeportivo()
    {
        $listaProductos = Producto::where('tipo', 'calzado')->get();
        return view('comprar', ['datosProductos' => $listaProductos, 'categoria' => 'CALZADO DEPORTIVO']);
    }

    // --- Mostrar complementos ---
    public function mostrarComplementos()
    {
        $listaProductos = DB::select('SELECT * FROM productos WHERE tipo = ?', ['complementos']);

        return view('comprar', ['datosProductos' => $listaProductos, 'categoria' => 'COMPLEMENTOS']);
    }

    // --- Mostrar equipamiento (método requerido por las rutas) ---
    public function mostrarEquipamiento()
    {
        $listaProductos = Producto::where('tipo', 'complementos')->get();
        return view('comprar', ['datosProductos' => $listaProductos, 'categoria' => 'EQUIPAMIENTO']);
    }

    // --- Mostrar hombre ---
    public function mostrarHombre()
    {
        $listaProductos = DB::select('SELECT * FROM productos WHERE genero = ?', ['masculino']);

        return view('comprar', ['datosProductos' => $listaProductos, 'categoria' => 'HOMBRE']);
    }

    // --- Mostrar mujer ---
    public function mostrarMujer()
    {
        $listaProductos = DB::select('SELECT * FROM productos WHERE genero = ?', ['femenino']);

        return view('comprar', ['datosProductos' => $listaProductos, 'categoria' => 'MUJER']);
    }

    // --- Mostrar solo un producto ---
    public function mostrarProductoUnico($id)
    {
        $producto = Producto::find($id);
        return view('producto', ["producto" => $producto]);
    }
}