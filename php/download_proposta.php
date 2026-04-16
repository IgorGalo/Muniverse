<?php
include_once 'conexao.php';

if (isset($_GET['id'])) {
    $id = $_GET['id'];

    // Consulta para buscar os bytes do arquivo e o nome do comitê
    $sql = "SELECT proposta_comite, nome_comite FROM comite WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $stmt->bind_result($proposta, $nome_comite);
    $stmt->fetch();

    if ($proposta) {
        // Define os cabeçalhos para download
        $nomeArquivo = "Proposta_" . preg_replace('/[^\w]/', '_', $nome_comite) . ".pdf"; // Sanitiza o nome
        header('Content-Type: application/pdf');
        header("Content-Disposition: attachment; filename=\"$nomeArquivo\"");
        header('Content-Length: ' . strlen($proposta));

        // Envia o conteúdo do arquivo
        echo $proposta;
    } else {
        echo "alert('Proposta não encontrada.');";
        
    }

    $stmt->close();
    $conn->close();
} else {
    echo "ID não fornecido.";
}

?>
