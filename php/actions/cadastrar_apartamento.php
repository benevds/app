<?php
// php/actions/cadastrar_apartamento.php

// Inclui o arquivo de conexão que já cria as tabelas
require_once '../config/conexao.php';

// Verifica se o formulário foi enviado
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Pega os dados do formulário
    $numero_ap = $_POST['numero_ap'] ?? null;
    $andar = $_POST['andar'] ?? null;
    $tipo = $_POST['tipo'] ?? null;
    $valor_aluguel = $_POST['valor_aluguel'] ?? null;
    $morador_nome = $_POST['morador_nome'] ?? ''; // Pode ser vazio
    $morador_contato = $_POST['morador_contato'] ?? ''; // Pode ser vazio

    // Validação simples
    if (!$numero_ap || !$andar || !$tipo || !$valor_aluguel) {
        die("Erro: Todos os campos obrigatórios devem ser preenchidos.");
    }

    // Prepara o comando SQL para inserir os dados de forma segura
    try {
        $sql = "INSERT INTO apartamentos (numero_ap, andar, tipo, valor_aluguel, morador_nome, morador_contato) VALUES (?, ?, ?, ?, ?, ?)";
        $stmt = $pdo->prepare($sql);
        
        // Executa o comando, passando os valores
        $stmt->execute([
            $numero_ap,
            $andar,
            $tipo,
            $valor_aluguel,
            $morador_nome,
            $morador_contato
        ]);

        // Redireciona de volta para a página de apartamentos após o sucesso
        header("Location: ../../apartamentos.php?sucesso=1");
        exit();

    } catch (PDOException $e) {
        // Em caso de erro, exibe a mensagem
        die("Erro ao cadastrar apartamento: " . $e->getMessage());
    }
} else {
    // Se alguém tentar acessar o script diretamente, redireciona
    header("Location: ../../apartamentos.php");
    exit();
}
?>