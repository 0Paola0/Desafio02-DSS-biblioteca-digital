<?php
require_once 'config/database.php';
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['btn_login'])) {
    
    $login = trim($_POST['login']);
    $password = $_POST['password'];
    
    if (empty($login) || empty($password)) {
        header('Location: login.php?error=1');
        exit();
    }
    
    // Buscar usuario
    $sql = "SELECT id, nombre_completo, password FROM usuarios 
            WHERE LOWER(username) = LOWER(:login) OR LOWER(email) = LOWER(:login)";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([':login' => $login]);
    $usuario = $stmt->fetch(PDO::FETCH_ASSOC);
    
    if ($usuario && password_verify($password, $usuario['password'])) {
        // Login exitoso
        $sql_update = "UPDATE usuarios SET ultimo_acceso = NOW() WHERE id = :id";
        $stmt_update = $pdo->prepare($sql_update);
        $stmt_update->execute([':id' => $usuario['id']]);
        
        $_SESSION['usuario_id'] = $usuario['id'];
        $_SESSION['nombre_completo'] = $usuario['nombre_completo'];
        
        header('Location: bienvenida.php');
        exit();
    } else {
        // Credenciales inválidas
        header('Location: login.php?error=1');
        exit();
    }
    
} else {
    header('Location: login.php');
    exit();
}
?>