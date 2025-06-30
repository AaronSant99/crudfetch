<?php
header('Content-Type: application/json');
require_once "Modelo/conexion.php";

$id = file_get_contents("php://input");
if (!$id || !is_numeric($id)) {
    echo json_encode(["success" => false, "message" => "ID inválido"]);
    exit;
}
$db = DB::getInstance();
$res = $db->query("SELECT * FROM productos WHERE id = ?", [$id]);
if ($res && count($res) > 0) {
    echo json_encode($res[0]);
} else {
    echo json_encode(["success" => false, "message" => "Producto no encontrado"]);
}
?>