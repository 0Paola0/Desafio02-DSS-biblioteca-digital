<?php
session_start();
if (isset($_SESSION['usuario_id'])) {
    header('Location: bienvenida.php');
    exit();
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Biblioteca Digital</title>
    <link rel="stylesheet" href="css/estilo.css">
</head>
<body>
    <div class="container">
        <h1>Biblioteca Digital</h1>
        <p>Bienvenido a la biblioteca digital. Por favor, inicia sesión o regístrate para acceder a tu perfil.</p>
        <div class="botones">
            <a href="login.php" class="btn">Iniciar Sesión</a>
            <a href="registro.php" class="btn">Registrarse</a>
        </div>
    </div>
</body>
</html>