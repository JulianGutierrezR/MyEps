<?php
$conexion = new mysqli('localhost', 'root', '', 'eps');
if ($conexion->connect_error) die("Conexión fallida: " . $conexion->connect_error);

$id = $_GET['id'];
$sql = "DELETE FROM Afiliado WHERE Id_afiliado = $id";

if($conexion->query($sql) === TRUE){
    echo "Afiliado eliminado exitosamente";
} else {
    echo "Error al elimianr: " . $conexion->error;
}

$conexion->close();
header('location: crear_afiliado.php');
?>