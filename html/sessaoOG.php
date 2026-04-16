<?php
include_once '../php/conexao.php';

// Verificar se o parâmetro 'id' foi passado na URL
if (isset($_GET['id'])) {
    $id_comite = (int)$_GET['id']; // Captura o ID do comitê da URL e garante que é um número inteiro

    // Consulta SQL para buscar os nomes dos delegados associados ao 'id_comite'
    $sql = "SELECT DISTINCT usuario.nome, usuario.foto
    FROM tb_delegado 
    INNER JOIN usuario ON tb_delegado.id_usuario = usuario.id 
    WHERE tb_delegado.id_comite = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id_comite);
    $stmt->execute();
    $result = $stmt->get_result();
} else {
    echo "ID do comitê não fornecido!";
    exit;
}

// Fechar a conexão
$conn->close();
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../formatacao.css">
    <link rel="stylesheet" href="../css/sessao.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.3/font/bootstrap-icons.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="../script/scriptGeral.js"></script>
    <script src="../script/scriptTimer.js"></script>
    <link rel="stylesheet" href="../css/menu.css">

    <title>Muniverse - Sessão</title>
</head>

<body>
    <div id="barrinha">
        <img id="logoNaDireita" src="../image/logoBarra2.png" alt="logo">
    </div>

    <input type="checkbox" id="check">
    <label for="check">
        <div class="menu">
            <span class="hamburguer"></span>
        </div>
    </label>

    <?php include_once '../php/menu.php'; ?>

    <div id="divtelasessao">
        <!--div 1-->
        <div id="divsessao">
            <div id="divdentrotimer">
                <div id="divtimer">
                    <div id="timer">01:00</div>
                </div>
                <br>
                <button id="buttonTimer" class="bi bi-chat-left-dots"></button>
                <button id="buttonTimerUp" class="bi bi-clock" onclick="popuptempo()"></button>
                <button id="buttonTimer" class="bi bi-arrow-clockwise" onclick="resetTimer()"></button>
                <button id="buttonTimer" class="bi bi-play" onclick="startTimer()"></button>
                <button id="buttonTimer" class="bi bi-pause" onclick="pauseTimer()"></button>

                <!-- O Modal -->
                <div id="timeModal" class="modal">
                    <div id="modal-content">
                        <span class="close">&times;</span>
                        <h2>Defina o tempo de fala</h2>
                        <br>
                        <input type="number" class="campoms" id="minutesInput" min="0" placeholder="Minutos">
                        <br><br>
                        <input type="number" class="campoms" id="secondsInput" min="0" max="59" placeholder="Segundos">
                        <br><br>
                        <button id="saveButton">Salvar</button>
                    </div>
                </div>

                <div>
                    <!-- Lista de orador atual -->
                    <div id="divnovorador">
                        <div class="orador-header">
                            <h2 class="titulosessao">Orador Atual</h2>
                            <button id="nextorador" onclick="moverOuLiberarOrador()" class="btn btn-secondary mt-3">Próximo Orador</button>
                        </div>

                        <ul id="listaOradores" class="list-group list-group-flush">
                            <!-- O orador atual aparecerá aqui -->
                        </ul>
                    </div>
                    
                    <!-- Lista de próximos oradores -->
                    <div id="divnovorador">
                        <h2 class="titulosessao" id="proxorador">Próximos Oradores</h2>
                        <ul id="listaProximosOradores" class="list-group list-group-flush">
                            <!-- Os próximos oradores aparecerão aqui -->
                        </ul>
                    </div>
                </div>

            </div>
        </div>
        <!--div-->
        <div id="divlista">
            <div id="divorador">
                <h2 class="titulosessao">Acrescentar Orador</h2>
                <div style="margin-top: 2rem; align-items: left;">
                    <ul id="listaAcrescentarOradores" class="list-group list-group-flush">
                        <?php
                        // Verificar se a consulta retornou resultados
                        if ($result->num_rows > 0) {
                            // Loop para exibir cada nome como um item de lista
                            while ($row = $result->fetch_assoc()) {
                                // Exibe o nome do banco de dados como item da lista
                                echo "<li id='listcss' class='list-group-item' onclick='adicionarOrador(\"" . htmlspecialchars($row["nome"]) . "\", this)'>" . htmlspecialchars($row["nome"]) . "</li>";
                            }
                        } else {
                            echo "<li id='listcss' class='list-group-item'>Nenhum orador encontrado</li>";
                        }
                        ?>
                    </ul>
                </div>
            </div>
        </div>

    </div>

</body>

</html>

