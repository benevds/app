<?php
require_once 'php/config/conexao.php';
// require_once 'php/config/proteger.php'; // Manter comentado para testes

// --- CÁLCULOS PARA OS CARDS DE RESUMO ---
$mes_atual = date('Y-m');

// Total Recebido no Mês
$stmt_receitas = $pdo->prepare("SELECT SUM(valor_pago) as total FROM pagamentos WHERE mes_referencia = ?");
$stmt_receitas->execute([$mes_atual]);
$total_recebido = $stmt_receitas->fetchColumn() ?: 0;

// Inadimplentes (Contagem de apartamentos que deveriam pagar e não pagaram no mês)
// Lógica: Conta apartamentos com morador que não têm registro de pagamento no mês atual
$stmt_inadimplentes = $pdo->prepare("
    SELECT COUNT(a.id) 
    FROM apartamentos a 
    WHERE a.usuario_id IS NOT NULL 
    AND NOT EXISTS (
        SELECT 1 FROM pagamentos p 
        WHERE p.apartamento_id = a.id AND p.mes_referencia = ?
    )
");
$stmt_inadimplentes->execute([$mes_atual]);
$total_inadimplentes = $stmt_inadimplentes->fetchColumn() ?: 0;

// Manutenções Pendentes
$stmt_tarefas = $pdo->prepare("SELECT COUNT(*) FROM tarefas WHERE status = 'pendente'");
$stmt_tarefas->execute();
$total_tarefas_pendentes = $stmt_tarefas->fetchColumn() ?: 0;

// Busca os 3 avisos mais recentes
$stmt_avisos = $pdo->query("SELECT * FROM avisos ORDER BY data_publicacao DESC LIMIT 3");
$avisos_recentes = $stmt_avisos->fetchAll(PDO::FETCH_ASSOC);

?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - SíndicoPro</title>
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
                <li class="active"><a href="dashboard.php"><i class="fas fa-tachometer-alt"></i><span>Dashboard</span></a></li>
                <li><a href="apartamentos.php"><i class="fas fa-building"></i><span>Apartamentos</span></a></li>
                <li><a href="moradores.php"><i class="fas fa-users"></i><span>Moradores</span></a></li>
                <li><a href="financas.php"><i class="fas fa-hand-holding-usd"></i><span>Financeiro</span></a></li>
                <li><a href="manutencao.php"><i class="fas fa-tools"></i><span>Manutenção</span></a></li>
                <li><a href="avisos.php"><i class="fas fa-bullhorn"></i><span>Avisos</span></a></li>
            </ul>
            <div class="sidebar-footer">
                <a href="php/auth/logout.php"><i class="fas fa-sign-out-alt"></i><span>Sair</span></a>
            </div>
        </aside>

        <main class="main-content">
            <header class="main-header">
                <h1>Dashboard</h1>
                <div class="user-info">
                    <span>Olá, Síndico!</span>
                </div>
            </header>

            <div class="cards-container">
                <div class="card">
                    <div class="card-icon" style="background-color: #e8dff5;">
                        <i class="fas fa-dollar-sign" style="color: var(--cor-principal);"></i>
                    </div>
                    <div class="card-info">
                        <h4>Recebido (Mês)</h4>
                        <p>R$ <?php echo number_format($total_recebido, 2, ',', '.'); ?></p>
                    </div>
                </div>
                <div class="card">
                    <div class="card-icon" style="background-color: #f5dfe2;">
                        <i class="fas fa-user-clock" style="color: #c0392b;"></i>
                    </div>
                    <div class="card-info">
                        <h4>Inadimplentes</h4>
                        <p><?php echo $total_inadimplentes; ?> Apartamento(s)</p>
                    </div>
                </div>
                <div class="card">
                     <div class="card-icon" style="background-color: #dff5e8;">
                        <i class="fas fa-tools" style="color: #27ae60;"></i>
                    </div>
                    <div class="card-info">
                        <h4>Manutenções</h4>
                        <p><?php echo $total_tarefas_pendentes; ?> Pendente(s)</p>
                    </div>
                </div>
            </div>

            <div class="content-box">
                <h2>Avisos Recentes</h2>
                <?php if (empty($avisos_recentes)): ?>
                    <p>Nenhum aviso publicado.</p>
                <?php else: ?>
                    <ul class="lista-simples">
                        <?php foreach($avisos_recentes as $aviso): ?>
                            <li>
                                <strong><?php echo htmlspecialchars($aviso['titulo']); ?></strong>
                                <small><?php echo date('d/m/Y', strtotime($aviso['data_publicacao'])); ?></small>
                            </li>
                        <?php endforeach; ?>
                    </ul>
                    <a href="avisos.php" class="link-ver-todos">Ver todos os avisos &rarr;</a>
                <?php endif; ?>
            </div>
        </main>
    </div>
</body>
</html>