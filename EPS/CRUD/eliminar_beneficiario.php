<?php
include('../db.php'); // Conexión a la base de datos

// Iniciar sesión para mostrar mensajes de éxito o error
session_start();

// Verificar si el parámetro id_beneficiario está presente en la URL
if (isset($_GET['id_beneficiario'])) {
    $id_beneficiario = intval($_GET['id_beneficiario']); // Sanitizar el ID recibido

    // Verificar que el beneficiario exista en la base de datos
    $sql_verificar = "SELECT * FROM beneficiario WHERE id_beneficiario = $id_beneficiario";
    $resultado = $conexion->query($sql_verificar);

    if ($resultado->num_rows > 0) {
        // Si existe, eliminar el beneficiario
        $sql_eliminar = "DELETE FROM beneficiario WHERE id_beneficiario = $id_beneficiario";
        if ($conexion->query($sql_eliminar) === TRUE) {
            // Guardar mensaje de éxito en la sesión
            $_SESSION['mensaje'] = "Beneficiario eliminado correctamente.";
        } else {
            // Guardar mensaje de error en la sesión
            $_SESSION['mensaje'] = "Error al eliminar el beneficiario: " . $conexion->error;
        }
    } else {
        // Guardar mensaje de error si el beneficiario no se encuentra
        $_SESSION['mensaje'] = "Beneficiario no encontrado.";
    }
} else {
    // Guardar mensaje de error si no se proporciona un ID
    $_SESSION['mensaje'] = "ID de beneficiario no proporcionado.";
}

// Redirigir de vuelta a crear_afiliado.php
header("Location: crear_afiliado.php");
exit;
?>
