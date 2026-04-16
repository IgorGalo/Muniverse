<?php
// Incluir a conexão com o banco de dados
include_once '../php/conexao.php';

// Verificar se o parâmetro 'id' foi passado na URL
if (isset($_GET['id'])) {
    $id_edicao = $_GET['id']; // Captura o valor de 'id' da URL
} else {
    echo "ID da edição não fornecido!";
    exit();
}
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../formatacao.css">
    <link rel="stylesheet" href="../css/mobile.css">
    <link rel="stylesheet" href="../css/menu.css">
    <script src="../script/scriptGeral.js"></script>
    <title>Comitê</title>
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
    ?>

    <div id="divcentro">
        <div id="divdentro">
            <h2 class="titulo">COMITÊ</h2>

            <!-- Redirecionamento via JavaScript -->
            <button id="btnsessao" class="btnsessao">Iniciar Sessão</button>

            <div style="text-align: center;">
                <!-- Formulário para upload de arquivo -->
                <form action="../php/upload.php?id=<?php echo $id_edicao; ?>" method="POST" enctype="multipart/form-data" style="display: flex; justify-content: center; align-items: center; gap: 1rem;">
                    <input type="file" name="arquivo" required>
                    <input id="BtnEnvio" type="submit" value="Enviar Arquivo">
                </form>
                <hr><br>

                <!-- Lista de arquivos disponíveis para download -->
                <h2>Arquivos Disponíveis para Download</h2>
                <div id="listaArquivos">
                    <!-- Conteúdo será carregado dinamicamente -->
                </div>
            </div>
        </div>
    </div>

    <script>
        // Redireciona ao clicar no botão "Iniciar Sessão"
        document.getElementById('btnsessao').addEventListener('click', function() {
            const idEdicao = "<?php echo $id_edicao; ?>";
            window.location.href = `sessao.php?id=${idEdicao}`;
        });

        // Função para carregar arquivos
        function carregarArquivos() {
            fetch(`../php/listar_arquivos.php?id=<?php echo $id_edicao; ?>`)
                .then(response => {
                    if (!response.ok) {
                        throw new Error('Erro ao carregar os arquivos');
                    }
                    return response.text(); // Obtém o conteúdo como texto
                })
                .then(data => {
                    document.getElementById('listaArquivos').innerHTML = data; // Insere o conteúdo no div
                })
                .catch(error => {
                    console.error('Erro:', error);
                    document.getElementById('listaArquivos').innerHTML = 'Erro ao carregar arquivos.';
                });
        }

        // Carrega os arquivos assim que a página é carregada
        document.addEventListener('DOMContentLoaded', carregarArquivos);

        // Alerta de sucesso no upload
        const urlParams = new URLSearchParams(window.location.search);
        if (urlParams.has('upload') && urlParams.get('upload') === 'sucesso') {
            alert("Arquivo enviado e salvo com sucesso!");
            carregarArquivos(); // Atualiza a lista após o upload
        }
    </script>
</body>

</html>
