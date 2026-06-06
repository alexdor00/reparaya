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
    $email = $_POST['email'];
    $telefono = $_POST['telefono'];
    $password = $_POST['password'];

    $db = conectarDB();

    $stmt = $db->prepare("SELECT id FROM usuarios WHERE email = ?");
    $stmt->execute([$email]);
    if($stmt->fetch()) {
        header('Location: ../views/admin/nuevo_tecnico.php?error=Ese email ya esta en uso');
        exit();
    }

    $passwordHash = password_hash($password, PASSWORD_BCRYPT);

    $stmt = $db->prepare("INSERT INTO usuarios (nombre, email, password, rol, telefono) VALUES (?, ?, ?, 'tecnico', ?)");
    $stmt->execute([$nombre, $email, $passwordHash, $telefono]);

    header('Location: ../views/admin/tecnicos.php?success=Tecnico creado correctamente');
    exit();
}

if(isset($_GET['action']) && $_GET['action'] == 'eliminar') {
    $id = $_GET['id'];
    $db = conectarDB();

    $stmt = $db->prepare("SELECT id FROM incidencias WHERE tecnico_id = ?");
    $stmt->execute([$id]);
    if($stmt->fetch()) {
        header('Location: ../views/admin/tecnicos.php?error=No puedes eliminar un tecnico con incidencias asignadas');
        exit();
    }

    $stmt = $db->prepare("DELETE FROM usuarios WHERE id = ? AND rol = 'tecnico'");
    $stmt->execute([$id]);

    header('Location: ../views/admin/tecnicos.php?success=Tecnico eliminado correctamente');
    exit();
}