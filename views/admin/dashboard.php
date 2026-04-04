<?php 
// views/admin/dashboard.php
require_once 'app/models/Attendance.php';
include 'views/layout/header.php'; 

$attendanceModel = new Attendance();
$allAttendance = $attendanceModel->getAllRecords();
?>

<div class="row">
    <div class="col-12">
        <div class="card shadow mb-4">
            <div class="card-header bg-white py-3 d-flex justify-content-between align-items-center">
                <h5 class="mb-0 text-primary fw-bold"><i class="fas fa-cog me-2"></i> Panel de Administración</h5>
                <span class="badge bg-primary px-3 py-2">Bienvenido, <?php echo $_SESSION['admin_nombre']; ?></span>
            </div>
            <div class="card-body">
                <!-- Navegación por pestañas -->
                <ul class="nav nav-tabs mb-4" id="adminTabs" role="tablist">
                    <li class="nav-item">
                        <button class="nav-link active" id="employees-tab" data-bs-toggle="tab" data-bs-target="#employees" type="button">
                            <i class="fas fa-users me-2"></i> Gestión de Empleados
                        </button>
                    </li>
                    <li class="nav-item">
                        <button class="nav-link" id="attendance-tab" data-bs-toggle="tab" data-bs-target="#attendance" type="button">
                            <i class="fas fa-calendar-check me-2"></i> Reporte de Asistencia
                        </button>
                    </li>
                </ul>

                <div class="tab-content" id="adminTabsContent">
                    <!-- PESTAÑA: GESTIÓN DE EMPLEADOS -->
                    <div class="tab-pane fade show active" id="employees" role="tabpanel">
                        <div class="row">
                            <div class="col-md-4">
                                <div class="card bg-light border-0">
                                    <div class="card-body">
                                        <h6 class="fw-bold mb-3"><i class="fas fa-plus-circle me-1"></i> Registrar Nuevo</h6>
                                        <form action="app/controllers/AdminController.php?action=add_employee" method="POST">
                                            <div class="mb-3">
                                                <label class="form-label small">DNI (Identificación)</label>
                                                <input type="text" class="form-control" name="dni" required placeholder="Ej: 12345678">
                                            </div>
                                            <div class="mb-3">
                                                <label class="form-label small">Nombres</label>
                                                <input type="text" class="form-control" name="nombre" required>
                                            </div>
                                            <div class="mb-3">
                                                <label class="form-label small">Apellidos</label>
                                                <input type="text" class="form-control" name="apellido" required>
                                            </div>
                                            <div class="d-grid">
                                                <button type="submit" class="btn btn-success">REGISTRAR</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-8">
                                <div class="table-responsive">
                                    <table class="table table-hover align-middle">
                                        <thead class="table-light">
                                            <tr>
                                                <th>DNI</th>
                                                <th>Nombre Completo</th>
                                                <th>Estado</th>
                                                <th>Acciones</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            require_once 'app/config/database.php';
                                            $db = new Database();
                                            $conn = $db->getConnection();
                                            $stmt = $conn->query("SELECT * FROM usuarios WHERE rol_id = 2 ORDER BY id DESC");
                                            while($row = $stmt->fetch(PDO::FETCH_ASSOC)):
                                            ?>
                                            <tr>
                                                <td><strong><?php echo htmlspecialchars($row['dni']); ?></strong></td>
                                                <td><?php echo htmlspecialchars($row['nombre'] . ' ' . $row['apellido']); ?></td>
                                                <td><span class="badge bg-success">Activo</span></td>
                                                <td>
                                                    <button class="btn btn-sm btn-outline-primary me-1"><i class="fas fa-edit"></i></button>
                                                    <button class="btn btn-sm btn-outline-danger"><i class="fas fa-trash"></i></button>
                                                </td>
                                            </tr>
                                            <?php endwhile; ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- PESTAÑA: REPORTE DE ASISTENCIA -->
                    <div class="tab-pane fade" id="attendance" role="tabpanel">
                        <div class="table-responsive">
                            <table class="table table-striped table-hover align-middle">
                                <thead class="table-dark">
                                    <tr>
                                        <th>Fecha</th>
                                        <th>Empleado</th>
                                        <th>DNI</th>
                                        <th>Entrada</th>
                                        <th>Salida</th>
                                        <th>Total Horas</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($allAttendance as $rec): ?>
                                    <tr>
                                        <td><?php echo date('d/m/Y', strtotime($rec['fecha'])); ?></td>
                                        <td><?php echo htmlspecialchars($rec['nombre'] . ' ' . $rec['apellido']); ?></td>
                                        <td><?php echo htmlspecialchars($rec['dni']); ?></td>
                                        <td><span class="text-success fw-bold"><?php echo $rec['entrada'] ? date('H:i:s', strtotime($rec['entrada'])) : '-'; ?></span></td>
                                        <td><span class="text-danger fw-bold"><?php echo $rec['salida'] ? date('H:i:s', strtotime($rec['salida'])) : 'En turno'; ?></span></td>
                                        <td>
                                            <?php 
                                            if ($rec['entrada'] && $rec['salida']) {
                                                $inicio = new DateTime($rec['entrada']);
                                                $fin = new DateTime($rec['salida']);
                                                $diff = $inicio->diff($fin);
                                                echo $diff->format('%H:%I:%S');
                                            } else {
                                                echo '<span class="text-muted italic">Pendiente</span>';
                                            }
                                            ?>
                                        </td>
                                    </tr>
                                    <?php endforeach; ?>
                                    <?php if (empty($allAttendance)): ?>
                                    <tr>
                                        <td colspan="6" class="text-center py-4">No hay registros de asistencia.</td>
                                    </tr>
                                    <?php endif; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="text-center mt-2">
    <a href="app/controllers/AuthController.php?action=logout" class="btn btn-outline-danger btn-sm">
        <i class="fas fa-power-off me-1"></i> Cerrar Sesión Segura
    </a>
</div>

<?php include 'views/layout/footer.php'; ?>
