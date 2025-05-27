<?php
session_start();

if (!isset($_SESSION['usuario'])) {
    die("Acceso denegado");
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['reiniciar'])) {
    $resultado = shell_exec("sudo /sbin/reboot");

    echo "Reiniciando";
    exit;
}
?>
