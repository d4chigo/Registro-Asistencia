<?php
// views/attendance/register.php
include 'views/layout/header.php';
?>

<div class="row justify-content-center">
    <div class="col-md-6">
        <div class="card shadow">
            <div class="card-header bg-white text-center py-4">
                <h2 class="h4 mb-0">Registro de Asistencia</h2>
                <p class="text-muted mb-0"><?php echo date('d/m/Y'); ?> - <span id="reloj">00:00:00</span></p>
            </div>
            <div class="card-body p-5 text-center">
                <form id="formAsistencia" action="app/controllers/AttendanceController.php?action=register" method="POST">
                    <div class="mb-4 text-start">
                        <label for="dni" class="form-label fw-bold">Ingrese su DNI</label>
                        <input type="text" class="form-control form-control-lg text-center" id="dni" name="dni" placeholder="Ej: 12345678" required autofocus>
                    </div>
                    <div class="d-grid gap-2">
                        <button type="submit" class="btn btn-primary btn-lg py-3">
                            <i class="fas fa-fingerprint"></i> REGISTRAR MARCAJE
                        </button>
                    </div>
                </form>
            </div>
        </div>
        
        <!-- Mensajes de éxito/error -->
        <div id="resultado" class="mt-4">
            <?php if (isset($_GET['status'])): ?>
                <?php 
                    $alertClass = 'alert-info';
                    if($_GET['status'] == 'success') $alertClass = 'alert-success';
                    if($_GET['status'] == 'error') $alertClass = 'alert-danger';
                    if($_GET['status'] == 'warning') $alertClass = 'alert-warning';
                ?>
                <div class="alert <?php echo $alertClass; ?> alert-dismissible fade show shadow-sm" role="alert">
                    <i class="fas <?php echo $_GET['status'] == 'success' ? 'fa-check-circle' : 'fa-exclamation-circle'; ?> me-2"></i>
                    <?php echo htmlspecialchars($_GET['msg']); ?>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            <?php endif; ?>
        </div>
    </div>
</div>

<script>
function actualizarReloj() {
    const ahora = new Date();
    document.getElementById('reloj').innerText = ahora.toLocaleTimeString();
}
setInterval(actualizarReloj, 1000);
actualizarReloj();
</script>

<?php include 'views/layout/footer.php'; ?>
