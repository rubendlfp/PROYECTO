<?php


namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class CompraventaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('compraventas')->insert([
            [
                'id_user' => '1',
                'nombre_producto' => 'Báscula Digital de Precisión',
                'descripcion_producto' => 'Báscula digital de cocina ',
                'precio' => '25.00',
                'imagen' => 'img/compraventa/bascula.jpg',
                'contacto' => 'juan.martinez@email.com',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'id_user' => '1',
                'nombre_producto' => 'Bicicleta de Montaña Specialized',
                'descripcion_producto' => 'Bicicleta de montaña Specialized Rockhopper 29"',
                'precio' => '450.00',
                'imagen' => 'img/compraventa/bici.jpg',
                'contacto' => 'maria.garcia@email.com',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'id_user' => '1',
                'nombre_producto' => 'Moto Yamaha MT-07 ABS',
                'descripcion_producto' => 'Yamaha MT-07 del 2020, ',
                'precio' => '6200.00',
                'imagen' => 'img/compraventa/moto.jpg',
                'contacto' => 'carlos.rodriguez@email.com',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'id_user' => '1',
                'nombre_producto' => 'Radio Vintage Bluetooth Retro',
                'descripcion_producto' => 'Radio vintage estilo años 50 con diseño retro',
                'precio' => '89.99',
                'imagen' => 'img/compraventa/radio.jpg',
                'contacto' => 'ana.lopez@email.com',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ]
        ]);
    }
}