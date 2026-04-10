<?php session_start(); ?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Iniciar Sesión - Biblioteca Digital</title>
    <link rel="stylesheet" href="css/estilo.css">
</head>
<body>
    <div class="container">
        <h1>Iniciar Sesión</h1>
        <?php if (isset($_GET['registro']) && $_GET['registro'] === 'exitoso'): ?>
            <p class="exito">¡Registro exitoso! Ahora puedes iniciar sesión.</p>
        <?php endif; ?>
        <?php if (isset($_GET['error'])): ?>
            <p class="error">Usuario o contraseña incorrectos.</p>
        <?php endif; ?>
        <form action="autenticar.php" method="POST">
            <label for="login">Usuario o correo electrónico:</label>
            <input type="text" name="login" id="login" required>

            <label for="password">Contraseña:</label>
            <input type="password" name="password" id="password" required>

            <button type="submit" name="btn_login">Ingresar</button>
        </form>
        <p>¿No tienes cuenta? <a href="registro.php">Regístrate aquí</a></p>
    </div>
</body>
</html>