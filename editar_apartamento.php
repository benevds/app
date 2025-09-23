<?php
require_once 'php/config/conexao.php';

// Pega o ID do apartamento da URL
$id = $_GET['id'] ?? null;
if (!$id) {
    die("ID do apartamento não fornecido.");
}

// Busca os dados do apartamento específico no banco
try {
    $stmt = $pdo->prepare("SELECT * FROM apartamentos WHERE id = ?");
    $stmt->execute([$id]);
    $apartamento = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$apartamento) {
        die("Apartamento não encontrado.");
    }
} catch (PDOException $e) {
    die("Erro ao buscar dados do apartamento: " . $e->getMessage());
}
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Editar Apartamento - SíndicoPro</title>
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
</head>
<body>
    <div class="app-container">
        <aside class="sidebar">
            <div class="sidebar-header"><h3>SíndicoPro</h3></div>
            <ul class="menu">
                 <li><a href="dashboard.php"><i class="fas fa-tachometer-alt"></i><span>Dashboard</span></a></li>
                <li class="active"><a href="apartamentos.php"><i class="fas fa-building"></i><span>Apartamentos</span></a></li>
                </ul>
        </aside>

        <main class="main-content">
            <header class="main-header">
                <h1>Editar Apartamento Nº <?php echo htmlspecialchars($apartamento['numero_ap']); ?></h1>
            </header>

            <div class="content-box form-section">
                <form action="php/actions/atualizar_apartamento.php" method="POST">
                    <input type="hidden" name="id" value="<?php echo $apartamento['id']; ?>">

                    <div class="form-grid">
                        <div class="input-group">
                            <label for="numero_ap">Número do AP</label>
                            <input type="number" id="numero_ap" name="numero_ap" value="<?php echo htmlspecialchars($apartamento['numero_ap']); ?>" required>
                        </div>
                        <div class="input-group">
                            <label for="andar">Andar</label>
                            <input type="number" id="andar" name="andar" value="<?php echo htmlspecialchars($apartamento['andar']); ?>" required>
                        </div>
                        <div class="input-group">
                            <label for="tipo">Tipo</label>
                            <select id="tipo" name="tipo" required>
                                <option value="padrão" <?php echo $apartamento['tipo'] == 'padrão' ? 'selected' : ''; ?>>Padrão (R$ 800)</option>
                                <option value="varanda" <?php echo $apartamento['tipo'] == 'varanda' ? 'selected' : ''; ?>>Com Varanda (R$ 900)</option>
                            </select>
                        </div>
                         <div class="input-group">
                            <label for="valor_aluguel">Valor do Aluguel</label>
                            <input type="text" id="valor_aluguel" name="valor_aluguel" value="<?php echo htmlspecialchars($apartamento['valor_aluguel']); ?>" required>
                        </div>
                        <div class="input-group">
                            <label for="morador_nome">Nome do Morador</label>
                            <input type="text" id="morador_nome" name="morador_nome" value="<?php echo htmlspecialchars($apartamento['morador_nome']); ?>">
                        </div>
                        <div class="input-group">
                            <label for="morador_contato">Contato</label>
                            <input type="text" id="morador_contato" name="morador_contato" value="<?php echo htmlspecialchars($apartamento['morador_contato']); ?>">
                        </div>
                    </div>
                    <button type="submit">Salvar Alterações</button>
                    <a href="apartamentos.php" class="button-cancel">Cancelar</a>
                </form>
            </div>
        </main>
    </div>
</body>
</html>