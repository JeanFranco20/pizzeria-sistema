<?php

$servidor = "localhost";
$usuario  = "root";
$clave    = "";
$baseDatos = "pizzeria_db";

try {
    $conexion = new PDO(
        "mysql:host=$servidor;dbname=$baseDatos;charset=utf8",
        $usuario,
        $clave
    );

    // Para que muestre los errores de SQL si algo sale mal
    $conexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

} catch (PDOException $error) {
    die("No se pudo conectar a la base de datos: " . $error->getMessage());
}
