<?php
require_once '../config/conexao.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = $_POST['id'];
    $numero_ap = $_POST['numero_ap'];
    $andar = $_POST['andar'];
    $tipo = $_POST['tipo'];
    $valor_aluguel = $_POST['valor_aluguel'];
    $morador_nome = $_POST['morador_nome'];
    $morador_contato = $_POST['morador_contato'];

    try {
        $sql = "UPDATE apartamentos SET 
                    numero_ap = ?, 
                    andar = ?, 
                    tipo = ?, 
                    valor_aluguel = ?, 
                    morador_nome = ?, 
                    morador_contato = ? 
                WHERE id = ?";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$numero_ap, $andar, $tipo, $valor_aluguel, $morador_nome, $morador_contato, $id]);

        header("Location: ../../apartamentos.php?sucesso=editado");
        exit();
    } catch (PDOException $e) {
        die("Erro ao atualizar apartamento: " . $e->getMessage());
    }
}
?>