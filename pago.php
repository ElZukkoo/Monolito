<?php
session_start();
include 'conexion.php';


$sql = "SELECT productos.*, carrito.cantidad FROM carrito JOIN productos ON carrito.id_producto = productos.id_producto WHERE carrito.id_usuario = :id_usuario";
$stmt = $pdo->prepare($sql);
$stmt->execute(['id_usuario' => $_SESSION['usuario_id']]);
$carrito = $stmt->fetchAll(PDO::FETCH_ASSOC);

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Simulación de pago
    $numero_tarjeta = $_POST['numero_tarjeta'];
    $nombre_titular = $_POST['nombre_titular'];
    $codigo_seguridad = $_POST['codigo_seguridad'];
    $fecha_expiracion = $_POST['fecha_expiracion'];

    // Insertar el pago en la tabla 'pago'
    $sql_pago = "INSERT INTO pago (metodo_pago, estado_pago) VALUES ('Tarjeta de crédito', 'Completado')";
    $stmt_pago = $pdo->prepare($sql_pago);
    $stmt_pago->execute();
    $id_pago = $pdo->lastInsertId();

    // Insertar la compra en la tabla 'compra'
    foreach ($carrito as $item) {
        $sql_compra = "INSERT INTO compra (id_carrito, id_pago, numero_tarjeta, nombre_titular, codigo_seguridad, fecha_expiracion) VALUES (:id_carrito, :id_pago, :numero_tarjeta, :nombre_titular, :codigo_seguridad, :fecha_expiracion)";
        $stmt_compra = $pdo->prepare($sql_compra);
        $stmt_compra->execute([
            'id_carrito' => $item['id_producto'],
            'id_pago' => $id_pago,
            'numero_tarjeta' => $numero_tarjeta,
            'nombre_titular' => $nombre_titular,
            'codigo_seguridad' => $codigo_seguridad,
            'fecha_expiracion' => $fecha_expiracion
        ]);
    }

    // Limpiar el carrito después del pago
    $sql_limpiar_carrito = "DELETE FROM carrito WHERE id_usuario = :id_usuario";
    $stmt_limpiar_carrito = $pdo->prepare($sql_limpiar_carrito);
    $stmt_limpiar_carrito->execute(['id_usuario' => $_SESSION['usuario_id']]);

    header('Location: pedidos.php');
    exit;
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pago - Aitzaloa</title>
    <link href="estilos.css" REL=StyleSheet> 
</head>
<body>
    <h2>Pago</h2>
    <div class="contenedor-pago">
        <?php if (empty($carrito)): ?>
            <p>El carrito está vacío.</p>
        <?php else: ?>
            <?php foreach ($carrito as $producto): ?>
                <div class="producto-pago">
                    <div>
                        <h3><?php echo htmlspecialchars($producto['nombre']); ?></h3>
                        <p><?php echo htmlspecialchars($producto['descripcion']); ?></p>
                        <p>Precio: $<?php echo number_format($producto['precio'], 2); ?></p>
                        <p>Cantidad: <?php echo $producto['cantidad']; ?></p>
                    </div>
                </div>
            <?php endforeach; ?>
            <div class="formulario-pago">
                <h3>Información de pago</h3>
                <form method="post">
                    <label for="numero_tarjeta">Número de tarjeta:</label>
                    <input type="text" name="numero_tarjeta" required>
                    <label for="nombre_titular">Nombre del titular:</label>
                    <input type="text" name="nombre_titular" required>
                    <label for="codigo_seguridad">Código de seguridad (CVV):</label>
                    <input type="text" name="codigo_seguridad" required>
                    <label for="fecha_expiracion">Fecha de expiración (MM/AA):</label>
                    <input type="text" name="fecha_expiracion" required>
                    <button type="submit">Pagar</button>
                </form>
            </div>
        <?php endif; ?>
    </div>
</body>
</html>
