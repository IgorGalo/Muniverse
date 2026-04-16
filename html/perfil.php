<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../formatacao.css">
    <link rel="stylesheet" href="../css/mobile.css">
    <link rel="stylesheet" href="../css/index.css">
    <link rel="stylesheet" href="../css/menu.css">
    <script src="../script/scriptGeral.js"></script>
    <title>Perfil</title>

    
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
    <?php
    include_once '../php/menu.php';
    session_start();

    // Obter o ID do usuário da sessão
    $id_user = $_SESSION['user_id'];

    // Conexão com o banco de dados
    include_once '../php/conexao.php';

    // Consulta para obter os dados do usuário
    $query = "SELECT 
    u.foto, 
    u.nome AS nome, 
    u.data_nasc, 
    td.id_representacao, 
    r.nome_representacao AS representacao, 
    c.nome_comite AS comite
 FROM 
    usuario u
 LEFT JOIN 
    tb_delegado td ON u.id = td.id_usuario
 LEFT JOIN 
    comite c ON td.id_comite = c.id
 LEFT JOIN 
    representacoes r ON td.id_representacao = r.id_representacoes
 WHERE 
    u.id = ?";

    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $id_user);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();
    ?>
        <div class="divcentro">
    <div class="perfil">
        <div class="perfil-conteudo">
            <div class="perfil-foto">
                <img class="foto-perfil" src="../uploads/<?php echo htmlspecialchars($user['foto']); ?>" alt="Foto do Usuário">
            </div>
            <div class="perfil-info">
                <h1><?php echo htmlspecialchars($user['nome']); ?></h1>
                <p><strong>Data de Nascimento:</strong> 
                    <?php
                    $data_nasc = new DateTime($user['data_nasc']);
                    echo $data_nasc->format('d/m/Y');
                    ?>
                </p>
                <p><strong>Comitê:</strong> <?php echo htmlspecialchars($user['comite']); ?></p>
                <p><strong>Representação:</strong> <?php echo htmlspecialchars($user['representacao']); ?></p>
            </div>
        </div>
    </div>
</div>

    <?php
    } else {
        echo "<div id='divcentro'><p>Usuário não encontrado.</p></div>";
    }

    $stmt->close();
    $conn->close();



    ?>

</body>

</html>