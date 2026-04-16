<?php
require 'conexao.php';

// Consulta para buscar todos os arquivos
$sql = "SELECT id, nome_arquivo, LENGTH(dados_arquivo) AS tamanho_arquivo FROM arquivos";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    echo "<table class='tabela-arquivos centralizada' border='1'>
            <tr>
                <th>Nome do Arquivo</th>
                <th>Tamanho</th>
                <th>Ação</th>
            </tr>";
    // Listar cada arquivo
    while ($row = $result->fetch_assoc()) {

        // Determina o tamanho do arquivo em MB ou KB
        if ($row['tamanho_arquivo'] >= 1024 * 1024) {
            // Convertendo para MB
            $tamanho = $row['tamanho_arquivo'] / (1024 * 1024);
            $tamanhoFormatado = number_format($tamanho, 2) . " MB";
        } else {
            // Convertendo para KB
            $tamanho = $row['tamanho_arquivo'] / 1024;
            $tamanhoFormatado = number_format($tamanho, 2) . " KB";
        }

        echo "<tr>
                <td>" . htmlspecialchars($row['nome_arquivo']) . "</td>
                <td>" . htmlspecialchars($tamanhoFormatado) . "</td>
                <td id='tdBx' ><a href='../php/download.php?id=" . $row['id'] . "'><button id='BaixarBtn' >Baixar</button></a></td>
              </tr>";
    }
    echo "</table>";
} else {
    echo "<p>Nenhum arquivo encontrado.</p>";
}
?>
