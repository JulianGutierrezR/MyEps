<?php
include '../db.php';
if ($conexion->connect_error) {
    die("Conexión fallida: " . $conexion->connect_error);
}


if (!isset($_GET['id']) || empty($_GET['id'])) {
    echo "ID no válido";
    exit;
}

$id = $_GET['id'];

// Verifica si el ID existe
$sql = "SELECT COUNT(*) FROM afiliado WHERE Id_afiliado = ?";
$stmt = $conexion->prepare($sql);
$stmt->bind_param("i", $id);
$result = $stmt->execute();
$count = $result->fetch_row()[0];

if ($count == 0) {
    echo "Afiliado no encontrado";
    exit;
}

?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Afiliado</title>
</head>
<body>
    <h1>Editar Afiliado</h1>
    <form method="POST" action="actualizar_afiliado.php?id=<?php echo $id; ?>">
        <label for="nombre">Nombre:</label>
        <input type="text" name="nombre" id="nombre" value="<?php echo $afiliado['nombre']; ?>" required><br>

        <label for="identificacion">Identificación:</label>
        <input type="text" name="identificacion" id="identificacion" value="<?php echo $afiliado['identificacion']; ?>" required><br>

        <!-- Repita para los demás campos -->

        <button type="submit">Actualizar</button>
    </form>
</body>
</html>
