<?php
require_once '../config/conexao.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $descricao = $_POST['descricao'];
    $valor = $_POST['valor'];
    $data_despesa = $_POST['data_despesa'];
    
    try {
        $sql = "INSERT INTO despesas (descricao, valor, data_despesa) VALUES (?, ?, ?)";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$descricao, $valor, $data_despesa]);

        header("Location: ../../financas.php?sucesso=despesa_registrada");
        exit();
    } catch (PDOException $e) {
        die("Erro ao registrar despesa: " . $e->getMessage());
    }
}
?>