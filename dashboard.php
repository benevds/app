<?php 
// require_once 'php/config/proteger.php'; // Descomente quando o login estiver 100%
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
                <li class="active"><a href="#"><i class="fas fa-tachometer-alt"></i><span>Dashboard</span></a></li>
                <li><a href="apartamentos.php"><i class="fas fa-building"></i><span>Apartamentos</span></a></li>
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
                        <h4>A Receber (Mês)</h4>
                        <p>R$ 33.300,00</p>
                    </div>
                </div>
                <div class="card">
                    <div class="card-icon" style="background-color: #f5dfe2;">
                        <i class="fas fa-user-clock" style="color: #c0392b;"></i>
                    </div>
                    <div class="card-info">
                        <h4>Inadimplentes</h4>
                        <p>2 Apartamentos</p>
                    </div>
                </div>
                <div class="card">
                     <div class="card-icon" style="background-color: #dff5e8;">
                        <i class="fas fa-tools" style="color: #27ae60;"></i>
                    </div>
                    <div class="card-info">
                        <h4>Manutenções</h4>
                        <p>3 Pendentes</p>
                    </div>
                </div>
            </div>

            <div class="content-box">
                <h2>Avisos Recentes</h2>
                </div>
        </main>
    </div>
</body>
</html>