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
    $nombre = $_POST['nombre'];
    $descripcion = $_POST['descripcion'];

    $db = conectarDB();
    $stmt = $db->prepare("INSERT INTO tipos_servicio (nombre, descripcion) VALUES (?, ?)");
    $stmt->execute([$nombre, $descripcion]);

    header('Location: ../views/admin/tipos_servicio.php?success=Tipo de servicio creado correctamente');
    exit();
}

if(isset($_GET['action']) && $_GET['action'] == 'eliminar') {
    $id = $_GET['id'];
    $db = conectarDB();

    $stmt = $db->prepare("SELECT id FROM incidencias WHERE tipo_servicio_id = ?");
    $stmt->execute([$id]);
    if($stmt->fetch()) {
        header('Location: ../views/admin/tipos_servicio.php?error=No puedes eliminar un tipo con incidencias asociadas');
        exit();
    }

    $stmt = $db->prepare("DELETE FROM tipos_servicio WHERE id = ?");
    $stmt->execute([$id]);

    header('Location: ../views/admin/tipos_servicio.php?success=Tipo eliminado correctamente');
    exit();
}