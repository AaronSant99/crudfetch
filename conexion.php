<?php
    // Configuración de la base de datos
    $servidor = "mysql:dbname=crud;host=localhost";  // Cadena de conexión a MySQL con base de datos 'crud' en localhost
    $user = "root";                                  // Usuario de la base de datos
    $pass = "";                                      // Contraseña del usuario (vacía por defecto en XAMPP)
    
    try {
        // Crear conexión PDO con configuración UTF-8
        $pdo = new PDO($servidor, $user, $pass, array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8"));
    } catch (PDOException $e) {
        // Mostrar error si la conexión falla
        echo "conexion fallida" .$e->getMessage();
    }

?>