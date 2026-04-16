<?php
require 'conexao.php'; // Arquivo com conexão ao banco

// Habilita exibição de erros para depuração
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Iniciar sessão
session_start();

// Recuperar o valor do comitê da sessão
if (isset($_SESSION['comite'])) {
    $comite = $_SESSION['comite'];
} else {
    // Retorna um erro JSON se nenhum comitê estiver selecionado
    echo json_encode(['error' => 'Nenhum comitê selecionado na sessão.']);
    exit;
}

header('Content-Type: application/json');

try {
    $query = "
    SELECT 
        u.nome AS nome_usuario,
        c.nome_comite AS comite,
        e.nome AS edicao, -- Inclui o nome da edição
        e.data_inicio,
        e.data_fim
    FROM usuario u
    LEFT JOIN tb_delegado d ON u.id = d.id_usuario  -- Relaciona usuario com delegado
    LEFT JOIN comite c ON d.id_comite = c.id  -- Relaciona delegado com comite
    LEFT JOIN edicao e ON c.id_edicao = e.id  -- Relaciona comite com edicao
    WHERE (? = '' OR c.nome_comite = ?)
    ";
    
    // Usando a conexão mysqli com parâmetros preparados
    $stmt = $conn->prepare($query);
    $stmt->bind_param('ss', $comite, $comite); // Vincula a variável $comite ao parâmetro da consulta
    
    $stmt->execute();

    // Fazendo o fetch dos resultados
    $result = $stmt->get_result();
    
    // Verifica se há algum erro ao obter os dados
    if ($result === false) {
        throw new Exception('Erro ao recuperar dados do banco.');
    }

    // Coletando todos os resultados em um array
    $data = [];
    while ($row = $result->fetch_assoc()) {
        $row['funcao'] = 'delegado'; // Define "delegado" como valor fixo
        $row['carga_horaria'] = 30; // Define a carga horária padrão
        $data[] = $row;
    }

    // Retorna os dados como JSON
    echo json_encode($data);
} catch (mysqli_sql_exception $e) {
    // Retorna o erro como JSON
    echo json_encode(['error' => 'Erro na consulta ao banco de dados: ' . $e->getMessage()]);
} catch (Exception $e) {
    // Retorna outros erros gerais como JSON
    echo json_encode(['error' => 'Erro: ' . $e->getMessage()]);
}

?>
