<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Models\CarritoCompra;
use App\Models\User;
use App\Models\Producto;
use Illuminate\Foundation\Testing\RefreshDatabase;

class CarritoCompraModelTest extends TestCase
{
    use RefreshDatabase;

    public function test_puede_crear_carrito()
    {
        $user = User::factory()->create();
        $producto = Producto::factory()->create();
        
        $carrito = CarritoCompra::create([
            'id_user' => $user->id,
            'id_producto' => $producto->id,
            'cantidad' => 2
        ]);
        
        $this->assertNotNull($carrito->id);
        $this->assertEquals(2, $carrito->cantidad);
    }

    public function test_tiene_relacion_con_usuario()
    {
        $user = User::factory()->create();
        $producto = Producto::factory()->create();
        
        $carrito = CarritoCompra::create([
            'id_user' => $user->id,
            'id_producto' => $producto->id,
            'cantidad' => 1
        ]);
        
        $this->assertEquals($user->id, $carrito->user->id);
    }

    public function test_tiene_relacion_con_producto()
    {
        $user = User::factory()->create();
        $producto = Producto::factory()->create(['titulo' => 'Test']);
        
        $carrito = CarritoCompra::create([
            'id_user' => $user->id,
            'id_producto' => $producto->id,
            'cantidad' => 1
        ]);
        
        $this->assertEquals('Test', $carrito->producto->titulo);
    }
}
