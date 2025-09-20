<?php
// php/auth/login_action.php

// A linha mais importante que pode ter se perdido: inicia a sessão!
session_start();

require_once '../config/conexao.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_POST['email'] ?? '';
    $senha = $_POST['senha'] ?? '';

    if (empty($email) || empty($senha)) {
        header("Location: ../../login.php?erro=campos_vazios");
        exit();
    }

    try {
        $stmt = $pdo->prepare("SELECT id, email, senha_hash, role, status FROM usuarios WHERE email = ?");
        $stmt->execute([$email]);
        $usuario = $stmt->fetch(PDO::FETCH_ASSOC);

        // A verificação que sabemos que está dando 'true'
        if ($usuario && password_verify($senha, $usuario['senha_hash'])) {
            
            // Agora, com session_start() no topo, estas linhas vão funcionar:
            $_SESSION['usuario_id'] = $usuario['id'];
            $_SESSION['usuario_email'] = $usuario['email'];
            $_SESSION['usuario_role'] = $usuario['role'];

            if ($usuario['status'] === 'primeiro_acesso') {
                header("Location: ../../trocar_senha.php");
                exit();
            } else {
                // Redirecionamento para o dashboard
                header("Location: ../../dashboard.php");
                exit();
            }

        } else {
            header("Location: ../../login.php?erro=login_invalido");
            exit();
        }
    } catch (PDOException $e) {
        header("Location: ../../login.php?erro=db_error");
        exit();
    }
} else {
    header("Location: ../../login.php");
    exit();
}
?>