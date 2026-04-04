<?php include 'views/layout/header.php'; ?>

<div class="row justify-content-center">
    <div class="col-md-5">
        <div class="card shadow">
            <div class="card-header bg-primary text-white text-center py-3">
                <h3 class="h5 mb-0"><i class="fas fa-user-shield me-2"></i> Acceso Administrativo</h3>
            </div>
            <div class="card-body p-4">
                <?php if (isset($_GET['error'])): ?>
                    <div class="alert alert-danger mb-4">
                        <i class="fas fa-exclamation-triangle me-2"></i> Credenciales incorrectas
                    </div>
                <?php endif; ?>
                
                <form action="app/controllers/AuthController.php?action=login" method="POST">
                    <div class="mb-3">
                        <label for="usuario" class="form-label">Usuario</label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="fas fa-user"></i></span>
                            <input type="text" class="form-control" id="usuario" name="usuario" required autofocus>
                        </div>
                    </div>
                    <div class="mb-4">
                        <label for="password" class="form-label">Contraseña</label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="fas fa-lock"></i></span>
                            <input type="password" class="form-control" id="password" name="password" required>
                        </div>
                    </div>
                    <div class="d-grid">
                        <button type="submit" class="btn btn-primary py-2">INGRESAR AL PANEL</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<?php include 'views/layout/footer.php'; ?>
