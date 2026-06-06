<?php
session_start();
if(!isset($_SESSION['usuario_id']) || $_SESSION['usuario_rol'] != 'cliente') {
    header('Location: ../../../public/index.php?page=login');
    exit();
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ReparaYa - Panel Cliente</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <div class="container">
        <a class="navbar-brand" href="#">ReparaYa</a>
        <div class="ms-auto">
            <span class="text-light me-3">Hola, <?php echo $_SESSION['usuario_nombre']; ?></span>
            <a href="../../../app/controllers/AuthController.php?action=logout" class="btn btn-outline-light">Cerrar Sesión</a>
        </div>
    </div>
</nav>

<div class="container mt-4">
    <h2>Panel de Cliente</h2>
    <p>Bienvenido a tu panel. Aquí podrás gestionar tus avisos.</p>

    <div class="row mt-4">
        <div class="col-md-4">
            <div class="card text-center p-3">
                <h5> Mis Avisos</h5>
                <p>Ver todas tus solicitudes</p>
                <a href="#" class="btn btn-warning">Ver Avisos</a>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card text-center p-3">
                <h5>Nueva Solicitud</h5>
                <p>Pedir un técnico</p>
                <a href="#" class="btn btn-warning">Nueva Solicitud</a>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card text-center p-3">
                <h5> Mi Perfil</h5>
                <p>Modificar mis datos</p>
                <a href="../../app/views/perfil.php" class="btn btn-warning">Ver Perfil</a>            </div>
        </div>
    </div>
</div>

</body>
</html>