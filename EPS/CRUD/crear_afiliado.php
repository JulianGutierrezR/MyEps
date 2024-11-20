<?php
include('../db.php'); // Conexión a la base de datos

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
            header('Location: crear_afiliado.php');
            exit;
        }
    } else {
        echo "Error al crear afiliado: " . $conexion->error;
    }
}

// Mostrar mensajes si existen
if (isset($_GET['mensaje'])) {
    echo "<p style='color: green;'>{$_GET['mensaje']}</p>";
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Crear Afiliado</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="menuc">
        <nav>
            <ul>
                <li><a href="autorizaciones.php">Autorizaciones</a></li>
                <li><a href="servicios.php">Servicios</a></li>
                <li><a href="planes.php">Planes complementarios</a></li> 
                <li><a href="listaf.php">Resolución</a></li> 
            </ul>
        </nav>
    </div>

    <div>
        <h1>Crear Afiliado</h1>
        <form method="POST" action="">
            <label for="nombre">Nombre:</label>
            <input type="text" name="nombre" id="nombre" required><br>

            <label for="identificacion">Identificación:</label>
            <input type="text" name="identificacion" id="identificacion" required><br>

            <label for="telefono">Teléfono:</label>
            <input type="text" name="telefono" id="telefono" required><br>

            <label for="edad">Edad:</label>
            <input type="number" name="edad" id="edad" required><br>

            <label for="genero">Género:</label>
            <select name="genero" id="genero" required>
                <option value="M">Masculino</option>
                <option value="F">Femenino</option>
            </select><br>

            <label for="lugar_de_nacimiento">Lugar de Nacimiento:</label>
            <input type="text" name="lugar_de_nacimiento" id="lugar_de_nacimiento" required><br>

            <label for="codigo_afiliado">Código de Afiliado:</label>
            <input type="text" name="codigo_afiliado" id="codigo_afiliado" required><br>

            <label for="id_planes">Plan:</label>
            <select name="id_planes" id="id_planes" required>
                <option value="" disabled selected>Selecciona un plan</option>
                <?php foreach ($planes as $plan): ?>
                    <option value="<?= $plan['id_planes'] ?>">
                        <?= $plan['descripcion'] ?> - $<?= $plan['tarifas'] ?>
                    </option>
                <?php endforeach; ?>
            </select><br>
            
            <label for="Beneficiario">¿Tiene Beneficiarios?</label>
            <select name="Beneficiario" id="Beneficiario" required>
                <option value="SI">Si</option>
                <option value="No">No</option>
            </select>

            <button>Crear Afiliado</button>
        </form>

        <section id="lista">
            <h2>Lista de Afiliados y Beneficiarios</h2>
            <?php
            $sql = "
                SELECT 
                    afiliado.id_afiliado,
                    afiliado.nombre AS afiliado_nombre,
                    afiliado.identificacion AS afiliado_identificacion,
                    afiliado.telefono AS afiliado_telefono,
                    afiliado.edad AS afiliado_edad,
                    afiliado.genero AS afiliado_genero,
                    afiliado.lugar_de_nacimiento AS afiliado_lugar,
                    afiliado.codigo_afiliado AS afiliado_codigo,
                    afiliado.id_planes,
                    beneficiario.id_beneficiario,
                    beneficiario.nombre AS beneficiario_nombre,
                    beneficiario.identificacion AS beneficiario_identificacion,
                    beneficiario.edad AS beneficiario_edad,
                    beneficiario.genero AS beneficiario_genero,
                    beneficiario.telefono AS beneficiario_telefono
                FROM afiliado
                LEFT JOIN beneficiario ON afiliado.id_afiliado = beneficiario.id_afiliado
                ORDER BY afiliado.id_afiliado, beneficiario.nombre
            ";

            $resultado = $conexion->query($sql);

            if ($resultado->num_rows > 0) {
                echo "<table border='1'>";
                echo "<tr>
                        <th>ID</th>
                        <th>Nombre</th>
                        <th>Identificación</th>
                        <th>Teléfono</th>
                        <th>Edad</th>
                        <th>Género</th>
                        <th>Lugar de Nacimiento</th>
                        <th>Código Afiliado</th>
                        <th>Plan</th>
                        <th>Acciones</th>
                    </tr>";

                $current_afiliado = null;

                while ($fila = $resultado->fetch_assoc()) {
                    if ($current_afiliado !== $fila['id_afiliado']) {
                        $current_afiliado = $fila['id_afiliado'];
                        echo "<tr>
                                <td>{$fila['id_afiliado']}</td>
                                <td>{$fila['afiliado_nombre']}</td>
                                <td>{$fila['afiliado_identificacion']}</td>
                                <td>{$fila['afiliado_telefono']}</td>
                                <td>{$fila['afiliado_edad']}</td>
                                <td>" . ($fila['afiliado_genero'] === 'M' ? 'Masculino' : 'Femenino') . "</td>
                                <td>{$fila['afiliado_lugar']}</td>
                                <td>{$fila['afiliado_codigo']}</td>
                                <td>{$fila['id_planes']}</td>
                                <td>
                                    <a href='editar_afiliado.php?id={$fila['id_afiliado']}'>Editar</a> |
                                    <a href='Eliminar_afiliado.php?id={$fila['id_afiliado']}'>Eliminar</a>
                                </td>
                            </tr>";
                    }

                    if (!empty($fila['beneficiario_nombre'])) {
                        echo "<tr class='beneficiario'>
                                <td></td>
                                <td>-- {$fila['beneficiario_nombre']}</td>
                                <td>{$fila['beneficiario_identificacion']}</td>
                                <td>{$fila['beneficiario_telefono']}</td>
                                <td>{$fila['beneficiario_edad']}</td>
                                <td>" . ($fila['beneficiario_genero'] === 'M' ? 'Masculino' : 'Femenino') . "</td>
                                <td colspan='3'>Beneficiario</td>
                                <td>
                                    <a href='eliminar_beneficiario.php?id_beneficiario={$fila['id_beneficiario']}' 
                                    onclick=\"return confirm('¿Estás seguro de eliminar este beneficiario?');\">Eliminar</a>
                                </td>
                            </tr>";
                    }
                }
                echo "</table>";
            } else {
                echo "<p>No hay afiliados registrados.</p>";
            }
            ?>
        </section>
    </div>
</body>
</html>
