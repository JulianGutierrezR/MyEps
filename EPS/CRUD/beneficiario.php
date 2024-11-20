<?php
include('../db.php');

$id_afiliado = $_GET['id_afiliado'];

// Insertar beneficiario
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nombre = $_POST['nombre'];
    $edad = $_POST['edad'];
    $identificacion = $_POST['identificacion'];
    $genero = $_POST['genero'];
    $telefono = $_POST['telefono'];

    $sql = "INSERT INTO beneficiario (nombre, edad, identificacion, genero, telefono, id_afiliado) 
            VALUES ('$nombre', '$edad', '$identificacion', '$genero', '$telefono', $id_afiliado)";

    if ($conexion->query($sql) === TRUE) {
        echo "Beneficiario agregado correctamente.";
    } else {
        echo "Error al agregar beneficiario: " . $conexion->error;
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Agregar Beneficiario</title>
</head>
<body>
    <h1>Agregar Beneficiario</h1>
    <form method="POST" action="">
        <label for="nombre">Nombre:</label>
        <input type="text" name="nombre" id="nombre" required><br>

        <label for="edad">Edad:</label>
        <input type="number" name="edad" id="edad" required><br>

        <label for="identificacion">Identificación:</label>
        <input type="text" name="identificacion" id="identificacion" required><br>

        <label for="genero">Género:</label>
        <select name="genero" id="genero" required>
            <option value="M">Masculino</option>
            <option value="F">Femenino</option>
        </select><br>

        <label for="telefono">Teléfono:</label>
        <input type="text" name="telefono" id="telefono" required><br>

        <button type="submit">Agregar Beneficiario</button>
    </form>
</body>
</html>