<?php
/**
 * LISTAR.PHP - Controlador para listar y buscar productos
 * Genera las filas HTML de la tabla de productos
 */

// Incluye el modelo de productos
require_once "Modelo/Productos.php";

// Obtiene el criterio de búsqueda desde el cuerpo de la petición
$data = file_get_contents("php://input");

// Busca productos con el criterio (vacío = todos los productos)
$productos = Producto::buscar(trim($data));

// Genera las filas HTML para cada producto
foreach ($productos as $prod) {
    echo "<tr>
            <td>" . htmlspecialchars($prod['id']) . "</td>
            <td>" . htmlspecialchars($prod['producto']) . "</td>
            <td>" . htmlspecialchars($prod['precio']) . "</td>
            <td>" . htmlspecialchars($prod['cantidad']) . "</td>
            <td>
                <button type='button' class='btn btn-success' onclick='Editar(" . json_encode($prod['id']) . ")'>Editar</button>
                <button type='button' class='btn btn-danger' onclick='Eliminar(" . json_encode($prod['id']) . ")'>Eliminar</button>
            </td>
        </tr>";
}
?>