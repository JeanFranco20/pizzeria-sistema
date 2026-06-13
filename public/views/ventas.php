<?php require __DIR__ . '/header.php'; ?>

<h3 class="mb-3">🛒 Registrar Venta</h3>

<?php if (!empty($mensaje)): ?>
    <div class="alert alert-info"><?php echo htmlspecialchars($mensaje); ?></div>
<?php endif; ?>

<form method="POST" action="index.php?page=ventas">

    <div class="row">

        <!-- Lista de productos -->
        <div class="col-md-8">
            <div class="card shadow-sm mb-3">
                <div class="card-header bg-white">
                    <strong>Productos disponibles</strong>
                </div>
                <div class="card-body">

                    <table class="table table-hover align-middle">
                        <thead>
                            <tr>
                                <th>Producto</th>
                                <th>Categoría</th>
                                <th>Precio</th>
                                <th style="width: 120px;">Cantidad</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($productos as $producto): ?>
                                <tr>
                                    <td>
                                        <input type="hidden" name="producto_id[]" value="<?php echo $producto['id']; ?>">
                                        <?php echo htmlspecialchars($producto['nombre']); ?>
                                        <?php if (!empty($producto['descripcion'])): ?>
                                            <br><small class="text-muted"><?php echo htmlspecialchars($producto['descripcion']); ?></small>
                                        <?php endif; ?>
                                    </td>
                                    <td><?php echo htmlspecialchars($producto['categoria']); ?></td>
                                    <td class="precio-producto" data-precio="<?php echo $producto['precio']; ?>">
                                        S/ <?php echo number_format($producto['precio'], 2); ?>
                                    </td>
                                    <td>
                                        <input type="number" name="cantidad[]" min="0" value="0" class="form-control input-cantidad">
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>

                    <?php if (empty($productos)): ?>
                        <p class="text-muted">No hay productos activos registrados.</p>
                    <?php endif; ?>

                </div>
            </div>
        </div>

        <!-- Datos de la venta y el pedido -->
        <div class="col-md-4">
            <div class="card shadow-sm mb-3">
                <div class="card-header bg-white">
                    <strong>Datos del pedido</strong>
                </div>
                <div class="card-body">

                    <div class="mb-3">
                        <label class="form-label">Tipo de pedido</label>
                        <select name="tipo_pedido" id="tipo_pedido" class="form-select" required>
                            <option value="local">En local (mesa)</option>
                            <option value="llevar">Para llevar</option>
                            <option value="delivery">Delivery</option>
                        </select>
                    </div>

                    <div class="mb-3" id="campo_mesa">
                        <label class="form-label">N° de mesa</label>
                        <input type="number" name="numero_mesa" class="form-control" min="1">
                    </div>

                    <div class="mb-3 d-none" id="campo_cliente">
                        <label class="form-label">Nombre del cliente</label>
                        <input type="text" name="nombre_cliente" class="form-control">
                    </div>

                    <div class="mb-3 d-none" id="campo_direccion">
                        <label class="form-label">Dirección de entrega</label>
                        <input type="text" name="direccion" class="form-control">
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Método de pago</label>
                        <select name="metodo_pago" class="form-select" required>
                            <option value="efectivo">Efectivo</option>
                            <option value="tarjeta">Tarjeta</option>
                            <option value="yape">Yape / Plin</option>
                        </select>
                    </div>

                </div>
            </div>

            <div class="card shadow-sm mb-3">
                <div class="card-body text-end">
                    <h5>Total: S/ <span id="totalVenta">0.00</span></h5>
                </div>
            </div>

            <button type="submit" name="registrar_venta" class="btn btn-danger w-100">
                Registrar venta y enviar a cocina
            </button>
        </div>

    </div>

</form>

<?php require __DIR__ . '/footer.php'; ?>
