<?php require __DIR__ . '/header.php'; ?>

<h3 class="mb-3">👨‍🍳 Pedidos en Cocina</h3>

<div class="row">

    <?php if (empty($pedidos)): ?>

        <div class="col-12">
            <div class="alert alert-secondary text-center">
                No hay pedidos registrados todavía.
            </div>
        </div>

    <?php else: ?>

        <?php foreach ($pedidos as $pedido): ?>

            <?php
                // Definimos un color según el estado del pedido
                switch ($pedido['estado']) {
                    case 'pendiente':
                        $colorBorde = 'border-warning';
                        $colorBadge = 'bg-warning text-dark';
                        break;
                    case 'en_preparacion':
                        $colorBorde = 'border-primary';
                        $colorBadge = 'bg-primary';
                        break;
                    case 'listo':
                        $colorBorde = 'border-success';
                        $colorBadge = 'bg-success';
                        break;
                    default:
                        $colorBorde = 'border-secondary';
                        $colorBadge = 'bg-secondary';
                        break;
                }
            ?>

            <div class="col-md-4 mb-3">
                <div class="card shadow-sm <?php echo $colorBorde; ?>" style="border-width: 2px;">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <strong>Pedido #<?php echo $pedido['id']; ?></strong>
                        <span class="badge <?php echo $colorBadge; ?>">
                            <?php echo strtoupper(str_replace('_', ' ', $pedido['estado'])); ?>
                        </span>
                    </div>

                    <div class="card-body">

                        <p class="mb-1">
                            <strong>Tipo:</strong> <?php echo strtoupper($pedido['tipo']); ?>
                        </p>

                        <?php if ($pedido['tipo'] == 'local' && $pedido['numero_mesa']): ?>
                            <p class="mb-1"><strong>Mesa:</strong> <?php echo $pedido['numero_mesa']; ?></p>
                        <?php endif; ?>

                        <?php if (!empty($pedido['nombre_cliente'])): ?>
                            <p class="mb-1"><strong>Cliente:</strong> <?php echo htmlspecialchars($pedido['nombre_cliente']); ?></p>
                        <?php endif; ?>

                        <?php if (!empty($pedido['direccion'])): ?>
                            <p class="mb-1"><strong>Dirección:</strong> <?php echo htmlspecialchars($pedido['direccion']); ?></p>
                        <?php endif; ?>

                        <p class="mb-2"><strong>Hora:</strong> <?php echo date('d/m/Y H:i', strtotime($pedido['fecha'])); ?></p>

                        <hr>

                        <ul class="list-unstyled mb-3">
                            <?php foreach ($pedido['detalles'] as $detalle): ?>
                                <li>
                                    <?php echo $detalle['cantidad']; ?> x <?php echo htmlspecialchars($detalle['nombre']); ?>
                                </li>
                            <?php endforeach; ?>
                        </ul>

                        <!-- Formulario para cambiar el estado -->
                        <form method="POST" action="index.php?page=pedidos" class="d-flex gap-2">
                            <input type="hidden" name="comanda_id" value="<?php echo $pedido['id']; ?>">

                            <select name="nuevo_estado" class="form-select form-select-sm">
                                <option value="pendiente" <?php echo $pedido['estado'] == 'pendiente' ? 'selected' : ''; ?>>Pendiente</option>
                                <option value="en_preparacion" <?php echo $pedido['estado'] == 'en_preparacion' ? 'selected' : ''; ?>>En preparación</option>
                                <option value="listo" <?php echo $pedido['estado'] == 'listo' ? 'selected' : ''; ?>>Listo</option>
                                <option value="entregado" <?php echo $pedido['estado'] == 'entregado' ? 'selected' : ''; ?>>Entregado</option>
                            </select>

                            <button type="submit" name="cambiar_estado" class="btn btn-sm btn-danger">Actualizar</button>
                        </form>

                    </div>
                </div>
            </div>

        <?php endforeach; ?>

    <?php endif; ?>

</div>

<?php require __DIR__ . '/footer.php'; ?>
