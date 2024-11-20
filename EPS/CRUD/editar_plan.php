<?php
include('../db.php');

// Verificar si se recibió el ID del plan
if (!isset($_GET['id']) || empty($_GET['id'])) {
    die('ID de plan no especificado.');
}

$id = intval($_GET['id']);

// Obtener los datos del plan
$sql_plan = "SELECT * FROM planes WHERE id_planes = $id";
$result_plan = $conexion->query($sql_plan);

if ($result_plan->num_rows == 0) {
    die('El plan no existe.');
}

$plan = $result_plan->fetch_assoc();

// Manejar la actualización del plan
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $contributivo = isset($_POST['contributivo']) ? 1 : 0;
    $complementario = isset($_POST['complementario']) ? 1 : 0;
    $plus = isset($_POST['plus']) ? 1 : 0;
    $preferencial = isset($_POST['preferencial']) ? 1 : 0;
    $exequial = isset($_POST['exequial']) ? 1 : 0;
    $tarifas = $_POST['tarifas'];

    $sql_update = "UPDATE planes SET 
        contributivo = $contributivo, 
        complementario = $complementario, 
        plus = $plus, 
        preferencial = $preferencial, 
        exequial = $exequial, 
        tarifas = $tarifas 
        WHERE id_planes = $id";

    if ($conexion->query($sql_update) === TRUE) {
        echo "Plan actualizado exitosamente.";
    } else {
        echo "Error al actualizar el plan: " . $conexion->error;
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Plan</title>
    <link rel="stylesheet" href="style_ep.css">
</head>
<body>
    <h1>Editar Plan</h1>
    <form method="POST" action="">
        <label>
            <input type="checkbox" name="contributivo" <?= $plan['contributivo'] ? 'checked' : '' ?>> Contributivo
        </label><br>
        <label>
            <input type="checkbox" name="complementario" <?= $plan['complementario'] ? 'checked' : '' ?>> Complementario
        </label><br>
        <label>
            <input type="checkbox" name="plus" <?= $plan['plus'] ? 'checked' : '' ?>> Plus
        </label><br>
        <label>
            <input type="checkbox" name="preferencial" <?= $plan['preferencial'] ? 'checked' : '' ?>> Preferencial
        </label><br>
        <label>
            <input type="checkbox" name="exequial" <?= $plan['exequial'] ? 'checked' : '' ?>> Exequial
        </label><br>
        <label for="tarifas">Tarifas:</label>
        <input type="number" step="0.01" name="tarifas" id="tarifas" value="<?= htmlspecialchars($plan['tarifas']) ?>" required><br><br>

        <button type="submit">Actualizar Plan</button>
    </form>
    
</body>
</html>
