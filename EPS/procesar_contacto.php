<?php
include('db.php'); // Conexión a la base de datos

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nombre = $_POST['name'];
    $correo = $_POST['email'];
    $mensaje = $_POST['message'];

    // Validar que los campos no estén vacíos
    if (!empty($nombre) && !empty($correo) && !empty($mensaje)) {
        $sql = "INSERT INTO contacto (nombre, correo, mensaje) VALUES ('$nombre', '$correo', '$mensaje')";

        if ($conexion->query($sql) === TRUE) {
            echo "<p>Mensaje enviado correctamente. Gracias por contactarnos.</p>";
        } else {
            echo "<p>Error al enviar el mensaje: " . $conexion->error . "</p>";
        }
    } else {
        echo "<p>Por favor, completa todos los campos del formulario.</p>";
    }
}
?>