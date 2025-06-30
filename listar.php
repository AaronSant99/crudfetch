<?php
require_once "Modelo/Productos.php";

// Obtener datos de búsqueda desde el cuerpo de la petición
$data = file_get_contents("php://input");
$productos = Producto::buscar(trim($data));

// Generar las filas de la tabla HTML
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