<?php
session_start();
if(!isset($_SESSION['usuario_id'])) {
    header('Location: ../../public/index.php?page=login');
    exit();
}
require_once '../../config/database.php';

$db = conectarDB();
$stmt = $db->prepare("SELECT * FROM usuarios WHERE id = ?");
$stmt->execute([$_SESSION['usuario_id']]);
$usuario = $stmt->fetch(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ReparaYa - Mi Perfil</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <div class="container">
        <a class="navbar-brand" href="#">ReparaYa</a>
        <div class="ms-auto">
            <a href="../../app/controllers/AuthController.php?action=logout" class="btn btn-outline-light">Cerrar Sesion</a>
        </div>
    </div>
</nav>

<div class="container mt-4">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card shadow p-4">
                <h4 class="mb-4">Mi Perfil</h4>

                <?php if(isset($_GET['success'])): ?>
                    <div class="alert alert-success"><?php echo htmlspecialchars($_GET['success']); ?></div>
                <?php endif; ?>

                <?php if(isset($_GET['error'])): ?>
                    <div class="alert alert-danger"><?php echo htmlspecialchars($_GET['error']); ?></div>
                <?php endif; ?>

                <form action="../../app/controllers/PerfilController.php" method="POST">
                    <div class="mb-3">
                        <label class="form-label">Nombre</label>
                        <input type="text" name="nombre" class="form-control" value="<?php echo htmlspecialchars($usuario['nombre']); ?>" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Email</label>
                        <input type="email" name="email" class="form-control" value="<?php echo htmlspecialchars($usuario['email']); ?>" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Telefono</label>
                        <input type="text" name="telefono" class="form-control" value="<?php echo htmlspecialchars($usuario['telefono']); ?>">
                    </div>
                    <hr>
                    <p class="text-muted">Deja en blanco si no quieres cambiar la contrasena</p>
                    <div class="mb-3">
                        <label class="form-label">Nueva Contrasena</label>
                        <input type="password" name="password" class="form-control">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Repetir Contrasena</label>
                        <input type="password" name="password2" class="form-control">
                    </div>
                    <button type="submit" class="btn btn-warning w-100">Guardar Cambios</button>
                </form>
            </div>
        </div>
    </div>
</div>

</body>
</html>