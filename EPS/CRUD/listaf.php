<?php
include('../db.php');
// Consulta para obtener los datos combinados de Afiliado, Autorizaciones y Servicios
$sql = "
    SELECT 
        a.id_afiliado, 
        a.nombre, 
        a.identificacion, 
        a.telefono, 
        a.edad, 
        a.genero, 
        a.lugar_de_nacimiento, 
        a.codigo_afiliado, 
        a.id_planes, 
        au.informacion_del_prestador, 
        au.ubicacion, 
        au.cobro, 
        au.observaciones, 
        au.descripcion, 
        au.cita_medica, 
        s.servicios_adicionales AS servicio
    FROM 
        afiliado a
    LEFT JOIN 
        autorizaciones au ON a.id_afiliado = au.id_autorizaciones
    LEFT JOIN 
        serviciosXplanes sp ON sp.id_planes = a.id_planes
    LEFT JOIN 
        servicios s ON s.id_servicios = sp.id_servicios
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
            <th>Información del Prestador</th>
            <th>Ubicación</th>
            <th>Cobro</th>
            <th>Observaciones</th>
            <th>Descripción</th>
            <th>Cita Médica</th>
            <th>Servicio</th>
            <th>Acciones</th>
        </tr>";
    while ($fila = $resultado->fetch_assoc()) {
        echo "<tr>
                <td>{$fila['id_afiliado']}</td>
                <td>{$fila['nombre']}</td>
                <td>{$fila['identificacion']}</td>
                <td>{$fila['telefono']}</td>
                <td>{$fila['edad']}</td>
                <td>" . ($fila['genero'] === 'F' ? 'Femenino' : 'Masculino') . "</td>
                <td>{$fila['lugar_de_nacimiento']}</td>
                <td>{$fila['codigo_afiliado']}</td>
                <td>{$fila['id_planes']}</td>
                <td>{$fila['informacion_del_prestador']}</td>
                <td>{$fila['ubicacion']}</td>
                <td>{$fila['cobro']}</td>
                <td>{$fila['observaciones']}</td>
                <td>{$fila['descripcion']}</td>
                <td>{$fila['cita_medica']}</td>
                <td>{$fila['servicio']}</td>
                <td>
                    <a href='editarf.php?id={$fila['id_afiliado']}'>Editar</a> |
                    <a href='eliminar_lista.php?id={$fila['id_afiliado']}' onClick=\"return confirm('¿Estás seguro de que quieres eliminar este afiliado?')\">Eliminar</a>
                </td>
            </tr>";
    }
    echo "</table>";
} else {
    echo "No hay afiliados agregados";
}

$conexion->close();
?>
