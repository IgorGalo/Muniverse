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
    $id_edicao = $_POST['id_edicao'];

    // Consulta para pegar os nomes dos delegados e as opções
    $sql = "
    SELECT u.nome, d.primeira_op_comite, d.segunda_op_comite, d.terceira_op_comite, d.id_comite
    FROM tb_delegado AS d
    INNER JOIN usuario AS u ON d.id_usuario = u.id
    WHERE d.id_edicao = ?
    ORDER BY u.nome ASC
";

    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id_edicao);
    $stmt->execute();
    $result = $stmt->get_result();

    $delegados = [];
    while ($row = $result->fetch_assoc()) {
        $delegados[] = [
            'nome' => $row['nome'],
            'primeira_op_comite' => $row['primeira_op_comite'],
            'segunda_op_comite' => $row['segunda_op_comite'],
            'terceira_op_comite' => $row['terceira_op_comite'],
            'id_comite' => $row['id_comite']
        ];
    }

    // Agora pegamos os comitês cadastrados para a edição
    $sql_comites = "SELECT id, nome_comite FROM comite WHERE id_edicao = ?";
    $stmt_comites = $conn->prepare($sql_comites);
    $stmt_comites->bind_param("i", $id_edicao);
    $stmt_comites->execute();
    $result_comites = $stmt_comites->get_result();

    $comites = [];
    while ($row = $result_comites->fetch_assoc()) {
        $comites[] = $row;
    }

    // Retorna os delegados e comitês como JSON
    echo json_encode(['delegados' => $delegados, 'comites' => $comites]);
    exit;
}

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['action']) && $_POST['action'] == 'save_comites') {
    $delegados = $_POST['delegados'];

    foreach ($delegados as $delegado) {
        $id_comite = $delegado['id_comite'];
        $nome = $delegado['nome'];

        $sql = "UPDATE tb_delegado 
                SET id_comite = ? 
                WHERE id_usuario = (SELECT id FROM usuario WHERE nome = ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param('is', $id_comite, $nome);
        $stmt->execute();
    }

    echo json_encode(['message' => 'Comitês salvos com sucesso!']);
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
            margin-top: 1rem;
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
            const id_edicao = urlParams.get('id');

            if (id_edicao) {
                carregarDelegados(id_edicao);
            } else {
                alert('ID da edição não encontrado na URL');
            }

            function carregarDelegados(id_edicao) {
                $.ajax({
                    url: '',
                    type: 'POST',
                    data: {
                        action: 'get_delegados',
                        id_edicao: id_edicao
                    },
                    dataType: 'json',
                    success: function(data) {
                        let tableBody = $('#delegadosTable tbody');
                        tableBody.empty();

                        if (data.delegados.length > 0) {
                            data.delegados.forEach((delegado) => {
                                tableBody.append(`
                                    <tr>
                                        <td>${delegado.nome}</td>
                                        <td>${delegado.primeira_op_comite}</td>
                                        <td>${delegado.segunda_op_comite}</td>
                                        <td>${delegado.terceira_op_comite}</td>
                                        <td>
                                            <select class="comite-select" data-nome="${delegado.nome}">
                                                <option value="" disabled selected hidden>Escolha uma representação</option>
                                                ${data.comites.map(comite => 
                                                    `<option value="${comite.id}" ${comite.id == delegado.id_comite ? 'selected' : ''}>${comite.nome_comite}</option>`
                                                ).join('')}
                                            </select>
                                        </td>
                                    </tr>
                                `);
                            });
                            $('.comite-select').select2();
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

                $('#delegadosTable .comite-select').each(function() {
                    const nome = $(this).data('nome');
                    const id_comite = $(this).val();

                    if (!id_comite) {
                        hasError = true;
                        alert(`Por favor, selecione uma representação para o delegado: ${nome}`);
                        return false; // Interrompe o loop
                    }

                    delegados.push({
                        nome,
                        id_comite
                    });
                });

                if (hasError) return;

                $.ajax({
                    url: '',
                    type: 'POST',
                    data: {
                        action: 'save_comites',
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
    <table id="delegadosTable" class="class=" tabdel>
        <thead>
            <tr>
                <th>Nome do Delegado</th>
                <th>1ª Opção</th>
                <th>2ª Opção</th>
                <th>3ª Opção</th>
                <th>Comitê</th>
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