<?php
header('Content-Type: application/json');

// Conexão com o banco de dados
$servername = "127.0.0.1";
$dbname = 'muniverse_db';
$username = 'muniverse';
$password = '_}+b6yxj^F';

$conn = new mysqli($servername, $username, $password, $dbname);

// Verificando a conexão
if ($conn->connect_error) {
    echo json_encode(['sucesso' => false, 'mensagem' => 'Erro na conexão com o banco de dados.']);
    exit;
}

// Obtendo os dados enviados via POST
$id = isset($_POST['id']) ? intval($_POST['id']) : 0;
$acao = isset($_POST['acao']) ? $_POST['acao'] : '';

if ($id > 0 && in_array($acao, ['aprovar', 'recusar'])) {
    if ($acao === 'aprovar') {
        // Aprovar comitê (atualizar a coluna "aprovacao")
        $sql = "UPDATE comite SET aprovacao = 1 WHERE id = ?";
        $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id);
    $stmt->execute();
    echo json_encode(['sucesso' => true]);

    } else {
        // Recusar comitê (excluir o registro e os diretores associados)
        
        // Inicia a transação
        $conn->begin_transaction();

        try {
            // Deleta os diretores associados ao comitê
            $sql_diretores = "DELETE FROM tb_diretor WHERE id_comite = ?";
            $stmt_diretores = $conn->prepare($sql_diretores);
            $stmt_diretores->bind_param("i", $id);
            $stmt_diretores->execute();

            // Deleta o comitê
            $sql_comite = "DELETE FROM comite WHERE id = ?";
            $stmt_comite = $conn->prepare($sql_comite);
            $stmt_comite->bind_param("i", $id);
            $stmt_comite->execute();

            // Se ambos os comandos foram executados com sucesso, confirma a transação
            $conn->commit();

            echo json_encode(['sucesso' => true]);

        } catch (Exception $e) {
            // Se ocorrer algum erro, faz rollback da transação
            $conn->rollback();
            echo json_encode(['sucesso' => false, 'mensagem' => 'Erro ao executar a operação: ' . $e->getMessage()]);
        }
    }

    $stmt->close();
} else {
    echo json_encode(['sucesso' => false, 'mensagem' => 'Dados inválidos.']);
}

$conn->close();
?>
