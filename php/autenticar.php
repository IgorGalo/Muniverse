<?php
session_start();
include("conexao.php");

$email = $_GET['email'];
$senha = $_GET['senha'];

// Consulta para verificar o usuário no banco de dados
$query = "SELECT * FROM usuarios WHERE email = '$email' AND senha = '$senha'";
$result = mysqli_query($conn, $query);

if (mysqli_num_rows($result) > 0) {
    $usuario = mysqli_fetch_assoc($result);
    $_SESSION['nome_user'] = $usuario['nome_user'];
    echo "true";
} else {
    echo "false";
}
?>
