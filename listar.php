<?php
// Obtener datos de búsqueda desde el cuerpo de la petición
$data = file_get_contents("php://input");

// Incluir archivo de conexión a la base de datos
require "conexion.php";

// Consulta por defecto: obtener todos los productos ordenados por ID descendente
$consulta = $pdo->prepare("SELECT * FROM productos ORDER BY id DESC");
$consulta->execute();

// Si hay datos de búsqueda, realizar búsqueda filtrada
if ($data != "") {
    // Buscar en los campos id, producto y precio usando LIKE
    $consulta = $pdo->prepare("SELECT * FROM productos WHERE id LIKE '%".$data."%' OR producto LIKE '%".$data."%' OR precio LIKE '%".$data."%'");
    $consulta->execute();
}

// Obtener todos los resultados
$resultado = $consulta->fetchAll(PDO::FETCH_ASSOC);

// Generar las filas de la tabla HTML
foreach ($resultado as $data) {
    echo "<tr>
            <td>" . $data['id'] . "</td>
            <td>" . $data['producto'] . "</td>
            <td>" . $data['precio'] . "</td>
            <td>" . $data['cantidad'] . "</td>
            <td>
                <button type='button' class='btn btn-success' onclick=Editar('" . $data['id'] . "')>Editar</button>
                <button type='button' class='btn btn-danger' onclick=Eliminar('" . $data['id'] . "')>Eliminar</button>
            </td>        
        </tr>";
}
