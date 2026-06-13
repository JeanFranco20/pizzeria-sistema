<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Rapi Pizza - Sistema de Pedidos y Ventas</title>

    <!-- Bootstrap 5 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Nuestros estilos -->
    <link href="public/css/estilo.css" rel="stylesheet">
</head>
<body>

<?php if (isset($_SESSION['usuario_id'])): ?>
<nav class="navbar navbar-expand-lg navbar-dark bg-danger">
    <div class="container-fluid">
        <a class="navbar-brand fw-bold" href="index.php?page=ventas">🍕 Rapi Pizza</a>

        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarMenu">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarMenu">
            <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                <li class="nav-item">
                    <a class="nav-link" href="index.php?page=ventas">Registrar Venta</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="index.php?page=pedidos">Cocina</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="index.php?page=productos">Productos</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="index.php?page=reportes">Reportes</a>
                </li>
            </ul>

            <span class="navbar-text text-white me-3">
                Hola, <strong><?php echo htmlspecialchars($_SESSION['usuario_nombre']); ?></strong>
                (<?php echo htmlspecialchars($_SESSION['usuario_rol']); ?>)
            </span>

            <a href="index.php?page=logout" class="btn btn-outline-light btn-sm">Cerrar sesión</a>
        </div>
    </div>
</nav>
<?php endif; ?>

<div class="container mt-4 mb-5">
