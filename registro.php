<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Criar Conta</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body class="login-body">
    <div class="login-container">
        <h2>Criar Nova Conta</h2>
        
        <?php // Para exibir mensagens de erro que podem vir do script de ação ?>
        <?php if(isset($_GET['erro'])): ?>
            <p class="mensagem-erro"><?php echo htmlspecialchars($_GET['erro']); ?></p>
        <?php endif; ?>

        <form action="php/actions/registrar_action.php" method="POST">
            <div class="input-group">
                <label for="nome">Nome Completo</label>
                <input type="text" id="nome" name="nome" required>
            </div>
            <div class="input-group">
                <label for="email">Email</label>
                <input type="email" id="email" name="email" required>
            </div>
            <div class="input-group">
                <label for="senha">Senha</label>
                <input type="password" id="senha" name="senha" required>
            </div>
            <div class="input-group">
                <label for="confirma_senha">Confirme a Senha</label>
                <input type="password" id="confirma_senha" name="confirma_senha" required>
            </div>
            <button type="submit">Registrar</button>
        </form>
        <p class="link-footer">Já tem uma conta? <a href="login.php">Faça login</a></p>
    </div>
</body>
</html>