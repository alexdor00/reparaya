<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);
session_start();
if(!isset($_SESSION['usuario_id']) || $_SESSION['usuario_rol'] != 'tecnico') {
    header('Location: ../../../public/index.php?page=login');
    exit();
}
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
            <span class="text-light me-3">Hola, <?php echo $_SESSION['usuario_nombre']; ?></span>
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
                <p class="text-muted">No tienes servicios asignados para hoy.</p>
            </div>
        </div>
        <div class="col-md-6">
            <div class="card p-3">
                <h5>Proximos Servicios</h5>
                <p class="text-muted">No tienes servicios proximos.</p>
            </div>
        </div>
    </div>
</div>

</body>
</html>