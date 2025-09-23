<?php
require_once 'php/config/conexao.php';
// require_once 'php/config/proteger.php';

// --- CÁLCULOS PARA OS CARDS DE RESUMO ---
$mes_atual = date('Y-m');

// Total Recebido no Mês
$stmt_receitas = $pdo->prepare("SELECT SUM(valor_pago) as total FROM pagamentos WHERE mes_referencia = ?");
$stmt_receitas->execute([$mes_atual]);
$total_recebido = $stmt_receitas->fetchColumn() ?: 0;

// Total de Despesas no Mês
$stmt_despesas = $pdo->prepare("SELECT SUM(valor) as total FROM despesas WHERE DATE_FORMAT(data_despesa, '%Y-%m') = ?");
$stmt_despesas->execute([$mes_atual]);
$total_despesas = $stmt_despesas->fetchColumn() ?: 0;

// Saldo do Mês
$saldo_mes = $total_recebido - $total_despesas;

// --- BUSCA DE DADOS PARA FORMULÁRIOS E TABELA ---

// Busca todos os apartamentos para o formulário de pagamento
$stmt_aps = $pdo->query("SELECT id, numero_ap, andar, morador_nome FROM apartamentos ORDER BY numero_ap");
$apartamentos = $stmt_aps->fetchAll(PDO::FETCH_ASSOC);

// Busca TODAS as transações (receitas E despesas) do mês para o extrato
$sql_extrato = "
    (SELECT data_pagamento as data, CONCAT('Pagamento AP ', ap.numero_ap) as descricao, 'receita' as tipo, valor_pago as valor 
     FROM pagamentos 
     JOIN apartamentos ap ON pagamentos.apartamento_id = ap.id 
     WHERE mes_referencia = :mes)
    UNION ALL
    (SELECT data_despesa as data, descricao, 'despesa' as tipo, valor 
     FROM despesas 
     WHERE DATE_FORMAT(data_despesa, '%Y-%m') = :mes)
    ORDER BY data DESC
";
$stmt_extrato = $pdo->prepare($sql_extrato);
$stmt_extrato->execute(['mes' => $mes_atual]);
$transacoes = $stmt_extrato->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestão Financeira - SíndicoPro</title>
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
                <li class="active"><a href="financas.php"><i class="fas fa-hand-holding-usd"></i><span>Financeiro</span></a></li>
                <li><a href="manutencao.php"><i class="fas fa-tools"></i><span>Manutenção</span></a></li>
                <li><a href="avisos.php"><i class="fas fa-bullhorn"></i><span>Avisos</span></a></li>
            </ul>
            <div class="sidebar-footer"><a href="php/auth/logout.php"><i class="fas fa-sign-out-alt"></i><span>Sair</span></a></div>
        </aside>

        <main class="main-content">
            <header class="main-header"><h1>Gestão Financeira</h1></header>

            <div class="cards-container">
                <div class="card"><div class="card-info"><h4>Saldo do Mês</h4><p>R$ <?php echo number_format($saldo_mes, 2, ',', '.'); ?></p></div></div>
                <div class="card"><div class="card-info"><h4>Total Recebido</h4><p style="color: green;">R$ <?php echo number_format($total_recebido, 2, ',', '.'); ?></p></div></div>
                <div class="card"><div class="card-info"><h4>Total de Despesas</h4><p style="color: red;">R$ <?php echo number_format($total_despesas, 2, ',', '.'); ?></p></div></div>
            </div>

            <div class="form-grid-double">
                <div class="content-box form-section">
                    <h2><i class="fas fa-plus-circle"></i> Registrar Pagamento</h2>
                    <form action="php/actions/registrar_pagamento.php" method="POST">
                        <div class="input-group">
                            <label for="apartamento_id">Apartamento</label>
                            <select id="apartamento_id" name="apartamento_id" required>
                                <option value="">Selecione...</option>
                                <?php foreach ($apartamentos as $ap): ?>
                                    <option value="<?php echo $ap['id']; ?>">
                                        AP <?php echo $ap['numero_ap']; ?> (<?php echo htmlspecialchars($ap['morador_nome'] ?: 'Vago'); ?>)
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="input-group">
                            <label for="valor_pago">Valor Pago</label>
                            <input type="text" name="valor_pago" required>
                        </div>
                        <div class="input-group">
                            <label for="data_pagamento">Data do Pagamento</label>
                            <input type="date" name="data_pagamento" value="<?php echo date('Y-m-d'); ?>" required>
                        </div>
                        <input type="hidden" name="mes_referencia" value="<?php echo $mes_atual; ?>">
                        <button type="submit">Registrar Entrada</button>
                    </form>
                </div>

                <div class="content-box form-section">
                    <h2><i class="fas fa-minus-circle"></i> Adicionar Despesa</h2>
                    <form action="php/actions/registrar_despesa.php" method="POST">
                         <div class="input-group">
                            <label for="descricao">Descrição</label>
                            <input type="text" name="descricao" required placeholder="Ex: Conta de Luz">
                        </div>
                        <div class="input-group">
                            <label for="valor">Valor da Despesa</label>
                            <input type="text" name="valor" required>
                        </div>
                        <div class="input-group">
                            <label for="data_despesa">Data da Despesa</label>
                            <input type="date" name="data_despesa" value="<?php echo date('Y-m-d'); ?>" required>
                        </div>
                        <button type="submit">Registrar Saída</button>
                    </form>
                </div>
            </div>
            
            <div class="content-box">
                <h2>Extrato de <?php echo date('F/Y'); ?></h2>
                <table class="data-table">
                    <thead><tr><th>Data</th><th>Descrição</th><th>Valor</th></tr></thead>
                    <tbody>
                        <?php foreach($transacoes as $tr): ?>
                        <tr>
                            <td><?php echo date('d/m/Y', strtotime($tr['data'])); ?></td>
                            <td><?php echo htmlspecialchars($tr['descricao']); ?></td>
                            <td class="<?php echo $tr['tipo'] === 'receita' ? 'valor-receita' : 'valor-despesa'; ?>">
                                <?php echo ($tr['tipo'] === 'receita' ? '+ ' : '- '); ?>
                                R$ <?php echo number_format($tr['valor'], 2, ',', '.'); ?>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                        <?php if(empty($transacoes)): ?>
                        <tr><td colspan="3">Nenhuma transação registrada este mês.</td></tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </main>
    </div>
</body>
</html>