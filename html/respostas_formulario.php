<!DOCTYPE html>
<html lang="en">

<head>
<meta charset="UTF-8">
<meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../formatacao.css">
    <link rel="stylesheet" href="../css/sessao.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.3/font/bootstrap-icons.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="../script/scriptGeral.js"></script>
    <script src="../script/scriptTimer.js"></script>
    <link rel="stylesheet" href="../css/menu.css">
    <title>Document</title>
    <style>

.central {
    display: flex;
    justify-content: center; /* Centraliza a div horizontalmente */
    align-items: center; /* Centraliza a div verticalmente */
}
.container {
    max-width: 400px;
    width: 100%;
    padding: 20px;
    background-color: #ffffff;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    border-radius: 8px;
    text-align: center; /* Garante que os elementos dentro da div sejam centralizados */
    display: flex;
    flex-direction: column; /* Organiza os itens verticalmente */
    align-items: center; /* Centraliza os radio buttons horizontalmente */
}

h2 {
    text-align: center;
    color: #333;
}

label {
    display: block;
    margin-top: 10px;
    color: #555;
}

input[type="radio"] {
    display: inline-block;
    margin-right: 10px; /* Ajuste o espaçamento entre os radio buttons */
}

input[type="text"],
input[type="email"],
input[type="password"],
input[type="tel"],
select,
textarea {
    width: 100%;
    padding: 10px;
    margin-top: 5px;
    border: 1px solid #ccc;
    border-radius: 4px;
    box-sizing: border-box;
}

textarea {
    resize: vertical;
}

.button-container {
    text-align: center;
    margin-top: 20px;
}

button {
    background-color: #4CAF50;
    color: white;
    padding: 10px 20px;
    border: none;
    border-radius: 4px;
    cursor: pointer;
}

button:hover {
    background-color: #45a049;
}

.terms {
    display: flex;
    align-items: center;
    justify-content: center; /* Centraliza os itens dentro da div */
    margin-top: 10px;
}

.terms input {
    margin-right: 5px;
}
</style>
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

<?php include_once '../php/menu.php'; 
include_once '../php/conexao.php';



if (isset($_GET['id'])) {
    // Obtém o valor do 'id'
    $id = $_GET['id'];

    // Exibe o ID
} else {
    echo "alert('Nenhum ID foi passado na URL.')";
}

if (isset($id)) {
    // Consulta SQL usando prepared statement
    $sql = "SELECT * FROM comite WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id); // 'i' indica que o parâmetro é um inteiro
    $stmt->execute();
    $result = $stmt->get_result();

    // Verifica se encontrou algum registro
    if ($result->num_rows > 0) {
        // Atribui os valores de cada coluna às variáveis
        while ($row = $result->fetch_assoc()) {
            $nome = $row['nome_comite'];
            $email = $row['email_comite'];
            $proposta = $row['proposta_comite'];
            $orgao = $row['orgao_comite'];
            $carater = $row['carater_comite'];
            $tema = $row['tema_comite'];
            $tipo = $row['tipo_comite'];
            $quando = $row['quando_comite'];
            $idioma = $row['idioma_comite'];
            $num_deleg = $row['num_deleg'];
            $questao = $row['questao_comite'];
            $motivacao_tema = $row['motivacao_tema'];
            $guia_comite = $row['guia_comite'];
            $decor_comite = $row['decor_comite'];
            $dossie_comite = $row['dossie_comite'];
        }
    } else {
        echo "alert('Nenhum registro encontrado para o ID edição $id.')";
    }

    $stmt->close();
} else {
    echo "alert('O ID não foi definido.')";
}
?>

<div class="central">
    <div class="container">

        <label for="nome"> <strong>Nome do Comitê</strong></label>
        <?php echo htmlspecialchars($nome); ?>

        <label for="email"> <strong>E-mail do Comitê</strong></label>
       <?php echo htmlspecialchars($email); ?>

        <label for="quantDire"><strong>Diretores que farão parte do comitê:</strong></label>
        <?php 
    include_once '../php/conexao.php';

    // Código para mostrar diretores
    $sql = "SELECT * FROM tb_diretor WHERE id_comite = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id); // 'i' indica que o parâmetro é um inteiro
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        // Processa cada linha de resultado
        while ($row = $result->fetch_assoc()) {
            echo "<div style='margin-bottom: 20px;'>";
            echo "" . htmlspecialchars($row['nome']) . "<br>";
            echo "<em>Idade:</em> " . htmlspecialchars($row['idade']) . "<br>";
            echo "<em>Contato:</em> " . htmlspecialchars($row['contato']) . "<br>";
            echo "<em>Instituição:</em> " . htmlspecialchars($row['instituicao']) . "<br>";
            echo "<em>Histórico:</em> " . htmlspecialchars($row['historico']) . "<br>";
            echo "<em>Motivação:</em> " . htmlspecialchars($row['motivacao']) . "<br>";
            echo "</div>";
            // Linha preta para separar os diretores
            echo "<hr>";
        }
    } else {
        echo "Nenhum diretor encontrado.";
    }
?>



        <div id="questions-container"></div>

        <label for="proposta"><strong>Proposta mais ornamentada e estruturada em PDF sobre Comitê.</strong></label>
<?php if (!empty($proposta)) : ?>
    <a href="../php/download_proposta.php?id=<?php echo htmlspecialchars($id); ?>" target="_blank">Baixar Proposta</a>
<?php else : ?>
    <span>Proposta não disponível.</span>
<?php endif; ?>


        <br>
        <label for="orgao"><strong>Órgão do Comitê:</strong>
            Ex.: UNESCO, CPI, CSNU, etc.</label>
        <?php echo htmlspecialchars($orgao); ?>

            <label>
                <strong>Caráter do Comitê:</strong>
                <br>
                <?php echo htmlspecialchars($carater); ?>

        <label for="tema"><strong>Tema do Comitê:</strong></label>
        <?php echo htmlspecialchars($tema); ?>

            <label>
                <strong>Tipo de Comitê:</strong>
                <br>
                <?php echo htmlspecialchars($tipo); ?>


        <label for="quando"><strong>Periodicidade do Comitê:</strong></label>
       <?php echo htmlspecialchars($quando); ?>

        <label for="idioma"><strong>Idioma do Comitê:</strong></label>
       <?php echo htmlspecialchars($idioma); ?>

        <label for="numDelegados"><strong>Número de Delegados do Comitê:</strong></label>
       <?php echo htmlspecialchars($num_deleg); ?>

        <label for="questao"><strong>Questão Abordada pelo Comitê:</strong></label>
       <?php echo htmlspecialchars($questao); ?>

        <label for="motivacao"><strong>Motivação por Trás do Tema:</strong></label>
        <?php echo htmlspecialchars($motivacao_tema); ?>

        <label for="guia"><strong>A Mesa se dispõe a realizar o Guia de Estudos ao longo do ano, entregando ao Secretariado com antecedência?</strong></label>
      <?php echo htmlspecialchars($guia_comite); ?>

        <label for="decor"><strong>A Mesa se dispõe a realizar a decoração da sala do Comitê?</strong></label>
        <?php echo htmlspecialchars($decor_comite); ?>

        <label for="dossie"><strong>Se for preciso, a Mesa se dispõe a realizar Dossiês para o Comitê?</strong></label>
       <?php echo htmlspecialchars($dossie_comite); ?>
    </div>
</div>

</body>

</html>