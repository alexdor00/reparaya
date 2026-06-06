<?php
session_start();
if(!isset($_SESSION['usuario_id']) || $_SESSION['usuario_rol'] != 'cliente') {
    header('Location: ../../../public/index.php?page=login');
    exit();
}
require_once '../../../config/database.php';

$db = conectarDB();
$stmt = $db->prepare("SELECT * FROM tipos_servicio");
$stmt->execute();
$tipos = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ReparaYa - Nueva Solicitud</title>
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
    <div class="row justify-content-center">
        <div class="col-md-7">
            <div class="card shadow p-4">
                <h4 class="mb-4">Nueva Solicitud de Servicio</h4>

                <?php if(isset($_GET['error'])): ?>
                    <div class="alert alert-danger"><?php echo htmlspecialchars($_GET['error']); ?></div>
                <?php endif; ?>

                <form action="../../../app/controllers/IncidenciaController.php" method="POST">
                    <input type="hidden" name="action" value="crear">
                    <div class="mb-3">
                        <label class="form-label">Tipo de Servicio</label>
                        <select name="tipo_servicio_id" class="form-select" required>
                            <option value="">Selecciona un tipo</option>
                            <?php foreach($tipos as $tipo): ?>
                                <option value="<?php echo $tipo['id']; ?>"><?php echo $tipo['nombre']; ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Prioridad</label>
                        <select name="prioridad" class="form-select" required>
                            <option value="estandar">Estandar</option>
                            <option value="urgente">Urgente (24h)</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Fecha Solicitada</label>
                        <input type="date" name="fecha_solicitada" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Franja Horaria</label>
                        <select name="franja_horaria" class="form-select" required>
                            <option value="manana">Manana (8:00 - 14:00)</option>
                            <option value="tarde">Tarde (14:00 - 20:00)</option>
                            <option value="noche">Noche (20:00 - 23:00)</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Descripcion de la Averia</label>
                        <textarea name="descripcion" class="form-control" rows="3" required></textarea>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Direccion</label>
                        <input type="text" name="direccion" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Telefono de Contacto</label>
                        <input type="text" name="telefono_contacto" class="form-control" required>
                    </div>
                    <button type="submit" class="btn btn-warning w-100">Enviar Solicitud</button>
                </form>
            </div>
        </div>
    </div>
</div>

</body>
</html>