<?php
include 'conexao.php';

header('Content-Type: application/json');

$data = json_decode(file_get_contents('php://input'), true);

if (isset($data['email'])) {
    $email = $data['email'];

    $sql = "SELECT COUNT(*) AS is_diretor FROM tb_diretor WHERE email = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $stmt->bind_result($is_diretor);
    $stmt->fetch();
    $stmt->close();

    echo json_encode(['isDiretor' => $is_diretor > 0]);
} else {
    echo json_encode(['error' => 'E-mail não fornecido.']);
}
$conn->close();
?>
