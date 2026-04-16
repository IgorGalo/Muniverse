<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../formatacao.css">
    <link rel="stylesheet" href="../css/mobile.css">
    <link rel="stylesheet" href="../css/menu.css">
    <script src="../script/scriptGeral.js"></script>
    <title>Envio de arquivos para o banco</title>
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
            <div style="text-align: center;">
            <!-- Formulário para upload de arquivo -->
            <form action="../php/upload.php" method="POST" enctype="multipart/form-data">
                <br>
                <input type="file" name="arquivo" required>
                <br><br>
                <input id="BtnEnvio" type="submit" value="Enviar Arquivo">
            
            </form>

            <hr><br>

            <!-- Lista de arquivos disponíveis para download -->
            <h2>Arquivos Disponíveis para Download</h2>
            <div id="listaArquivos">
                <!-- A lista de arquivos será carregada aqui -->
            </div>
        </div>
            <script>
                // Função para carregar arquivos
                function carregarArquivos() {
                    fetch('../php/listar_arquivos.php')
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
            </script>
            
        </div>
    </div>

    <script>
        const urlParams = new URLSearchParams(window.location.search);
        if (urlParams.has('upload') && urlParams.get('upload') === 'sucesso') {
            alert("Arquivo enviado e salvo com sucesso!");
        }
    </script>

</body>
</html>
