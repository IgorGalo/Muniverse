<?php
// Inclua o arquivo de conexão com o banco de dados
include 'conexao.php';

// Verifique a conexão
if ($conn->connect_error) {
    die("Falha na conexão: " . $conn->connect_error);
}

// Execute uma consulta para obter todas as linhas da tabela `edicao`
$sql = "SELECT * FROM edicao";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    // Para cada linha encontrada, cria um container
    while ($row = $result->fetch_assoc()) {
        // Verifica se a foto existe e usa o caminho no banco de dados
        $foto = isset($row['foto_edicao']) ? 'data:image/jpeg;base64,' . base64_encode($row['foto_edicao']) : 'image/semIMG.png';
        $nomeEdicao = isset($row['nome']) ? $row['nome'] : 'Nome não disponível'; // Nome da edição
        $id_edicao = $row['id']; // Supondo que o id da edição esteja disponível na variável $row

        echo '
        <div class="container">
    <div class="image-frame">
        <a href="html/edicoes.php?id=' . $id_edicao . '"><img id="userImage" src="' . $foto . '" alt="Imagem do Usuário"></a>
    </div>
    <h1>' . $nomeEdicao . '</h1>
</div>';
    }
} else {
    // Mostra mensagem de log no console
    echo '<script>console.log("Nenhum registro encontrado.")</script>';
}

// Feche a conexão
$conn->close();
?>
