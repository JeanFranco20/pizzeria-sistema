<?php require __DIR__ . '/header.php'; ?>

<h3 class="mb-3">🍕 Gestión de Productos</h3>

<?php if (!empty($mensaje)): ?>
    <div class="alert alert-info"><?php echo htmlspecialchars($mensaje); ?></div>
<?php endif; ?>

<div class="row">

    <!-- Formulario para registrar / editar -->
    <div class="col-md-4">
        <div class="card shadow-sm mb-3">
            <div class="card-header bg-white">
                <strong><?php echo $productoEditar ? 'Editar producto' : 'Nuevo producto'; ?></strong>
            </div>
            <div class="card-body">

                <form method="POST" action="index.php?page=productos">

                    <?php if ($productoEditar): ?>
                        <input type="hidden" name="id" value="<?php echo $productoEditar['id']; ?>">
                    <?php endif; ?>

                    <div class="mb-3">
                        <label class="form-label">Nombre</label>
                        <input type="text" name="nombre" class="form-control"
                               value="<?php echo $productoEditar ? htmlspecialchars($productoEditar['nombre']) : ''; ?>" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Descripción</label>
                        <textarea name="descripcion" class="form-control" rows="2"><?php echo $productoEditar ? htmlspecialchars($productoEditar['descripcion']) : ''; ?></textarea>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Categoría</label>
                        <input type="text" name="categoria" class="form-control" placeholder="Pizza, Bebida, Entrada..."
                               value="<?php echo $productoEditar ? htmlspecialchars($productoEditar['categoria']) : ''; ?>" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Precio (S/)</label>
                        <input type="number" step="0.01" name="precio" class="form-control"
                               value="<?php echo $productoEditar ? $productoEditar['precio'] : ''; ?>" required>
                    </div>

                    <button type="submit" name="guardar" class="btn btn-danger w-100">
                        <?php echo $productoEditar ? 'Actualizar' : 'Guardar'; ?>
                    </button>

                    <?php if ($productoEditar): ?>
                        <a href="index.php?page=productos" class="btn btn-secondary w-100 mt-2">Cancelar</a>
                    <?php endif; ?>

                </form>

            </div>
        </div>
    </div>

    <!-- Listado de productos -->
    <div class="col-md-8">
        <div class="card shadow-sm">
            <div class="card-header bg-white">
                <strong>Listado de productos</strong>
            </div>
            <div class="card-body">

                <table class="table table-hover align-middle">
                    <thead>
                        <tr>
                            <th>Nombre</th>
                            <th>Categoría</th>
                            <th>Precio</th>
                            <th>Estado</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($productos as $producto): ?>
                            <tr>
                                <td>
                                    <?php echo htmlspecialchars($producto['nombre']); ?>
                                    <?php if (!empty($producto['descripcion'])): ?>
                                        <br><small class="text-muted"><?php echo htmlspecialchars($producto['descripcion']); ?></small>
                                    <?php endif; ?>
                                </td>
                                <td><?php echo htmlspecialchars($producto['categoria']); ?></td>
                                <td>S/ <?php echo number_format($producto['precio'], 2); ?></td>
                                <td>
                                    <?php if ($producto['activo'] == 1): ?>
                                        <span class="badge bg-success">Activo</span>
                                    <?php else: ?>
                                        <span class="badge bg-secondary">Inactivo</span>
                                    <?php endif; ?>
                                </td>
                                <td>
                                    <a href="index.php?page=productos&editar=<?php echo $producto['id']; ?>" class="btn btn-sm btn-outline-primary">
                                        Editar
                                    </a>

                                    <?php if ($producto['activo'] == 1): ?>
                                        <form method="POST" action="index.php?page=productos" class="d-inline">
                                            <input type="hidden" name="id" value="<?php echo $producto['id']; ?>">
                                            <button type="submit" name="desactivar" class="btn btn-sm btn-outline-danger"
                                                    onclick="return confirm('¿Desactivar este producto?')">
                                                Desactivar
                                            </button>
                                        </form>
                                    <?php else: ?>
                                        <form method="POST" action="index.php?page=productos" class="d-inline">
                                            <input type="hidden" name="id" value="<?php echo $producto['id']; ?>">
                                            <button type="submit" name="activar" class="btn btn-sm btn-outline-success">
                                                Activar
                                            </button>
                                        </form>
                                    <?php endif; ?>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>

                <?php if (empty($productos)): ?>
                    <p class="text-muted">Aún no hay productos registrados.</p>
                <?php endif; ?>

            </div>
        </div>
    </div>

</div>

<?php require __DIR__ . '/footer.php'; ?>
