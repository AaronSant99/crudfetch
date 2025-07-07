<?php
// Incluye la clase de conexión a la base de datos
require_once "Modelo/conexion.php";

/**
 * Clase Producto - Modelo para manejar productos
 * Contiene propiedades y métodos para CRUD de productos
 */
class Producto {
    // Propiedades del producto
    public $id;
    public $codigo;
    public $producto;
    public $precio;
    public $cantidad;
    public $errors = []; // Array para almacenar errores de validación

    /**
     * Constructor - Inicializa las propiedades con los datos recibidos
     * @param array $data - Datos del producto desde formulario
     */
    public function __construct($data = []) {
        $this->id = $data['idp'] ?? null;           // ID del producto (para edición)
        $this->codigo = trim($data['codigo'] ?? ''); // Código del producto
        $this->producto = trim($data['producto'] ?? ''); // Nombre del producto
        $this->precio = $data['precio'] ?? '';       // Precio del producto
        $this->cantidad = $data['cantidad'] ?? '';   // Cantidad en stock
    }

    /**
     * Valida los datos del producto
     * @return bool - true si todos los datos son válidos, false si hay errores
     */
    public function validar() {
        $this->errors = []; // Reinicia el array de errores
        
        // Validar código (obligatorio)
        if ($this->codigo === '') $this->errors[] = "El campo Código es obligatorio.";
        
        // Validar producto (obligatorio)
        if ($this->producto === '') $this->errors[] = "El campo Producto es obligatorio.";
        
        // Validar precio (debe ser número mayor o igual a 0)
        if ($this->precio === '' || !is_numeric($this->precio) || $this->precio < 0) {
            $this->errors[] = "El precio debe ser un número mayor o igual a 0.";
        }
        
        // Validar cantidad (debe ser número mayor o igual a 0)
        if ($this->cantidad === '' || !is_numeric($this->cantidad) || $this->cantidad < 0) {
            $this->errors[] = "La cantidad debe ser un número mayor o igual a 0.";
        }
        
        return empty($this->errors); // Retorna true si no hay errores
    }

    /**
     * Guarda un nuevo producto en la base de datos
     * @return bool - true si se guardó correctamente, false si hay errores
     */
    public function guardar() {
        // Valida los datos antes de guardar
        if (!$this->validar()) return false;
        
        // Obtiene la instancia de la base de datos
        $db = DB::getInstance();
        
        // Prepara los datos para insertar
        $datos = [
            'codigo' => $this->codigo,
            'producto' => $this->producto,
            'precio' => $this->precio,
            'cantidad' => $this->cantidad
        ];
        
        // Inserta el producto usando prepared statements
        return $db->insertSeguro('productos', $datos);
    }

    /**
     * Actualiza un producto existente en la base de datos
     * @return bool - true si se actualizó correctamente, false si hay errores
     */
    public function editar() {
        // Valida los datos antes de actualizar
        if (!$this->validar()) return false;
        
        // Obtiene la instancia de la base de datos
        $db = DB::getInstance();
        
        // Prepara los datos para actualizar
        $datos = [
            'codigo' => $this->codigo,
            'producto' => $this->producto,
            'precio' => $this->precio,
            'cantidad' => $this->cantidad
        ];
        
        // Actualiza el producto usando prepared statements
        return $db->updateSeguro('productos', $datos, "id = ".$this->id);
    }

    /**
     * Busca productos en la base de datos
     * @param string $criterio - Criterio de búsqueda (opcional)
     * @return array - Array de productos encontrados
     */
    public static function buscar($criterio = "") {
        $db = DB::getInstance();
        
        // Si no hay criterio, obtiene todos los productos
        if ($criterio === "") {
            return $db->query("SELECT * FROM productos ORDER BY id DESC");
        }
        
        // Si hay criterio, busca en ID, producto y precio
        $query = "SELECT * FROM productos WHERE id LIKE ? OR producto LIKE ? OR precio LIKE ? ORDER BY id DESC";
        $param = ["%$criterio%", "%$criterio%", "%$criterio%"]; // Parámetros para búsqueda con LIKE
        
        return $db->query($query, $param);
    }
}
?>