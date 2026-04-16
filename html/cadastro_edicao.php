<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../formatacao.css">
    <link rel="stylesheet" href="../css/sessao.css">
    <script src="../script/scriptGeral.js"></script>
    <script src="../script/scriptTimer.js"></script>
    <link rel="stylesheet" href="../css/menu.css">
    <style>
        .date-group {
            display: flex;
            gap: 10px;
            align-items: center;
        }

        .date-group label {
            white-space: nowrap;
        }

        .date-group input {
            width: auto;
        }
    </style>
    <title>Cadastrar Edição - Muniverse</title>
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

    <div id="divcentro">
        <div id="divdentro">
            <h2 style="text-align: center;">Cadastro de Edição</h2>
            <form action="../php/cad_edicao.php" method="POST" enctype="multipart/form-data">
                <label for="nome_edicao">Nome da Edição:</label><br>
                <input type="text" id="nome_edicao" name="nome_edicao" required><br><br>

                <label for="descricao">Descrição:</label><br>
                <textarea class="textdesc" id="descricao" name="descricao" required></textarea><br><br>

                <label for="foto">Foto da Capa:</label><br>
                <input type="file" id="foto" name="foto" accept="image/*"><br><br>

                <label for="fundo">Foto do Fundo:</label><br>
                <input type="file" id="fundo" name="fundo" accept="image/*"><br><br>

                <div class="date-group">
                    <label for="data_inicio">Início do Evento:</label>
                    <input type="date" id="data_inicio" name="data_inicio" required>
                    <label for="data_fim">Fim do Evento:</label>
                    <input type="date" id="data_fim" name="data_fim" required>
                </div>
                <br>

                <div class="date-group">
                    <label for="inicio_mesa">Início da Inscrição de Mesa:</label>
                    <input type="date" id="inicio_mesa" name="inicio_mesa" required>
                    <label for="fim_mesa">Fim da Inscrição de Mesa:</label>
                    <input type="date" id="fim_mesa" name="fim_mesa" required>
                </div>
                <br>

                <div class="date-group">
                    <label for="inicio_deleg">Início da Inscrição de Delegado:</label>
                    <input type="date" id="inicio_deleg" name="inicio_deleg" required>
                    <label for="fim_deleg">Fim da Inscrição de Delegado:</label>
                    <input type="date" id="fim_deleg" name="fim_deleg" required>
                </div>
                <br>
                
                <br>

                <div style="text-align: center;">
                    <input type="submit" value="Salvar Edição"><br><br><br>
                </div>
            </form>
        </div>
    </div>
</body>

</html>
