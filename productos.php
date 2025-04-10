
<?php
session_start([
    'cookie_lifetime' => 86400, // 1 día
    'cookie_secure'   => true,  // Solo HTTPS
    'cookie_httponly' => true,  // No accesible por JS
    'use_strict_mode' => true   // Previene fixation
]);
include 'conexion.php';

$sql = "SELECT * FROM productos";
$stmt = $pdo->query($sql);
$productos = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>



<!DOCTYPE html>
<html lang="es">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Productos - Aitzaloa</title>
        <link href="estilos.css" REL=StyleSheet> 
    </head>
    <body>

        <!-- Contenido principal con imagen de fondo -->
      
            <h2>Productos</h2>
                <div class="contenedor-productos">
                    <?php foreach ($productos as $producto): ?>
                        <div class="tarjeta">
                            <img src="<?php echo htmlspecialchars($producto['imagen']); ?>" alt="<?php echo htmlspecialchars($producto['nombre']); ?>" class="imagen-producto">
                            <h3><?php echo htmlspecialchars($producto['nombre']); ?></h3>
                            <p><?php echo htmlspecialchars($producto['descripcion']); ?></p>
                            <p><strong>Precio: $<?php echo number_format($producto['precio'], 2); ?></strong></p>
                            <a class="boton" href="carrito.php?id_producto=<?php echo $producto['id_producto']; ?>">Añadir al carrito</a>
                        </div>
                    <?php endforeach; ?>
                </div>
           

    </body>
</html>
