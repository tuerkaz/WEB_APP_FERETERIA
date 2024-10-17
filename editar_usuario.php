<?php
include 'conexion.php';

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $sql = "SELECT nombre, correo, tipo_cliente FROM usuarios WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $stmt->bind_result($nombre, $correo, $tipo_cliente);
    $stmt->fetch();
    $stmt->close();
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Editar Usuario</title>
</head>
<body>
    <h1>Editar Usuario</h1>
    <form action="actualizar_usuario.php" method="POST">
        <input type="hidden" name="id" value="<?= htmlspecialchars($id) ?>">
        <label for="nombre">Nombre Completo:</label>
        <input type="text" name="nombre" value="<?= htmlspecialchars($nombre) ?>" required><br>

        <label for="correo">Correo Electrónico:</label>
        <input type="email" name="correo" value="<?= htmlspecialchars($correo) ?>" required><br>

        <label for="tipo_cliente">Tipo de Cliente:</label>
        <select name="tipo_cliente">
            <option value="nuevo" <?= $tipo_cliente == 'nuevo' ? 'selected' : '' ?>>Nuevo</option>
            <option value="casual" <?= $tipo_cliente == 'casual' ? 'selected' : '' ?>>Casual</option>
            <option value="periodico" <?= $tipo_cliente == 'periodico' ? 'selected' : '' ?>>Periódico</option>
            <option value="permanente" <?= $tipo_cliente == 'permanente' ? 'selected' : '' ?>>Permanente</option>
        </select><br>

        <button type="submit">Actualizar</button>
    </form>
</body>
</html>
