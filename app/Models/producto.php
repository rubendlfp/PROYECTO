<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Producto extends Model
{
    use HasFactory;

    protected $table = 'productos';

    protected $fillable = [
        'titulo',
        'descripcion',
        'tipo',
        'categoria_prenda',
        'genero',
        'marca',
        'precio',
        'valoracion',
        'imagen',
        'img2',
        'img3',
        'img4',
        'etiquetas'
    ];

    protected $casts = [
        'precio' => 'decimal:2',
        'valoracion' => 'decimal:1'
    ];

    // Relación con el carrito de compras
    public function carritoCompras()
    {
        return $this->hasMany(CarritoCompra::class, 'id_producto');
    }

    // Relación con favoritos
    public function favoritos()
    {
        return $this->hasMany(Favorito::class, 'id_producto');
    }

    // Relación con compraventa
    public function compraventas()
    {
        return $this->hasMany(Compraventa::class, 'id_producto');
    }
}
