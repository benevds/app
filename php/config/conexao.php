<?php
// php/config/conexao.php

$host = 'localhost';
$dbname = 'sindico_pro_db'; // Nome do banco de dados
$user = 'root';
$pass = '';

try {
    // Tenta conectar ao MySQL para criar o banco de dados
    $pdo_init = new PDO("mysql:host=$host", $user, $pass);
    $pdo_init->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $pdo_init->exec("CREATE DATABASE IF NOT EXISTS `$dbname` CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;");
    
    // Conecta ao banco de dados específico do projeto
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $user, $pass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

} catch (PDOException $e) {
    die("Erro: Não foi possível conectar ou configurar o banco de dados. " . $e->getMessage());
}

// --- CRIAÇÃO AUTOMÁTICA DAS TABELAS ---
// Este código só executa se as tabelas não existirem.
$tabelas_sql = [
    "CREATE TABLE IF NOT EXISTS usuarios (
        id INT AUTO_INCREMENT PRIMARY KEY, email VARCHAR(255) NOT NULL UNIQUE, senha_hash VARCHAR(255) NOT NULL
    );",
    "CREATE TABLE IF NOT EXISTS apartamentos (
        id INT AUTO_INCREMENT PRIMARY KEY, numero_ap INT NOT NULL, andar INT NOT NULL, tipo ENUM('padrão', 'varanda') NOT NULL, valor_aluguel DECIMAL(10, 2) NOT NULL, morador_nome VARCHAR(255), morador_contato VARCHAR(50)
    );",
    "CREATE TABLE IF NOT EXISTS pagamentos (
        id INT AUTO_INCREMENT PRIMARY KEY, apartamento_id INT NOT NULL, mes_referencia VARCHAR(7) NOT NULL, data_pagamento DATE, valor_pago DECIMAL(10, 2), status ENUM('pago', 'pendente') NOT NULL DEFAULT 'pendente', FOREIGN KEY (apartamento_id) REFERENCES apartamentos(id)
    );",
    "CREATE TABLE IF NOT EXISTS despesas (
        id INT AUTO_INCREMENT PRIMARY KEY, descricao VARCHAR(255) NOT NULL, valor DECIMAL(10, 2) NOT NULL, data_despesa DATE NOT NULL, categoria VARCHAR(100)
    );",
    "CREATE TABLE IF NOT EXISTS avisos (
        id INT AUTO_INCREMENT PRIMARY KEY, titulo VARCHAR(255) NOT NULL, conteudo TEXT NOT NULL, data_publicacao TIMESTAMP DEFAULT CURRENT_TIMESTAMP
    );",
    "CREATE TABLE IF NOT EXISTS tarefas (
        id INT AUTO_INCREMENT PRIMARY KEY, titulo VARCHAR(255) NOT NULL, descricao TEXT, apartamento_id INT, status ENUM('pendente', 'em_andamento', 'concluida') NOT NULL DEFAULT 'pendente', data_criacao TIMESTAMP DEFAULT CURRENT_TIMESTAMP, FOREIGN KEY (apartamento_id) REFERENCES apartamentos(id)
    );"
];

try {
    foreach ($tabelas_sql as $sql) {
        $pdo->exec($sql);
    }
} catch (PDOException $e) {
    die("Erro ao criar as tabelas: " . $e->getMessage());
}
?>