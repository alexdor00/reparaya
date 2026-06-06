<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);
session_start();
if(!isset($_SESSION['usuario_id']) || $_SESSION['usuario_rol'] != 'admin') {
    header('Location: ../../public/index.php?page=login');
    exit();
}
require_once '../../config/database.php';

$action = $_POST['action'] ?? '';

if($action == 'crear') {
    $cliente_id = $_POST['cliente_id'];
    $tipo_servicio_id = $_POST['tipo_servicio_id'];
    $tecnico_id = !empty($_POST['tecnico_id']) ? $_POST['tecnico_id'] : null;
    $prioridad = $_POST['prioridad'];
    $fecha_solicitada = $_POST['fecha_solicitada'];
    $franja_horaria = $_POST['franja_horaria'];
    $descripcion = $_POST['descripcion'];
    $direccion = $_POST['direccion'];
    $telefono_contacto = $_POST['telefono_contacto'];

    $codigo = 'INC-' . strtoupper(uniqid());

    $db = conectarDB();
    $stmt = $db->prepare("INSERT INTO incidencias (codigo, cliente_id, tipo_servicio_id, descripcion, direccion, telefono_contacto, fecha_solicitada, franja_horaria, prioridad, tecnico_id) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
    $stmt->execute([$codigo, $cliente_id, $tipo_servicio_id, $descripcion, $direccion, $telefono_contacto, $fecha_solicitada, $franja_horaria, $prioridad, $tecnico_id]);

    header('Location: ../views/admin/incidencias.php?success=Incidencia creada correctamente');
    exit();
}

if($action == 'editar') {
    $id = $_POST['id'];
    $tipo_servicio_id = $_POST['tipo_servicio_id'];
    $tecnico_id = !empty($_POST['tecnico_id']) ? $_POST['tecnico_id'] : null;
    $prioridad = $_POST['prioridad'];
    $estado = $_POST['estado'];
    $fecha_solicitada = $_POST['fecha_solicitada'];
    $franja_horaria = $_POST['franja_horaria'];
    $descripcion = $_POST['descripcion'];
    $direccion = $_POST['direccion'];
    $telefono_contacto = $_POST['telefono_contacto'];

    $db = conectarDB();
    $stmt = $db->prepare("UPDATE incidencias SET tipo_servicio_id = ?, tecnico_id = ?, prioridad = ?, estado = ?, fecha_solicitada = ?, franja_horaria = ?, descripcion = ?, direccion = ?, telefono_contacto = ? WHERE id = ?");
    $stmt->execute([$tipo_servicio_id, $tecnico_id, $prioridad, $estado, $fecha_solicitada, $franja_horaria, $descripcion, $direccion, $telefono_contacto, $id]);

    header('Location: ../views/admin/incidencias.php?success=Incidencia actualizada correctamente');
    exit();
}

if(isset($_GET['action']) && $_GET['action'] == 'cancelar') {
    $id = $_GET['id'];
    $db = conectarDB();
    $stmt = $db->prepare("UPDATE incidencias SET estado = 'cancelada' WHERE id = ?");
    $stmt->execute([$id]);
    header('Location: ../views/admin/incidencias.php?success=Incidencia cancelada correctamente');
    exit();
}