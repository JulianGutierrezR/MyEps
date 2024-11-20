<?php
// Conexión a la base de datos
include('../db.php');

// Crear registro
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $datos_paciente = $_POST['datos_paciente'];
    $numero = $_POST['numero'];
    $informacion_prestador = $_POST['informacion_prestador'];
    $ubicacion = $_POST['ubicacion'];
    $cobro = $_POST['cobro'];
    $observaciones = $_POST['observaciones'];
    $descripcion = $_POST['descripcion'];
    $cita_medica = $_POST['cita_medica'];
    $id_afiliado = $_POST['id_afiliado'];

    $sql = "INSERT INTO autorizaciones (datos_del_paciente, numero, informacion_del_prestador, ubicacion, cobro, observaciones, descripcion, cita_medica, id_afiliado)
            VALUES ('$datos_paciente', '$numero', '$informacion_prestador', '$ubicacion', $cobro, '$observaciones', '$descripcion', '$cita_medica', $id_afiliado)";
    
    if ($conexion->query($sql) === TRUE) {
        echo "Registro creado exitosamente.";
    } else {
        echo "Error: " . $conexion->error;
    }
}
$sql_auto = "SELECT * FROM autorizaciones";
$result_auto = $conexion->query($sql_auto);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Gestión de Autorizaciones</title>
    <link rel="stylesheet" href="style_au.css">
</head>
<body>
    <h1>Autorizaciones</h1>
    <form method="POST">
        <input type="text" name="datos_paciente" placeholder="Datos del paciente" required>
        <input type="text" name="numero" placeholder="Número" required>
        <input type="text" name="informacion_prestador" placeholder="Información del prestador" required>
        <input type="text" name="ubicacion" placeholder="Ubicación" required>
        <input type="number" name="cobro" placeholder="Cobro" step="0.01" required>
        <textarea name="observaciones" placeholder="Observaciones"></textarea>
        <textarea name="descripcion" placeholder="Descripción"></textarea>
        <input type="datetime-local" name="cita_medica" required>
        <input type="number" name="id_afiliado" placeholder="ID Afiliado" required>
        <button type="submit" name="crear">Crear</button>
    </form>

    <h2>Listado de Autorizaciones</h2>
    <table border="1">
        <tr>
            <th>ID</th>
            <th>Datos del Paciente</th>
            <th>Número</th>
            <th>Información del Prestador</th>
            <th>Ubicación</th>
            <th>Cobro</th>
            <th>Observaciones</th>
            <th>Descripción</th>
            <th>Cita Médica</th>
            <th>ID Afiliado</th>
        </tr>
        <?php while ($row = $result_auto->fetch_assoc()) { ?>
        <tr>
            <td><?php echo $row['id_autorizaciones']; ?></td>
            <td><?php echo $row['datos_del_paciente']; ?></td>
            <td><?php echo $row['numero']; ?></td>
            <td><?php echo $row['informacion_del_prestador']; ?></td>
            <td><?php echo $row['ubicacion']; ?></td>
            <td><?php echo $row['cobro']; ?></td>
            <td><?php echo $row['observaciones']; ?></td>
            <td><?php echo $row['descripcion']; ?></td>
            <td><?php echo $row['cita_medica']; ?></td>
            <td><?php echo $row['id_afiliado']; ?></td>
        </tr>
        <?php } ?>
    </table>
</body>
</html>