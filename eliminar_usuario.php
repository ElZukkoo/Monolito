<?php
session_start();
include 'conexion.php';

if ($_SESSION['tipo_usuario'] != 'administrador') {
    header("Location: login.php");
    exit();
}

if (isset($_GET['id_usuario'])) {
    $id_usuario = $_GET['id_usuario'];

    // Eliminar usuario
    $sql = "DELETE FROM usuarios WHERE id_usuario = :id_usuario";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':id_usuario', $id_usuario);
    $stmt->execute();

    header("Location: admin.php");
    exit();
}
?>
