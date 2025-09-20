<?php
// php/actions/cadastrar_morador.php

require_once '../config/conexao.php';
// require_once '../config/proteger.php';

// Apenas síndicos podem cadastrar
// if ($_SESSION['usuario_role'] !== 'sindico') {
//     die("Acesso negado.");
// }

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_POST['email'];
    $senha_temporaria = $_POST['senha_temporaria'];
    $apartamento_id = $_POST['apartamento_id'];

    if (empty($email) || empty($senha_temporaria) || empty($apartamento_id)) {
        die("Erro: preencha todos os campos.");
    }

    $senha_hash = password_hash($senha_temporaria, PASSWORD_DEFAULT);
    
    try {
        // Inicia uma transação para garantir que ambas as operações funcionem
        $pdo->beginTransaction();

        // 1. Insere o novo usuário com status 'primeiro_acesso'
        $sql_user = "INSERT INTO usuarios (email, senha_hash, role, status) VALUES (?, ?, 'morador', 'primeiro_acesso')";
        $stmt_user = $pdo->prepare($sql_user);
        $stmt_user->execute([$email, $senha_hash]);
        $novo_usuario_id = $pdo->lastInsertId();

        // 2. Atualiza a tabela de apartamentos para ligar o novo usuário a ele
        $sql_ap = "UPDATE apartamentos SET usuario_id = ? WHERE id = ?";
        $stmt_ap = $pdo->prepare($sql_ap);
        $stmt_ap->execute([$novo_usuario_id, $apartamento_id]);

        // Se tudo deu certo, confirma as alterações
        $pdo->commit();

        header("Location: ../../moradores.php?sucesso=1");
        exit();

    } catch (PDOException $e) {
        // Se algo der errado, desfaz tudo
        $pdo->rollBack();
        die("Erro ao cadastrar morador: " . $e->getMessage());
    }
}
?>