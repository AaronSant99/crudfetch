<?php
// Verificar si se han enviado datos por POST
if (isset($_POST)) {
    // Obtener los valores del formulario
    $codigo = trim($_POST['codigo']);
    $producto = trim($_POST['producto']);
    $precio = $_POST['precio'];
    $cantidad = $_POST['cantidad'];
    
    // Validaciones
    $errores = [];

    // Validar campos vacíos
    if ($codigo === '' || $producto === '' || $precio === '' || $cantidad === '') {
        $errores[] = "Todos los campos son obligatorios.";
    }

    // Validar que precio y cantidad sean numéricos y no negativos
    if (!is_numeric($precio) || $precio < 0) {
        $errores[] = "El precio debe ser un número igual o mayor a 0.";
    }
    if (!is_numeric($cantidad) || $cantidad < 0) {
        $errores[] = "La cantidad debe ser un número igual o mayor a 0.";
    }

    // Si hay errores, devolver el primero
    if (!empty($errores)) {
        echo $errores[0];
        exit;
    }

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