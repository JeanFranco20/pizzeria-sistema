<?php require __DIR__ . '/header.php'; ?>

<div class="row justify-content-center">
    <div class="col-md-5 col-lg-4">

        <div class="text-center mt-5 mb-3">
            <h1>🍕</h1>
            <h3 class="fw-bold">Rapi Pizza</h3>
            <p class="text-muted">Crear una cuenta nueva</p>
        </div>

        <div class="card shadow-sm">
            <div class="card-body p-4">

                <h5 class="card-title mb-3 text-center">Registro</h5>

                <?php if (!empty($error)): ?>
                    <div class="alert alert-danger py-2">
                        <?php echo htmlspecialchars($error); ?>
                    </div>
                <?php endif; ?>

                <form method="POST" action="index.php?page=login&accion=registro">

                    <div class="mb-3">
                        <label class="form-label">Nombre completo</label>
                        <input type="text" name="nombre" class="form-control" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Correo electrónico</label>
                        <input type="email" name="correo" class="form-control" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Contraseña</label>
                        <input type="password" name="password" class="form-control" required>
                    </div>

                    <button type="submit" class="btn btn-danger w-100">Registrarme</button>

                </form>

                <p class="text-center mt-3 mb-0">
                    ¿Ya tienes cuenta?
                    <a href="index.php?page=login">Inicia sesión</a>
                </p>

            </div>
        </div>

    </div>
</div>

<?php require __DIR__ . '/footer.php'; ?>
