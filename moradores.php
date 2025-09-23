<?php 
require_once 'php/config/conexao.php';
// require_once 'php/config/proteger.php'; // Manter comentado para testes

// SIMULAÇÃO DE LOGIN DE SÍNDICO PARA TESTES
// session_start(); $_SESSION['usuario_role'] = 'sindico';

// Apenas síndicos podem acessar esta página
// if (!isset($_SESSION['usuario_role']) || $_SESSION['usuario_role'] !== 'sindico') {
//     die("Acesso negado. Apenas síndicos podem gerenciar moradores.");
// }

// Busca todos os usuários (moradores e síndicos)
$stmt_users = $pdo->query("SELECT id, email, role, status FROM usuarios ORDER BY role, email");
$usuarios = $stmt_users->fetchAll(PDO::FETCH_ASSOC);

// Busca apartamentos que ainda não têm morador associado
$stmt_aps = $pdo->query("SELECT id, numero_ap, andar FROM apartamentos WHERE usuario_id IS NULL ORDER BY numero_ap");
$apartamentos_vagos = $stmt_aps->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestão de Moradores - SíndicoPro</title>
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
                <li class="active"><a href="moradores.php"><i class="fas fa-users"></i><span>Moradores</span></a></li>
                <li><a href="financas.php"><i class="fas fa-hand-holding-usd"></i><span>Financeiro</span></a></li>
                <li><a href="manutencao.php"><i class="fas fa-tools"></i><span>Manutenção</span></a></li>
                <li><a href="#avisos.php"><i class="fas fa-bullhorn"></i><span>Avisos</span></a></li>
            </ul>
            <div class="sidebar-footer"><a href="php/auth/logout.php"><i class="fas fa-sign-out-alt"></i><span>Sair</span></a></div>
        </aside>

        <main class="main-content">
            <header class="main-header"><h1>Gestão de Moradores</h1></header>

            <div class="content-box form-section">
                <h2>Adicionar Novo Morador</h2>
                <form action="php/actions/cadastrar_morador.php" method="POST">
                    <div class="form-grid">
                        <div class="input-group">
                            <label for="email">Email (Login do Morador)</label>
                            <input type="email" id="email" name="email" required>
                        </div>
                        <div class="input-group">
                            <label for="senha_temporaria">Senha Temporária</label>
                            <input type="text" id="senha_temporaria" name="senha_temporaria" required>
                        </div>
                        <div class="input-group">
                            <label for="apartamento_id">Associar ao Apartamento</label>
                            <select id="apartamento_id" name="apartamento_id" required>
                                <option value="">Selecione um AP vago...</option>
                                <?php foreach ($apartamentos_vagos as $ap): ?>
                                    <option value="<?php echo $ap['id']; ?>">
                                        AP <?php echo $ap['numero_ap']; ?> (Andar <?php echo $ap['andar']; ?>)
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    </div>
                    <button type="submit">Cadastrar Morador</button>
                </form>
            </div>

            <div class="content-box">
                <h2>Usuários do Sistema</h2>
                <table class="data-table">
                    <thead>
                        <tr>
                            <th>Email (Login)</th>
                            <th>Tipo</th>
                            <th>Status</th>
                            <th>Ações</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach($usuarios as $user): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($user['email']); ?></td>
                            <td><?php echo htmlspecialchars(ucfirst($user['role'])); ?></td>
                            <td><?php echo htmlspecialchars(ucfirst($user['status'])); ?></td>
                            <td class="actions"><a href="#" title="Excluir"><i class="fas fa-trash-alt"></i></a></td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </main>
    </div>
</body>
</html> 