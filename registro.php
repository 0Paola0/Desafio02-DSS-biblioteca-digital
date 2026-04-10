<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Registro - Biblioteca Digital</title>
    <link rel="stylesheet" href="css/estilo.css">
</head>
<body>
    <div class="container">
        <h1>Registro de Lector</h1>
        
        <?php
        // Mostrar mensajes de error según el parámetro GET
        if (isset($_GET['error'])) {
            $error = $_GET['error'];
            $mensaje = '';
            switch ($error) {
                case 'campos_vacios':
                    $mensaje = 'Todos los campos son obligatorios.';
                    break;
                case 'email_invalido':
                    $mensaje = 'El correo electrónico no es válido.';
                    break;
                case 'duplicado':
                    $mensaje = 'El nombre de usuario o correo electrónico ya está registrado.';
                    break;
                case 'db_error':
                    $mensaje = 'Error en la base de datos. Inténtelo de nuevo más tarde.';
                    break;
                default:
                    $mensaje = 'Ha ocurrido un error.';
            }
            echo '<p class="error">' . htmlspecialchars($mensaje) . '</p>';
        }
        ?>
        
        <form action="guardar_usuario.php" method="POST">
            <label for="nombre_completo">Nombre completo:</label>
            <input type="text" name="nombre_completo" id="nombre_completo" required>

            <label for="username">Nombre de usuario:</label>
            <input type="text" name="username" id="username" required>

            <label for="email">Correo electrónico:</label>
            <input type="email" name="email" id="email" required>

            <label for="password">Contraseña:</label>
            <input type="password" name="password" id="password" required>

            <button type="submit" name="registro">Registrarse</button>
        </form>
        <p>¿Ya tienes cuenta? <a href="login.php">Inicia sesión</a></p>
    </div>
</body>
</html>