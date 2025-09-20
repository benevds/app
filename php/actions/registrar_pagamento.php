<?php
require_once '../config/conexao.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $apartamento_id = $_POST['apartamento_id'];
    $valor_pago = $_POST['valor_pago'];
    $data_pagamento = $_POST['data_pagamento'];
    $mes_referencia = $_POST['mes_referencia'];

    try {
        $sql = "INSERT INTO pagamentos (apartamento_id, valor_pago, data_pagamento, mes_referencia, status) VALUES (?, ?, ?, ?, 'pago')";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$apartamento_id, $valor_pago, $data_pagamento, $mes_referencia]);
        
        header("Location: ../../financas.php?sucesso=pagamento_registrado");
        exit();
    } catch (PDOException $e) {
        die("Erro ao registrar pagamento: " . $e->getMessage());
    }
}
?>