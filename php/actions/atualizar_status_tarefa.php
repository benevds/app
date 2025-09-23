<?php
require_once '../config/conexao.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $tarefa_id = $_POST['tarefa_id'];
    $novo_status = $_POST['novo_status'];

    // Validação para garantir que o status é um dos permitidos
    $status_permitidos = ['pendente', 'em_andamento', 'concluida'];
    if (in_array($novo_status, $status_permitidos)) {
        try {
            $sql = "UPDATE tarefas SET status = ? WHERE id = ?";
            $stmt = $pdo->prepare($sql);
            $stmt->execute([$novo_status, $tarefa_id]);

            header("Location: ../../manutencao.php?status_atualizado=1");
            exit();
        } catch (PDOException $e) {
            die("Erro ao atualizar status: " . $e->getMessage());
        }
    } else {
        die("Status inválido.");
    }
}
?>