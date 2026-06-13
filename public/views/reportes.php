<?php require __DIR__ . '/header.php'; ?>

<h3 class="mb-3">📊 Reporte de Ventas</h3>

<!-- Filtro de fechas -->
<div class="card shadow-sm mb-3">
    <div class="card-body">
        <form method="GET" action="index.php" class="row g-3 align-items-end">
            <input type="hidden" name="page" value="reportes">

            <div class="col-md-3">
                <label class="form-label">Desde</label>
                <input type="date" name="desde" class="form-control" value="<?php echo $desde; ?>">
            </div>

            <div class="col-md-3">
                <label class="form-label">Hasta</label>
                <input type="date" name="hasta" class="form-control" value="<?php echo $hasta; ?>">
            </div>

            <div class="col-md-3">
                <button type="submit" class="btn btn-danger">Filtrar</button>
            </div>
        </form>
    </div>
</div>

<div class="row">

    <!-- Total vendido -->
    <div class="col-md-4 mb-3">
        <div class="card shadow-sm text-center">
            <div class="card-body">
                <h6 class="text-muted">Total vendido en el periodo</h6>
                <h2 class="text-danger">S/ <?php echo number_format($totalVentas, 2); ?></h2>
            </div>
        </div>
    </div>

    <!-- Productos más vendidos -->
    <div class="col-md-8 mb-3">
        <div class="card shadow-sm">
            <div class="card-header bg-white">
                <strong>Productos más vendidos</strong>
            </div>
            <div class="card-body">

                <?php if (empty($masVendidos)): ?>
                    <p class="text-muted mb-0">No hay datos en este periodo.</p>
                <?php else: ?>
                    <table class="table table-sm mb-0">
                        <thead>
                            <tr>
                                <th>Producto</th>
                                <th>Cantidad vendida</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($masVendidos as $item): ?>
                                <tr>
                                    <td><?php echo htmlspecialchars($item['nombre']); ?></td>
                                    <td><?php echo $item['cantidad_total']; ?></td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                <?php endif; ?>

            </div>
        </div>
    </div>

</div>

<!-- Detalle de ventas -->
<div class="card shadow-sm">
    <div class="card-header bg-white">
        <strong>Detalle de ventas</strong>
    </div>
    <div class="card-body">

        <?php if (empty($ventas)): ?>
            <p class="text-muted mb-0">No se encontraron ventas en el periodo seleccionado.</p>
        <?php else: ?>
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th>N° Venta</th>
                        <th>Fecha</th>
                        <th>Cajero</th>
                        <th>Método de pago</th>
                        <th>Estado</th>
                        <th>Total</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($ventas as $venta): ?>
                        <tr>
                            <td>#<?php echo $venta['id']; ?></td>
                            <td><?php echo date('d/m/Y H:i', strtotime($venta['fecha'])); ?></td>
                            <td><?php echo htmlspecialchars($venta['cajero']); ?></td>
                            <td><?php echo htmlspecialchars($venta['metodo_pago']); ?></td>
                            <td>
                                <span class="badge bg-success"><?php echo htmlspecialchars($venta['estado']); ?></span>
                            </td>
                            <td>S/ <?php echo number_format($venta['total'], 2); ?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php endif; ?>

    </div>
</div>

<?php require __DIR__ . '/footer.php'; ?>
