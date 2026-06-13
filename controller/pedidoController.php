<?php
// Controlador de Pedidos (vista cocina)
// Muestra los pedidos pendientes y permite cambiar su estado (RF06 y RF07)

if (!isset($_SESSION['usuario_id'])) {
    header('Location: index.php?page=login');
    exit;
}

require_once __DIR__ . '/../models/Comanda.php';

$comandaModelo = new Comanda($conexion);

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['cambiar_estado'])) {
    $comandaModelo->actualizarEstado($_POST['comanda_id'], $_POST['nuevo_estado']);
}

$pedidos = $comandaModelo->listarPedidos();

require __DIR__ . '/../public/views/cocina.php';
