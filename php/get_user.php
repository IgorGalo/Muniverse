<?php
session_start();

header("Content-Type: application/json");

$response = [
    'nome_user' => $_SESSION['nome_user'] ?? null,
    'user_id' => $_SESSION['user_id'] ?? null
];

echo json_encode($response);
?>
