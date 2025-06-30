<?php
class DB {
    private static $instance = null;
    private $pdo;

    private function __construct() {
        $servidor = "mysql:dbname=crud;host=localhost";
        $user = "root";
        $pass = "";
        $this->pdo = new PDO($servidor, $user, $pass, array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8"));
    }

    public static function getInstance() {
        if (self::$instance == null) {
            self::$instance = new DB();
        }
        return self::$instance;
    }

    public function insertSeguro($tabla, $datos) {
        $campos = implode(",", array_keys($datos));
        $placeholders = ":" . implode(", :", array_keys($datos));
        $sql = "INSERT INTO $tabla ($campos) VALUES ($placeholders)";
        $stmt = $this->pdo->prepare($sql);
        foreach ($datos as $campo => $valor) {
            $stmt->bindValue(":$campo", $valor);
        }
        return $stmt->execute();
    }

    public function updateSeguro($tabla, $datos, $where) {
        $sets = [];
        foreach($datos as $campo => $valor) {
            $sets[] = "$campo = :$campo";
        }
        $setString = implode(", ", $sets);
        $sql = "UPDATE $tabla SET $setString WHERE $where";
        $stmt = $this->pdo->prepare($sql);
        foreach ($datos as $campo => $valor) {
            $stmt->bindValue(":$campo", $valor);
        }
        return $stmt->execute();
    }

    public function query($sql, $params = []) {
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute($params);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
?>