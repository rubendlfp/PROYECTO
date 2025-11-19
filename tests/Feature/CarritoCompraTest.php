<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\CarritoCompra;
use App\Models\User;
use App\Models\Producto;
use Illuminate\Foundation\Testing\RefreshDatabase;

class CarritoCompraTest extends TestCase
{
    use RefreshDatabase;

    public function test_puede_agregar_producto_al_carrito()
    {
        $user = User::factory()->create();
        $producto = Producto::factory()->create();
        
        $this->actingAs($user)->post('/guardarProductoCarrito', [
            'id_producto' => $producto->id,
            'cantidad' => 2
        ]);
        
        $this->assertDatabaseHas('carrito', [
            'id_user' => $user->id,
            'id_producto' => $producto->id,
            'cantidad' => 2
        ]);
    }

    public function test_agregar_producto_duplicado_incrementa_cantidad()
    {
        $user = User::factory()->create();
        $producto = Producto::factory()->create();
        
        CarritoCompra::create([
            'id_user' => $user->id,
            'id_producto' => $producto->id,
            'cantidad' => 3
        ]);
        
        $this->actingAs($user)->post('/guardarProductoCarrito', [
            'id_producto' => $producto->id,
            'cantidad' => 2
        ]);
        
        $carrito = CarritoCompra::where('id_user', $user->id)->first();
        $this->assertEquals(5, $carrito->cantidad);
    }

    public function test_usuario_no_autenticado_no_puede_agregar()
    {
        $producto = Producto::factory()->create();
        
        $response = $this->post('/guardarProductoCarrito', [
            'id_producto' => $producto->id
        ]);
        
        $response->assertRedirect('/login');
        $this->assertDatabaseCount('carrito', 0);
    }

    public function test_rechaza_cantidad_invalida()
    {
        $user = User::factory()->create();
        $producto = Producto::factory()->create();
        
        $response = $this->actingAs($user)->post('/guardarProductoCarrito', [
            'id_producto' => $producto->id,
            'cantidad' => 0
        ]);
        $response->assertSessionHasErrors('cantidad');
    }

    public function test_rechaza_producto_inexistente()
    {
        $user = User::factory()->create();
        
        $response = $this->actingAs($user)->post('/guardarProductoCarrito', [
            'id_producto' => 99999
        ]);
        
        $response->assertSessionHasErrors('id_producto');
    }

    public function test_puede_ver_carrito()
    {
        $user = User::factory()->create();
        
        $response = $this->actingAs($user)->get('/carritoCompra');
        
        $response->assertStatus(200);
        $response->assertViewIs('carritoCompra');
    }

    public function test_calcula_precio_total_correctamente()
    {
        $user = User::factory()->create();
        
        $productoA = Producto::factory()->create(['precio' => 10.00]);
        CarritoCompra::create([
            'id_user' => $user->id,
            'id_producto' => $productoA->id,
            'cantidad' => 2
        ]);
        
        $productoB = Producto::factory()->create(['precio' => 15.00]);
        CarritoCompra::create([
            'id_user' => $user->id,
            'id_producto' => $productoB->id,
            'cantidad' => 1
        ]);
        
        $response = $this->actingAs($user)->get('/carritoCompra');
        
        $this->assertEquals(35.00, $response->viewData('precioTotal'));
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
        
        $this->actingAs($user)->post("/actualizarCantidad/{$carrito->id}", [
            'cantidad' => 5
        ]);
        
        $this->assertEquals(5, $carrito->fresh()->cantidad);
    }

    public function test_usuario_no_puede_actualizar_carrito_ajeno()
    {
        $userA = User::factory()->create();
        $userB = User::factory()->create();
        $producto = Producto::factory()->create();
        
        $carrito = CarritoCompra::create([
            'id_user' => $userB->id,
            'id_producto' => $producto->id,
            'cantidad' => 2
        ]);
        
        $response = $this->actingAs($userA)->post("/actualizarCantidad/{$carrito->id}", [
            'cantidad' => 10
        ]);
        
        $response->assertStatus(404);
        $this->assertEquals(2, $carrito->fresh()->cantidad);
    }

    public function test_puede_eliminar_producto()
    {
        $user = User::factory()->create();
        $producto = Producto::factory()->create();
        
        $carrito = CarritoCompra::create([
            'id_user' => $user->id,
            'id_producto' => $producto->id,
            'cantidad' => 1
        ]);
        
        $this->actingAs($user)->get("/eliminarProdCarrito?id_borrar={$carrito->id}");
        
        $this->assertDatabaseMissing('carrito', ['id' => $carrito->id]);
    }

    public function test_usuario_no_puede_eliminar_carrito_ajeno()
    {
        $userA = User::factory()->create();
        $userB = User::factory()->create();
        $producto = Producto::factory()->create();
        
        $carrito = CarritoCompra::create([
            'id_user' => $userB->id,
            'id_producto' => $producto->id,
            'cantidad' => 1
        ]);
        
        $response = $this->actingAs($userA)->get("/eliminarProdCarrito?id_borrar={$carrito->id}");
        
        $response->assertStatus(404);
        $this->assertDatabaseHas('carrito', ['id' => $carrito->id]);
    }
}
