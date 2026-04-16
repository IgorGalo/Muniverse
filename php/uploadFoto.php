<?php
session_start();
require 'conexao.php'; // Inclua a conexão com o banco de dados

// Verificar se o arquivo foi enviado sem erro
if (isset($_FILES['imagem']) && $_FILES['imagem']['error'] === UPLOAD_ERR_OK) {
    // Lê o arquivo de imagem
    $foto = file_get_contents($_FILES['imagem']['tmp_name']);

    // Se necessário, pode validar o tipo do arquivo (exemplo: JPG, PNG)
    // $tipoImagem = mime_content_type($_FILES['imagem']['tmp_name']);
    // if (!in_array($tipoImagem, ['image/jpeg', 'image/png'])) {
    //     echo json_encode(["success" => false, "message" => "Formato de imagem não permitido."]);
    //     exit;
    // }

    // Armazenar a foto no banco de dados para o usuário logado
    if (isset($_SESSION['user_id'])) {
        $usuario_id = $_SESSION['user_id'];

        // Preparar o comando SQL para atualizar a foto do usuário
        $stmt = $conn->prepare("UPDATE usuario SET foto = ? WHERE id = ?");
        $stmt->bind_param("si", $foto, $usuario_id);

        // Executar a query
        if ($stmt->execute()) {
            // Se o upload e a atualização foram bem-sucedidos, retornar sucesso
            // E enviar a URL para a foto
            $stmt->close();

            // Obter a foto do banco de dados
            $stmt = $conn->prepare("SELECT foto FROM usuario WHERE id = ?");
            $stmt->bind_param("i", $usuario_id);
            $stmt->execute();
            $stmt->bind_result($fotoAtualizada);
            $stmt->fetch();

            // Gerar a URL para a imagem
            $fotoBase64 = base64_encode($fotoAtualizada);

            echo json_encode(["success" => true, "foto" => 'data:image/jpeg;base64,' . $fotoBase64]);
        } else {
            echo json_encode(["success" => false, "message" => "Erro ao atualizar a foto no banco de dados."]);
        }

        $stmt->close();
    } else {
        echo json_encode(["success" => false, "message" => "Usuário não encontrado."]);
    }
} else {
    echo json_encode(["success" => false, "message" => "Erro ao fazer upload da imagem."]);
}
?>
