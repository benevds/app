<?php
session_start();
// Se o usuário não estiver logado, não pode estar aqui
if (!isset($_SESSION['usuario_id'])) {
    header("Location: login.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Crie sua Nova Senha - SíndicoPro</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body class="login-body">
    <div class="login-container">
        <h2>Bem-vindo(a)!</h2>
        <p>Por segurança, crie uma nova senha pessoal para o seu primeiro acesso.</p>
        <form action="php/actions/salvar_nova_senha.php" method="POST">
            <div class="input-group">
                <label for="nova_senha">Nova Senha</label>
                <input type="password" id="nova_senha" name="nova_senha" required>
            </div>
            <div class="input-group">
                <label for="confirma_senha">Confirme a Nova Senha</label>
                <input type="password" id="confirma_senha" name="confirma_senha" required>
            </div>
            <button type="submit">Salvar Senha e Entrar</button>
        </form>
    </div>
</body>
</html>