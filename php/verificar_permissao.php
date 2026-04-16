<?php
include '../php/conexao.php';

header('Content-Type: application/json');

session_start();
$user_id = $_SESSION['user_id'] ?? null;
$id_edicao = $_GET['id_edicao'] ?? null;

if (!$user_id || !$id_edicao) {
    echo json_encode(['permissao' => false]);
    exit;
}

$sql = "SELECT COUNT(*) AS count FROM edicao_usuarios WHERE id_usuario = ? AND id_edicao = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("ii", $user_id, $id_edicao);
$stmt->execute();
$stmt->bind_result($count);
$stmt->fetch();
$stmt->close();

echo json_encode(['permissao' => $count > 0]);
$conn->close();
