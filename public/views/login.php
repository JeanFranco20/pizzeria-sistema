<?php require __DIR__ . '/header.php'; ?>

<div class="row justify-content-center">
    <div class="col-md-5 col-lg-4">

        <div class="text-center mt-5 mb-3">
            <h1>🍕</h1>
            <h3 class="fw-bold">Rapi Pizza</h3>
            <p class="text-muted">Sistema de Pedidos y Ventas</p>
        </div>

        <div class="card shadow-sm">
            <div class="card-body p-4">

                <h5 class="card-title mb-3 text-center">Iniciar sesión</h5>

                <?php if (!empty($error)): ?>
                    <div class="alert alert-danger py-2">
                        <?php echo htmlspecialchars($error); ?>
                    </div>
                <?php endif; ?>

                <form method="POST" action="index.php?page=login&accion=login">

                    <div class="mb-3">
                        <label class="form-label">Correo electrónico</label>
                        <input type="email" name="correo" class="form-control" placeholder="ejemplo@pizzeria.com" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Contraseña</label>
                        <input type="password" name="password" class="form-control" placeholder="••••••••" required>
                    </div>

                    <button type="submit" class="btn btn-danger w-100">Ingresar</button>

                </form>

                <p class="text-center mt-3 mb-0">
                    ¿No tienes cuenta?
                    <a href="index.php?page=login&accion=registro">Regístrate aquí</a>
                </p>

            </div>
        </div>

        <div class="alert alert-secondary mt-3 small">
            <strong>Usuarios de prueba:</strong><br>
            admin@pizzeria.com / admin123<br>
            cajero@pizzeria.com / cajero123
        </div>

    </div>
</div>

<?php require __DIR__ . '/footer.php'; ?>
