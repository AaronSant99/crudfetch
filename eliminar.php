<?php
    // Obtener el ID del producto a eliminar desde el cuerpo de la petición
    $data = file_get_contents("php://input");
    
    // Incluir archivo de conexión a la base de datos
    require "conexion.php";
    
    // Preparar consulta para eliminar el producto por ID
    $query = $pdo->prepare("DELETE FROM productos WHERE id = :id");
    $query->bindParam(":id", $data);  // Vincular el parámetro ID
    $query->execute();                // Ejecutar la eliminación
    
    // Confirmar que la operación fue exitosa
    echo "ok";
?>