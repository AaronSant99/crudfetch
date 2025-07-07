<?php
/**
 * REGISTRAR.PHP - Controlador para crear y actualizar productos
 * Maneja las acciones de Guardar y Modificar
 */

// Establece el tipo de respuesta como JSON
header('Content-Type: application/json');

// Incluye el modelo de productos
require_once "Modelo/Productos.php";

// Obtiene la acción desde POST
$accion = $_POST['Accion'] ?? '';

// Estructura de respuesta por defecto
$respuesta = [
    "success" => false,
    "message" => "Acción no reconocida.",
    "accion" => $accion,
    "errors" => []
];

// Procesa la acción solicitada
switch ($accion) {
    case 'Guardar':
        // Crear nuevo producto
        $producto = new Producto($_POST); // Crea instancia con datos POST
        
        if ($producto->guardar()) {
            $respuesta["success"] = true;
            $respuesta["message"] = "Producto registrado correctamente.";
            $respuesta["accion"] = "guardar";
        } else {
            $respuesta["errors"] = $producto->errors;
            $respuesta["message"] = $producto->errors ? implode(" ", $producto->errors) : "Error al guardar.";
        }
        break;
        
    case 'Modificar':
        // Actualizar producto existente
        $producto = new Producto($_POST); // Crea instancia con datos POST
        
        if ($producto->editar()) {
            $respuesta["success"] = true;
            $respuesta["message"] = "Producto modificado correctamente.";
            $respuesta["accion"] = "modificar";
        } else {
            $respuesta["errors"] = $producto->errors;
            $respuesta["message"] = $producto->errors ? implode(" ", $producto->errors) : "Error al modificar.";
        }
        break;
        
    default:
        $respuesta["message"] = "Acción no válida.";
        break;
}

// Envía la respuesta en formato JSON
echo json_encode($respuesta);
?>