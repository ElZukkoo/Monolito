<?php
include 'conexion.php';
session_start();


// Verificar si el usuario ha iniciado sesión
if (!isset($_SESSION['id_usuario'])) {
    header('Location: login.php');
    exit;
}

$sql = "SELECT compra.*, productos.nombre, productos.descripcion, productos.precio, pago.estado_pago FROM compra JOIN carrito ON compra.id_carrito = carrito.id_producto JOIN productos ON carrito.id_producto = productos.id_producto JOIN pago ON compra.id_pago = pago.id_pago WHERE carrito.id_usuario = :id_usuario";
$stmt = $pdo->prepare($sql);
$stmt->execute(['id_usuario' => $_SESSION['id_usuario']]);
$pedidos = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Carrito de Compras - Aitzaloa</title>
    <link href="estilos.css" REL=StyleSheet>  
</head>
<body>
    <!-- Contenido principal con imagen de fondo -->
        <h2>Pedidos</h2>
    <div class="contenedor-pedidos">
        <?php if (empty($pedidos)): ?>
            <p>Aún no hay pedidos realizados.</p>
        <?php else: ?>
            <?php foreach ($pedidos as $pedido): ?>
                <div class="pedido">
                    <h3><?php echo htmlspecialchars($pedido['nombre']); ?></h3>
                    <p><?php echo htmlspecialchars($pedido['descripcion']); ?></p>
                    <p>Precio: $<?php echo number_format($pedido['precio'], 2); ?></p>
                    <p>Estado del pago: <?php echo htmlspecialchars($pedido['estado_pago']); ?></p>
                </div>
            <?php endforeach; ?>
        <?php endif; ?>
    </div>
    <!-- Pie de página -->
    <footer>
        <p>&copy; 2025 Aitzaloa - Todos los derechos reservados</p>
    </footer>
</body>
</html>