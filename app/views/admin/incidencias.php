<?php
session_start();
if(!isset($_SESSION['usuario_id']) || $_SESSION['usuario_rol'] != 'admin') {
    header('Location: ../../../public/index.php?page=login');
    exit();
}
require_once '../../../config/database.php';

$db = conectarDB();
$stmt = $db->prepare("
    SELECT i.*, ts.nombre as tipo_servicio, u.nombre as cliente_nombre,
    t.nombre as tecnico_nombre
    FROM incidencias i
    JOIN tipos_servicio ts ON i.tipo_servicio_id = ts.id
    JOIN usuarios u ON i.cliente_id = u.id
    LEFT JOIN usuarios t ON i.tecnico_id = t.id
    ORDER BY i.created_at DESC
");
$stmt->execute();
$incidencias = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ReparaYa - Incidencias</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

<nav class="navbar navbar-expand-lg navbar-dark bg-danger">
    <div class="container">
        <a class="navbar-brand" href="dashboard.php">ReparaYa - Admin</a>
        <div class="ms-auto">
            <span class="text-light me-3"><?php echo $_SESSION['usuario_nombre']; ?></span>
            <a href="../../../app/controllers/AuthController.php?action=logout" class="btn btn-outline-light">Cerrar Sesion</a>
        </div>
    </div>
</nav>

<div class="container mt-4">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h4>Todas las Incidencias</h4>
        <a href="nueva_incidencia.php" class="btn btn-danger">Nueva Incidencia</a>
    </div>

    <?php if(isset($_GET['success'])): ?>
        <div class="alert alert-success"><?php echo htmlspecialchars($_GET['success']); ?></div>
    <?php endif; ?>

    <table class="table table-bordered">
        <thead class="table-dark">
            <tr>
                <th>Codigo</th>
                <th>Cliente</th>
                <th>Tipo Servicio</th>
                <th>Prioridad</th>
                <th>Fecha</th>
                <th>Estado</th>
                <th>Tecnico</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach($incidencias as $inc): ?>
            <tr>
                <td><?php echo $inc['codigo']; ?></td>
                <td><?php echo $inc['cliente_nombre']; ?></td>
                <td><?php echo $inc['tipo_servicio']; ?></td>
                <td>
                    <?php if($inc['prioridad'] == 'urgente'): ?>
                        <span class="badge bg-danger">Urgente</span>
                    <?php else: ?>
                        <span class="badge bg-secondary">Estandar</span>
                    <?php endif; ?>
                </td>
                <td><?php echo $inc['fecha_solicitada']; ?></td>
                <td><?php echo ucfirst($inc['estado']); ?></td>
                <td><?php echo $inc['tecnico_nombre'] ?? 'Sin asignar'; ?></td>
                <td>
                    <a href="editar_incidencia.php?id=<?php echo $inc['id']; ?>" class="btn btn-sm btn-warning">Editar</a>
                    <a href="../../../app/controllers/AdminController.php?action=cancelar&id=<?php echo $inc['id']; ?>" 
                       class="btn btn-sm btn-danger"
                       onclick="return confirm('Seguro que quieres cancelar?')">Cancelar</a>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>

</body>
</html>