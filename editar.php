<?php
/**
 * EDITAR.PHP - Controlador para obtener datos de un producto
 * Retorna los datos de un producto específico para edición
 */

// Establece el tipo de respuesta como JSON
header('Content-Type: application/json');

// Incluye la conexión a la base de datos
require_once "Modelo/conexion.php";

// Obtiene el ID del producto desde el cuerpo de la petición
$id = file_get_contents("php://input");

// Valida que el ID sea válido
if (!$id || !is_numeric($id)) {
    echo json_encode(["success" => false, "message" => "ID inválido"]);
    exit;
}

// Obtiene la instancia de la base de datos
$db = DB::getInstance();

// Busca el producto por ID
$res = $db->query("SELECT * FROM productos WHERE id = ?", [$id]);

// Verifica si se encontró el producto
if ($res && count($res) > 0) {
    // Retorna los datos del producto encontrado
    echo json_encode($res[0]);
} else {
    // Retorna error si no se encontró el producto
    echo json_encode(["success" => false, "message" => "Producto no encontrado"]);
}
?>