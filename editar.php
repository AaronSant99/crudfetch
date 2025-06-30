<?php
    // Obtener el ID del producto desde el cuerpo de la petición
    $data = file_get_contents("php://input");
    
    // Incluir archivo de conexión a la base de datos
    require "conexion.php";
    
    // Preparar consulta para obtener los datos del producto por ID
    $query = $pdo->prepare("SELECT * FROM productos WHERE id = :id");
    $query->bindParam(":id", $data);  // Vincular el parámetro ID
    $query->execute();                // Ejecutar la consulta
    
    // Obtener el resultado como array asociativo
    $resultado = $query->fetch(PDO::FETCH_ASSOC);
    
    // Devolver los datos del producto en formato JSON
    echo json_encode($resultado);
?>