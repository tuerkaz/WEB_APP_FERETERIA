<?php
include 'conexion.php';

$cliente_id = $_POST['cliente_id'];
$productos = $_POST['productos'];

// Verificar tipo de cliente
$sql_cliente = "SELECT tipo_cliente FROM usuarios WHERE id = ?";
$stmt_cliente = $conn->prepare($sql_cliente);
$stmt_cliente->bind_param("i", $cliente_id);
$stmt_cliente->execute();
$stmt_cliente->bind_result($tipo_cliente);
$stmt_cliente->fetch();
$stmt_cliente->close();

// Definir el descuento según el tipo de cliente
$descuento_cliente = 0;
switch ($tipo_cliente) {
    case 'permanente':
        $descuento_cliente = 0.10;
        break;
    case 'periodico':
        $descuento_cliente = 0.05;
        break;
    case 'casual':
        $descuento_cliente = 0.02;
        break;
    case 'nuevo':
        $descuento_cliente = 0;
        break;
}

// Calcular el subtotal y aplicar descuentos
$subtotal = 0;
$detalle_productos = [];

foreach ($productos as $producto_id => $cantidad) {
    if ($cantidad > 0) {
        $sql_producto = "SELECT precio FROM productos WHERE id = ?";
        $stmt_producto = $conn->prepare($sql_producto);
        $stmt_producto->bind_param("i", $producto_id);
        $stmt_producto->execute();
        $stmt_producto->bind_result($precio);
        $stmt_producto->fetch();
        $stmt_producto->close();

        $subtotal += $precio * $cantidad;
        $detalle_productos[] = ['producto_id' => $producto_id, 'cantidad' => $cantidad, 'precio_unitario' => $precio];
    }
}

// Aplicar descuento adicional si el subtotal supera los $100,000
$descuento_adicional = ($subtotal > 100000) ? 0.02 : 0;
$total_descuento = $subtotal * ($descuento_cliente + $descuento_adicional);
$total = $subtotal - $total_descuento;

// Guardar cotización
$sql_cotizacion = "INSERT INTO cotizaciones (usuario_id, subtotal, descuento, total) VALUES (?, ?, ?, ?)";
$stmt_cotizacion = $conn->prepare($sql_cotizacion);
$stmt_cotizacion->bind_param("iddd", $cliente_id, $subtotal, $total_descuento, $total);
$stmt_cotizacion->execute();
$cotizacion_id = $stmt_cotizacion->insert_id;
$stmt_cotizacion->close();

// Guardar detalles de la cotización
foreach ($detalle_productos as $detalle) {
    $sql_detalle = "INSERT INTO detalle_cotizacion (cotizacion_id, producto_id, cantidad, precio_unitario) VALUES (?, ?, ?, ?)";
    $stmt_detalle = $conn->prepare($sql_detalle);
    $stmt_detalle->bind_param("iiid", $cotizacion_id, $detalle['producto_id'], $detalle['cantidad'], $detalle['precio_unitario']);
    $stmt_detalle->execute();
    $stmt_detalle->close();
}

echo "Cotización realizada exitosamente. Total: $" . number_format($total, 2);

$conn->close();
?>
