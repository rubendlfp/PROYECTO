<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Models\CarritoCompra;
use App\Models\User;
use App\Models\Producto;
use Illuminate\Foundation\Testing\RefreshDatabase;

class CarritoCompraIntegrationTest extends TestCase
{
    use RefreshDatabase;

    public function test_guarda_en_base_de_datos()
    {
        $user = User::factory()->create();
        $producto = Producto::factory()->create();
        
        $carrito = CarritoCompra::create([
            'id_user' => $user->id,
            'id_producto' => $producto->id,
            'cantidad' => 3
        ]);
        
        $this->assertDatabaseHas('carrito', [
            'id_producto' => $producto->id,
            'cantidad' => 3
        ]);
    }

    public function test_puede_actualizar_cantidad()
    {
        $user = User::factory()->create();
        $producto = Producto::factory()->create();
        
        $carrito = CarritoCompra::create([
            'id_user' => $user->id,
            'id_producto' => $producto->id,
            'cantidad' => 2
        ]);
        
        $carrito->update(['cantidad' => 5]);
        
        $this->assertEquals(5, $carrito->fresh()->cantidad);
    }

    public function test_puede_eliminar_registro()
    {
        $user = User::factory()->create();
        $producto = Producto::factory()->create();
        
        $carrito = CarritoCompra::create([
            'id_user' => $user->id,
            'id_producto' => $producto->id,
            'cantidad' => 1
        ]);
        
        $id = $carrito->id;
        $carrito->delete();
        
        $this->assertDatabaseMissing('carrito', ['id' => $id]);
    }

    public function test_calcula_total_de_productos()
    {
        $user = User::factory()->create();
        
        CarritoCompra::create([
            'id_user' => $user->id,
            'id_producto' => Producto::factory()->create()->id,
            'cantidad' => 2
        ]);
        
        CarritoCompra::create([
            'id_user' => $user->id,
            'id_producto' => Producto::factory()->create()->id,
            'cantidad' => 3
        ]);
        
        $total = CarritoCompra::where('id_user', $user->id)->sum('cantidad');
        
        $this->assertEquals(5, $total);
    }
}
