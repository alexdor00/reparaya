<?php
session_start();
require_once '../../config/database.php';

if(isset($_GET['action']) && $_GET['action'] == 'logout') {
    session_destroy();
    header('Location: ../../public/index.php');
    exit();
}

$action = $_POST['action'] ?? '';

if($action == 'login') {
    $email = $_POST['email'];
    $password = $_POST['password'];

    $db = conectarDB();
    $stmt = $db->prepare("SELECT * FROM usuarios WHERE email = ?");
    $stmt->execute([$email]);
    $usuario = $stmt->fetch(PDO::FETCH_ASSOC);

    if($usuario && password_verify($password, $usuario['password'])) {
        $_SESSION['usuario_id'] = $usuario['id'];
        $_SESSION['usuario_nombre'] = $usuario['nombre'];
        $_SESSION['usuario_rol'] = $usuario['rol'];

        if($usuario['rol'] == 'admin') {
            header('Location: ../views/admin/dashboard.php');
        } elseif($usuario['rol'] == 'tecnico') {
            header('Location: ../views/tecnico/dashboard.php');
        } else {
            header('Location: ../views/cliente/dashboard.php');
        }
        exit();
    } else {
        header('Location: ../../public/index.php?page=login&error=Email o contrasena incorrectos');
        exit();
    }
}

if($action == 'registro') {
    $nombre = $_POST['nombre'];
    $email = $_POST['email'];
    $telefono = $_POST['telefono'];
    $password = $_POST['password'];
    $password2 = $_POST['password2'];

    if($password != $password2) {
        header('Location: ../../public/index.php?page=registro&error=Las contrasenas no coinciden');
        exit();
    }

    $db = conectarDB();

    $stmt = $db->prepare("SELECT id FROM usuarios WHERE email = ?");
    $stmt->execute([$email]);
    if($stmt->fetch()) {
        header('Location: ../../public/index.php?page=registro&error=Ese email ya esta registrado');
        exit();
    }

    $passwordHash = password_hash($password, PASSWORD_BCRYPT);

    $stmt = $db->prepare("INSERT INTO usuarios (nombre, email, password, rol, telefono) VALUES (?, ?, ?, 'cliente', ?)");
    $stmt->execute([$nombre, $email, $passwordHash, $telefono]);

    header('Location: ../../public/index.php?page=login&success=Cuenta creada correctamente');
    exit();
}