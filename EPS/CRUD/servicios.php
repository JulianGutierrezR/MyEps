<?php
// Conexión a la base de datos
include('../db.php');

// Crear registro de servicio
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['crear'])) {
    $citas_medicas = isset($_POST['citas_medicas']) ? 1 : 0;
    $citas_prioritarias = isset($_POST['citas_prioritarias']) ? 1 : 0;
    $medicamentos = isset($_POST['medicamentos']) ? 1 : 0;
    $atencion_virtual = isset($_POST['atencion_virtual']) ? 1 : 0;
    $atencion_medica = isset($_POST['atencion_medica']) ? 1 : 0;
    $servicios_adicionales = $_POST['servicios_adicionales'];
    $atencion_especializada = isset($_POST['atencion_especializada']) ? 1 : 0;
    $urgencias = isset($_POST['urgencias']) ? 1 : 0;

    $sql = "INSERT INTO servicios (citas_medicas, citas_prioritarias, medicamentos, atencion_virtual, atencion_medica, servicios_adicionales, atencion_especializada, urgencias)
            VALUES ($citas_medicas, $citas_prioritarias, $medicamentos, $atencion_virtual, $atencion_medica, '$servicios_adicionales', $atencion_especializada, $urgencias)";
    
    if ($conexion->query($sql) === TRUE) {
        echo "Servicio registrado exitosamente.";
    } else {
        echo "Error: " . $conexion->error;
    }
}

// Guardar datos del paciente asociado al servicio
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['guardar_paciente'])) {
    $id_servicio = $_POST['id_servicio'];
    $nombre_usuario = $_POST['nombre_usuario'];
    $email_usuario = $_POST['email_usuario'];
    $telefono_usuario = $_POST['telefono_usuario'];

    $sql = "INSERT INTO usuarios_servicios (id_servicio, nombre_usuario, email_usuario, telefono_usuario) 
            VALUES ($id_servicio, '$nombre_usuario', '$email_usuario', '$telefono_usuario')";

    if ($conexion->query($sql) === TRUE) {
        echo "Paciente registrado exitosamente.";
    } else {
        echo "Error: " . $conexion->error;
    }
}

// Mostrar registros de servicios
$result = $conexion->query("SELECT * FROM servicios");
?>

<!DOCTYPE html>
<html>
<head>
    <title>Gestión de Servicios</title>
    <link rel="stylesheet" href="styles_ser.css">
</head>
<body>
    <h1>Servicios</h1>

    <!-- Formulario para crear un nuevo servicio -->
    <form method="POST">
        <label>Citas Médicas:</label><input type="checkbox" name="citas_medicas"><br>
        <label>Citas Prioritarias:</label><input type="checkbox" name="citas_prioritarias"><br>
        <label>Medicamentos:</label><input type="checkbox" name="medicamentos"><br>
        <label>Atención Virtual:</label><input type="checkbox" name="atencion_virtual"><br>
        <label>Atención Médica:</label><input type="checkbox" name="atencion_medica"><br>
        <label>Servicios Adicionales:</label><textarea name="servicios_adicionales"></textarea><br>
        <label>Atención Especializada:</label><input type="checkbox" name="atencion_especializada"><br>
        <label>Urgencias:</label><input type="checkbox" name="urgencias"><br>
        <button type="submit" name="crear">Crear</button>
    </form>

    <!-- Listado de servicios -->
    <h2>Listado de Servicios</h2>
    <table border="1">
        <tr>
            <th>ID</th>
            <th>Citas Médicas</th>
            <th>Citas Prioritarias</th>
            <th>Medicamentos</th>
            <th>Atención Virtual</th>
            <th>Atención Médica</th>
            <th>Servicios Adicionales</th>
            <th>Atención Especializada</th>
            <th>Urgencias</th>
            <th>Acciones</th>
        </tr>
        <?php while ($row = $result->fetch_assoc()) { ?>
        <tr>
            <td><?php echo $row['id_servicios']; ?></td>
            <td><?php echo $row['citas_medicas'] ? 'Sí' : 'No'; ?></td>
            <td><?php echo $row['citas_prioritarias'] ? 'Sí' : 'No'; ?></td>
            <td><?php echo $row['medicamentos'] ? 'Sí' : 'No'; ?></td>
            <td><?php echo $row['atencion_virtual'] ? 'Sí' : 'No'; ?></td>
            <td><?php echo $row['atencion_medica'] ? 'Sí' : 'No'; ?></td>
            <td><?php echo $row['servicios_adicionales']; ?></td>
            <td><?php echo $row['atencion_especializada'] ? 'Sí' : 'No'; ?></td>
            <td><?php echo $row['urgencias'] ? 'Sí' : 'No'; ?></td>
            <td>
                <form method="POST">
                    <input type="hidden" name="id_servicio" value="<?php echo $row['id_servicios']; ?>">
                    <button type="submit" name="seleccionar_servicio">Seleccionar</button>
                </form>
            </td>
        </tr>
        <?php } ?>
    </table>

    <!-- Formulario dinámico para asociar pacientes a un servicio -->
    <?php if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['seleccionar_servicio'])) { 
        $id_servicio = $_POST['id_servicio']; ?>
        <h2>Registrar Paciente para el Servicio ID: <?php echo $id_servicio; ?></h2>
        <form method="POST">
            <input type="hidden" name="id_servicio" value="<?php echo $id_servicio; ?>">
            <label>Nombre del Paciente:</label><input type="text" name="nombre_usuario" required><br>
            <label>Correo Electrónico:</label><input type="email" name="email_usuario" required><br>
            <label>Teléfono:</label><input type="text" name="telefono_usuario" required><br>
            <button type="submit" name="guardar_paciente">Guardar</button>
        </form>
    <?php } ?>

</body>
</html>
<?php $conexion->close(); ?>
