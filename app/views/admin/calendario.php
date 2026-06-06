<?php
session_start();
if(!isset($_SESSION['usuario_id']) || $_SESSION['usuario_rol'] != 'admin') {
    header('Location: ../../../public/index.php?page=login');
    exit();
}
require_once '../../../config/database.php';

$db = conectarDB();
$stmt = $db->prepare("
    SELECT i.*, ts.nombre as tipo_servicio, u.nombre as cliente_nombre
    FROM incidencias i
    JOIN tipos_servicio ts ON i.tipo_servicio_id = ts.id
    JOIN usuarios u ON i.cliente_id = u.id
    WHERE i.estado != 'cancelada'
");
$stmt->execute();
$incidencias = $stmt->fetchAll(PDO::FETCH_ASSOC);

$eventos = [];
foreach($incidencias as $inc) {
    $color = $inc['prioridad'] == 'urgente' ? '#dc3545' : '#6c757d';
    $eventos[] = [
        'id' => $inc['id'],
        'title' => $inc['tipo_servicio'] . ' - ' . $inc['cliente_nombre'],
        'start' => $inc['fecha_solicitada'],
        'color' => $color,
        'extendedProps' => [
            'codigo' => $inc['codigo'],
            'descripcion' => $inc['descripcion'],
            'direccion' => $inc['direccion'],
            'telefono' => $inc['telefono_contacto'],
            'prioridad' => $inc['prioridad'],
            'estado' => $inc['estado'],
            'franja' => $inc['franja_horaria']
        ]
    ];
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ReparaYa - Calendario</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.8/index.global.min.css" rel="stylesheet">
    <style>
        .fc-event { cursor: pointer; }
    </style>
</head>
<body>

<nav class="navbar navbar-expand-lg navbar-dark bg-danger">
    <div class="container">
        <a class="navbar-brand" href="dashboard.php">ReparaYa - Admin</a>
        <div class="ms-auto">
            <a href="dashboard.php" class="btn btn-outline-light me-2">Volver</a>
            <a href="../../../app/controllers/AuthController.php?action=logout" class="btn btn-outline-light">Cerrar Sesion</a>
        </div>
    </div>
</nav>

<div class="container mt-4">
    <h4 class="mb-3">Calendario de Incidencias</h4>
    <div class="mb-3">
        <span class="badge bg-danger me-2">Urgente</span>
        <span class="badge bg-secondary">Estandar</span>
    </div>
    <div id="calendario"></div>
</div>

<!-- Modal detalle -->
<div class="modal fade" id="modalDetalle" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Detalle de Incidencia</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body" id="modalContenido"></div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.8/index.global.min.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        var calendarEl = document.getElementById('calendario');
        var eventos = <?php echo json_encode($eventos); ?>;

        var calendar = new FullCalendar.Calendar(calendarEl, {
            initialView: 'dayGridMonth',
            locale: 'es',
            headerToolbar: {
                left: 'prev,next today',
                center: 'title',
                right: 'dayGridMonth,timeGridWeek,timeGridDay'
            },
            events: eventos,
            eventClick: function(info) {
                var props = info.event.extendedProps;
                var html = `
                    <p><strong>Codigo:</strong> ${props.codigo}</p>
                    <p><strong>Descripcion:</strong> ${props.descripcion}</p>
                    <p><strong>Direccion:</strong> ${props.direccion}</p>
                    <p><strong>Telefono:</strong> ${props.telefono}</p>
                    <p><strong>Prioridad:</strong> ${props.prioridad}</p>
                    <p><strong>Estado:</strong> ${props.estado}</p>
                    <p><strong>Franja horaria:</strong> ${props.franja}</p>
                `;
                document.getElementById('modalContenido').innerHTML = html;
                new bootstrap.Modal(document.getElementById('modalDetalle')).show();
            }
        });
        calendar.render();
    });
</script>

</body>
</html>