<?php
require_once "Modelo/conexion.php";

class Producto {
    public $id;
    public $codigo;
    public $producto;
    public $precio;
    public $cantidad;
    public $errors = [];

    public function __construct($data = []) {
        $this->id = $data['idp'] ?? null;
        $this->codigo = trim($data['codigo'] ?? '');
        $this->producto = trim($data['producto'] ?? '');
        $this->precio = $data['precio'] ?? '';
        $this->cantidad = $data['cantidad'] ?? '';
    }

    public function validar() {
        $this->errors = [];
        if ($this->codigo === '') $this->errors[] = "El campo Código es obligatorio.";
        if ($this->producto === '') $this->errors[] = "El campo Producto es obligatorio.";
        if ($this->precio === '' || !is_numeric($this->precio) || $this->precio < 0) $this->errors[] = "El precio debe ser un número mayor o igual a 0.";
        if ($this->cantidad === '' || !is_numeric($this->cantidad) || $this->cantidad < 0) $this->errors[] = "La cantidad debe ser un número mayor o igual a 0.";
        return empty($this->errors);
    }

    public function guardar() {
        if (!$this->validar()) return false;
        $db = DB::getInstance();
        $datos = [
            'codigo' => $this->codigo,
            'producto' => $this->producto,
            'precio' => $this->precio,
            'cantidad' => $this->cantidad
        ];
        return $db->insertSeguro('productos', $datos);
    }

    public function editar() {
        if (!$this->validar()) return false;
        $db = DB::getInstance();
        $datos = [
            'codigo' => $this->codigo,
            'producto' => $this->producto,
            'precio' => $this->precio,
            'cantidad' => $this->cantidad
        ];
        return $db->updateSeguro('productos', $datos, "id = ".$this->id);
    }

    public static function buscar($criterio = "") {
        $db = DB::getInstance();
        if ($criterio === "") {
            return $db->query("SELECT * FROM productos ORDER BY id DESC");
        }
        $query = "SELECT * FROM productos WHERE id LIKE ? OR producto LIKE ? OR precio LIKE ? ORDER BY id DESC";
        $param = ["%$criterio%", "%$criterio%", "%$criterio%"];
        return $db->query($query, $param);
    }
}
?>