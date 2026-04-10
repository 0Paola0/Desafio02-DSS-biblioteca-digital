<?php
require_once 'config/database.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['registro'])) {
    $nombre_completo = trim($_POST['nombre_completo']);
    $username = trim($_POST['username']);
    $email = trim($_POST['email']);
    $password = $_POST['password'];

    // Validaciones básicas
    if (empty($nombre_completo) || empty($username) || empty($email) || empty($password)) {
        header('Location: registro.php?error=campos_vacios');
        exit();
    }

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        header('Location: registro.php?error=email_invalido');
        exit();
    }

    // Verificar duplicados
    $sql_check = "SELECT id FROM usuarios WHERE username = :username OR email = :email";
    $stmt_check = $pdo->prepare($sql_check);
    $stmt_check->execute([':username' => $username, ':email' => $email]);
    
    if ($stmt_check->rowCount() > 0) {
        header('Location: registro.php?error=duplicado');
        exit();
    }

    // Encriptar contraseña
    $hash_password = password_hash($password, PASSWORD_DEFAULT);

    // Insertar nuevo usuario
    $sql = "INSERT INTO usuarios (nombre_completo, username, email, password) 
            VALUES (:nombre_completo, :username, :email, :password)";
    $stmt = $pdo->prepare($sql);
    
    try {
        $stmt->execute([
            ':nombre_completo' => $nombre_completo,
            ':username' => $username,
            ':email' => $email,
            ':password' => $hash_password
        ]);
        header('Location: login.php?registro=exitoso');
        exit();
    } catch (PDOException $e) {
        // Error inesperado de BD
        header('Location: registro.php?error=db_error');
        exit();
    }
} else {
    header('Location: registro.php');
    exit();
}
?>