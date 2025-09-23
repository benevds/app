<?php
require_once '../config/conexao.php';

$id = $_GET['id'] ?? null;
if (!$id) {
    die("ID do apartamento não fornecido.");
}

try {
    // IMPORTANTE: Antes de excluir, precisamos desassociar de pagamentos, tarefas, etc.
    // para não quebrar o banco de dados. Por enquanto, vamos fazer o básico.
    
    $sql = "DELETE FROM apartamentos WHERE id = ?";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$id]);

    header("Location: ../../apartamentos.php?sucesso=excluido");
    exit();

} catch (PDOException $e) {
    // Se o apartamento tiver registros ligados (pagamentos, etc.), o banco vai dar um erro de chave estrangeira.
    // É uma proteção!
    die("Erro ao excluir apartamento: " . $e->getMessage() . ". <br><br><strong>Possível Causa:</strong> Este apartamento pode ter pagamentos ou tarefas registrados. É preciso remover os registros associados antes de excluir o apartamento.");
}
?>