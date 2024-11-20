<?php
include('../db.php');

// Manejar la creación de un nuevo plan
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $contributivo = isset($_POST['contributivo']) ? 1 : 0;
    $complementario = isset($_POST['complementario']) ? 1 : 0;
    $plus = isset($_POST['plus']) ? 1 : 0;
    $preferencial = isset($_POST['preferencial']) ? 1 : 0;
    $exequial = isset($_POST['exequial']) ? 1 : 0;
    $tarifas = $_POST['tarifas'];

    $sql = "INSERT INTO planes (contributivo, complementario, plus, preferencial, exequial, tarifas) 
            VALUES ($contributivo, $complementario, $plus, $preferencial, $exequial, $tarifas)";
    
    if ($conexion->query($sql) === TRUE) {
        echo "Plan creado exitosamente.";
    } else {
        echo "Error al crear el plan: " . $conexion->error;
    }
}

// Obtener la lista de planes
$sql_planes = "SELECT * FROM planes";
$result_planes = $conexion->query($sql_planes);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Planes</title>
    <link rel="stylesheet" href="style_pl.css">
</head>
<body>
    <h1>Gestión de Planes</h1>

    <!-- Listado de planes -->
    

    <!-- Formulario para agregar un nuevo plan -->
    <h2>Crear un nuevo plan</h2>
    <form method="POST" action="">
        <label>
            <input type="checkbox" name="contributivo"> Contributivo
        </label><br>
        <label>
            <input type="checkbox" name="complementario"> Complementario
        </label><br>
        <label>
            <input type="checkbox" name="plus"> Plus
        </label><br>
        <label>
            <input type="checkbox" name="preferencial"> Preferencial
        </label><br>
        <label>
            <input type="checkbox" name="exequial"> Exequial
        </label><br>
        <label for="tarifas">Tarifas:</label>
        <input type="number" step="0.01" name="tarifas" id="tarifas" required><br><br>

        <button type="submit">Agregar Plan</button>
    </form>
    <h2>Planes existentes</h2>
    <table border="1">
        <tr>
            <th>ID</th>
            <th>Características</th>
            <th>Tarifas</th>
            <th>Acciones</th>
        </tr>
        <?php while ($plan = $result_planes->fetch_assoc()): ?>
        <tr>
            <td><?= $plan['id_planes'] ?></td>
            <td>
                <?= $plan['contributivo'] ? 'Contributivo, ' : '' ?>
                <?= $plan['complementario'] ? 'Complementario, ' : '' ?>
                <?= $plan['plus'] ? 'Plus, ' : '' ?>
                <?= $plan['preferencial'] ? 'Preferencial, ' : '' ?>
                <?= $plan['exequial'] ? 'Exequial' : '' ?>
            </td>
            <td>$<?= number_format($plan['tarifas'], 2) ?></td>
            <td>
                <a href="editar_plan.php?id=<?= $plan['id_planes'] ?>">Editar</a> |
                <a href="eliminar_plan.php?id=<?= $plan['id_planes'] ?>" onclick="return confirm('¿Estás seguro de eliminar este plan?')">Eliminar</a>
            </td>
        </tr>
        <?php endwhile; ?>
    </table>
</body>
</html>
