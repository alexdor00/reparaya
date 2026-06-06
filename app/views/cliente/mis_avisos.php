<?php
session_start();
if(!isset($_SESSION['usuario_id']) || $_SESSION['usuario_rol'] != 'cliente') {
    header('Location: ../../../public/index.php?page=login');
    exit();
}
require_once '../../../config/database.php';

$db = conectarDB();
$stmt = $db->prepare("
    SELECT i.*, ts.nombre as tipo_servicio 
    FROM incidencias i
    JOIN tipos_servicio ts ON i.tipo_servicio_id = ts.id
    WHERE i.cliente_id = ?
    ORDER BY i.created_at DESC
");
$stmt->execute([$_SESSION['usuario_id']]);
$incidencias = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ReparaYa - Mis Avisos</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <div class="container">
        <a class="navbar-brand" href="#">ReparaYa</a>
        <div class="ms-auto">
            <span class="text-light me-3"><?php echo $_SESSION['usuario_nombre']; ?></span>
            <a href="dashboard.php" class="btn btn-outline-light me-2">Volver</a>
            <a href="../../../app/controllers/AuthController.php?action=logout" class="btn btn-outline-light">Cerrar Sesion</a>
        </div>
    </div>
</nav>

<div class="container mt-4">
    <h4>Mis Avisos</h4>

    <?php if(isset($_GET['success'])): ?>
        <div class="alert alert-success"><?php echo htmlspecialchars($_GET['success']); ?></div>
    <?php endif; ?>

    <?php if(empty($incidencias)): ?>
        <div class="alert alert-info">No tienes ninguna solicitud todavia.</div>
    <?php else: ?>
        <table class="table table-bordered mt-3">
            <thead class="table-dark">
                <tr>
                    <th>Codigo</th>
                    <th>Tipo Servicio</th>
                    <th>Prioridad</th>
                    <th>Fecha</th>
                    <th>Estado</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach($incidencias as $inc): ?>
                <tr>
                    <td><?php echo $inc['codigo']; ?></td>
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
                    <td>
                        <?php
                        $fecha = new DateTime($inc['fecha_solicitada']);
                        $hoy = new DateTime();
                        $diferencia = $hoy->diff($fecha)->days;
                        if($inc['estado'] != 'cancelada' && $diferencia >= 2):
                        ?>
                            <a href="../../../app/controllers/IncidenciaController.php?action=cancelar&id=<?php echo $inc['id']; ?>" 
                               class="btn btn-sm btn-danger"
                               onclick="return confirm('Seguro que quieres cancelar?')">Cancelar</a>
                        <?php endif; ?>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php endif; ?>

    <a href="nueva_incidencia.php" class="btn btn-warning mt-3">Nueva Solicitud</a>
</div>

</body>
</html>