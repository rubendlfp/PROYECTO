<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class productoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('productos')->insert([
            // ROPA DEPORTIVA
            [
                'titulo' => 'Camiseta Nike Dri-FIT Running',
                'descripcion' => 'Camiseta técnica de running con tecnología Dri-FIT para mantenerte seco durante entrenamientos intensos. Tejido transpirable y ligero.',
                'tipo' => 'ropa',
                'categoria_prenda' => 'camiseta técnica',
                'genero' => 'masculino',
                'marca' => 'Nike',
                'precio' => 29.99,
                'valoracion' => 4.8,
                'imagen' => 'img/productos/1/4217b1f45e.jpg',
                'img2' => 'img/productos/1/5aeb8316af.jpg',
                'img3' => 'img/productos/1/a998f87799.jpg',
                'img4' => 'img/productos/1/ced033c236.jpg',
                'etiquetas' => 'running, dri-fit, transpirable, técnica',
            ],
            [
                'titulo' => 'Shorts de Entrenamiento Adidas',
                'descripcion' => 'Shorts ligeros para entrenamiento con tecnología Climalite. Perfectos para fitness y entrenamientos de alta intensidad.',
                'tipo' => 'ropa',
                'categoria_prenda' => 'pantalón corto',
                'genero' => 'masculino',
                'marca' => 'Adidas',
                'precio' => 50.99,
                'valoracion' => 4.5,
                'imagen' => 'img/productos/2/1b08cb533f.jpg',
                'img2' => 'img/productos/2/3036c88db6.jpg',
                'img3' => 'img/productos/2/cd143db194.jpg',
                'img4' => 'img/productos/2/fffbbd1efa.jpg',
                'etiquetas' => 'training, climalite, fitness, ligero',
            ],
            [
                'titulo' => 'Sudadera Under Armour Hoodie',
                'descripcion' => 'Sudadera con capucha ideal para entrenamientos y calentamiento. Tejido Storm resistente al agua y al viento.',
                'tipo' => 'ropa',
                'categoria_prenda' => 'sudadera con capucha',
                'genero' => 'masculino',
                'marca' => 'Under Armour',
                'precio' => 65.99,
                'valoracion' => 4.7,
                'imagen' => 'img/productos/8/35da2af620.jpg',
                'img2' => 'img/productos/8/876874d2af.jpg',
                'img3' => 'img/productos/8/9523a38ef3.jpg',
                'img4' => 'img/productos/8/ec9f990271.jpg',
                'etiquetas' => 'hoodie, storm, resistente, calentamiento',
            ],
            [
                'titulo' => 'Leggings Nike Pro Training',
                'descripcion' => 'Mallas deportivas de alta compresión para entrenamientos intensos. Diseño ergonómico con tecnología Dri-FIT.',
                'tipo' => 'ropa',
                'categoria_prenda' => 'mallas deportivas',
                'genero' => 'femenino',
                'marca' => 'Nike',
                'precio' => 42.50,
                'valoracion' => 4.9,
                'imagen' => 'img/productos/9/0487b0eca0.jpg',
                'img2' => 'img/productos/9/5578f3f518.jpg',
                'img3' => 'img/productos/9/9cb2beffe6.jpg',
                'img4' => 'img/productos/9/b2a64eece7.jpg',
                'etiquetas' => 'leggings, compresión, pro, training',
            ],

            // CALZADO DEPORTIVO
            [
                'titulo' => 'Nike Air Zoom Pegasus 40',
                'descripcion' => 'Zapatillas de running con amortiguación Air Zoom para máximo rendimiento en largas distancias. Suela resistente y transpirable.',
                'tipo' => 'calzado',
                'categoria_prenda' => 'zapatillas running',
                'genero' => 'femenino',
                'marca' => 'Nike',
                'precio' => 130.00,
                'valoracion' => 4.8,
                'imagen' => 'img/productos/4/01ac883366.jpg',
                'img2' => 'img/productos/4/0eafd244b3.jpg',
                'img3' => 'img/productos/4/160349600c.jpg',
                'img4' => 'img/productos/4/e38fb30aa6.jpg',
                'etiquetas' => 'running, air zoom, pegasus, amortiguación',
            ],
            [
                'titulo' => 'Adidas UltraBoost 23',
                'descripcion' => 'Zapatillas premium con tecnología Boost para máximo retorno de energía. Perfectas para running y training.',
                'tipo' => 'calzado',
                'categoria_prenda' => 'zapatillas running',
                'genero' => 'femenino',
                'marca' => 'Adidas',
                'precio' => 180.00,
                'valoracion' => 4.9,
                'imagen' => 'img/productos/6/6b9fc5cb4b.jpg',
                'img2' => 'img/productos/6/850551c9c3.jpg',
                'img3' => 'img/productos/6/c024cd95f5.jpg',
                'img4' => 'img/productos/6/c348e79423.jpg',
                'etiquetas' => 'ultraboost, boost, premium, energy return',
            ],
            [
                'titulo' => 'Zapatillas Cross Training Reebok',
                'descripcion' => 'Zapatillas versátiles para entrenamiento cruzado. Estabilidad lateral mejorada y suela antideslizante para gimnasio.',
                'tipo' => 'calzado',
                'categoria_prenda' => 'zapatillas training',
                'genero' => 'femenino',
                'marca' => 'Reebok',
                'precio' => 95.00,
                'valoracion' => 4.5,
                'imagen' => 'img/productos/7/337a4984d1.jpg',
                'img2' => 'img/productos/7/46eb6276c1.jpg',
                'img3' => 'img/productos/7/81648ce0ea.jpg',
                'img4' => 'img/productos/7/e06f507e29.jpg',
                'etiquetas' => 'cross training, estabilidad, gym, versátil',
            ],

            // EQUIPAMIENTO DEPORTIVO
            [
                'titulo' => 'Mancuernas Ajustables 20kg Set',
                'descripcion' => 'Set de mancuernas ajustables de 5 a 20kg cada una. Perfectas para entrenamiento en casa o gimnasio. Incluye discos intercambiables.',
                'tipo' => 'complementos',
                'categoria_prenda' => 'equipamiento fitness',
                'genero' => 'masculino',
                'marca' => 'PowerTech',
                'precio' => 149.99,
                'valoracion' => 4.6,
                'imagen' => 'img/productos/3/Mancuerna1.jpg',
                'img2' => 'img/productos/3/Mancuerna2.jpg',
                'img3' => 'img/productos/3/Mancuerna3.jpg',
                'img4' => 'img/productos/3/Mancuerna4.jpg',
                'etiquetas' => 'mancuernas, ajustables, pesas, fitness',
            ],
            [
                'titulo' => 'Balón de Fútbol FIFA Quality',
                'descripcion' => 'Balón oficial con certificación FIFA Quality. Construcción termosellada para máxima durabilidad y control perfecto.',
                'tipo' => 'complementos',
                'categoria_prenda' => 'balón deportivo',
                'genero' => 'masculino',
                'marca' => 'SportPro',
                'precio' => 35.00,
                'valoracion' => 4.8,
                'imagen' => 'img/productos/5/006352848d.jpg',
                'img2' => 'img/productos/5/3453aede63.jpg',
                'img3' => 'img/productos/5/8300d7b06c.jpg',
                'img4' => 'img/productos/5/dfa773f950.jpg',
                'etiquetas' => 'fútbol, fifa, oficial, termosellado',
            ],
            [
                'titulo' => 'Esterilla de Yoga Premium',
                'descripcion' => 'Esterilla antideslizante de 6mm de grosor. Material eco-friendly con marcas de alineación para yoga y pilates.',
                'tipo' => 'complementos',
                'categoria_prenda' => 'accesorio yoga',
                'genero' => 'femenino',
                'marca' => 'YogaFlex',
                'precio' => 45.00,
                'valoracion' => 4.7,
                'imagen' => 'img/productos/10/1c2b2681b7.jpg',
                'img2' => 'img/productos/10/55cfad5a72.jpg',
                'img3' => 'img/productos/10/796a7ca34f.jpg',
                'img4' => 'img/productos/10/c12fc9f19c.jpg',
                'etiquetas' => 'yoga, esterilla, antideslizante, eco-friendly',
            ],

        ]);
    }
}