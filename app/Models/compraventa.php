<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class compraventa extends Model
{
    use HasFactory;

    protected $fillable = [
        'id_user',
        'nombre_producto',
        'descripcion_producto',
        'precio',
        'contacto',
        'imagen'
    ];

    // Relación con el usuario propietario
    public function user()
    {
        return $this->belongsTo(User::class, 'id_user');
    }
}
