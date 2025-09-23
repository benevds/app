<?php
// php/config/conexao.php

// FORÇA O PHP A MOSTRAR ERROS
ini_set('display_errors', 1);
error_reporting(E_ALL);

// --- CONFIGURAÇÕES DO BANCO DE DADOS ---
$host = 'localhost';
$dbname = 'sindico_pro_db';
$user = 'root';
$pass = '';

try {
    // 1. Garante que o banco de dados exista
    $pdo_init = new PDO("mysql:host=$host", $user, $pass);
    $pdo_init->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $pdo_init->exec("CREATE DATABASE IF NOT EXISTS `$dbname` CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;");
    
    // 2. Conecta-se ao banco do projeto
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $user, $pass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

} catch (PDOException $e) {
    die("Erro CRÍTICO na conexão ou configuração do banco: " . $e->getMessage());
}

// --- CRIAÇÃO E ATUALIZAÇÃO AUTOMÁTICA DA ESTRUTURA ---
try {
    // Garante que a tabela base exista, mesmo que na versão antiga
    $pdo->exec("
    CREATE TABLE IF NOT EXISTS `usuarios` (
      `id` int(11) NOT NULL AUTO_INCREMENT,
      `email` varchar(255) NOT NULL,
      `senha_hash` varchar(255) NOT NULL,
      `data_cadastro` timestamp NOT NULL DEFAULT current_timestamp(),
      PRIMARY KEY (`id`),
      UNIQUE KEY `email` (`email`)
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;");

    // A MÁGICA: Verifica se a coluna 'nome' existe
    $stmt_check_column = $pdo->query("SHOW COLUMNS FROM `usuarios` LIKE 'nome'");
    
    if ($stmt_check_column->rowCount() == 0) {
        // Se a coluna 'nome' NÃO existe, adiciona ela na posição correta (depois do id).
        $pdo->exec("ALTER TABLE `usuarios` ADD COLUMN `nome` VARCHAR(255) NOT NULL AFTER `id`;");
    }

} catch (PDOException $e) {
    die("Erro ao criar ou atualizar a tabela 'usuarios': " . $e->getMessage());
}
?>