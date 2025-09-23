<?php
require_once '../config/conexao.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $titulo = $_POST['titulo'];
    // Se nenhum AP for selecionado, o valor será nulo.
    $apartamento_id = !empty($_POST['apartamento_id']) ? $_POST['apartamento_id'] : null;

    if (empty($titulo)) {
        die("O título da tarefa é obrigatório.");
    }

    try {
        $sql = "INSERT INTO tarefas (titulo, apartamento_id) VALUES (?, ?)";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$titulo, $apartamento_id]);

        header("Location: ../../manutencao.php?sucesso=1");
        exit();
    } catch (PDOException $e) {
        die("Erro ao adicionar tarefa: " . $e->getMessage());
    }
}
?>