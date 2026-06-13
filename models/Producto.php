<?php
// Modelo Producto
// Funciones relacionadas a la tabla producto (RF08 Gestión de productos)

class Producto {

    private $conexion;

    public function __construct($conexion) {
        $this->conexion = $conexion;
    }

    // Trae todos los productos (activos e inactivos) para el panel del admin
    public function listarTodos() {
        $sql = "SELECT * FROM producto ORDER BY categoria, nombre";
        $stmt = $this->conexion->query($sql);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Trae solo los productos activos (para usarlos al registrar una venta)
    public function listarActivos() {
        $sql = "SELECT * FROM producto WHERE activo = 1 ORDER BY categoria, nombre";
        $stmt = $this->conexion->query($sql);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Busca un producto por su id
    public function buscarPorId($id) {
        $sql = "SELECT * FROM producto WHERE id = ?";
        $stmt = $this->conexion->prepare($sql);
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // Registra un nuevo producto
    public function registrar($nombre, $descripcion, $categoria, $precio) {
        $sql = "INSERT INTO producto (nombre, descripcion, categoria, precio) VALUES (?, ?, ?, ?)";
        $stmt = $this->conexion->prepare($sql);
        return $stmt->execute([$nombre, $descripcion, $categoria, $precio]);
    }

    // Edita un producto existente
    public function editar($id, $nombre, $descripcion, $categoria, $precio) {
        $sql = "UPDATE producto SET nombre = ?, descripcion = ?, categoria = ?, precio = ? WHERE id = ?";
        $stmt = $this->conexion->prepare($sql);
        return $stmt->execute([$nombre, $descripcion, $categoria, $precio, $id]);
    }

    // En vez de eliminar, se desactiva el producto (no se borra el historial)
    public function desactivar($id) {
        $sql = "UPDATE producto SET activo = 0 WHERE id = ?";
        $stmt = $this->conexion->prepare($sql);
        return $stmt->execute([$id]);
    }

    // Vuelve a activar un producto
    public function activar($id) {
        $sql = "UPDATE producto SET activo = 1 WHERE id = ?";
        $stmt = $this->conexion->prepare($sql);
        return $stmt->execute([$id]);
    }
}
