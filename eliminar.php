<?php
/**
 * ELIMINAR.PHP - Controlador para eliminar productos
 * Elimina un producto específico de la base de datos
 */

// Establece el tipo de respuesta como JSON
header('Content-Type: application/json');

// Incluye la conexión a la base de datos
require_once "Modelo/conexion.php";

// Obtiene el ID del producto desde el cuerpo de la petición
$id = file_get_contents("php://input");

// Estructura de respuesta por defecto
$respuesta = ["success" => false, "message" => "No se pudo eliminar el producto."];

// Valida que el ID sea válido
if ($id && is_numeric($id)) {
    // Obtiene la instancia de la base de datos
    $db = DB::getInstance();
    
    // Ejecuta la consulta DELETE con prepared statement
    $stmt = $db->query("DELETE FROM productos WHERE id = ?", [$id]);
    
    // Verifica si el producto fue eliminado (ya no existe)
    $verifica = $db->query("SELECT * FROM productos WHERE id = ?", [$id]);
    
    if (empty($verifica)) {
        $respuesta["success"] = true;
        $respuesta["message"] = "Producto eliminado correctamente.";
    }
}

// Envía la respuesta en formato JSON
echo json_encode($respuesta);
?>