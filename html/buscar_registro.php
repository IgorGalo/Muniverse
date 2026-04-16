<?php

session_start();

header('Content-Type: application/json');
$input = file_get_contents('php://input');
$dados = json_decode($input, true);

$idDelegado = $dados['id'];

// Configurações de conexão com o banco de dados
// Conexão com o banco de dados
$servername = "127.0.0.1";
$dbname = 'muniverse_db';
$username = 'muniverse';
$password = '_}+b6yxj^F';

// Criando a conexão
try {
    $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    echo json_encode("Erro de conexão " . $e->getMessage());
    exit();
}

if ($idDelegado != null) {
    // Query para buscar o registro anterior
    $sql = "SELECT id_representacoes, nome_representacao FROM representacoes WHERE id_comite = ?";
    $stmt = $conn->prepare($sql);
    try {
        $stmt->execute([$idDelegado]);
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        echo json_encode("Erro SQL: " . $e->getMessage());
        exit();
    }
    if ($result != null) {

        for ($i=0; $i < count($result); $i++) { 
            $id_representacoes[$i] = $result[$i]['id_representacoes'];
            $nome_representacao[$i] = $result[$i]['nome_representacao'];     
        }        

        $response = [
            'id_representacoes' => $id_representacoes,
            'nome_representacao' => $nome_representacao
        ];
    } else {
        echo json_encode("Nenhum registro anterior encontrado.");
        exit();
    }
} else {
    echo json_encode("Nenhum ID encontrado");
    exit();
}

echo json_encode($response);

?>