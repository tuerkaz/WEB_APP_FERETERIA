<?php
include 'conexion.php';

// Obtener productos disponibles
$sql_productos = "SELECT id, nombre_producto, precio FROM productos";
$result_productos = $conn->query($sql_productos);

?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Realizar Cotización</title>
</head>
<body>
    <h1>Realizar Cotización</h1>
    <form action="procesar_cotizacion.php" method="POST">
        <label for="cliente_id">ID del Cliente:</label>
        <input type="number" name="cliente_id" required><br>

        <h2>Productos</h2>
        <?php while ($producto = $result_productos->fetch_assoc()): ?>
            <div>
                <label><?= htmlspecialchars($producto['nombre_producto']) ?> ($<?= $producto['precio'] ?>)</label>
                <input type="number" name="productos[<?= $producto['id'] ?>]" placeholder="Cantidad" min="0">
            </div>
        <?php endwhile; ?>

        <button type="submit">Cotizar</button>
    </form>
</body>
</html>
<?php $conn->close(); ?>
