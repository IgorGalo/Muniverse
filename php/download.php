<?php
require 'conexao.php';

if (isset($_GET['id'])) {
    $id = intval($_GET['id']);

    // Busca o arquivo no banco de dados
    $sql = "SELECT nome_arquivo, dados_arquivo FROM arquivos WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $stmt->bind_result($fileName, $fileContent);
    $stmt->fetch(); // Captura os resultados
    $stmt->close();

    if ($fileContent !== null) { // Verifica se o conteúdo não é nulo
        // Definir os cabeçalhos para o download
        header("Content-Disposition: attachment; filename=\"" . basename($fileName) . "\"");
        header("Content-Type: application/octet-stream");
        header("Content-Length: " . strlen($fileContent));

        // Envia o conteúdo do arquivo para o download
        echo $fileContent;
        exit();
    } else {
        echo "Arquivo não encontrado.";
    }
} else {
    echo "ID de arquivo inválido.";
}
?>
