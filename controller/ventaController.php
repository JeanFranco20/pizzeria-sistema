<?php
// Controlador de Venta
// Permite registrar una venta y generar automáticamente su pedido (RF03 + RF05)

if (!isset($_SESSION['usuario_id'])) {
    header('Location: index.php?page=login');
    exit;
}

require_once __DIR__ . '/../models/Producto.php';
require_once __DIR__ . '/../models/Venta.php';

$productoModelo = new Producto($conexion);
$ventaModelo = new Venta($conexion);

$mensaje = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['registrar_venta'])) {

    $productosIds = $_POST['producto_id'] ?? [];
    $cantidades = $_POST['cantidad'] ?? [];
    $metodoPago = $_POST['metodo_pago'];
    $tipoPedido = $_POST['tipo_pedido'];

    $numeroMesa = isset($_POST['numero_mesa']) ? trim($_POST['numero_mesa']) : '';
    $nombreCliente = isset($_POST['nombre_cliente']) ? trim($_POST['nombre_cliente']) : '';
    $direccion = isset($_POST['direccion']) ? trim($_POST['direccion']) : '';

    $idVenta = $ventaModelo->registrarVentaCompleta(
        $_SESSION['usuario_id'],
        $metodoPago,
        $tipoPedido,
        $numeroMesa,
        $nombreCliente,
        $direccion,
        $productosIds,
        $cantidades
    );

    if ($idVenta) {
        $mensaje = "Venta registrada correctamente. N° de venta: " . $idVenta;
    } else {
        $mensaje = "Debes seleccionar al menos un producto con cantidad mayor a 0";
    }
}

$productos = $productoModelo->listarActivos();

require __DIR__ . '/../public/views/ventas.php';
