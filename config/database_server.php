<?php

define('DB_HOST', 'localhost');
define('DB_NAME', 'wordpress7');
define('DB_USER', 'wordpress7');
define('DB_PASS', 'kJvlFO88UY6a31Md');

function conectarDB() {
    try {
        $pdo = new PDO(
            "mysql:host=" . DB_HOST . ";dbname=" . DB_NAME . ";charset=utf8",
            DB_USER,
            DB_PASS
        );
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        return $pdo;
    } catch (PDOException $e) {
        die("Error de conexion: " . $e->getMessage());
    }
}