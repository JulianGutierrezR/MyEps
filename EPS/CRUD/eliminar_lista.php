<?php
include '../db.php';

if (!isset($_GET['id']) || empty($_GET['id'])) {
    echo "ID no válido";
    exit;
}

$id = $_GET['id'];

$sql = "DELETE FROM planes WHERE id_planes = ?";
$stmt = $conexion->prepare($sql);
$stmt->bind_param("i", $id);

if ($stmt->execute()) {
    // Luego, intenta eliminar el afiliado principal
    $sql = "DELETE FROM afiliado WHERE Id_afiliado = ?";
    $stmt = $conexion->prepare($sql);
    $stmt->bind_param("i", $id);
    if ($stmt->execute()) {
        echo "Afiliado y sus autorizaciones eliminados correctamente";
    } else {
        echo "Error al eliminar el afiliado: " . $conexion->error;
    }
} else {
    echo "Error al eliminar las autorizaciones: " . $conexion->error;
}

// Redirigir al usuario después de eliminar
header('Location: listaf.php');
exit;
?>



