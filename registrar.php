<?php
// Verificar si se han enviado datos por POST
if (isset($_POST)) {
    // Obtener los valores del formulario
    $codigo = $_POST['codigo'];
    $producto = $_POST['producto'];
    $precio = $_POST['precio'];
    $cantidad = $_POST['cantidad'];
    
    // Incluir archivo de conexión a la base de datos
    require("conexion.php");
    
    // Verificar si es un nuevo registro o una actualización
    if (empty($_POST['idp'])){
        // INSERTAR nuevo producto
        $query = $pdo->prepare("INSERT INTO productos (codigo, producto, precio, cantidad) VALUES (:cod, :pro, :pre, :cant)");
        $query->bindParam(":cod", $codigo);
        $query->bindParam(":pro", $producto);
        $query->bindParam(":pre", $precio);
        $query->bindParam(":cant", $cantidad);
        $query->execute();
        $pdo = null;  // Cerrar conexión
        echo "ok";    // Respuesta de éxito para nuevo registro
    }else{
        // ACTUALIZAR producto existente
        $id = $_POST['idp'];  // Obtener ID del producto a actualizar
        $query = $pdo->prepare("UPDATE productos SET codigo = :cod, producto = :pro, precio =:pre, cantidad = :cant WHERE id = :id");
        $query->bindParam(":cod", $codigo);
        $query->bindParam(":pro", $producto);
        $query->bindParam(":pre", $precio);
        $query->bindParam(":cant", $cantidad);
        $query->bindParam("id", $id);
        $query->execute();
        $pdo = null;        // Cerrar conexión
        echo "modificado";  // Respuesta de éxito para actualización
    }
    
}
