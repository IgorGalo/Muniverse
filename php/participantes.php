<?php
include_once 'conexao.php';


// Consulta SQL para buscar os nomes dos usuários
$sql = "SELECT nome FROM usuario";
$result = $conn->query($sql);

// Verificar se a consulta retornou resultados
if ($result->num_rows > 0) {
    // Loop para exibir cada nome como um item de lista
    while ($row = $result->fetch_assoc()) {
        echo "<li>" . htmlspecialchars($row["nome"]) . "</li>";
    }
} else {
    // Caso não haja resultados
    echo "<li>Nenhum usuário encontrado</li>";
}
