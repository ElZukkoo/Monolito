<?php

session_start();
include 'conexion.php';

// Verificar si el usuario ha iniciado sesión
if (!isset($_SESSION['id_usuario'])) {
    header('Location: login.php');
    exit;
}

if (isset($_GET['id_producto'])) {
    $id_producto = $_GET['id_producto'];
    $sql = "INSERT INTO carrito (id_usuario, id_producto, cantidad) VALUES (:id_usuario, :id_producto, 1)";
    $stmt = $pdo->prepare($sql);
    $stmt->execute(['id_usuario' => $_SESSION['id_usuario'], 'id_producto' => $id_producto]);
}

if (isset($_GET['eliminar_producto'])) {
    $id_producto = $_GET['eliminar_producto'];
    $sql = "DELETE FROM carrito WHERE id_usuario = :id_usuario AND id_producto = :id_producto";
    $stmt = $pdo->prepare($sql);
    $stmt->execute(['id_usuario' => $_SESSION['id_usuario'], 'id_producto' => $id_producto]);
}

$sql = "SELECT productos.*, carrito.cantidad FROM carrito JOIN productos ON carrito.id_producto = productos.id_producto WHERE carrito.id_usuario = :id_usuario";
$stmt = $pdo->prepare($sql);
$stmt->execute(['id_usuario' => $_SESSION['id_usuario']]);
$carrito = $stmt->fetchAll(PDO::FETCH_ASSOC);
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


        <h2>Carrito de Compras</h2>
    <div class="contenedor-carrito">
        <?php if (empty($carrito)): ?>
            <p>El carrito está vacío.</p>
        <?php else: ?>
            <?php foreach ($carrito as $producto): ?>
                <div class="producto-carrito">
                    <div style="display: flex; align-items: center;">
                        <img src="<?php echo htmlspecialchars($producto['imagen']); ?>" alt="<?php echo htmlspecialchars($producto['nombre']); ?>" class="imagen-producto">
                        <div>
                            <h3><?php echo htmlspecialchars($producto['nombre']); ?></h3>
                            <p><?php echo htmlspecialchars($producto['descripcion']); ?></p>
                            <p>Precio: $<?php echo number_format($producto['precio'], 2); ?></p>
                            <p>Cantidad: <?php echo $producto['cantidad']; ?></p>
                        </div>
                    </div>
                    <a class="boton" href="carrito.php?eliminar_producto=<?php echo $producto['id_producto']; ?>">Eliminar</a>
                </div>
            <?php endforeach; ?>
            <a class="boton" href="pago.php">Realizar pago</a>
        <?php endif; ?>
    </div>
       
</body>
</html>
