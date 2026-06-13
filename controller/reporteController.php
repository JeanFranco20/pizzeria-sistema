<?php
// Controlador de Reportes
// Genera reportes de ventas por rango de fechas (RF04)

if (!isset($_SESSION['usuario_id'])) {
    header('Location: index.php?page=login');
    exit;
}

require_once __DIR__ . '/../models/Venta.php';

$ventaModelo = new Venta($conexion);

// Si no eligen fechas, por defecto mostramos los últimos 7 días
$desde = $_GET['desde'] ?? date('Y-m-d', strtotime('-7 days'));
$hasta = $_GET['hasta'] ?? date('Y-m-d');

$ventas = $ventaModelo->listarPorFecha($desde, $hasta);
$totalVentas = $ventaModelo->totalPorFecha($desde, $hasta);
$masVendidos = $ventaModelo->productosMasVendidos($desde, $hasta);

require __DIR__ . '/../public/views/reportes.php';
