<?php
// Inclui o arquivo de conexão
include_once 'conexao.php';
session_start();

// Exibe erros para depuração
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $user_id = $_SESSION['user_id'] ?? null;
    $turma = $_POST['turma'] ?? null;
    $participacao_anterior = is_array($_POST['participacao']) ? implode(', ', $_POST['participacao']) : $_POST['participacao'];
    $funcao = $_POST['funcao'] ?? [];
    if (!is_array($funcao)) {
        $funcao = [$funcao]; // Converte para array se for string
    }
    $outro = trim($_POST['outra_funcao'] ?? '');

    if (!empty($outro)) {
        $funcao[] = $outro;
    }
    $funcoesString = !empty($funcao) ? implode(', ', $funcao) : '';
    $justificativa = $conn->real_escape_string($_POST['justificativa'] ?? '');

    if (!$user_id || !$turma || empty($funcoesString)) {
        echo "<script>alert('Preencha todos os campos obrigatórios.');</script>";
        exit;
    }

    // Consulta preparada
    $stmt = $conn->prepare("INSERT INTO staff (id_usuário, turma, participacao_anterior, funcao, justificativa) VALUES (?, ?, ?, ?, ?)");
    $stmt->bind_param("issss", $user_id, $turma, $participacao_anterior, $funcoesString, $justificativa);

    if ($stmt->execute()) {
        echo "<script>window.location.href = '../index.php';</script>";
    } else {
        error_log("Erro ao executar a consulta: " . $stmt->error);
        echo "<script>alert('Erro ao inserir os dados iniciais.');</script>";
    }

    $stmt->close();
    $conn->close();
}
?>
