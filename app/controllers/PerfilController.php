<?php
session_start();
if(!isset($_SESSION['usuario_id'])) {
    header('Location: ../../public/index.php?page=login');
    exit();
}
require_once '../../config/database.php';

$nombre = $_POST['nombre'];
$email = $_POST['email'];
$telefono = $_POST['telefono'];
$password = $_POST['password'];
$password2 = $_POST['password2'];

$db = conectarDB();

// Comprobamos si el email ya lo usa otro usuario
$stmt = $db->prepare("SELECT id FROM usuarios WHERE email = ? AND id != ?");
$stmt->execute([$email, $_SESSION['usuario_id']]);
if($stmt->fetch()) {
    header('Location: ../views/perfil.php?error=Ese email ya esta en uso');
    exit();
}

if(!empty($password)) {
    if($password != $password2) {
        header('Location: ../views/perfil.php?error=Las contrasenas no coinciden');
        exit();
    }
    $passwordHash = password_hash($password, PASSWORD_BCRYPT);
    $stmt = $db->prepare("UPDATE usuarios SET nombre = ?, email = ?, telefono = ?, password = ? WHERE id = ?");
    $stmt->execute([$nombre, $email, $telefono, $passwordHash, $_SESSION['usuario_id']]);
} else {
    $stmt = $db->prepare("UPDATE usuarios SET nombre = ?, email = ?, telefono = ? WHERE id = ?");
    $stmt->execute([$nombre, $email, $telefono, $_SESSION['usuario_id']]);
}

$_SESSION['usuario_nombre'] = $nombre;

header('Location: ../views/perfil.php?success=Perfil actualizado correctamente');
exit();