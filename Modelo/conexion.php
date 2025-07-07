<?php
/**
 * Clase DB - Maneja la conexión a la base de datos
 * Implementa el patrón Singleton para una sola instancia de conexión
 */
class DB {
    private static $instance = null; // Instancia única de la clase
    private $pdo; // Objeto PDO para conexión

    /**
     * Constructor privado - Establece la conexión a la base de datos
     * Solo se puede crear una instancia desde getInstance()
     */
    private function __construct() {
        // Configuración de la conexión
        $servidor = "mysql:dbname=crud;host=localhost";
        $user = "root";
        $pass = "";
        
        // Crear conexión PDO con configuración UTF-8
        $this->pdo = new PDO($servidor, $user, $pass, array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8"));
    }

    /**
     * Obtiene la instancia única de la clase (Patrón Singleton)
     * @return DB - Instancia de la clase DB
     */
    public static function getInstance() {
        // Si no existe instancia, la crea
        if (self::$instance == null) {
            self::$instance = new DB();
        }
        return self::$instance;
    }

    /**
     * Inserta datos de forma segura usando prepared statements
     * @param string $tabla - Nombre de la tabla
     * @param array $datos - Array asociativo con los datos a insertar
     * @return bool - true si se insertó correctamente
     */
    public function insertSeguro($tabla, $datos) {
        // Obtiene los nombres de las columnas
        $campos = implode(",", array_keys($datos));
        
        // Crea placeholders para los valores (:campo1, :campo2, etc.)
        $placeholders = ":" . implode(", :", array_keys($datos));
        
        // Construye la consulta SQL
        $sql = "INSERT INTO $tabla ($campos) VALUES ($placeholders)";
        
        // Prepara la consulta
        $stmt = $this->pdo->prepare($sql);
        
        // Vincula cada valor a su placeholder
        foreach ($datos as $campo => $valor) {
            $stmt->bindValue(":$campo", $valor);
        }
        
        // Ejecuta la consulta
        return $stmt->execute();
    }

    /**
     * Actualiza datos de forma segura usando prepared statements
     * @param string $tabla - Nombre de la tabla
     * @param array $datos - Array asociativo con los datos a actualizar
     * @param string $where - Condición WHERE para la actualización
     * @return bool - true si se actualizó correctamente
     */
    public function updateSeguro($tabla, $datos, $where) {
        $sets = [];
        
        // Crea las cláusulas SET (campo = :campo)
        foreach($datos as $campo => $valor) {
            $sets[] = "$campo = :$campo";
        }
        
        // Une todas las cláusulas SET
        $setString = implode(", ", $sets);
        
        // Construye la consulta SQL
        $sql = "UPDATE $tabla SET $setString WHERE $where";
        
        // Prepara la consulta
        $stmt = $this->pdo->prepare($sql);
        
        // Vincula cada valor a su placeholder
        foreach ($datos as $campo => $valor) {
            $stmt->bindValue(":$campo", $valor);
        }
        
        // Ejecuta la consulta
        return $stmt->execute();
    }

    /**
     * Ejecuta consultas SQL de forma segura
     * @param string $sql - Consulta SQL a ejecutar
     * @param array $params - Parámetros para la consulta (opcional)
     * @return array - Array con los resultados de la consulta
     */
    public function query($sql, $params = []) {
        // Prepara la consulta
        $stmt = $this->pdo->prepare($sql);
        
        // Ejecuta con los parámetros
        $stmt->execute($params);
        
        // Retorna todos los resultados como array asociativo
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
?>