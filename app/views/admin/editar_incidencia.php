<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);
session_start();
if(!isset($_SESSION['usuario_id']) || $_SESSION['usuario_rol'] != 'admin') {
    header('Location: ../../../public/index.php?page=login');
    exit();
}
require_once '../../../config/database.php';

$db = conectarDB();
$id = $_GET['id'];

$stmt = $db->prepare("SELECT * FROM incidencias WHERE id = ?");
$stmt->execute([$id]);
$inc = $stmt->fetch(PDO::FETCH_ASSOC);

if(!$inc) {
    header('Location: incidencias.php');
    exit();
}

$stmt = $db->prepare("SELECT * FROM tipos_servicio");
$stmt->execute();
$tipos = $stmt->fetchAll(PDO::FETCH_ASSOC);

$stmt = $db->prepare("SELECT * FROM usuarios WHERE rol = 'tecnico'");
$stmt->execute();
$tecnicos = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ReparaYa - Editar Incidencia</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

<nav class="navbar navbar-expand-lg navbar-dark bg-danger">
    <div class="container">
        <a class="navbar-brand" href="dashboard.php">ReparaYa - Admin</a>
        <div class="ms-auto">
            <a href="incidencias.php" class="btn btn-outline-light me-2">Volver</a>
            <a href="../../../app/controllers/AuthController.php?action=logout" class="btn btn-outline-light">Cerrar Sesion</a>
        </div>
    </div>
</nav>

<div class="container mt-4">
    <div class="row justify-content-center">
        <div class="col-md-7">
            <div class="card shadow p-4">
                <h4 class="mb-4">Editar Incidencia - <?php echo $inc['codigo']; ?></h4>

                <form action="../../../app/controllers/AdminController.php" method="POST">
                    <input type="hidden" name="action" value="editar">
                    <input type="hidden" name="id" value="<?php echo $inc['id']; ?>">
                    <div class="mb-3">
                        <label class="form-label">Tipo de Servicio</label>
                        <select name="tipo_servicio_id" class="form-select" required>
                            <?php foreach($tipos as $tipo): ?>
                                <option value="<?php echo $tipo['id']; ?>" <?php echo $tipo['id'] == $inc['tipo_servicio_id'] ? 'selected' : ''; ?>>
                                    <?php echo $tipo['nombre']; ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Tecnico Asignado</label>
                        <select name="tecnico_id" class="form-select">
                            <option value="">Sin asignar</option>
                            <?php foreach($tecnicos as $tecnico): ?>
                                <option value="<?php echo $tecnico['id']; ?>" <?php echo $tecnico['id'] == $inc['tecnico_id'] ? 'selected' : ''; ?>>
                                    <?php echo $tecnico['nombre']; ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Prioridad</label>
                        <select name="prioridad" class="form-select" required>
                            <option value="estandar" <?php echo $inc['prioridad'] == 'estandar' ? 'selected' : ''; ?>>Estandar</option>
                            <option value="urgente" <?php echo $inc['prioridad'] == 'urgente' ? 'selected' : ''; ?>>Urgente (24h)</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Estado</label>
                        <select name="estado" class="form-select" required>
                            <option value="pendiente" <?php echo $inc['estado'] == 'pendiente' ? 'selected' : ''; ?>>Pendiente</option>
                            <option value="asignada" <?php echo $inc['estado'] == 'asignada' ? 'selected' : ''; ?>>Asignada</option>
                            <option value="en_proceso" <?php echo $inc['estado'] == 'en_proceso' ? 'selected' : ''; ?>>En Proceso</option>
                            <option value="completada" <?php echo $inc['estado'] == 'completada' ? 'selected' : ''; ?>>Completada</option>
                            <option value="cancelada" <?php echo $inc['estado'] == 'cancelada' ? 'selected' : ''; ?>>Cancelada</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Fecha Solicitada</label>
                        <input type="date" name="fecha_solicitada" class="form-control" value="<?php echo $inc['fecha_solicitada']; ?>" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Franja Horaria</label>
                        <select name="franja_horaria" class="form-select" required>
                            <option value="manana" <?php echo $inc['franja_horaria'] == 'manana' ? 'selected' : ''; ?>>Manana (8:00 - 14:00)</option>
                            <option value="tarde" <?php echo $inc['franja_horaria'] == 'tarde' ? 'selected' : ''; ?>>Tarde (14:00 - 20:00)</option>
                            <option value="noche" <?php echo $inc['franja_horaria'] == 'noche' ? 'selected' : ''; ?>>Noche (20:00 - 23:00)</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Descripcion</label>
                        <textarea name="descripcion" class="form-control" rows="3" required><?php echo $inc['descripcion']; ?></textarea>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Direccion</label>
                        <input type="text" name="direccion" class="form-control" value="<?php echo $inc['direccion']; ?>" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Telefono de Contacto</label>
                        <input type="text" name="telefono_contacto" class="form-control" value="<?php echo $inc['telefono_contacto']; ?>" required>
                    </div>
                    <button type="submit" class="btn btn-danger w-100">Guardar Cambios</button>
                </form>
            </div>
        </div>
    </div>
</div>

</body>
</html>