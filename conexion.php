<?php
$servidor = "localhost"; 
$usuario = "root"; 
$clave = "";
$baseDeDatos = "Compus";
try {
    $pdo = new PDO("mysql:host=$servidor;dbname=$baseDeDatos;charset=utf8", $usuario, $clave);
    // Establecer el modo de error de PDO para excepciones
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    echo "Error de conexión: " . $e->getMessage();
    exit();
}
?>
