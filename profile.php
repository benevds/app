<?php
session_start();
require_once "includes/db.php";

if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
    header("location: login.php");
    exit;
}

$new_password = $confirm_password = "";
$new_password_err = $confirm_password_err = "";
$update_success = "";

if($_SERVER["REQUEST_METHOD"] == "POST"){
 
    if(isset($_POST["update_password"])){
        if(empty(trim($_POST["new_password"]))){
            $new_password_err = "Por favor, insira a nova senha.";     
        } elseif(strlen(trim($_POST["new_password"])) < 6){
            $new_password_err = "A senha deve ter pelo menos 6 caracteres.";
        } else{
            $new_password = trim($_POST["new_password"]);
        }
        
        if(empty(trim($_POST["confirm_password"]))){
            $confirm_password_err = "Por favor, confirme a senha.";     
        } else{
            $confirm_password = trim($_POST["confirm_password"]);
            if(empty($new_password_err) && ($new_password != $confirm_password)){
                $confirm_password_err = "As senhas não correspondem.";
            }
        }

        if(empty($new_password_err) && empty($confirm_password_err)){
            $sql = "UPDATE users SET password = ? WHERE id = ?";
            
            if($stmt = mysqli_prepare($link, $sql)){
                mysqli_stmt_bind_param($stmt, "si", $param_password, $param_id);
                
                $param_password = password_hash($new_password, PASSWORD_DEFAULT);
                $param_id = $_SESSION["id"];
                
                if(mysqli_stmt_execute($stmt)){
                    $update_success = "Senha alterada com sucesso!";
                } else{
                    echo "Oops! Algo deu errado. Por favor, tente novamente mais tarde.";
                }

                mysqli_stmt_close($stmt);
            }
        }
    }
    // Adicionar lógica para alterar outros dados do usuário aqui
}
?>

<?php include 'includes/header.php'; ?>
<div class="container">
    <h2>Perfil do Usuário</h2>
    <p>Aqui você pode alterar sua senha.</p>

    <?php 
    if(!empty($update_success)){
        echo '<div class="alert alert-success">' . $update_success . '</div>';
    }        
    ?>

    <div class="form-container" style="width: 100%; margin: 0;">
        <h3>Alterar Senha</h3>
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post"> 
            <div class="form-group <?php echo (!empty($new_password_err)) ? 'has-error' : ''; ?>">
                <label>Nova Senha</label>
                <input type="password" name="new_password" class="form-control" value="<?php echo $new_password; ?>">
                <span class="help-block"><?php echo $new_password_err; ?></span>
            </div>
            <div class="form-group <?php echo (!empty($confirm_password_err)) ? 'has-error' : ''; ?>">
                <label>Confirme a Nova Senha</label>
                <input type="password" name="confirm_password" class="form-control">
                <span class="help-block"><?php echo $confirm_password_err; ?></span>
            </div>
            <div class="form-group">
                <input type="submit" name="update_password" class="btn" value="Alterar Senha">
            </div>
        </form>
    </div>
</div>
<?php include 'includes/footer.php'; ?>
