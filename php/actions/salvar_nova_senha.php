<?php
// php/actions/salvar_nova_senha.php
session_start();
require_once '../config/conexao.php';

if (!isset($_SESSION['usuario_id'])) {
    header("Location: ../../login.php");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nova_senha = $_POST['nova_senha'];
    $confirma_senha = $_POST['confirma_senha'];
    $usuario_id = $_SESSION['usuario_id'];

    if (empty($nova_senha) || $nova_senha !== $confirma_senha) {
        // Idealmente, redirecionar com uma mensagem de erro
        die("Erro: As senhas não coincidem ou estão vazias.");
    }

    $nova_senha_hash = password_hash($nova_senha, PASSWORD_DEFAULT);

    try {
        // Atualiza a senha e o status do usuário para 'ativo'
        $sql = "UPDATE usuarios SET senha_hash = ?, status = 'ativo' WHERE id = ?";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$nova_senha_hash, $usuario_id]);

        // Redireciona para o dashboard, agora com acesso total
        header("Location: ../../dashboard.php");
        exit();
        
    } catch (PDOException $e) {
        die("Erro ao atualizar a senha: " . $e->getMessage());
    }
}
?>