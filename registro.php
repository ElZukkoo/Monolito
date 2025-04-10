<?php
session_start();
include 'conexion.php';

// Habilitar la visualización de errores
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Verificar si el formulario fue enviado
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['nombre_usuario']) && isset($_POST['correo']) && isset($_POST['contraseña'])) {
        $nombre_usuario = $_POST['nombre_usuario'];
        $correo = $_POST['correo'];
        $contraseña = $_POST['contraseña'];
        $tipo_usuario = 'cliente'; // Establecer el tipo de usuario como cliente

        // Verificar si el correo ya existe
        try {
            $sql_check = "SELECT * FROM usuarios WHERE correo = :correo";
            $stmt_check = $pdo->prepare($sql_check);
            $stmt_check->bindParam(':correo', $correo);
            $stmt_check->execute();
            $usuario_existente = $stmt_check->fetch(PDO::FETCH_ASSOC);

            if ($usuario_existente) {
                echo "El correo ya está registrado.";
            } else {
                // Insertar el nuevo usuario en la base de datos
                try {
                    $sql_insert = "INSERT INTO usuarios (nombre_usuario, correo, contraseña, tipo_usuario) VALUES (:nombre_usuario, :correo, :contraseña, :tipo_usuario)";
                    $stmt_insert = $pdo->prepare($sql_insert);
                    $stmt_insert->bindParam(':nombre_usuario', $nombre_usuario);
                    $stmt_insert->bindParam(':correo', $correo);
                    $stmt_insert->bindParam(':contraseña', $contraseña); // Considera hashear la contraseña
                    $stmt_insert->bindParam(':tipo_usuario', $tipo_usuario);
                    $stmt_insert->execute();
                    echo "Registro exitoso.";
                    header("Location: login.php"); // Redirigir al usuario a la página de inicio de sesión
                    exit();
                } catch (PDOException $e) {
                    echo "Error al registrar el usuario: " . $e->getMessage();
                }
            }
        } catch (PDOException $e) {
            echo "Error al verificar el correo: " . $e->getMessage();
        }
    }
}
?>



<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Registro - Aitzaloa</title>
  <link href="estilos.css" rel="stylesheet">
</head>
<body class="page-registro">
  <div class="register-container">
    <h2 class="register-title">Registro</h2>
    <form action="registro.php" method="POST" class="register-form">
      <div class="form-group">
        <label for="nombre_usuario" class="form-label">Nombre de Usuario:</label>
        <input type="text" name="nombre_usuario" id="nombre_usuario" class="form-input" required>
      </div>
      <div class="form-group">
        <label for="correo" class="form-label">Correo:</label>
        <input type="email" name="correo" id="correo" class="form-input" required>
      </div>
      <div class="form-group">
        <label for="contraseña" class="form-label">Contraseña:</label>
        <input type="password" name="contraseña" id="contraseña" class="form-input" required>
      </div>
      <button type="submit" class="register-button">Registrarse</button>
    </form>
    <p class="register-footer">¿Ya tienes cuenta? <a href="login.php" class="register-link">Inicia sesión aquí</a></p>
  </div>
</body>
</html>
