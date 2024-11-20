<?php
include('../db.php');


// Obtener el afiliado a editar
if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $sql = "SELECT * FROM afiliado WHERE Id_afiliado = $id";
    $result = $conexion->query($sql);
    
    if ($result->num_rows > 0) {
        $afiliado = $result->fetch_assoc();
    } else {
        echo "Afiliado no encontrado.";
        exit;
    }
}

// Obtener planes desde la base de datos
$sql_planes = "SELECT id_planes, CONCAT(
    CASE WHEN contributivo = 1 THEN 'Contributivo, ' ELSE '' END,
    CASE WHEN complementario = 1 THEN 'Complementario, ' ELSE '' END,
    CASE WHEN plus = 1 THEN 'Plus, ' ELSE '' END,
    CASE WHEN preferencial = 1 THEN 'Preferencial, ' ELSE '' END,
    CASE WHEN exequial = 1 THEN 'Exequial' ELSE '' END
) AS descripcion, tarifas 
FROM planes";

$result_planes = $conexion->query($sql_planes);
$planes = $result_planes->fetch_all(MYSQLI_ASSOC);

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Datos del afiliado
    $nombre = $_POST['nombre'];
    $identificacion = $_POST['identificacion'];
    $telefono = $_POST['telefono'];
    $edad = $_POST['edad'];
    $genero = $_POST['genero'];
    $lugar_de_nacimiento = $_POST['lugar_de_nacimiento'];
    $codigo_afiliado = $_POST['codigo_afiliado'];
    $id_planes = $_POST['id_planes'];

    // Insertar afiliado
    $sql = "INSERT INTO afiliado (nombre, identificacion, telefono, edad, genero, lugar_de_nacimiento, codigo_afiliado, id_planes) 
            VALUES ('$nombre', '$identificacion', '$telefono', '$edad', '$genero', '$lugar_de_nacimiento', '$codigo_afiliado', $id_planes)";

    if ($conexion->query($sql) === TRUE) {
        $id_afiliado = $conexion->insert_id; // Obtener el ID del afiliado recién creado

        if (isset($_POST['Beneficiario']) && $_POST['Beneficiario'] === 'SI') {
            // Redirigir a Beneficiario.php si seleccionaron "SI"
            header("Location: Beneficiario.php?id_afiliado=$id_afiliado");
            exit;
        } else {
            // Redirigir a listar_beneficiarios.php si seleccionaron "No"
            header('Location: #lista' . $id_afiliado);
            exit;
        }
        
    } else {
        echo "Error al crear afiliado: " . $conexion->error;
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Afiliado</title>
    <link rel="stylesheet" href="style_ea.css">
</head>
<body>
    <h1>Editar Afiliado</h1>
    <form method="POST" action="">
        <label for="nombre">Nombre:</label>
        <input type="text" name="nombre" id="nombre" value="<?php echo $afiliado['nombre'];?>" required><br>

        <label for="identificacion">Identificación:</label>
        <input type="text" name="identificacion" id="identificacion" value="<?php echo $afiliado['identificacion'];?>" required><br>

        <label for="telefono">Teléfono:</label>
        <input type="text" name="telefono" id="telefono" value="<?php echo $afiliado['telefono'];?>" required><br>

        <label for="edad">Edad:</label>
        <input type="number" name="edad" id="edad" value="<?php echo $afiliado['edad'];?>" required><br>

        <label for="genero">Género:</label>
        <select name="genero" id="genero" required>
            <option value="M" <?php echo $afiliado['genero'] == 'M'?'selected' : '';?>>Masculino</option>
            <option value="F" <?php echo $afiliado['genero'] == 'F'?'selected' : '';?>>Femenino</option>
        </select><br>

        <label for="lugar_de_nacimiento">Lugar de Nacimiento:</label>
        <input type="text" name="lugar_de_nacimiento" id="lugar_de_nacimiento" value="<?php echo $afiliado['lugar_de_nacimiento'];?>" required><br>

        <label for="codigo_afiliado">Código de Afiliado:</label>
        <input type="text" name="codigo_afiliado" id="codigo_afiliado" value="<?php echo $afiliado['codigo_afiliado'];?>" required><br>

        <label for="id_planes">Plan:</label>
        <select name="id_planes" id="id_planes" required>
            <option value="" disabled selected>Selecciona un plan</option>
            <?php foreach ($planes as $plan): ?>
                <option value="<?= $plan['id_planes'] ?>">
                    <?= $plan['descripcion'] ?> - $<?= $plan['tarifas'] ?>
                </option>
            <?php endforeach; ?>
        </select><br>
        
        <button type="submit">Actualizar</button>
    </form>
</body>
</html>