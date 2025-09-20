<?php 
require_once 'php/config/conexao.php';
// require_once 'php/config/proteger.php'; // Vamos manter comentado por enquanto

// Busca todos os apartamentos no banco para listar
try {
    $stmt = $pdo->query("SELECT * FROM apartamentos ORDER BY andar, numero_ap");
    $apartamentos = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    die("Erro ao buscar apartamentos: " . $e->getMessage());
}
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestão de Apartamentos - SíndicoPro</title>
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
</head>
<body>
    <div class="app-container">
        <aside class="sidebar">
            <div class="sidebar-header">
                <h3>SíndicoPro</h3>
            </div>
            <ul class="menu">
                <li><a href="dashboard.php"><i class="fas fa-tachometer-alt"></i><span>Dashboard</span></a></li>
                <li class="active"><a href="apartamentos.php"><i class="fas fa-building"></i><span>Apartamentos</span></a></li>
                <li><a href="financas.php"><i class="fas fa-hand-holding-usd"></i><span>Financeiro</span></a></li>
                <li><a href="#"><i class="fas fa-tools"></i><span>Manutenção</span></a></li>
                <li><a href="#"><i class="fas fa-bullhorn"></i><span>Avisos</span></a></li>
                <li class=""><a href="moradores.php"><i class="fas fa-users"></i><span>Moradores</span></a></li>
            </ul>
            <div class="sidebar-footer">
                <a href="php/auth/logout.php"><i class="fas fa-sign-out-alt"></i><span>Sair</span></a>
            </div>
        </aside>

        <main class="main-content">
            <header class="main-header">
                <h1>Gestão de Apartamentos</h1>
            </header>

            <div class="content-box form-section">
                <h2>Adicionar Novo Apartamento</h2>
                <form action="php/actions/cadastrar_apartamento.php" method="POST">
                    <div class="form-grid">
                        <div class="input-group">
                            <label for="numero_ap">Número do AP</label>
                            <input type="number" id="numero_ap" name="numero_ap" required>
                        </div>
                        <div class="input-group">
                            <label for="andar">Andar</label>
                            <input type="number" id="andar" name="andar" required>
                        </div>
                        <div class="input-group">
                            <label for="tipo">Tipo</label>
                            <select id="tipo" name="tipo" required>
                                <option value="padrão">Padrão (R$ 800)</option>
                                <option value="varanda">Com Varanda (R$ 900)</option>
                            </select>
                        </div>
                         <div class="input-group">
                            <label for="valor_aluguel">Valor do Aluguel</label>
                            <input type="text" id="valor_aluguel" name="valor_aluguel" required>
                        </div>
                        <div class="input-group">
                            <label for="morador_nome">Nome do Morador</label>
                            <input type="text" id="morador_nome" name="morador_nome">
                        </div>
                        <div class="input-group">
                            <label for="morador_contato">Contato</label>
                            <input type="text" id="morador_contato" name="morador_contato">
                        </div>
                    </div>
                    <button type="submit">Adicionar Apartamento</button>
                </form>
            </div>

            <div class="content-box">
                <h2>Apartamentos Cadastrados</h2>
                <table class="data-table">
                    <thead>
                        <tr>
                            <th>AP</th>
                            <th>Andar</th>
                            <th>Tipo</th>
                            <th>Aluguel</th>
                            <th>Morador</th>
                            <th>Ações</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($apartamentos as $ap): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($ap['numero_ap']); ?></td>
                            <td><?php echo htmlspecialchars($ap['andar']); ?>º</td>
                            <td><?php echo htmlspecialchars(ucfirst($ap['tipo'])); ?></td>
                            <td>R$ <?php echo number_format($ap['valor_aluguel'], 2, ',', '.'); ?></td>
                            <td><?php echo htmlspecialchars($ap['morador_nome'] ?? 'Vago'); ?></td>
                            <td class="actions">
                                <a href="#" title="Editar"><i class="fas fa-edit"></i></a>
                                <a href="#" title="Excluir"><i class="fas fa-trash-alt"></i></a>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                        <?php if (empty($apartamentos)): ?>
                            <tr>
                                <td colspan="6">Nenhum apartamento cadastrado ainda.</td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </main>
    </div>
</body>
</html>