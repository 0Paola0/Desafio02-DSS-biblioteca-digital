<?php
session_start();
require_once 'config/database.php';

// Verificar autenticación
if (!isset($_SESSION['usuario_id'])) {
    header('Location: login.php');
    exit();
}

    $usuario_id = $_SESSION['usuario_id'];
    $nombre_completo = $_SESSION['nombre_completo'];

    // Obtener información de último acceso
    $sql_usuario = "SELECT ultimo_acceso FROM usuarios WHERE id = :id";
    $stmt_usuario = $pdo->prepare($sql_usuario);
    $stmt_usuario->execute([':id' => $usuario_id]);
    $ultimo_acceso = $stmt_usuario->fetchColumn();

    // Obtener lista de préstamos activos del usuario (libros que tiene prestados)
    $sql_prestamos = "SELECT p.id AS prestamo_id, l.titulo, l.autor, p.fecha_prestamo 
                  FROM prestamos p 
                  JOIN libros l ON p.libro_id = l.id 
                  WHERE p.usuario_id = :usuario_id AND p.fecha_devolucion IS NULL 
                  ORDER BY p.fecha_prestamo DESC";
    $stmt_prestamos = $pdo->prepare($sql_prestamos);
    $stmt_prestamos->execute([':usuario_id' => $usuario_id]);
    $prestamos = $stmt_prestamos->fetchAll(PDO::FETCH_ASSOC);

    // Obtener lista de todos los libros disponibles (catálogo)
    $sql_libros = "SELECT id, titulo, autor, anio_publicacion, genero 
               FROM libros 
               WHERE disponibilidad = TRUE 
               ORDER BY titulo";
    $stmt_libros = $pdo->prepare($sql_libros);
    $stmt_libros->execute();
    $libros_disponibles = $stmt_libros->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Panel del Lector - Biblioteca Digital</title>
    <link rel="stylesheet" href="css/estilo.css">
</head>
<body>
    <div class="container">
        <header>
            <h1>Biblioteca Digital</h1>
            <div class="user-info">
                <p>Bienvenido, <strong><?php echo htmlspecialchars($nombre_completo); ?></strong></p>
                <p>Último acceso: <?php echo $ultimo_acceso ? htmlspecialchars($ultimo_acceso) : 'Primera vez'; ?></p>
                <a href="logout.php" class="btn-logout">Cerrar Sesión</a>
            </div>
        </header>

        <section>
            <h2>Mis Libros Prestados</h2>
            <?php if (count($prestamos) > 0): ?>
                <table>
                    <thead>
                        <tr>
                            <th>Título</th>
                            <th>Autor</th>
                            <th>Fecha de Préstamo</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($prestamos as $p): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($p['titulo']); ?></td>
                            <td><?php echo htmlspecialchars($p['autor']); ?></td>
                            <td><?php echo htmlspecialchars($p['fecha_prestamo']); ?></td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            <?php else: ?>
                <p>No tienes libros prestados actualmente.</p>
            <?php endif; ?>
        </section>

        <section>
            <h2>Catálogo de Libros Disponibles</h2>
            <?php if (count($libros_disponibles) > 0): ?>
                <ul class="libros-lista">
                    <?php foreach ($libros_disponibles as $libro): ?>
                    <li>
                        <strong><?php echo htmlspecialchars($libro['titulo']); ?></strong><br>
                        <?php echo htmlspecialchars($libro['autor']); ?> 
                        (<?php echo $libro['anio_publicacion']; ?>) - 
                        <?php echo htmlspecialchars($libro['genero']); ?>
                    </li>
                    <?php endforeach; ?>
                </ul>
            <?php else: ?>
                <p>No hay libros disponibles en este momento.</p>
            <?php endif; ?>
        </section>
    </div>
</body>
</html>