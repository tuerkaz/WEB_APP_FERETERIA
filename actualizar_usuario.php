<?php
include 'conexion.php';

if (!empty($_POST['id']) && !empty($_POST['nombre']) && !empty($_POST['correo']) && !empty($_POST['tipo_cliente'])) {
    $id = $_POST['id'];
    $nombre = $_POST['nombre'];
    $correo = $_POST['correo'];
    $tipo_cliente = $_POST['tipo_cliente'];

    $sql = "UPDATE usuarios SET nombre = ?, correo = ?, tipo_cliente = ? WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sssi", $nombre, $correo, $tipo_cliente, $id);

    if ($stmt->execute()) {
        echo "Usuario actualizado con éxito.";
    } else {
        echo "Error al actualizar el usuario: " . $stmt->error;
    }

    $stmt->close();
} else {
    echo "Todos los campos son obligatorios.";
}

$conn->close();
?>
