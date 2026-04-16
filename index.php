<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="formatacao.css">
    <link rel="stylesheet" href="css/mobile.css">
    <link rel="stylesheet" href="css/index.css">
    <link rel="stylesheet" href="css/menu.css">

    <title>Muniverse - Inicio</title>
</head>
<body>
    <div id="barrinha">
        <img id="logoNaDireita" src="image/logoBarra2.png" alt="logo">
    </div>

    <input type="checkbox" id="check">
    <label for="check">
        <div class="menu">
            <span class="hamburguer"></span>
        </div>
    </label>

    <?php
    include_once 'php/menu.php';
    ?>

    <div id="divinicial">
    <?php
        // Inclui o conteúdo dinâmico gerado pelo arquivo edicoes.php
        include_once 'php/get_edicoes.php';
        ?>

        <div class="container">
            <div class="image-frame">
                <a href="html/cadastro_edicao.php"><img src="image/addedicao.png" alt="Imagem de Edição do Usuário"></a>
            </div>
            <h1>Adicionar Nova Edição</h1>
        </div>
    </div>

    <script src="script/scriptGeral.js"></script>
    
</body>
</html>
