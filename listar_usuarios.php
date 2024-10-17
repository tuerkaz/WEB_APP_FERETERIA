<?php
// Incluir conexión a la base de datos
include 'conexion.php';

// Consultar los usuarios registrados
$sql = "SELECT id, nombre, correo, tipo_cliente FROM usuarios";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Listado de Usuarios</title>
</head>
<body>
    <h1>Usuarios Registrados</h1>
    <table border="1">
        <tr>
            <th>Nombre</th>
            <th>Correo</th>
            <th>Tipo de Cliente</th>
            <th>Acciones</th>
        </tr>
        <?php while($row = $result->fetch_assoc()): ?>
        <tr>
            <td><?= htmlspecialchars($row['nombre']) ?></td>
            <td><?= htmlspecialchars($row['correo']) ?></td>
            <td><?= htmlspecialchars($row['tipo_cliente']) ?></td>
            <td>
                <a href="editar_usuario.php?id=<?= $row['id'] ?>">Editar</a>
                <a href="eliminar_usuario.php?id=<?= $row['id'] ?>" onclick="return confirm('¿Seguro que deseas eliminar este usuario?');">Eliminar</a>
            </td>
        </tr>
        <?php endwhile; ?>
    </table>
</body>
</html>
<?php
$conn->close();
?>
