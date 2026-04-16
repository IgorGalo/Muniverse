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
    <title>MUNIVERSE - Solicitação de Comitê</title>
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

    <div id="divcentro" style="display: block;">
        <h2 class="titulo">Solicitação de Comitê</h2>
        <div id="comite-list">
            <?php
            include_once '../php/conexao.php';


            // Consultando os comitês com aprovacao = 0
            $sql = "SELECT id, nome_comite FROM comite WHERE aprovacao = 0";
            $result = $conn->query($sql);

            // Listando os comitês
            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    echo "
                    <div class='comite-item' id='comite-" . $row['id'] . "'>
                        <h3>
                            <a class='comite-link' href='respostas_formulario.php?id=" . $row['id'] . "'>
                                " . htmlspecialchars($row['nome_comite']) . "
                            </a>
                        </h3>
                        <div class='botoes'>
                            <button class='aprovar' onclick='aprovarComite(" . $row['id'] . ")'>Aprovar</button>
                            <button class='recusar' onclick='recusarComite(" . $row['id'] . ")'>Recusar</button>
                        </div>
                    </div>";
                }
            } else {
                echo "<p>Nenhum comitê inscrito encontrado.</p>";
            }

            // Fechando a conexão
            $conn->close();
            ?>
        </div>
    </div>

</body>

</html>