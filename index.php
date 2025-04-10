<?php
include 'conexion.php';
session_start([
    'cookie_lifetime' => 86400, // 1 día
    'cookie_secure'   => true,  // Solo HTTPS
    'cookie_httponly' => true,  // No accesible por JS
    'use_strict_mode' => true   // Previene fixation
]);

?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Aitzaloa - Tu Tienda de Computadoras</title>
    <link rel="stylesheet" href="estilos.css">
</head>
<body>

    <!-- Header con logo y navegación -->
    <header>
        <div class="logo">
            Aitzaloa <span>eCommerce</span>
        </div>
        <nav>
            <a onclick="cargarModulo('inicio.php')">Inicio</a>
            <a onclick="cargarModulo('productos.php')">Productos</a>
            <a onclick="cargarModulo('carrito.php')">Carrito de Compras</a>
            <a onclick="cargarModulo('pedidos.php')">Pedidos</a>
            <a onclick="cargarModulo('perfil.php')">Perfil</a>
        </nav>
    </header>

    <!-- Contenido principal con imagen de fondo -->
    <main class="descripcion">
        <div id="overlay" class="overlay">
            <h2>Bienvenido a Aitzaloa</h2>
            <h2>Nosotros</h2>
            <p>En Aitzaloa, nos apasiona ofrecer computadoras de alta calidad que satisfacen las necesidades de cada usuario, ya sea para uso personal, profesional o empresarial. Nuestra misión es asegurarnos de que cada cliente encuentre la máquina perfecta, con la confianza de que está adquiriendo un producto confiable y respaldado por un excelente servicio.</p>
            <h2>Nuestra misión</h2>
            <p>Nuestra misión es brindar acceso a computadoras de última tecnología, asegurando un proceso de compra sencillo, seguro y transparente. Nos dedicamos a ofrecer productos que optimicen el rendimiento y la productividad de nuestros clientes, proporcionando atención personalizada para encontrar la mejor opción según sus necesidades y presupuesto.</p>
            <h2>Nuestra visión</h2>
            <p>Queremos ser la empresa líder en la venta de computadoras, destacándonos por nuestra calidad, seguridad y asesoría experta. Buscamos ser el aliado de nuestros clientes, ayudándoles a tomar decisiones inteligentes y seguras al elegir sus dispositivos, y establecernos como una marca confiable que, más allá de vender productos, mejora la experiencia tecnológica de todos.</p>
        </div>
    </main>

    <!-- Pie de página -->
    <footer>
        <p>&copy; 2025 Aitzaloa - Todos los derechos reservados</p>
    </footer>
<script>
    function cargarModulo(url) {
        var xhr = new XMLHttpRequest();
        xhr.open("GET", url, true);

        xhr.onreadystatechange = function () {
            if (xhr.readyState === 4 && xhr.status === 200) {
                document.getElementById("overlay").innerHTML = xhr.responseText;
            }
        };

        xhr.send();
    }
</script>


</body>
</html>
