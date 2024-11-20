<?php
$conexion = new mysqli('localhost', 'root', '', 'eps');
if ($conexion->connect_error) {
    die("Conexión fallida: " . $conexion->connect_error);
}
?>
