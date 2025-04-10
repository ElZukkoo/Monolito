<?php
/*session_start();
include 'conexion.php';

// Habilitar la visualización de errores
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Verificar si el formulario fue enviado
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['correo']) && isset($_POST['contra'])) {
        $correo = $_POST['correo'];
        $contraseña = $_POST['contra'];

        // Buscar el usuario en la base de datos
        try {
            $sql = "SELECT * FROM usuarios WHERE correo = :correo";
            echo "Consulta SQL: " . $sql . "<br>";
            echo "Correo: " . $correo . "<br>";
            $stmt = $pdo->prepare($sql);
            $stmt->bindParam(':correo', $correo);
            $stmt->execute();
            $usuario = $stmt->fetch(PDO::FETCH_ASSOC);

            if (!$usuario) {
                echo "Usuario no encontrado con el correo: " . $correo;
            }

            if ($usuario && $contraseña === $usuario['contra']) { // Comparación de texto plano
                echo "Contraseña ingresada: " . $contraseña . "<br>";
                echo "Contraseña de la base de datos: " . $usuario['contra'] . "<br>";
                $_SESSION['usuario'] = $usuario['nombre_usuario'];
                $_SESSION['id_usuario'] = $usuario['id_usuarios'];
                var_dump($_SESSION); // Depuración: verificar la sesión
                echo "Sesión iniciada"; //depuracion, para ver si llega hasta aqui
                header('Location: index.php'); // Redirección
                exit();
            } else {
                echo "Correo o contraseña incorrectos.";
            }
        } catch (Exception $e) {
            echo "Error al realizar la consulta: " . $e->getMessage();
        }
    }
}*/
?>
<?php
include 'conexion.php';
session_start([
    'cookie_lifetime' => 86400, // 1 día
]);



if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['correo']) && isset($_POST['contra'])) {
        $correo = $_POST['correo'];
        $contraseña = $_POST['contra'];

        try {
            $sql = "SELECT * FROM usuarios WHERE correo = :correo";
            $stmt = $pdo->prepare($sql);
            $stmt->bindParam(':correo', $correo);
            $stmt->execute();
            $usuario = $stmt->fetch(PDO::FETCH_ASSOC);

            if ($usuario && $contraseña === $usuario['contra']) {
                $_SESSION['usuario'] = $usuario['nombre_usuario'];
                $_SESSION['id_usuario'] = $usuario['id_usuarios'];
                $message = "funciona.";
                echo "<script>alert('$message');</script>";
                header('Location: index.php');
                exit();
            } else {
                $_SESSION['error'] = "Correo o contraseña incorrectos.";
                header('Location: login.php');
                exit();
            }
        } catch (Exception $e) {
            $_SESSION['error'] = "Error al realizar la consulta.";
            header('Location: login.php');
            exit();
        }
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <<meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Perfil de Usuario</title>
    <link href="estilos.css" REL=StyleSheet>  
</head>
<body>
 
        <div class="page-login"> <!-- Contenedor específico -->
        <div class="login-container">
            <h2 class="login-title">Iniciar sesión</h2>
            <form action="login.php" method="POST" class="login-form">
            <div class="form-group">
                <label for="correo" class="form-label">Correo:</label>
                <input type="email" name="correo" id="correo" class="form-input" required>
            </div>
            
            <div class="form-group">
                <label for="contraseña" class="form-label">Contraseña:</label>
                <input type="password" name="contra" id="contraseña" class="form-input" required>
            </div>
            
            <button type="submit" class="login-button">Iniciar sesión</button>
            </form>
            <p class="login-footer">¿No tienes cuenta? <a onclick="cargarModulo('registro.php')">Regístrate aquí</a></p>
        </div>
    </div>
       

    <!-- Pie de página -->
    <footer>
        <p>&copy; 2025 Aitzaloa - Todos los derechos reservados</p>
    </footer>
</body>
</html>