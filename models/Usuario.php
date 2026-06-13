<?php
// Modelo Usuario
// Aquí están todas las funciones que tienen que ver con la tabla usuario

class Usuario {

    private $conexion;

    public function __construct($conexion) {
        $this->conexion = $conexion;
    }

    // Busca un usuario activo por su correo (sirve para el login)
    public function buscarPorCorreo($correo) {
        $sql = "SELECT * FROM usuario WHERE correo = ? AND activo = 1";
        $stmt = $this->conexion->prepare($sql);
        $stmt->execute([$correo]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // Registra un nuevo usuario (por defecto con el rol "cajero")
    public function registrar($nombre, $correo, $password, $rol = 'cajero') {
        $passwordEncriptada = password_hash($password, PASSWORD_DEFAULT);

        $sql = "INSERT INTO usuario (nombre, correo, password, rol) VALUES (?, ?, ?, ?)";
        $stmt = $this->conexion->prepare($sql);
        return $stmt->execute([$nombre, $correo, $passwordEncriptada, $rol]);
    }

    // Lista todos los usuarios (para que el admin los vea)
    public function listarTodos() {
        $sql = "SELECT id, nombre, correo, rol, activo FROM usuario ORDER BY id";
        $stmt = $this->conexion->query($sql);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
