<?php
require_once 'php/config/conexao.php';
// require_once 'php/config/proteger.php';

// Busca todas as tarefas, juntando com os dados do apartamento se houver
$sql = "SELECT t.*, a.numero_ap, a.andar
        FROM tarefas t
        LEFT JOIN apartamentos a ON t.apartamento_id = a.id
        ORDER BY FIELD(t.status, 'pendente', 'em_andamento', 'concluida'), t.data_criacao DESC";
$stmt_tarefas = $pdo->query($sql);
$tarefas = $stmt_tarefas->fetchAll(PDO::FETCH_ASSOC);

// Busca apartamentos para o formulário
$stmt_aps = $pdo->query("SELECT id, numero_ap, andar FROM apartamentos ORDER BY numero_ap");
$apartamentos = $stmt_aps->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manutenção e Tarefas - SíndicoPro</title>
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
</head>
<body>
    <div class="app-container">
        <aside class="sidebar">
            <div class="sidebar-header"><h3>SíndicoPro</h3></div>
            <ul class="menu">
                <li><a href="dashboard.php"><i class="fas fa-tachometer-alt"></i><span>Dashboard</span></a></li>
                <li><a href="apartamentos.php"><i class="fas fa-building"></i><span>Apartamentos</span></a></li>
                <li><a href="moradores.php"><i class="fas fa-users"></i><span>Moradores</span></a></li>
                <li><a href="financas.php"><i class="fas fa-hand-holding-usd"></i><span>Financeiro</span></a></li>
                <li class="active"><a href="manutencao.php"><i class="fas fa-tools"></i><span>Manutenção</span></a></li>
                <li><a href="avisos.php"><i class="fas fa-bullhorn"></i><span>Avisos</span></a></li>
            </ul>
            <div class="sidebar-footer"><a href="php/auth/logout.php"><i class="fas fa-sign-out-alt"></i><span>Sair</span></a></div>
        </aside>

        <main class="main-content">
            <header class="main-header"><h1>Manutenção e Tarefas</h1></header>

            <div class="content-box form-section">
                <h2>Adicionar Nova Tarefa</h2>
                <form action="php/actions/adicionar_tarefa.php" method="POST">
                    <div class="input-group">
                        <label for="titulo">Título da Tarefa</label>
                        <input type="text" id="titulo" name="titulo" required placeholder="Ex: Consertar vazamento na garagem">
                    </div>
                    <div class="form-grid">
                        <div class="input-group">
                            <label for="apartamento_id">Associar a um Apartamento (Opcional)</label>
                            <select id="apartamento_id" name="apartamento_id">
                                <option value="">Nenhum (tarefa geral do condomínio)</option>
                                <?php foreach ($apartamentos as $ap): ?>
                                    <option value="<?php echo $ap['id']; ?>">
                                        AP <?php echo $ap['numero_ap']; ?> (Andar <?php echo $ap['andar']; ?>)
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    </div>
                    <button type="submit">Adicionar Tarefa</button>
                </form>
            </div>

            <div class="tasks-container">
                <?php if (empty($tarefas)): ?>
                    <div class="content-box"><p>Nenhuma tarefa registrada. Adicione uma acima!</p></div>
                <?php else: ?>
                    <?php foreach ($tarefas as $tarefa): ?>
                        <div class="task-card status-<?php echo $tarefa['status']; ?>">
                            <div class="task-info">
                                <h3><?php echo htmlspecialchars($tarefa['titulo']); ?></h3>
                                <p class="task-meta">
                                    Criado em: <?php echo date('d/m/Y', strtotime($tarefa['data_criacao'])); ?>
                                    <?php if ($tarefa['numero_ap']): ?>
                                        | <i class="fas fa-building"></i> AP <?php echo $tarefa['numero_ap']; ?>
                                    <?php endif; ?>
                                </p>
                            </div>
                            <div class="task-status">
                                <form action="php/actions/atualizar_status_tarefa.php" method="POST">
                                    <input type="hidden" name="tarefa_id" value="<?php echo $tarefa['id']; ?>">
                                    <select name="novo_status" class="status-select" onchange="this.form.submit()">
                                        <option value="pendente" <?php echo $tarefa['status'] == 'pendente' ? 'selected' : ''; ?>>Pendente</option>
                                        <option value="em_andamento" <?php echo $tarefa['status'] == 'em_andamento' ? 'selected' : ''; ?>>Em Andamento</option>
                                        <option value="concluida" <?php echo $tarefa['status'] == 'concluida' ? 'selected' : ''; ?>>Concluída</option>
                                    </select>
                                </form>
                            </div>
                        </div>
                    <?php endforeach; ?>
                <?php endif; ?>
            </div>
        </main>
    </div>
</body>
</html>