<?php
// Impede o cache da imagem
header("Cache-Control: no-cache, must-revalidate");
header("Expires: Sat, 26 Jul 1997 05:00:00 GMT"); // Data no passado para garantir a expiração
header("Pragma: no-cache");

session_start();
require 'conexao.php'; // Inclua a conexão com o banco de dados

// Verifique se o usuário está logado e obtenha a imagem do banco de dados
if (isset($_SESSION['user_id'])) {
    $usuario_id = $_SESSION['user_id'];

    // Prepare a consulta para obter a foto
    $stmt = $conn->prepare("SELECT foto FROM usuario WHERE id = ?");
    $stmt->bind_param("i", $usuario_id);
    $stmt->execute();
    $stmt->bind_result($foto);
    $stmt->fetch();
    $stmt->close();

    // Verifique se há uma foto no banco de dados
    if ($foto) {
        // Defina o tipo de conteúdo da resposta (imagem)
        header("Content-Type: image/jpeg");

        // Exibe a foto no formato correto
        echo $foto;
    } else {
        // Carrega uma imagem padrão caso a foto não esteja no banco de dados
        header("Content-Type: image/jpeg");
        readfile("../image/User.jpg");
    }
} else {
    // Carrega a imagem padrão se o usuário não estiver logado
    header("Content-Type: image/jpeg");
    readfile("../image/User.jpg");
}
?>
