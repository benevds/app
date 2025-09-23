<?php
require_once 'php/config/conexao.php';
// require_once 'php/config/proteger.php'; // Manter comentado para testes

// SIMULAÇÃO DE LOGIN PARA TESTES (apague ou comente depois)
session_start();
// Para testar como SÍNDICO, descomente a linha abaixo:
// $_SESSION['usuario_role'] = 'sindico';
// Para testar como MORADOR, descomente a linha abaixo:
if (!isset($_SESSION['usuario_role'])) { $_SESSION['usuario_role'] = 'morador'; }


// Busca todos os avisos no banco, do mais novo para o mais antigo
$stmt = $pdo->query("SELECT * FROM avisos ORDER BY data_publicacao DESC");
$avisos = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mural de Avisos - SíndicoPro</title>
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
                <li><a href="manutencao.php"><i class="fas fa-tools"></i><span>Manutenção</span></a></li>
                <li class="active"><a href="avisos.php"><i class="fas fa-bullhorn"></i><span>Avisos</span></a></li>
            </ul>
            <div class="sidebar-footer"><a href="php/auth/logout.php"><i class="fas fa-sign-out-alt"></i><span>Sair</span></a></div>
        </aside>

        <main class="main-content">
            <header class="main-header"><h1>Mural de Avisos</h1></header>

            <?php // Este formulário só aparece se o usuário for SÍNDICO ?>
            <?php if (isset($_SESSION['usuario_role']) && $_SESSION['usuario_role'] === 'sindico'): ?>
            <div class="content-box form-section">
                <h2>Publicar Novo Aviso</h2>
                <form action="php/actions/adicionar_aviso.php" method="POST">
                    <div class="input-group">
                        <label for="titulo">Título do Aviso</label>
                        <input type="text" id="titulo" name="titulo" required placeholder="Ex: Manutenção da Caixa d'Água">
                    </div>
                    <div class="input-group">
                        <label for="conteudo">Conteúdo do Aviso</label>
                        <textarea id="conteudo" name="conteudo" rows="4" required></textarea>
                    </div>
                    <button type="submit">Publicar Aviso</button>
                </form>
            </div>
            <?php endif; ?>

            <div class="avisos-container">
                <?php if (empty($avisos)): ?>
                    <div class="content-box"><p>Nenhum aviso publicado ainda.</p></div>
                <?php else: ?>
                    <?php foreach ($avisos as $aviso): ?>
                        <div class="aviso-card content-box">
                            <h3><?php echo htmlspecialchars($aviso['titulo']); ?></h3>
                            <p class="aviso-data">Publicado em: <?php echo date('d/m/Y \à\s H:i', strtotime($aviso['data_publicacao'])); ?></p>
                            <div class="aviso-conteudo">
                                <?php echo nl2br(htmlspecialchars($aviso['conteudo'])); ?>
                            </div>
                        </div>
                    <?php endforeach; ?>
                <?php endif; ?>
            </div>
        </main>
    </div>
</body>
</html>