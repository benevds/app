<?php
// php/actions/registrar_action.php
require_once '../config/conexao.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nome = trim($_POST['nome']);
    $email = trim($_POST['email']);
    $senha = $_POST['senha'];
    $confirma_senha = $_POST['confirma_senha'];

    // --- VALIDAÇÕES ---
    if (empty($nome) || empty($email) || empty($senha)) {
        header("Location: ../../registro.php?erro=Por favor, preencha todos os campos.");
        exit();
    }

    if ($senha !== $confirma_senha) {
        header("Location: ../../registro.php?erro=As senhas não coincidem.");
        exit();
    }

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        header("Location: ../../registro.php?erro=O email fornecido não é válido.");
        exit();
    }

    // Verifica se o email já está cadastrado
    try {
        $stmt = $pdo->prepare("SELECT id FROM usuarios WHERE email = ?");
        $stmt->execute([$email]);
        if ($stmt->fetch()) {
            header("Location: ../../registro.php?erro=Este email já está em uso.");
            exit();
        }
    } catch (PDOException $e) {
        die("Erro ao verificar email: " . $e->getMessage());
    }

    // --- SE TUDO ESTIVER OK, PROSSEGUE ---

    // Criptografa a senha
    $senha_hash = password_hash($senha, PASSWORD_DEFAULT);

    // Insere o novo usuário no banco
    try {
        $stmt = $pdo->prepare("INSERT INTO usuarios (nome, email, senha_hash) VALUES (?, ?, ?)");
        $stmt->execute([$nome, $email, $senha_hash]);
        
        // Redireciona para a página de login com mensagem de sucesso
        header("Location: ../../login.php?sucesso=registrado");
        exit();
    } catch (PDOException $e) {
        die("Erro ao registrar o usuário: " . $e->getMessage());
    }
} else {
    // Se alguém tentar acessar o arquivo diretamente, redireciona
    header("Location: ../../registro.php");
    exit();
}
?>