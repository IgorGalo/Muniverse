<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../formatacao.css">
    <link rel="stylesheet" href="../css/mobile.css">
    <link rel="stylesheet" href="../css/index.css">
    <link rel="stylesheet" href="../css/menu.css">
    <script src="../script/scriptGeral.js"></script>

    <title>Inscrição de Mesa - Muniverse</title>
</head>

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
<div class="central">
    <div class="container" >
        <h2>Inscrição de Mesa e Proposta de Comitê</h2>
        <?php
        // ID da edição que você deseja passar
        if (isset($_GET['id'])) {
            // Obtém o valor do 'id' diretamente da URL
            $id_edicao = intval($_GET['id']); // Use intval para garantir que seja um número
          echo "<script>console.log('ID da edição obtido da URL: $id_edicao');</script>";
        } else {
         // Exibe uma mensagem de erro se o ID não estiver na URL
         $id_edicao = 0;
         echo "<script>console.log('ID da edição não encontrado na URL');</script>";
        }
        ?>

        <form  action="../php/cad_mesa.php?id=<?php echo htmlspecialchars($id_edicao); ?>" method="POST" id="form_mesa" enctype="multipart/form-data">
        <label for="email"> <strong>Nome do Comitê</strong></label>
            <input type="text" id="nome" name="nome" required>

            <label for="desc"><strong>Descrição do Comitê</strong></label>
  <textarea id="desc" name="desc" required rows="5" cols="50" placeholder="Digite a descrição do comitê..."></textarea>
  
            <label for="contato"><strong>Contato:</strong>
                <br>
                E-mail do comitê </label>
            <input type="email" id="email" name="email" required>

            <label for="quantDire"><strong>Quantos diretores farão parte do comitê?</strong></label>
            <select id="quantDire" name="quantDire" onchange="generateQuestions()">
                <option value="" disabled selected>Selecione...</option>
                <option value="2">2</option>
                <option value="3">3</option>
                <option value="4">4</option>
                <option value="5">5</option>
            </select>
            <div id="questions-container"></div>
            <br>
            <label for="foto"><strong>Foto do Comitê.</strong></label>
            <input type="file" id="foto" name="foto" accept="image/*" >
            <br>
            <br>
            <label for="proposta"><strong>Se desejar ou houver já uma proposta mais
                    ornamentada e estruturada, envie um arquivo PDF sobre seu Comitê.</strong></label>
            <input type="file" id="proposta-pdf" name="proposta" accept=".pdf" >
            <br>
            <br>
            <label for="planRepresentacoes"><strong>Planilha de representações.</strong></label>
            <input type="file" id="planRepresentacoes" name="planRepresentacoes" 
       accept=".csv, .xlsx, .xls, .ods, .tsv, .txt, .json, .xml, .html, .pdf">
            <br>
            <br>
            <label for="orgao"><strong>Qual o Órgão do Comitê?</strong>
                <br>
                Ex.: UNESCO, CPI, CSNU, etc.</label>
            <input type="text" id="orgao" name="orgao" required>


            <div class="container">
    <label>
        <strong>Qual o Caráter do Comitê?</strong>
        <br>
        <input class="radioIns" type="radio" id="opc1" name="carater_comite" value="recomendatorio">
        Recomendatório (que sugere ou recomenda ações)
    </label>
    <label>
        <input class="radioIns" type="radio" id="opc2" name="carater_comite" value="mandatorio">
        Mandatório (que determina ações)
    </label>
</div>


            <label for="tema"><strong>Qual o Tema do Comitê?</strong></label>
            <input type="text" id="tema" name="tema" required>

            <div class="container">
    <label>
        <strong>Qual o Tipo de Comitê?</strong>
        <br>
        <input class="radioIns" type="radio" id="opcTipo1" name="tipo_comite" value="atual">
        Atual (no presente)
    </label>
    <label>
        <input class="radioIns" type="radio" id="opcTipo2" name="tipo_comite" value="futurista">
        Futurista / Distópico
    </label>
    <label>
        <input class="radioIns" type="radio" id="opcTipo3" name="tipo_comite" value="historico">
        Histórico
    </label>
    <label>
        <input class="radioIns" type="radio" id="opcTipo4" name="tipo_comite" value="juri_simulado">
        Júri Simulado
    </label>
    <label>
        <input class="radioIns" type="radio" id="opcTipo5" name="tipo_comite" value="gabinete">
        Gabinete
    </label>
    <label>
        <input class="radioIns" type="radio" id="opcTipo6" name="tipo_comite" value="ficcio_tematico">
        Fictício / Temático
    </label>
</div>


            <label for="tema"><strong>Quando se passa o Comitê?</strong>
                <br>
                Caso seja um Comitê Atual, escreva "Presente</label>
            <input type="text" id="quando" name="quando" required>

            <div class="container">
    <label>
        <strong>Idioma oficial do Comitê:</strong>
        <br>
        Língua falada durante o debate pelas Delegações e Diretores
        <br>
        <input class="radioIns" type="radio" id="pt" name="idioma_comite" value="portugues">
        Português
    </label>
    <label>
        <input class="radioIns" type="radio" id="en" name="idioma_comite" value="espanhol">
        Espanhol
    </label>
    <label>
        <input class="radioIns" type="radio" id="es" name="idioma_comite" value="ingles">
        Inglês
    </label>
</div>


            <label for="tema"><strong>Qual o número de Delegações no seu Comitê?</strong>
                <br>
                Cite algumas.</label>
            <input type="text" id="deleg" name="deleg" required>

            <label for="tema"><strong>Pelo menos, uma Questão/Tópico que possa movimentar o debate.</strong> <br>
                Essa Questão, ao longo do ano, pode mudar e deve ser complementada para a discussão. Exceto em casos como Gabinetes de Guerra
            </label>
            <input type="text" id="topico" name="topico" required>

            <label for="tema"><strong>Qual a motivação dos Diretores, em geral, por escolher esse tema?</strong>
            </label>
            <input type="text" id="motivoTema" name="motivoTema" required>

            <div class="container">
    <label>
        <strong>A Mesa se dispõe a realizar o Guia de Estudos ao longo do ano, entregando ao Secretariado com antecedência?</strong>
        <br>
        <input class="radioIns" type="radio" id="optguia1" name="guia_comite" value="sim">
        Sim
    </label>
    <label>
        <input class="radioIns" type="radio" id="optguia2" name="guia_comite" value="nao">
        Não
    </label>
</div>


<div class="container">
    <label>
        <strong>A Mesa se dispõe a realizar a decoração da sala do Comitê?</strong>
        <br>
        <input class="radioIns" type="radio" id="optDecor1" name="decor_comite" value="sim">
        Sim
    </label>
    <label>
        <input class="radioIns" type="radio" id="optDecor2" name="decor_comite" value="nao">
        Não
    </label>
</div>


<div class="container">
    <label>
        <strong>Se for preciso, a Mesa se dispõe a realizar Dossiês para o Comitê?</strong>
        <br>
        Opcional, mas obrigatório em casos como de Comitês de Guerra
        <br>
        <input class="radioIns" type="radio" id="optDossie1" name="dossie_comite" value="sim">
        Sim
    </label>
    <label>
        <input class="radioIns" type="radio" id="optDossie2" name="dossie_comite" value="nao">
        Não
    </label>
</div>


            <div class="button-container">
                <button type="submit">Enviar</button>
            </div>
        </form>
    </div>
    </div>
    <script>
        function generateQuestions() {
            // Seleciona o container de perguntas e limpa seu conteúdo
            const questionsContainer = document.getElementById('questions-container');
            questionsContainer.innerHTML = '';

            // Pega o número de perguntas escolhidas pelo usuário
            const numQuestions = parseInt(document.getElementById('quantDire').value);

            // Gera as caixas de texto conforme a quantidade selecionada
            for (let i = 1; i <= numQuestions; i++) {
                const label1 = document.createElement('label');
                const label2 = document.createElement('label');
                const label3 = document.createElement('label');
                const label4 = document.createElement('label');
                const label5 = document.createElement('label');
                const label6 = document.createElement('label');

                label1.innerText = `Contato do diretor ${i}:`;
                label1.setAttribute('for', `question-${i}`);

                const input1 = document.createElement('input');
                input1.type = 'text';
                input1.id = `contato-${i}`;
                input1.name = `contato-${i}`;
                input1.placeholder = `Digite o contato... ${i}`;
                input1.required = true;

                label2.innerText = `Nome completo do diretor ${i}:`;
                label2.setAttribute('for', `question-${i}`);

                const input2 = document.createElement('input');
                input2.type = 'text';
                input2.id = `nome-${i}`;
                input2.name = `nome-${i}`;
                input2.placeholder = `Digite o nome... ${i}`;
                input2.required = true;

                label3.innerText = `Idade do diretor ${i}:`;
                label3.setAttribute('for', `question-${i}`);

                const input3 = document.createElement('input');
                input3.type = 'text';
                input3.id = `idade-${i}`;
                input3.name = `idade-${i}`;
                input3.placeholder = `Digite a idade... ${i}`;
                input3.required = true;

                label4.innerText = `Instituição de Ensino do diretor ${i}:`;
                label4.setAttribute('for', `question-${i}`);

                const input4 = document.createElement('input');
                input4.type = 'text';
                input4.id = `InstEns-${i}`;
                input4.name = `InstEns-${i}`;
                input4.placeholder = `Digite a Instituição de Ensino... ${i}`;
                input4.required = true;

                label5.innerText = `Histórico de Simulações do diretor ${i}:`;
                label5.setAttribute('for', `question-${i}`);

                const input5 = document.createElement('input');
                input5.type = 'text';
                input5.id = `historico-${i}`;
                input5.name = `historico-${i}`;
                input5.placeholder = `Participação, em qualquer cargo, em eventos do tipo. ${i}`;
                input5.required = true;

                label6.innerText = `O que motivou o diretor ${i} a ser Mesa?`;
                label6.setAttribute('for', `question-${i}`);

                const input6 = document.createElement('input');
                input6.type = 'textarea';
                input6.id = `motivacao-${i}`;
                input6.name = `motivacao-${i}`;
                input6.placeholder = `Digite aqui... ${i}`;
                input6.required = true;

                questionsContainer.appendChild(label1);
                questionsContainer.appendChild(input1);

                questionsContainer.appendChild(label2);
                questionsContainer.appendChild(input2);
                questionsContainer.appendChild(label3);
                questionsContainer.appendChild(input3);
                questionsContainer.appendChild(label4);
                questionsContainer.appendChild(input4);
                questionsContainer.appendChild(label5);
                questionsContainer.appendChild(input5);
                questionsContainer.appendChild(label6);
                questionsContainer.appendChild(input6);
            }
        }

        // Adiciona um evento de escuta para o envio do formulário
        document.getElementById('dynamic-form').addEventListener('submit', function(event) {
            event.preventDefault(); // Evita o envio padrão do formulário

            // Seleciona todas as perguntas dinâmicas
            const numQuestions = parseInt(document.getElementById('quantDire').value);
            const responses = {};

            for (let i = 1; i <= numQuestions; i++) {
                const answer = document.getElementById(`question-${i}`).value;
                responses[`Pergunta ${i}`] = answer;
            }

            console.log("Respostas:", responses);
            alert("Respostas coletadas com sucesso! Veja o console para verificar.");

            // Aqui você pode enviar 'responses' para um servidor, se desejar.
        });

        function checkOnlyOne(checkbox) {
            // Pega todos os checkboxes com o mesmo nome do que foi clicado
            const checkboxes = document.querySelectorAll('input[name="option"]');

            // Itera por cada checkbox, desmarcando os que são diferentes do selecionado
            checkboxes.forEach((box) => {
                if (box !== checkbox) {
                    box.checked = false;
                }
            });
        }
    </script>
</body>

</html>