<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../formatacao.css">
    <link rel="stylesheet" href="../css/menu.css">

    <title>Edição XXX - Muniverse</title>
</head>

<body>
    <div id="barrinha">
        <img id="logoNaDireita" src="../image/logoBarra2.png" alt="logo">
    </div>

    <input type="checkbox" style="display: none;" id="check">
    <label for="check">

        <div class="menu">
            <span class="hamburguer"></span>
        </div>
    </label>

    <?php
    include_once '../php/menu.php';
    ?>

</body>

</html>