<?php
include 'conexion.php';
session_start();
 // Asegúrate de que este archivo contiene la conexión a tu base de datos

// Verificar si el usuario ha iniciado sesión
if (!isset($_SESSION['id_usuario'])) {
    header('Location: login.php');
    exit;
}
// Obtener la información del usuario de la base de datos
try {
    $sql = "SELECT nombre_usuario, correo, contraseña FROM usuarios WHERE id_usuarios = :id_usuario";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':id_usuario', $_SESSION['id_usuario']);
    $stmt->execute();
    $usuario = $stmt->fetch(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    echo "Error al obtener la información del usuario: " . $e->getMessage();
    exit;
}

// Procesar la actualización del perfil si se envía el formulario
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['actualizar_perfil'])) {
    $nombre_usuario = $_POST['nombre_usuario'];
    $correo = $_POST['correo'];
    $contraseña = $_POST['contraseña']; // Considera hashear la contraseña

    try {
        $sql = "UPDATE usuarios SET nombre_usuario = :nombre_usuario, correo = :correo, contraseña = :contraseña WHERE id_usuarios = :id_usuario";
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':nombre_usuario', $nombre_usuario);
        $stmt->bindParam(':correo', $correo);
        $stmt->bindParam(':contraseña', $contraseña); // Considera hashear la contraseña
        $stmt->bindParam(':id_usuario', $_SESSION['id_usuario']);
        $stmt->execute();
        echo "Perfil actualizado con éxito.";
    } catch (PDOException $e) {
        echo "Error al actualizar el perfil: " . $e->getMessage();
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Perfil de Usuario</title>
    <link href="estilos.css" REL=StyleSheet> 
</head>
<body>

    <!-- Contenido principal con imagen de fondo -->
        <h2>Perfil de Usuario</h2>
    <form method="post" action="">
        <label for="nombre_usuario">Nombre de Usuario:</label><br>
        <input type="text" name="nombre_usuario" value="<?php echo $usuario['nombre_usuario']; ?>"><br><br>

        <label for="correo">Correo:</label><br>
        <input type="email" name="correo" value="<?php echo $usuario['correo']; ?>"><br><br>

        <label for="contraseña">Contraseña:</label><br>
        <input type="password" name="contraseña" value="<?php echo $usuario['contraseña']; ?>"><br><br>

        <input type="submit" name="actualizar_perfil" value="Actualizar Perfil">
    </form>

    <a href="logout.php">Cerrar Sesión</a>
        

    <!-- Pie de página -->
    <footer>
        <p>&copy; 2025 Aitzaloa - Todos los derechos reservados</p>
    </footer>
</body>
</html>