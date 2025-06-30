<?php
header('Content-Type: application/json');
require_once "Modelo/Productos.php";

$accion = $_POST['Accion'] ?? '';
$respuesta = [
    "success" => false,
    "message" => "Acción no reconocida.",
    "accion" => $accion,
    "errors" => []
];

switch ($accion) {
    case 'Guardar':
        $producto = new Producto($_POST);
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
        $producto = new Producto($_POST);
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
echo json_encode($respuesta);
?>