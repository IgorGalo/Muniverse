
<?php
include_once '../php/conexao.php';

// Verificar se o parâmetro 'id' foi passado na URL
if (isset($_GET['id'])) {
    $id_comite = (int)$_GET['id']; // Captura o ID do comitê da URL e garante que é um número inteiro

    // Consulta SQL para buscar os nomes e fotos dos delegados associados ao 'id_comite'
    $sql = "SELECT DISTINCT usuario.nome, usuario.foto
    FROM tb_delegado 
    INNER JOIN usuario ON tb_delegado.id_usuario = usuario.id 
    WHERE tb_delegado.id_comite = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id_comite);
    $stmt->execute();
    $result = $stmt->get_result();
} else {
    echo "ID do comitê não fornecido!";
    exit;
}

// Fechar a conexão
$conn->close();
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../formatacao.css">
    <link rel="stylesheet" href="../css/sessao.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.3/font/bootstrap-icons.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="../script/scriptGeral.js"></script>
    <script src="../script/scriptTimer.js"></script>
    <link rel="stylesheet" href="../css/menu.css">

    <style>
        #toggleButton {
            position: fixed;
            bottom: 0;
            left: 0;
            width: 100%;
            text-align: center;
            padding: 10px;
            background-color: #C1D9E1;
            color: white;
            font-weight: bold;
            z-index: 1000;
            /* Certifique-se de que está acima de outros elementos */
        }

        #expandableBar {
            position: fixed;
            bottom: 40px;
            /* Logo acima do botão toggle */
            left: 0;
            width: 100%;
            border-top: 1px solid #ccc;
            background-color: #C1D9E1;
            padding: 10px;
            display: none;
            z-index: 999;
            /* Logo abaixo do botão toggle */
        }

        #expandableBar .bar-content {
            margin-top: 10px;
        }

        #expandableBar .btn {
            width: 48%;
            margin: 1%;
        }

        #iconseta {
            color: #006270;
        }

        #btnex {
            background-color: #006270;
            color: #C1D9E1;
        }

        #realizarChamadaBtn {
            background-color: #006270;
            color: #C1D9E1;
        }

        /* Estilo do fundo do modal */
        .modal {
            display: none;
            position: fixed;
            z-index: 1000;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            overflow: auto;
            background-color: rgba(0, 0, 0, 0.5);
            /* Fundo escurecido */
        }

        /* Estilo do conteúdo do modal */
        .modal-content {
            background-color: #fff;
            margin: 10% auto;
            padding: 20px;
            border-radius: 8px;
            width: 50%;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
            text-align: center;
        }

        /* Botão de fechar */
        .close {
            color: #aaa;
            float: right;
            font-size: 28px;
            font-weight: bold;
            cursor: pointer;
        }

        .close:hover,
        .close:focus {
            color: #000;
            text-decoration: none;
        }

        .modal-content h2 {
            text-align: left;
            margin: 0;
        }

        .modal-content .close {
            float: none;
            display: inline-block;
            margin-left: auto;
        }

        .modal-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            border-bottom: 1px solid #ddd;
            padding-bottom: 10px;
            margin-bottom: 20px;
        }

        #listaAcrescentarOradores {
            position: relative;
            z-index: 10;
            /* Adiciona um z-index maior */
        }

        .list-group-item {
            display: flex;
            align-items: center;
            justify-content: space-between;
            /* Garantir que o conteúdo seja distribuído corretamente */
            padding: 10px;
            font-size: 16px;
            cursor: default;
            /* Evitar que o item da lista seja clicado */
        }

        #listaAcrescentarOradores .list-group-item {
            cursor: pointer;
            /* Garanta que o cursor seja de clique */
        }

        .list-group-item img {
            border-radius: 50%;
            width: 40px;
            height: 40px;
            margin-right: 10px;
            /* Espaço entre a foto e o nome */
        }

        .list-group-item span {
            white-space: nowrap;
            /* Impede a quebra de linha no nome */
            overflow: hidden;
            /* Esconde o texto que ultrapassar o limite */
            text-overflow: ellipsis;
            /* Adiciona '...' no final do nome, caso ele ultrapasse o espaço */
        }

        /* Remover o efeito de escurecimento ao passar o mouse */
        .list-group-item:hover {
            background-color: white;
            /* Manter a cor do fundo igual ao normal */
            color: black;
            /* Garantir que a cor do texto não mude */
        }

        .checkbox-container {
            display: flex;
            justify-content: flex-end;
            align-items: center;
            width: 100%;
        }

        .checkbox-label {
            background-color: white;
            color: black;
            border: 1px solid black;
            padding: 5px 10px;
            margin-left: 10px;
            cursor: pointer;
        }

        /* Esconde o quadradinho do checkbox */
        .checkbox {
            display: none;
        }

        .checkbox+.checkbox-label {
            display: inline-block;
            background-color: white;
            color: black;
            border: 1px solid black;
            padding: 5px 10px;
            cursor: pointer;
        }

        /* Estilos para quando os checkboxes estão marcados */
        .checkbox:checked+.checkbox-label {
            color: white;
        }

        .checkbox:checked#pCheckbox+.checkbox-label {
            background-color: yellow;
        }

        .checkbox:checked#pvCheckbox+.checkbox-label {
            background-color: green;
        }

        .checkbox:checked#aCheckbox+.checkbox-label {
            background-color: red;
        }
    </style>


    <title>Muniverse - Sessão</title>
</head>

<body>
    <!-- Barrinha principal -->
    <div id="barrinha">
        <img id="logoNaDireita" src="../image/logoBarra2.png" alt="logo">
    </div>

    <!-- Botão de toggle -->
    <div id="toggleButton" onclick="toggleExpandableBar()">
        <i id="iconseta" class="bi bi-chevron-up"></i>
    </div>

    <!-- Barra expansível -->
    <div id="expandableBar">
        <div class="bar-content">
            <p id="iconseta">Nenhuma agenda foi definida</p>
            <div class="d-flex justify-content-between">
                <button id="btnex" class="btn btn-primary">Defina uma agenda</button>
                <button id="realizarChamadaBtn" class="btn">Realizar Chamada</button>

                <div id="realizarChamadaModal" class="modal">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h2>Marcar Presença</h2>
                            <span class="close">&times;</span>
                        </div>
                        <ul class="list-group">
                            <?php
                            if ($result->num_rows > 0) {
                                while ($row = $result->fetch_assoc()) {
                                    echo "<li class='list-group-item'>" .
                                        "<div class='d-flex align-items-center'>" .
                                        "<img src='" . htmlspecialchars($row["foto"]) . "' alt='Foto de " . htmlspecialchars($row["nome"]) . "'>" .
                                        "<span>" . htmlspecialchars($row["nome"]) . "</span>" .
                                        "</div>" .
                                        "<div class='checkbox-container'>" .
                                        "<input type='radio' name='status_" . $row['nome'] . "' id='pCheckbox_" . $row['nome'] . "' class='checkbox' onchange='changeColor(this)'>" .
                                        "<label for='pCheckbox_" . $row['nome'] . "' class='checkbox-label'>P</label>" .
                                        "<input type='radio' name='status_" . $row['nome'] . "' id='pvCheckbox_" . $row['nome'] . "' class='checkbox' onchange='changeColor(this)'>" .
                                        "<label for='pvCheckbox_" . $row['nome'] . "' class='checkbox-label'>PV</label>" .
                                        "<input type='radio' name='status_" . $row['nome'] . "' id='aCheckbox_" . $row['nome'] . "' class='checkbox' onchange='changeColor(this)'>" .
                                        "<label for='aCheckbox_" . $row['nome'] . "' class='checkbox-label'>A</label>" .
                                        "</div>" .
                                        "</li>";
                                }
                            } else {
                                echo "<li class='list-group-item'>Nenhum delegado encontrado</li>";
                            }
                            ?>
                        </ul>
                        <button id="saveButton" class="btn btn-primary" onclick="saveSelection()">Salvar</button>
                    </div>
                </div>

            </div>
        </div>
    </div>

    <input type="checkbox" id="check">
    <label for="check">
        <div class="menu">
            <span class="hamburguer"></span>
        </div>
    </label>

    <?php include_once '../php/menu.php'; ?>

    <div id="divtelasessao">
        <!--div 1-->
        <div id="divsessao">
            <div id="divdentrotimer">
                <div id="divtimer">
                    <div id="timer">01:00</div>
                </div>
                <br>
                <button id="buttonTimer" class="bi bi-chat-left-dots"></button>
                <button id="buttonTimerUp" class="bi bi-clock" onclick="popuptempo()"></button>
                <button id="buttonTimer" class="bi bi-arrow-clockwise" onclick="resetTimer()"></button>
                <button id="buttonTimer" class="bi bi-play" onclick="startTimer()"></button>
                <button id="buttonTimer" class="bi bi-pause" onclick="pauseTimer()"></button>

                <!-- O Modal -->
                <div id="timeModal" class="modal">
                    <div id="modal-content">
                        <span class="close">&times;</span>
                        <h2>Defina o tempo de fala</h2>
                        <br>
                        <input type="number" class="campoms" id="minutesInput" min="0" placeholder="Minutos">
                        <br><br>
                        <input type="number" class="campoms" id="secondsInput" min="0" max="59" placeholder="Segundos">
                        <br><br>
                        <button id="saveButton" class="btn btn-primary" onclick="saveSelection()">Salvar</button>
                    </div>
                </div>

                <div>
                    <!-- Lista de orador atual -->
                    <div id="divnovorador">
                        <div class="orador-header">
                            <h2 class="titulosessao">Orador Atual</h2>
                            <button id="nextorador" onclick="moverOuLiberarOrador()" class="btn btn-secondary mt-3">Próximo Orador</button>
                        </div>

                        <ul id="listaOradores" class="list-group list-group-flush">
                            <!-- O orador atual aparecerá aqui -->
                        </ul>
                    </div>

                    <!-- Lista de próximos oradores -->
                    <div id="divnovorador">
                        <h2 class="titulosessao" id="proxorador">Próximos Oradores</h2>
                        <ul id="listaProximosOradores" class="list-group list-group-flush">
                            <!-- Os próximos oradores aparecerão aqui -->
                    </div>
                </div>
            </div>
        </div>
        <!--div-->
        <div id="divlista">
            <div id="divorador">
                <h2 class="titulosessao">Acrescentar Orador</h2>
                <div style="margin-top: 2rem; align-items: left;">
                    <ul id="listaAcrescentarOradores" class="list-group list-group-flush">


                    <li id='listcss' class='list-group-item' onclick='adicionarOrador("teste", "teste")'>teste</li>
                    
                    <?php
                        if ($result->num_rows > 0) {
                            while ($row = $result->fetch_assoc()) {
                                // Exibe a foto e o nome do delegado
                                echo "<li id='listcss' class='list-group-item' onclick='adicionarOrador(\"teste\", \"teste\")'>";
                                echo htmlspecialchars($row["nome"]);
                                echo "</li>";
                            }
                        } else {
                            echo "<li id='listcss' class='list-group-item'>Nenhum orador encontrado</li>";
                        }
                        ?>
                
                </ul>

                    </ul>
                </div>
            </div>
        </div>

    </div>

    <script>
        function toggleExpandableBar() {
            const bar = document.getElementById('expandableBar');
            bar.style.display = bar.style.display === 'none' || bar.style.display === '' ? 'block' : 'none';
        }
        // Seleciona os elementos
        const modal = document.getElementById('realizarChamadaModal');
        const btn = document.getElementById('realizarChamadaBtn');
        const span = document.querySelector('.close');

        // Quando o botão for clicado, exibe o modal
        btn.onclick = function() {
            modal.style.display = 'block';
        };

        // Quando o botão "x" for clicado, esconde o modal
        span.onclick = function() {
            modal.style.display = 'none';
        };

        // Fecha o modal ao clicar fora do conteúdo
        window.onclick = function(event) {
            if (event.target === modal) {
                modal.style.display = 'none';
            }
        };

        function changeColor(checkbox) {
            const allCheckboxes = document.querySelectorAll('.checkbox');
            const allLabels = document.querySelectorAll('.checkbox-label');

            // Se o checkbox for marcado, muda a cor de fundo correspondente
            if (checkbox.checked) {
                const label = checkbox.nextElementSibling;

                if (checkbox.id.includes('pCheckbox')) {
                    label.style.backgroundColor = 'yellow'; // Cor para P
                } else if (checkbox.id.includes('pvCheckbox')) {
                    label.style.backgroundColor = 'green'; // Cor para PV
                } else if (checkbox.id.includes('aCheckbox')) {
                    label.style.backgroundColor = 'red'; // Cor para A
                }
            } else {
                // Se desmarcar, remove a cor de fundo
                const label = checkbox.nextElementSibling;
                label.style.backgroundColor = ''; // Remove a cor
            }

            // Desmarca todos os outros checkboxes com o mesmo nome
            const nameGroup = checkbox.name;
            document.querySelectorAll('input[name="' + nameGroup + '"]').forEach((cb) => {
                if (cb !== checkbox) {
                    cb.checked = false;
                    const label = cb.nextElementSibling;
                    label.style.backgroundColor = ''; // Remove a cor
                }
            });
        }

        let nomeSelecionado = "";  // Variável para armazenar o nome do delegado selecionado

// Função para definir o nome selecionado
function selecionarDelegado(nome) {
    nomeSelecionado = nome;  // Armazena o nome do delegado selecionado
}

// Função para salvar a seleção dos delegados
function saveSelection() {
    // Exemplo de dados dos delegados (substitua conforme necessário)
    let dadosDelegados = [
        { nome: "Delegado 1", foto: "foto1.jpg" },
        { nome: "Delegado 2", foto: "foto2.jpg" }
    ];

    

    let listaAcrescentarOradores = document.getElementById('listaAcrescentarOradores');

    dadosDelegados.forEach(delegate => {
        let li = document.createElement('li');
        li.classList.add('list-group-item');
        
        // Insira o conteúdo HTML para cada delegado
        li.innerHTML = `
            <div class='d-flex align-items-center'>
                <img src='${delegate.foto}' alt='Foto de ${delegate.nome}' class='img-thumbnail'>
                <span>${delegate.nome}</span>
            </div>
        `;

        // Adicione o evento onclick de forma dinâmica
        li.onclick = function() {
            // Passa o nome selecionado, que é o nome do delegado selecionado
            adicionarOrador(nomeSelecionado, delegate.nome);
        };

        // Adicione o novo item à lista
        listaAcrescentarOradores.appendChild(li);
    });

    // Fechar o modal, se existir
    let modal = document.getElementById('realizarChamadaModal');
    if (modal) {
        modal.style.display = 'none'; // Fecha o modal
    } else {
        console.error('Modal não encontrado! Verifique o ID "realizarChamadaModal".');
    }
}



        span.onclick = function() {
            modal.style.display = 'none';
        };

        // Fecha o modal ao clicar fora do conteúdo
        window.onclick = function(event) {
            if (event.target === modal) {
                modal.style.display = 'none';
            }
        };

        function adicionarOrador(nome, item) {
            
            event.stopPropagation(); // Impede que o evento se propague para outros elementos

            const oradoresList = document.getElementById('listaProximosOradores'); // Lista de oradores atuais

            // Cria um novo item para a lista de oradores
            const newOrador = document.createElement('li');
            newOrador.classList.add('list-group-item');
            newOrador.textContent = nome;

            // Adiciona o orador na lista de oradores
            oradoresList.appendChild(newOrador);

            // Remove o item da lista de "Acrescentar Orador"
            item.remove();
        }

        function moverOuLiberarOrador() {
  const listaProximosOradores = document.getElementById('listaProximosOradores');
  const listaOradoresAtuais = document.getElementById('listaOradores');
  const listaAcrescentarOradores = document.getElementById('listaAcrescentarOradores');

  // Se já houver um orador atual, liberar ele e reabilitar na lista de "Acrescentar Orador"
  if (oradorAtual !== null) {
    const nomeOradorLiberado = oradorAtual.textContent;

    // Procurar o orador na lista de "Acrescentar Orador" e reabilitar
    const itensAcrescentar = listaAcrescentarOradores.getElementsByTagName('li');
    for (let i = 0; i < itensAcrescentar.length; i++) {
      if (itensAcrescentar[i].textContent === nomeOradorLiberado) {
        itensAcrescentar[i].style.pointerEvents = 'auto'; // Reabilitar o clique
        itensAcrescentar[i].style.backgroundColor = ''; // Restaurar o estilo original
        break;
      }
    }

    // Remover o orador atual da lista de oradores
    listaOradoresAtuais.removeChild(oradorAtual);

    oradorAtual = null;
  }

  // Verificar se há próximos oradores na lista
  if (listaProximosOradores.children.length > 0) {
    const proximoOrador = listaProximosOradores.children[0];

    // Mover o próximo orador para a lista de orador atual
    listaOradoresAtuais.appendChild(proximoOrador);
    oradorAtual = proximoOrador;

    // Desabilitar o novo orador atual
    oradorAtual.style.pointerEvents = 'none';
    oradorAtual.style.backgroundColor = '#f0f0f0'; // Indicar que está desabilitado
  }
}
    </script>

</body>

</html>