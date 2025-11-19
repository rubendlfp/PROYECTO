<?php

namespace Database\Factories;

use App\Models\Producto;
use Illuminate\Database\Eloquent\Factories\Factory;

class ProductoFactory extends Factory
{
    protected $model = Producto::class;

    public function definition()
    {
        return [
            'titulo' => $this->faker->words(3, true),
            'descripcion' => $this->faker->sentence(),
            'tipo' => $this->faker->randomElement(['Ropa', 'Calzado', 'Complemento']),
            'categoria_prenda' => $this->faker->randomElement(['Camiseta', 'Pantalon', 'Zapatos']),
            'genero' => $this->faker->randomElement(['Hombre', 'Mujer', 'Unisex']),
            'marca' => $this->faker->company(),
            'precio' => $this->faker->randomFloat(2, 10, 200),
            'valoracion' => $this->faker->randomFloat(1, 1, 5),
            'imagen' => $this->faker->imageUrl(640, 480, 'fashion'),
            'img2' => $this->faker->imageUrl(640, 480, 'fashion'),
            'img3' => $this->faker->imageUrl(640, 480, 'fashion'),
            'img4' => $this->faker->imageUrl(640, 480, 'fashion'),
            'etiquetas' => $this->faker->words(3, true)
        ];
    }
}
