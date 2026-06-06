<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ReparaYa - Login</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-4">
            <div class="card shadow">
                <div class="card-body p-4">
                    <h3 class="text-center mb-4">🔧 ReparaYa</h3>
                    <h5 class="text-center mb-4">Iniciar Sesión</h5>

                    <?php if(isset($_GET['error'])): ?>
                        <div class="alert alert-danger">
                            <?php echo htmlspecialchars($_GET['error']); ?>
                        </div>
                    <?php endif; ?>

                    <form action="../app/controllers/AuthController.php" method="POST">
                        <input type="hidden" name="action" value="login">
                        <div class="mb-3">
                            <label class="form-label">Email</label>
                            <input type="email" name="email" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Contraseña</label>
                            <input type="password" name="password" class="form-control" required>
                        </div>
                        <button type="submit" class="btn btn-warning w-100">Entrar</button>
                    </form>

                    <p class="text-center mt-3">
                        ¿No tienes cuenta? <a href="index.php?page=registro">Regístrate</a>
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>

</body>
</html>