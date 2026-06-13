<?php
// Controlador de Producto
// Gestión de productos (RF08): registrar, editar, activar/desactivar

if (!isset($_SESSION['usuario_id'])) {
    header('Location: index.php?page=login');
    exit;
}

require_once __DIR__ . '/../models/Producto.php';

$productoModelo = new Producto($conexion);

$mensaje = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    // ---------- GUARDAR (nuevo o editar) ----------
    if (isset($_POST['guardar'])) {

        $nombre = trim($_POST['nombre']);
        $descripcion = trim($_POST['descripcion']);
        $categoria = trim($_POST['categoria']);
        $precio = $_POST['precio'];

        if ($nombre === '' || $categoria === '' || $precio === '') {
            $mensaje = "Por favor completa los campos obligatorios (nombre, categoría y precio)";

        } else {

            if (!empty($_POST['id'])) {
                // Si viene un id, estamos editando
                $productoModelo->editar($_POST['id'], $nombre, $descripcion, $categoria, $precio);
                $mensaje = "Producto actualizado correctamente";
            } else {
                // Si no hay id, es un producto nuevo
                $productoModelo->registrar($nombre, $descripcion, $categoria, $precio);
                $mensaje = "Producto registrado correctamente";
            }
        }
    }

    // ---------- DESACTIVAR ----------
    if (isset($_POST['desactivar'])) {
        $productoModelo->desactivar($_POST['id']);
        $mensaje = "Producto desactivado";
    }

    // ---------- ACTIVAR ----------
    if (isset($_POST['activar'])) {
        $productoModelo->activar($_POST['id']);
        $mensaje = "Producto activado";
    }
}

// Si viene ?editar=ID en la url, cargamos los datos de ese producto para el formulario
$productoEditar = null;
if (isset($_GET['editar'])) {
    $productoEditar = $productoModelo->buscarPorId($_GET['editar']);
}

$productos = $productoModelo->listarTodos();

require __DIR__ . '/../public/views/productos.php';
