<?php
// Definindo os parâmetros de conexão com o banco de dados
$host = '127.0.0.1';
$user = 'muniverse';
$password = '_}+b6yxj^F';
$database = 'muniverse_db';

// Conexão com o banco de dados
$conn = new mysqli($host, $user, $password, $database);

// Verificando se a conexão foi bem-sucedida
if ($conn->connect_error) {
    die("Falha na conexão: " . $conn->connect_error);
}

// Função para pegar os nomes dos delegados e as opções
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['action']) && $_POST['action'] == 'get_delegados') {
    $id_comite = $_POST['id_comite'];

    // Consulta para pegar os nomes dos delegados e as opções
    $sql = "
    SELECT u.nome, d.id_representacao, d.primeira_op_rep, d.segunda_op_rep, d.terceira_op_rep 
    FROM usuario u 
    JOIN tb_delegado d ON u.id = d.id_usuario 
    WHERE d.id_comite = ?
    ORDER BY u.nome ASC";

    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id_comite);
    $stmt->execute();
    $result = $stmt->get_result();

    $delegados = [];
    while ($row = $result->fetch_assoc()) {
        $delegados[] = [
            'nome' => $row['nome'],
            'id_representacao' => $row['id_representacao'],
            'primeira_op_rep' => $row['primeira_op_rep'],
            'segunda_op_rep' => $row['segunda_op_rep'],
            'terceira_op_rep' => $row['terceira_op_rep']
        ];
    }

    // Agora pegamos as representações cadastradas para o comitê
    $sql_representacoes = "SELECT id_representacoes, nome_representacao FROM representacoes WHERE id_comite = ?";
    $stmt_representacoes = $conn->prepare($sql_representacoes);
    $stmt_representacoes->bind_param("i", $id_comite);
    $stmt_representacoes->execute();
    $result_representacoes = $stmt_representacoes->get_result();

    $representacoes = [];
    while ($row = $result_representacoes->fetch_assoc()) {
        $representacoes[] = $row;
    }

    // Retorna os delegados e representações como JSON
    echo json_encode(['delegados' => $delegados, 'representacoes' => $representacoes]);
    exit;
}

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['action']) && $_POST['action'] == 'save_representacoes') {
    // Pega os dados dos delegados enviados via POST
    $delegados = $_POST['delegados'];

    foreach ($delegados as $delegado) {
        $id_representacao = $delegado['id_representacao'];
        $nome = $delegado['nome'];

        // Atualiza a tabela tb_delegado com a representação escolhida
        $sql = "UPDATE tb_delegado 
                SET id_representacao = ? 
                WHERE id_usuario = (SELECT id FROM usuario WHERE nome = ? LIMIT 1)";

        $stmt = $conn->prepare($sql);

        // Verifica se a consulta foi preparada corretamente
        if ($stmt === false) {
            error_log('Erro na preparação da consulta: ' . $conn->error);
            die(json_encode(['error' => 'Erro na preparação da consulta']));
        }

        $stmt->bind_param('is', $id_representacao, $nome);
        $stmt->execute();

        // Verifica se a execução da consulta foi bem-sucedida
        if ($stmt->affected_rows === 0) {
            error_log("Nenhuma linha foi atualizada para nome: $nome com id_representacao: $id_representacao");
        } else {
            error_log("Atualização bem-sucedida para nome: $nome com id_representacao: $id_representacao");
        }
    }

    // Retorna uma resposta de sucesso
    echo json_encode(['message' => 'Representações salvas com sucesso!']);
    exit;
}

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
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <title>Gerenciar Comitês e Delegados</title>
    <style>
        table {
            width: 80%;
            border-collapse: collapse;
            margin: 5rem auto;
            background-color: #C1D9E1;
        }

        th,
        td {
            border: 1px solid #006270;
            padding: 8px;
            text-align: center;
        }

        th {
            background-color: #006270;
            color: #C1D9E1;
            font-weight: bold;
            font-size: 1.5rem;
        }

        tr:nth-child(even) {
            background-color: #C1D9E1;
        }

        tr:nth-child(odd) {
            background-color: #C1D9E1;
        }

        .nome-delegado,
        .opcao {
            font-weight: bold;
            background-color: #C1D9E1;
            padding: 8px;
            text-align: left;
        }

        .comite-select {
            width: 15rem;
            padding: 1rem;
            font-size: 14px;
            border: 1px solid #006270;
            background-color: #006270;
            height: 36px;
            box-sizing: border-box;
        }

        .comite-select option {
            padding: 1rem;
        }

        .tabdel {
            margin-top: 5rem;
            /* Reduzi para aproximar os elementos */
            border-radius: 5rem;
        }


        /* Estilo para os botões */
        .buttons-container {
            text-align: center;
            margin-top: -3rem;
        }

        .btn {
            background-color: #006270;
            color: #C1D9E1;
            padding: 10px 20px;
            font-size: 1.2rem;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            margin: 0 10px;
        }

        .btn:hover {
            background-color: #004f59;
        }
    </style>

    <script>
        $(document).ready(function() {
            const urlParams = new URLSearchParams(window.location.search);
            const id_comite = urlParams.get('id');

            if (id_comite) {
                carregarDelegados(id_comite);
            } else {
                alert('ID da edição não encontrado na URL');
            }

            function carregarDelegados(id_comite) {
                $.ajax({
                    url: '',
                    type: 'POST',
                    data: {
                        action: 'get_delegados',
                        id_comite: id_comite
                    },
                    dataType: 'json',
                    success: function(data) {
                        let tableBody = $('#delegadosTable tbody');
                        tableBody.empty();

                        if (data.delegados.length > 0) {
                            data.delegados.forEach((delegado) => {
                                tableBody.append(
                                    `<tr>
                            <td>${delegado.nome}</td>
                            <td>${delegado.primeira_op_rep || '-'}</td>
                            <td>${delegado.segunda_op_rep || '-'}</td>
                            <td>${delegado.terceira_op_rep || '-'}</td>
                            <td>
                                <select class="representacao-select" data-nome="${delegado.nome}">
                                <option value="" disabled selected hidden>Escolha uma representação</option>
                                    ${data.representacoes.map(representacao => 
                                        `<option value="${representacao.id_representacoes}" 
                                            ${representacao.id_representacoes == delegado.id_representacao ? 'selected' : ''}>
                                            ${representacao.nome_representacao}
                                        </option>`).join('')}
                                </select>
                            </td>
                        </tr>`
                                );
                            });
                            $('.representacao-select').select2();
                        } else {
                            tableBody.append('<tr><td colspan="5">Nenhum delegado encontrado para esta edição.</td></tr>');
                        }
                    },
                    error: function(xhr, status, error) {
                        console.error('Erro ao carregar delegados:', error);
                    }
                });
            }

            $('#salvar').on('click', function() {
                console.log('Botão Salvar clicado');
                const delegados = [];
                let hasError = false;

                $('#delegadosTable .representacao-select').each(function() {
                    const nome = $(this).data('nome');
                    const id_representacao = $(this).val();

                    if (!id_representacao) {
                        hasError = true;
                        alert(`Por favor, selecione uma representação para o delegado: ${nome}`);
                        return false; // Interrompe o loop
                    }

                    delegados.push({
                        nome,
                        id_representacao
                    });
                });

                if (hasError) return;

                $.ajax({
                    url: '',
                    type: 'POST',
                    data: {
                        action: 'save_representacoes',
                        delegados: delegados
                    },
                    success: function(response) {
                        alert('Representações salvas com sucesso!');
                    },
                    error: function(xhr, status, error) {
                        console.error('Erro ao salvar representações:', error);
                    }
                });
            });
        });
    </script>
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

    <!-- Tabela de Delegados -->
    <table id="delegadosTable" class="tabdel">
        <thead>
            <tr>
                <th>Nome do Delegado</th>
                <th>1ª Opção</th>
                <th>2ª Opção</th>
                <th>3ª Opção</th>
                <th>Representação</th>
            </tr>
        </thead>
        <tbody>
            <!-- Delegados serão carregados aqui -->
        </tbody>
    </table>

    <!-- Botões de ação -->
    <div class="buttons-container">
        <button id="salvar" class="btn">Salvar</button>
    </div>
</body>

</html>