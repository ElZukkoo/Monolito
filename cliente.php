<?php
session_start();
include 'conexion.php';

// Verificar que el usuario sea un cliente
if (!isset($_SESSION['usuario']) || $_SESSION['tipo_usuario'] != 'cliente') {
    header("Location: login.php");
    exit();
}

// Obtener información del cliente
$id_usuario = $_SESSION['id_usuario'];
$usuario = $pdo->query("SELECT * FROM usuarios WHERE id_usuario = $id_usuario")->fetch();

// Funcionalidad para actualizar el perfil
if (isset($_POST['update_profile'])) {
    $nombre_usuario = $_POST['nombre_usuario'];
    $correo = $_POST['correo'];
    $contraseña = password_hash($_POST['contraseña'], PASSWORD_DEFAULT); // Encriptar la contraseña

    $sql = "UPDATE usuarios SET nombre_usuario = :nombre_usuario, correo = :correo, contraseña = :contraseña WHERE id_usuario = :id_usuario";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':id_usuario', $id_usuario);
    $stmt->bindParam(':nombre_usuario', $nombre_usuario);
    $stmt->bindParam(':correo', $correo);
    $stmt->bindParam(':contraseña', $contraseña);
    $stmt->execute();
    header("Location: cliente.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>cliente- Aitzaloa</title>
    <link href="estilos.css" REL=StyleSheet> 
</head>
<body>
    <h1>Bienvenido, <?= $usuario['nombre_usuario'] ?></h1>
    <h2>Mi Perfil</h2>
    <form action="cliente.php" method="POST">
        <input type="text" name="nombre_usuario" value="<?= $usuario['nombre_usuario'] ?>" required>
        <input type="email" name="correo" value="<?= $usuario['correo'] ?>" required>
        <input type="password" name="contraseña" placeholder="Nueva Contraseña" required>
        <button type="submit" name="update_profile">Actualizar Perfil</button>
    </form>

    <h2>Productos Disponibles</h2>
    <!-- Aquí puedes agregar los productos que el cliente puede ver -->
</body>
</html>

