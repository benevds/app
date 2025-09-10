<?php
session_start();
 
if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
    header("location: login.php");
    exit;
}
?>
 
<?php include 'includes/header.php'; ?>
<div class="container">
    <div class="page-header">
        <h1>Olá, <b><?php echo htmlspecialchars($_SESSION["username"]); ?></b>. Bem-vindo ao nosso site.</h1>
    </div>
    <p>
        Esta é a sua página principal. A partir daqui, você pode gerenciar suas apostas, visualizar jogos e muito mais.
    </p>
    <p>
        <a href="profile.php" class="btn">Ver Perfil</a>
        <a href="logout.php" class="btn btn-danger">Sair da conta</a>
    </p>
</div>
<?php include 'includes/footer.php'; ?>
