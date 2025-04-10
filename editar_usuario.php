<?php
session_start();
include 'conexion.php';

if ($_SESSION['tipo_usuario'] != 'administrador') {
    header("Location: login.php");
    exit();
}

if (isset($_GET['id_usuario'])) {
    $id_usuario = $_GET['id_usuario'];

    // Obtener usuario para editar
    $sql = "SELECT * FROM usuarios WHERE id_usuario = :id_usuario";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':id_usuario', $id_usuario);
    $stmt->execute();
    $usuario = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $nombre_usuario = $_POST['nombre_usuario'];
        $correo = $_POST['correo'];
        $contraseña = password_hash($_POST['contraseña'], PASSWORD_DEFAULT);

        $sql = "UPDATE usuarios SET nombre_usuario = :nombre_usuario, correo = :correo, contraseña = :contraseña WHERE id_usuario = :id_usuario";
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':id_usuario', $id_usuario);
        $stmt->bindParam(':nombre_usuario', $nombre_usuario);
        $stmt->bindParam(':correo', $correo);
        $stmt->bindParam(':contraseña', $contraseña);
        $stmt->execute();

        header("Location: admin.php");
        exit();
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Usuario - Aitzaloa</title>
    <link rel="stylesheet" href="css/estilos.css">
</head>
<body>
    <header>
        <h1>Editar Usuario</h1>
    </header>

    <div class="content">
        <form action="editar_usuario.php?id_usuario=<?= $usuario['id_usuario'] ?>" method="POST">
            <label for="nombre_usuario">Nombre de Usuario</label>
            <input type="text" name="nombre_usuario" value="<?= $usuario['nombre_usuario'] ?>" required>

            <label for="correo">Correo</label>
            <input type="email" name="correo" value="<?= $usuario['correo'] ?>" required>

            <label for="contraseña">Contraseña</label>
            <input type="password" name="contraseña" required>

            <button type="submit">Guardar Cambios</button>
        </form>
    </div>
</body>
</html>
