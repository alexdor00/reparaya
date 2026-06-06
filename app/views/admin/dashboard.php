<?php
session_start();
if(!isset($_SESSION['usuario_id']) || $_SESSION['usuario_rol'] != 'admin') {
    header('Location: ../../../public/index.php?page=login');
    exit();
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ReparaYa - Panel Admin</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

<nav class="navbar navbar-expand-lg navbar-dark bg-danger">
    <div class="container">
        <a class="navbar-brand" href="#"> ReparaYa - Admin</a>
        <div class="ms-auto">
            <span class="text-light me-3">Hola, <?php echo $_SESSION['usuario_nombre']; ?></span>
            <a href="../../../app/controllers/AuthController.php?action=logout" class="btn btn-outline-light">Cerrar Sesión</a>
        </div>
    </div>
</nav>

<div class="container mt-4">
    <h2>Panel de Administración</h2>

    <div class="row mt-4">
        <div class="col-md-3">
            <div class="card text-center p-3">
                <h5>Todas las Incidencias</h5>
                <a href="#" class="btn btn-danger mt-2">Ver Incidencias</a>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card text-center p-3">
                <h5> Nueva Incidencia</h5>
                <a href="#" class="btn btn-danger mt-2">Crear</a>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card text-center p-3">
                <h5> Gestionar Técnicos</h5>
                <a href="#" class="btn btn-danger mt-2">Ver Técnicos</a>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card text-center p-3">
                <h5>Calendario</h5>
                <a href="#" class="btn btn-danger mt-2">Ver Calendario</a>
            </div>
        </div>
    </div>
</div>

</body>
</html>