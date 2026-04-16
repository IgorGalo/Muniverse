<?php 
// Inclui o arquivo de conexão
include_once 'conexao.php';
session_start();

// Verifique se o formulário foi enviado
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $user_id = $_SESSION['user_id'];
    
    echo "<script>alert('id_usuario: " . $user_id . "');</script>";

        $restricoes = $_POST['restricao'] ?? []; // Obtém os valores dos checkboxes marcados
    $outro = trim($_POST['outro_restricao'] ?? ''); // Obtém o valor do campo de texto "Outro"

    // Adiciona o valor de "Outro" ao array de restrições, se não estiver vazio
    if (!empty($outro)) {
        $restricoes[] = $outro;
    }

    if (!empty($restricoes)) {
        $restricoesString = implode(', ', $restricoes);
    } else {
        echo "<script>alert('Nenhuma restrição selecionada.');</script>";
    }

    $historico = $conn->real_escape_string($_POST['historico']);

$turma = isset($_POST['turma']) ? $_POST['turma'] : null;

if ($turma === "Nenhuma") {
    $instituicao = isset($_POST['nenhuma_input']) && !empty(trim($_POST['nenhuma_input'])) ? trim($_POST['nenhuma_input']) : 'Instituição não informada';
} else {
    $instituicao = $turma;
}


$primeira_op = $_POST['primeira-opcao'] ?? 'nenhuma';;
$segunda_op = $_POST['segunda-opcao'] ?? 'nenhuma';;
$terceira_op = $_POST['terceira-opcao'] ?? 'nenhuma';;

$primeira_rep = $_POST['primeiraRep'] ?? 'nenhuma';
$segunda_rep = $_POST['segundaRep'] ?? 'nenhuma';
$terceira_rep = $_POST['terceiraRep'] ?? 'nenhuma';


    // Insere os dados no banco de dados
    $sql = "INSERT INTO tb_delegado (
        id_usuario, restricoes, historico, instituicao, 
        primeira_op_comite, segunda_op_comite, terceira_op_comite,
        primeira_op_rep, segunda_op_rep, terceira_op_rep, aprovacao
    ) 
    VALUES (
        '$user_id', '$restricoesString', '$historico', '$instituicao', 
        '$primeira_op', '$segunda_op', '$terceira_op',
        '$primeira_rep', '$segunda_rep', '$terceira_rep', '0'
    )";
    if ($conn->query($sql) === TRUE) {
        echo "<script>
                window.location.href = '../index.php';
              </script>";
    } else {
        echo "<script>alert('Erro ao inserir os dados iniciais.');</script>";
        echo "Erro na consulta SQL: $sql<br>";
        echo "Erro do MySQL: " . $conn->error . "<br>";
        logErro("Erro na consulta SQL: $sql - Erro do MySQL: " . $conn->error);
    }

    // Fecha a conexão
    $conn->close();
}
?>