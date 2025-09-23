<?php
// php/actions/adicionar_aviso.php
session_start();
require_once '../config/conexao.php';
require_once '../config/proteger.php'; // Garante que só usuários logados acessem

// Medida de segurança extra: garante que só o síndico pode adicionar avisos
if ($_SESSION['usuario_role'] !== 'sindico') {
    die("Acesso negado. Apenas síndicos podem publicar avisos.");
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $titulo = $_POST['titulo'] ?? '';
    $conteudo = $_POST['conteudo'] ?? '';

    if (empty($titulo) || empty($conteudo)) {
        die("Erro: Título e conteúdo são obrigatórios.");
    }

    try {
        $sql = "INSERT INTO avisos (titulo, conteudo) VALUES (?, ?)";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$titulo, $conteudo]);

        header("Location: ../../avisos.php?sucesso=1");
        exit();

    } catch (PDOException $e) {
        die("Erro ao publicar aviso: " . $e->getMessage());
    }
}
?>