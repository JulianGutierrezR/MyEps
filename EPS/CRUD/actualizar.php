<?php
include '../db.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id = $_GET['id'];
    $nombre = $_POST['nombre'];
    $identificacion = $_POST['identificacion'];
    // ... (repita para todos los campos)
    
    $sql = "UPDATE afiliado SET nombre = ?, identificacion = ?, ... WHERE Id_afiliado = ?";
    $stmt = $conexion->prepare($sql);
    $stmt->bind_param("ss...", $nombre, $identificacion, ...); // ... (repita para todos los campos)
    
    if ($stmt->execute()) {
        echo "Datos actualizados correctamente";
        header('Location: listar_afiliados.php');
        exit;
    } else {
        echo "Error al actualizar los datos";
    }
}
?>
