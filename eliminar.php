<?php
header('Content-Type: application/json');
require_once "Modelo/conexion.php";

$id = file_get_contents("php://input");
$respuesta = ["success" => false, "message" => "No se pudo eliminar el producto."];

if ($id && is_numeric($id)) {
    $db = DB::getInstance();
    // Ejecutar la consulta con prepare/execute para eliminar
    $stmt = $db->query("DELETE FROM productos WHERE id = ?", [$id]);
    // Mejor verifica si el registro ya no existe
    $verifica = $db->query("SELECT * FROM productos WHERE id = ?", [$id]);
    if (empty($verifica)) {
        $respuesta["success"] = true;
        $respuesta["message"] = "Producto eliminado correctamente.";
    }
}
echo json_encode($respuesta);