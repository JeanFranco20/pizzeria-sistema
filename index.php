<?php
// index.php
// Este archivo es el punto de entrada del sistema.
// Según el valor de "page" en la URL, carga el controlador correspondiente.

session_start();
require_once 'config/conexion.php';

$page = $_GET['page'] ?? 'login';

switch ($page) {

    case 'login':
        require 'controller/usuarioController.php';
        break;

    case 'productos':
        require 'controller/productoController.php';
        break;

    case 'ventas':
        require 'controller/ventaController.php';
        break;

    case 'pedidos':
        require 'controller/pedidoController.php';
        break;

    case 'reportes':
        require 'controller/reporteController.php';
        break;

    case 'logout':
        session_destroy();
        header('Location: index.php?page=login');
        break;

    default:
        require 'controller/usuarioController.php';
        break;
}
