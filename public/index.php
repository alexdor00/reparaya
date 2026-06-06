<?php
session_start();

$page = isset($_GET['page']) ? $_GET['page'] : 'home';

switch($page) {
    case 'home':
        require_once '../app/views/home.php';
        break;
    case 'login':
        require_once '../app/views/login.php';
        break;
    case 'registro':
        require_once '../app/views/registro.php';
        break;
    default:
        require_once '../app/views/home.php';
        break;
}
