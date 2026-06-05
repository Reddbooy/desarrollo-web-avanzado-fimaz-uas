<!-- This PHP code snippet is creating a login form for a website. Here's a breakdown of what it does: -->
<?php require_once __DIR__ . '/../layouts/header.php'; ?>
<?php $_SESSION['csrf_token'] = bin2hex(random_bytes(32)) ?>
<div class="row justify-content-center">
    <div class="col-md-5">
        <div class="card shadow-sm">
            <div class="card-header bg-primary text-white">
                Iniciar Sesion
            </div>
            <div class="card-body">
                <form action="auth/login" method="POST">
                    <input type="hidden" name="csrf" value="<?= $_SESSION['csrf_token'] ?>">
                    <div class="mb-3">
                        <label class="form-label">Usuario</label>
                        <input type="text" name="username" class="form-control" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Contraseña</label>
                        <input type="password" name="password" class="form-control" required>
                    </div>

                    <button type="submit" class="btn btn-primary w-100">Entrar</button>
                </form>
            </div>
        </div>
    </div>
</div>

<?php require_once __DIR__ . '/../layouts/footer.php'; ?>