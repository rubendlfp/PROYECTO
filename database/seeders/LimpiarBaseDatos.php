<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class LimpiarBaseDatos extends Seeder
{
    /**
     * Limpiar todas las tablas antes de ejecutar los seeders
     *
     * @return void
     */
    public function run()
    {
        echo "🧹 Iniciando limpieza de base de datos...\n";
        
        // Deshabilitar verificación de claves foráneas temporalmente
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        
        // Limpiar tablas en el orden correcto (hijas primero para evitar errores de FK)
        $tablasALimpiar = [
            'carrito',
            'favoritos', 
            'pedidos',
            'compraventas', // Corregido: era 'compraventa', debería ser 'compraventas'
            'productos',
            'users'
        ];
        
        foreach ($tablasALimpiar as $tabla) {
            if (Schema::hasTable($tabla)) {
                $registrosEliminados = DB::table($tabla)->count();
                DB::table($tabla)->delete();
                
                // Reiniciar AUTO_INCREMENT a 1
                DB::statement("ALTER TABLE `{$tabla}` AUTO_INCREMENT = 1");
                
                echo "✅ Tabla '{$tabla}' limpiada ({$registrosEliminados} registros eliminados)\n";
            } else {
                echo "⚠️  Tabla '{$tabla}' no existe\n";
            }
        }
        
        // Reactivar verificación de claves foráneas
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
        
        echo "🚀 Base de datos completamente limpia y lista para nuevos datos\n";
        echo "💡 Ejecuta: php artisan db:seed para repoblar con datos frescos\n";
    }
}