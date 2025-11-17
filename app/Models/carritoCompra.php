<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CarritoCompra extends Model
{
    use HasFactory;

    protected $table = 'carrito_compras';

    protected $fillable = [
        'id_user',
        'id_producto',
        'cantidad'
    ];

    protected $casts = [
        'cantidad' => 'integer',
        'id_user' => 'integer',
        'id_producto' => 'integer'
    ];

    // Relación con el modelo User
    public function user()
    {
        return $this->belongsTo(User::class, 'id_user');
    }

    // Relación con el modelo Producto
    public function producto()
    {
        return $this->belongsTo(Producto::class, 'id_producto');
    }
}
