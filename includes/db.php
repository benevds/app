<?php
// Inclui as variáveis de configuração do banco de dados
require_once __DIR__ . '/../config.php';

// 1. Tenta se conectar ao banco de dados
$link = mysqli_connect(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_NAME);

// Se a conexão falhar, exibe um erro e para a execução
if($link === false){
    die("ERRO: Não foi possível conectar ao banco de dados. " . mysqli_connect_error());
}

// 2. Verifica se a tabela 'users' já existe
$query_check_table = "SHOW TABLES LIKE 'users'";
$result = mysqli_query($link, $query_check_table);

// 3. Se a tabela NÃO existir (se o número de linhas do resultado for 0), o código abaixo será executado
if(mysqli_num_rows($result) == 0) {
    
    // Define o comando SQL para criar a tabela 'users'
    $sql_create_table = "
    CREATE TABLE users (
        id INT NOT NULL PRIMARY KEY AUTO_INCREMENT,
        username VARCHAR(50) NOT NULL UNIQUE,
        password VARCHAR(255) NOT NULL,
        created_at DATETIME DEFAULT CURRENT_TIMESTAMP
    )";

    // Executa o comando e, se falhar, exibe um erro
    if(!mysqli_query($link, $sql_create_table)){
        die("ERRO: Não foi possível criar a tabela 'users'. " . mysqli_error($link));
    }
}
// Se a tabela já existir, nada acontece e o código continua normalmente.
?>