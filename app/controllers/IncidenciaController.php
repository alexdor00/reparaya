<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);
session_start();
if(!isset($_SESSION['usuario_id'])) {
    header('Location: ../../public/index.php?page=login');
    exit();
}
require_once '../../config/database.php';

$action = $_POST['action'] ?? '';

if($action == 'crear') {
    $tipo_servicio_id = $_POST['tipo_servicio_id'];
    $prioridad = $_POST['prioridad'];
    $fecha_solicitada = $_POST['fecha_solicitada'];
    $franja_horaria = $_POST['franja_horaria'];
    $descripcion = $_POST['descripcion'];
    $direccion = $_POST['direccion'];
    $telefono_contacto = $_POST['telefono_contacto'];
    $cliente_id = $_SESSION['usuario_id'];

    if($prioridad == 'estandar') {
        $fecha = new DateTime($fecha_solicitada);
        $hoy = new DateTime();
        $diferencia = $hoy->diff($fecha)->days;

        if($diferencia < 2) {
            header('Location: ../views/cliente/nueva_incidencia.php?error=Los servicios estandar necesitan 48 horas de antelacion');
            exit();
        }
    }

    $codigo = 'INC-' . strtoupper(uniqid());

    $db = conectarDB();
    $stmt = $db->prepare("INSERT INTO incidencias (codigo, cliente_id, tipo_servicio_id, descripcion, direccion, telefono_contacto, fecha_solicitada, franja_horaria, prioridad) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)");
    $stmt->execute([$codigo, $cliente_id, $tipo_servicio_id, $descripcion, $direccion, $telefono_contacto, $fecha_solicitada, $franja_horaria, $prioridad]);

    header('Location: ../views/cliente/mis_avisos.php?success=Solicitud creada correctamente con codigo ' . $codigo);
    exit();
}

if(isset($_GET['action']) && $_GET['action'] == 'cancelar') {
    $id = $_GET['id'];
    $db = conectarDB();

    $stmt = $db->prepare("SELECT * FROM incidencias WHERE id = ? AND cliente_id = ?");
    $stmt->execute([$id, $_SESSION['usuario_id']]);
    $incidencia = $stmt->fetch(PDO::FETCH_ASSOC);

    if($incidencia) {
        $fecha = new DateTime($incidencia['fecha_solicitada']);
        $hoy = new DateTime();
        $diferencia = $hoy->diff($fecha)->days;

        if($diferencia < 2) {
            header('Location: ../views/cliente/mis_avisos.php?error=No puedes cancelar con menos de 48 horas de antelacion');
            exit();
        }

        $stmt = $db->prepare("UPDATE incidencias SET estado = 'cancelada' WHERE id = ?");
        $stmt->execute([$id]);

        header('Location: ../views/cliente/mis_avisos.php?success=Incidencia cancelada correctamente');
        exit();
    }
}