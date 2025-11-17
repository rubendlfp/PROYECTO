<?php

/**
 * Script para crear la base de datos
 * Este archivo crea la conexión y la base de datos si no existe
 */

// Configuración de la base de datos
$host = 'localhost';
$username = 'root';
$password = '';
$database = 'proyecto_2daw';

try {
    // Crear conexión sin especificar la base de datos
    $conn = new mysqli($host, $username, $password);
    
    // Verificar la conexión
    if ($conn->connect_error) {
        die("Error de conexión: " . $conn->connect_error);
    }
    
    echo "Conexión exitosa al servidor MySQL\n";
    
    // Crear la base de datos si no existe
    $sql = "CREATE DATABASE IF NOT EXISTS `{$database}` CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci";
    
    if ($conn->query($sql) === TRUE) {
        echo "Base de datos '{$database}' creada o ya existe\n";
    } else {
        echo "Error al crear la base de datos: " . $conn->error . "\n";
    }
    
    // Cerrar la conexión
    $conn->close();
    
    echo "\nProceso completado exitosamente\n";
    
} catch (Exception $e) {
    die("Error: " . $e->getMessage());
}

?>
