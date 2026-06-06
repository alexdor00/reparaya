<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);
session_start();
if(!isset($_SESSION['usuario_id']) || $_SESSION['usuario_rol'] != 'tecnico') {
    header('Location: ../../../public/index.php?page=login');
    exit();
}
require_once '../../../config/database.php';

$db = conectarDB();

$hoy = date('Y-m-d');

$stmt = $db->prepare("
    SELECT i.*, ts.nombre as tipo_servicio, u.nombre as cliente_nombre
    FROM incidencias i
    JOIN tipos_servicio ts ON i.tipo_servicio_id = ts.id
    JOIN usuarios u ON i.cliente_id = u.id
    WHERE i.tecnico_id = ? AND i.fecha_solicitada = ? AND i.estado != 'cancelada'
");
$stmt->execute([$_SESSION['usuario_id'], $hoy]);
$servicios_hoy = $stmt->fetchAll(PDO::FETCH_ASSOC);

$stmt = $db->prepare("
    SELECT i.*, ts.nombre as tipo_servicio, u.nombre as cliente_nombre
    FROM incidencias i
    JOIN tipos_servicio ts ON i.tipo_servicio_id = ts.id
    JOIN usuarios u ON i.cliente_id = u.id
    WHERE i.tecnico_id = ? AND i.fecha_solicitada > ? AND i.estado != 'cancelada'
    ORDER BY i.fecha_solicitada ASC
");
$stmt->execute([$_SESSION['usuario_id'], $hoy]);
$proximos = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ReparaYa - Panel Tecnico</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

<nav class="navbar navbar-expand-lg navbar-dark bg-primary">
    <div class="container">
        <a class="navbar-brand" href="#">ReparaYa - Tecnico</a>
        <div class="ms-auto">
            <span class="text-light me-3"><?php echo $_SESSION['usuario_nombre']; ?></span>
            <a href="../../../app/views/perfil.php" class="btn btn-outline-light me-2">Mi Perfil</a>
            <a href="../../../app/controllers/AuthController.php?action=logout" class="btn btn-outline-light">Cerrar Sesion</a>
        </div>
    </div>
</nav>

<div class="container mt-4">
    <h2>Mi Agenda de Trabajo</h2>
    <p>Aqui puedes consultar los servicios que tienes asignados.</p>

    <div class="row mt-4">
        <div class="col-md-6">
            <div class="card p-3">
                <h5>Servicios de Hoy</h5>
                <?php if(empty($servicios_hoy)): ?>
                    <p class="text-muted">No tienes servicios para hoy.</p>
                <?php else: ?>
                    <table class="table table-sm">
                        <thead>
                            <tr>
                                <th>Codigo</th>
                                <th>Tipo</th>
                                <th>Franja</th>
                                <th>Direccion</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach($servicios_hoy as $s): ?>
                            <tr>
                                <td><?php echo $s['codigo']; ?></td>
                                <td><?php echo $s['tipo_servicio']; ?></td>
                                <td><?php echo ucfirst($s['franja_horaria']); ?></td>
                                <td><?php echo $s['direccion']; ?></td>
                            </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                <?php endif; ?>
            </div>
        </div>
        <div class="col-md-6">
            <div class="card p-3">
                <h5>Proximos Servicios</h5>
                <?php if(empty($proximos)): ?>
                    <p class="text-muted">No tienes servicios proximos.</p>
                <?php else: ?>
                    <table class="table table-sm">
                        <thead>
                            <tr>
                                <th>Fecha</th>
                                <th>Tipo</th>
                                <th>Franja</th>
                                <th>Direccion</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach($proximos as $s): ?>
                            <tr>
                                <td><?php echo $s['fecha_solicitada']; ?></td>
                                <td><?php echo $s['tipo_servicio']; ?></td>
                                <td><?php echo ucfirst($s['franja_horaria']); ?></td>
                                <td><?php echo $s['direccion']; ?></td>
                            </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>

</body>
</html>