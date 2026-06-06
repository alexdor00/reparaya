<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ReparaYa - Gestion de Averias</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .hero {
            background: linear-gradient(135deg, #dc3545, #343a40);
            color: white;
            padding: 80px 0;
        }
        .servicio-card {
            border: none;
            border-radius: 10px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
            transition: transform 0.2s;
        }
        .servicio-card:hover {
            transform: translateY(-5px);
        }
        .como-funciona {
            background: #f8f9fa;
            padding: 60px 0;
        }
    </style>
</head>
<body>

<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <div class="container">
        <a class="navbar-brand fw-bold" href="index.php">ReparaYa</a>
        <div class="ms-auto">
            <a href="index.php?page=login" class="btn btn-outline-light me-2">Iniciar Sesion</a>
            <a href="index.php?page=registro" class="btn btn-danger">Registrarse</a>
        </div>
    </div>
</nav>

<!-- Hero -->
<div class="hero text-center">
    <div class="container">
        <h1 class="display-4 fw-bold">Gestion de Averias Domesticas</h1>
        <a href="index.php?page=registro" class="btn btn-light btn-lg mt-4">Solicitar Tecnico Ahora</a>
    </div>
</div>

<!-- Servicios -->
<div class="container mt-5">
    <h2 class="text-center mb-4">Nuestros Servicios</h2>
    <div class="row g-4">
        <div class="col-md-4">
            <div class="card servicio-card p-4 text-center">
                <h4>Fontaneria</h4>
                <p class="text-muted">Reparacion de tuberias, grifos, desagues e instalaciones de agua.</p>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card servicio-card p-4 text-center">
                <h4>Electricidad</h4>
                <p class="text-muted">Instalaciones electricas, averias y mantenimiento del hogar.</p>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card servicio-card p-4 text-center">
                <h4>Carpinteria</h4>
                <p class="text-muted">Reparacion de puertas, ventanas, muebles y estructuras de madera.</p>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card servicio-card p-4 text-center">
                <h4>Pintura</h4>
                <p class="text-muted">Pintura interior y exterior con acabados de calidad.</p>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card servicio-card p-4 text-center">
                <h4>Albañileria</h4>
                <p class="text-muted">Reformas, reparaciones de obra y trabajos de construccion.</p>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card servicio-card p-4 text-center">
                <h4>Servicio Urgente</h4>
                <p class="text-muted">Atencion en menos de 24 horas para emergencias del hogar.</p>
            </div>
        </div>
    </div>
</div>

<!-- Como funciona -->
<div class="como-funciona mt-5">
    <div class="container">
        <h2 class="text-center mb-4">Como Funciona</h2>
        <div class="row text-center">
            <div class="col-md-4">
                <div class="p-3">
                    <h1 class="text-danger fw-bold">1</h1>
                    <h5>Registrate</h5>
                    <p class="text-muted">Crea tu cuenta en menos de un minuto con tu email.</p>
                </div>
            </div>
            <div class="col-md-4">
                <div class="p-3">
                    <h1 class="text-danger fw-bold">2</h1>
                    <h5>Solicita un Tecnico</h5>
                    <p class="text-muted">Describe la averia, elige fecha y franja horaria.</p>
                </div>
            </div>
            <div class="col-md-4">
                <div class="p-3">
                    <h1 class="text-danger fw-bold">3</h1>
                    <h5>Recibe Asistencia</h5>
                    <p class="text-muted">Un tecnico cualificado acudira a tu domicilio.</p>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Footer -->
<footer class="bg-dark text-light text-center py-4 mt-5">
    <p class="mb-0">ReparaYa - Gestion de Averias Domesticas</p>
</footer>

</body>
</html>