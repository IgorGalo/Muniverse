<?php
// Incluir a conexão com o banco de dados
include '../php/conexao.php';

// Inicializar variáveis
$error_message = null;
$inscricaomesa_ativa = false;
$inscricaodeleg_ativa = false;

// Verificar se o parâmetro 'id' foi passado na URL
if (isset($_GET['id'])) {
    $id_edicao = (int)$_GET['id']; // Captura o ID da URL e garante que é um número inteiro

    // Preparar a consulta para buscar a edição pelo ID
    $sql = "SELECT nome, foto_fundo, data_inicio, data_fim, descricao, inicio_mesa, fim_mesa, inicio_deleg, fim_deleg FROM edicao WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id_edicao);
    $stmt->execute();
    $stmt->store_result();

    // Verificar se encontrou a edição
    if ($stmt->num_rows > 0) {
        $stmt->bind_result($nome, $foto_edicao, $data_inicio, $data_fim, $descricao, $mesa_inicio, $mesa_fim, $deleg_inicio, $deleg_fim);
        $stmt->fetch();

        // Obter a data atual
        $data_atual = date('Y-m-d');

        // Verificar se a data atual está entre as datas de inscrição de mesa e delegado
        $inscricaomesa_ativa = ($data_atual >= $mesa_inicio && $data_atual <= $mesa_fim);
        $inscricaodeleg_ativa = ($data_atual >= $deleg_inicio && $data_atual <= $deleg_fim);

        // Gerar caminho para a imagem ou usar imagem padrão
        $foto = !empty($foto_edicao) ? 'data:image/jpeg;base64,' . base64_encode($foto_edicao) : '../image/semIMG.png';
    } else {
        $error_message = "Edição não encontrada!";
    }

    $stmt->close();

    // Consultar os comitês da edição
    $sql_comites = "SELECT id, nome_comite, descricao, carater_comite, orgao_comite, tema_comite, foto_comite 
    FROM comite 
    WHERE id_edicao = ? AND aprovacao = 1";
    $stmt_comites = $conn->prepare($sql_comites);
    $stmt_comites->bind_param("i", $id_edicao);
    $stmt_comites->execute();
    $result_comites = $stmt_comites->get_result();
} else {
    $error_message = "ID da edição não fornecido!";
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../formatacao.css">
    <link rel="stylesheet" href="../css/mobile.css">
    <link rel="stylesheet" href="../css/index.css">
    <link rel="stylesheet" href="../css/menu.css">
    <title>Edição</title>
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

    <div id="desc-edicao">
        <?php if (isset($error_message)): ?>
            <div class="error-message"><?php echo $error_message; ?></div>
        <?php else: ?>
            <div class="edicao-details">
                <img src="<?php echo $foto; ?>" alt="Foto da Edição" class="edicao-image">
                <div class="edicao-info">
                    <h2 class="nome-edicao"><?php echo htmlspecialchars($nome); ?></h2>
                    <p><strong>Descrição:</strong> <?php echo nl2br(htmlspecialchars($descricao)); ?></p>
                    <p class="nome-edicao"><strong>Início:</strong> <?php echo date('d/m/Y', strtotime($data_inicio)); ?> <strong>Fim:</strong> <?php echo date('d/m/Y', strtotime($data_fim)); ?></p>
                </div>
            </div>
            <!-- Links de Inscrição -->
            <div class="inscricao-links">
                <?php if ($inscricaomesa_ativa): ?>
                    <a href="inscricao_mesa.php?id=<?php echo $id_edicao; ?>" class="botao-inscricao botao-inscricao-mesa">Inscrição de Mesa</a>
                <?php else: ?>
                    <p>Inscrições de Mesa: de <?php echo date('d/m/Y', strtotime($mesa_inicio)); ?> até <?php echo date('d/m/Y', strtotime($mesa_fim)); ?>.</p>
                <?php endif; ?>
                <?php if ($inscricaodeleg_ativa):?>
                    <a href="inscricao_delegado.php?id=<?php echo $id_edicao; ?>" class="botao-inscricao">Inscrição de Delegado</a>
                <?php else: ?>
                    <p>Inscrições de Delegado: de <?php echo date('d/m/Y', strtotime($deleg_inicio)); ?> até <?php echo date('d/m/Y', strtotime($deleg_fim)); ?>.</p>
                <?php endif;?>
            </div>
            <!-- Link Designar Comitê -->
            <?php if (strtotime($data_atual) < strtotime($data_inicio)): ?>
                <a href="designa_comite.php?id=<?php echo $id_edicao; ?>" class="botao-inscricao">Designar Comitê</a>
            <?php endif; ?>
        <?php endif; ?>
    </div>

    <div id="desc-edicao">
        <!-- Listagem dos Comitês -->
        <?php if ($result_comites->num_rows > 0): ?>
            <?php while ($row_comite = $result_comites->fetch_assoc()):
                // Recuperar a foto_comite do banco de dados como dados binários
                $foto_comite = $row_comite['foto_comite'];

                // Verificar se a foto_comite não está vazia
                if (!empty($foto_comite)) {
                    // Codificar os dados binários em base64
                    $foto_comite = 'data:image/jpeg;base64,' . base64_encode($foto_comite);
                } else {
                    // Caso não haja imagem, usar uma imagem padrão
                    $foto_comite = '../image/semIMG.png';
                }
            ?>
                <br>
                <img src="<?php echo htmlspecialchars($foto_comite); ?>" alt="Foto do Comitê" class="comite-image">
                <p style="text-align: center;"><?php echo htmlspecialchars($row_comite['orgao_comite']) . ' - ' . htmlspecialchars($row_comite['nome_comite']); ?></p>
                <p style="text-align: center;"><?php echo htmlspecialchars($row_comite['tema_comite']); ?></p>
                <br>
                <p><strong>Descrição:</strong> <?php echo nl2br(htmlspecialchars($row_comite['descricao'])); ?></p>

                <!-- Link para acessar o Comitê -->
                <a href="comite.php?id=<?php echo $row_comite['id']; ?>" class="botao-inscricao">Acessar Comitê</a>

                <!-- Link para designar delegado -->
                <a href="designa_deleg.php?id=<?php echo $row_comite['id']; ?>" class="botao-inscricao">Designar Delegado</a>
                <br>
            <?php endwhile; ?>
        <?php else: ?>
            <p>Nenhum comitê pendente de aprovação.</p>
        <?php endif; ?>
    </div>

    <script src="../script/scriptGeral.js"></script>
    <br><br><br><br>
</body>

</html>