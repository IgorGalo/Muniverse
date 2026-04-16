<?php
session_start();
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
    <script src="../script/scriptGeral.js"></script>
    <title>Inscrição Delegado</title>
</head>

<style>
    .central {
        display: flex;
        justify-content: center;
        /* Centraliza a div horizontalmente */
        align-items: center;
        /* Centraliza a div verticalmente */
    }

    .container {
        max-width: 400px;
        width: 100%;
        padding: 20px;
        background-color: #ffffff;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        border-radius: 8px;
        text-align: center;
        /* Garante que os elementos dentro da div sejam centralizados */
        display: flex;
        flex-direction: column;
        /* Organiza os itens verticalmente */
        align-items: center;
        /* Centraliza os radio buttons horizontalmente */
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
        margin-right: 10px;
        /* Ajuste o espaçamento entre os radio buttons */
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
        justify-content: center;
        /* Centraliza os itens dentro da div */
        margin-top: 10px;
    }

    .terms input {
        margin-right: 5px;
    }

    .radio-container {
        display: flex;
        align-items: center;
        margin-bottom: 5px;
    }

    .radio-container label {
        margin-left: 5px;
        color: var(--cor4);
    }

    .terms {
        display: flex;
        align-items: center;
        justify-content: start;
        /* Alinha o texto e o checkbox à esquerda */
        gap: 8px;
        /* Espaçamento entre o checkbox e o texto */
        margin-top: 10px;
        font-size: 14px;
        /* Ajusta o tamanho da fonte */
        color: #333;
        /* Cor do texto */
    }
</style>

<body>
    <script>
        function carregarRepresentacoes(destino) {
            // Configurar a solicitação AJAX
            const xhr = new XMLHttpRequest();
            xhr.open("GET", "buscar_representacoes.php", true);

            xhr.onload = function() {
                if (xhr.status === 200) {
                    // Insere o resultado no elemento especificado
                    document.getElementById(destino).innerHTML = xhr.responseText;
                } else {
                    console.error("Erro ao carregar representações.");
                }
            };

            xhr.send();
        }

        function show(id1, id2) {
            document.getElementById(id1).style.display = 'block';
            document.getElementById(id2).style.display = 'block';
        }

        function hide(id1, id2) {
    var elem1 = document.getElementById(id1);
    var elem2 = document.getElementById(id2);

    if (elem1) {
        elem1.style.display = 'none';
    } else {
        console.warn("Elemento com ID '" + id1 + "' não encontrado.");
    }

    if (elem2) {
        elem2.style.display = 'none';
    } else {
        console.warn("Elemento com ID '" + id2 + "' não encontrado.");
    }
}

    </script>
    <?php
    // Conexão com o banco de dados
    $servername = "127.0.0.1";
    $dbname = 'muniverse_db';
    $username = 'muniverse';
    $password = '_}+b6yxj^F';

    // Criando a conexão
    $conn = new mysqli($servername, $username, $password, $dbname);

    // Verificando a conexão
    if ($conn->connect_error) {
        die("Falha na conexão: " . $conn->connect_error);
    }
    ?>

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
    ?>

    <div class="central">
        <div class="container">
            <h2>Inscrição de Delegado</h2>

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

            <form action="../php/cad_deleg.php?id=<?php echo htmlspecialchars($id_edicao); ?>" method="POST" id="form_deleg" enctype="multipart/form-data">
                <div>
                    <label>
                        <strong>Restrições alimentares</strong><br>Caso possua alguma alergia, favor informar em outros<br>
                        <input type="checkbox" id="nenhuma" name="restricao[]" value="Nenhuma"> Nenhuma
                    </label>
                    <label>
                        <input type="checkbox" id="Vegano" name="restricao[]" value="Vegano"> Vegano
                    </label>
                    <label>
                        <input type="checkbox" id="Vegetariano" name="restricao[]" value="Vegetariano"> Vegetariano
                    </label>
                    <label>
                        <input type="checkbox" id="int_gluten" name="restricao[]" value="Intolerância ao glúten"> Intolerância ao glúten
                    </label>
                    <label>
                        <input type="checkbox" id="int_lactotes" name="restricao[]" value="Intolerância à lactose"> Intolerância à lactose
                    </label>
                    <label for="outro">Outro:</label>
                    <input type="text" id="outro_rest" name="outro_restricao">
                </div>

                <label for="quant_simul"> <strong>De quantas simulações já participou?:</strong><br>(Mock NÃO conta como simulação)<br></label>
                <input type="text" id="historico" name="historico" required>

                <div>
                    <label>
                        <strong>Caso seja estudante do IFMG - Campus Ouro Branco, favor informar a turma e o
                            curso</strong></label>
                    <label>
                        <input type="radio" id="ADM_1" name="turma" value="ADM 1" onclick="hide('nenhuma_label', 'nenhuma_input')" required> ADM 1
                    </label>
                    <label>
                        <input type="radio" id="ADM_2" name="turma" value="ADM 2" onclick="hide('nenhuma_label', 'nenhuma_input')" required> ADM 2
                    </label>
                    <label>
                        <input type="radio" id="ADM_3" name="turma" value="ADM 3" onclick="hide('nenhuma_label', 'nenhuma_input')" required> ADM 3
                    </label>
                    <label>
                        <input type="radio" id="INFO_1" name="turma" value="INFO 1" onclick="hide('nenhuma_label', 'nenhuma_input')" required> INFO 1
                    </label>
                    <label>
                        <input type="radio" id="INFO_2" name="turma" value="INFO 2" onclick="hide('nenhuma_label', 'nenhuma_input')" required> INFO 2
                    </label>
                    <label>
                        <input type="radio" id="INFO_3" name="turma" value="INFO 3" onclick="hide('nenhuma_label', 'nenhuma_input')" required> INFO 3
                    </label>
                    <label>
                        <input type="radio" id="MET_1" name="turma" value="MET 1" onclick="hide('nenhuma_label', 'nenhuma_input')" required> MET 1
                    </label>
                    <label>
                        <input type="radio" id="MET_2" name="turma" value="MET 2" onclick="hide('nenhuma_label', 'nenhuma_input')" required> MET 2
                    </label>
                    <label>
                        <input type="radio" id="MET_3" name="turma" value="MET 3" onclick="hide('nenhuma_label', 'nenhuma_input')" required> MET 3
                    </label>
                    <label>
                        <input type="radio" name="turma" id="nenhuma" value="Nenhuma" onclick="show('nenhuma_label', 'nenhuma_input')" required> Nenhuma
                    </label>
                    <label for="nenhuma" id="nenhuma_label" style="display: none;">
                        <strong>Informe a Instituição da qual você faz parte:</strong>
                    </label>
                    <input type="text" id="nenhuma_input" name="nenhuma_input" value="" style="display: none;">
                </div>

                <div id="input-container" class="input-container"></div>

                <!-- Primeira opção de comitê -->
                <label><strong>Escolha sua PRIMEIRA opção de comitê</strong></label>
                <!-- Primeira opção de comitê -->
                <?php
                $sql = "SELECT id, nome_comite FROM comite";
                $result = $conn->query($sql);
                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                ?>
                        <input type="radio" name="primeira-opcao" value="<?php echo $row['nome_comite']; ?>"
                        id="<?php echo $row['id']; ?>"
                            onclick="buscarRegistroAnterior(this.id, 'primeiraRep')">
                        <?php echo $row['nome_comite']; ?><br>
                <?php
                    }
                } else {
                    echo "Nenhum dado encontrado.";
                }
                ?>


                <!-- Segunda opção de comitê -->
                <label><strong>Escolha sua SEGUNDA opção de comitê</strong></label>
                <?php
                $sql = "SELECT id, nome_comite FROM comite";
                $result = $conn->query($sql);
                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                ?>
                        <input type="radio" name="segunda-opcao" value="<?php echo $row['nome_comite']; ?>"
                        id="<?php echo $row['id']; ?>"
                            onclick="buscarRegistroAnterior(this.id, 'segundaRep')">
                        <?php echo $row['nome_comite']; ?><br>
                <?php
                    }
                } else {
                    echo "Nenhum dado encontrado.";
                }
                ?>

                <!-- Terceira opção de comitê -->
                <label><strong>Escolha sua TERCEIRA opção de comitê</strong></label>
                <?php
                $sql = "SELECT id, nome_comite FROM comite";
                $result = $conn->query($sql);
                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                ?>
                        <input type="radio" name="terceira-opcao" value="<?php echo $row['nome_comite']; ?>"
                        id="<?php echo $row['id']; ?>"
                            onclick="buscarRegistroAnterior(this.id, 'terceiraRep')">
                        <?php echo $row['nome_comite']; ?><br>
                <?php
                    }
                } else {
                    echo "Nenhum dado encontrado.";
                }
                ?>
                <!-- Opção de representação -->
                <label><strong>Qual a sua primeira opção de representação?</strong></label>
                <div id="primeiraRep"></div>

                <!-- Segunda opção de representação -->
                <label><strong>Qual a sua segunda opção de representação?</strong></label>
                <div id="segundaRep"></div>

                <!-- Terceira opção de representação -->
                <label><strong>Qual a sua terceira opção de representação?</strong></label>
                <div id="terceiraRep"></div>

                <div>
                    <label>
                        <strong>Finalização da Inscrição</strong><br>Antes de finalizar sua inscrição, por favor, nos
                        informe se você faz parte de uma das <strong>Escolas Municipais de Ouro Branco</strong>, ou se pertence a
                        demais instituições e <strong>possui CadÚnico</strong>, ou simplesmente pertence a demais instituições.<br>
                        -Se você é aluno de Escola Municipais de Ouro Branco, selecione "Pertenço a uma
                        Escola Municipal de Ouro Branco"; <br>
                        -Caso pertença ao IFMG - OB ou qualquer outra instituição, selecione "Outra Instituição"; <br>
                        -Caso pertença ao IFMG - OB ou qualquer outra instituição e possua CadÚnico, selecione "Outra Instituição com CadÚnico".<br>
                        <strong>Nota: </strong>Caso seja aluno da rede municipal e possua CadÚnico, escolha mesmo assim a opção de
                        escola municipal. <br>

                        <input type="radio" id="EscolaMunicipal" name="escola" value="EscolaMunicipal" onclick="show('EscolaMun_label','EscolaMun_input'); hide('outraInst_label', 'outraInst_input'); hide('outraInstCad_label', 'outraInstCad_input')"> Pertenço a uma Escola Municipal de Ouro Branco
                    </label>
                    <br>
                    <label for="EscolaMun" id="EscolaMun_label" style="display: none;">
                        <strong>Escolas Municipais de Ouro Branco</strong> <br>
                        A Prefeitura de Ouro Branco, em parceria com a UNIF, está incentivando a participação dos
                        alunos da rede municipal em nosso evento. Confira os benefícios exclusivos disponibilizados
                        pela prefeitura para os alunos das escolas municipais: <br>
                        <strong>Transporte ao evento:</strong> A prefeitura disponibilizará um transporte para levar os alunos da rede
                        municipal até o IFMG para o evento. O ônibus terá rotas definidas pela prefeitura para garantir o
                        transporte eficiente e seguro dos participantes. <br>
                        <strong>Almoço:</strong> Durante o evento, forneceremos lanches entre os intervalos das sessões da simulação,
                        porém não fornecemos almoço. Em prol de seus alunos, a prefeitura buscará os alunos no IFMG e
                        os levará para a Escola Livre Mente, onde será servido um almoço gratuito e exclusivo para os
                        alunos das escolas municipais. <br>
                        <strong>Desconto na Inscrição:</strong> Os alunos das escolas
                        municipais receberão um desconto especial na taxa de inscrição. Em vez de pagar R$40, o valor
                        da inscrição será de apenas R$25 para os alunos das escolas municipais de Ouro Branco. <br>
                        Para continuar com a inscrição, por favor, leia os
                        termos e condições abaixo e prossiga para o
                        pagamento. <br>
                        <strong>TERMOS E CONDIÇÕES</strong> <br>
                        Ao prosseguir com a inscrição na VIII UNIF, você concorda com os seguintes termos e condições: <br>
                        -Será cobrada uma taxa no valor de R$25,00 para confirmar sua inscrição na UNIF; valor especial e único para alunos
                        da rede de escolas municipais de Ouro Branco. O pagamento deverá ser realizado conforme instruções fornecidas no final deste formulário. <br>
                        -É necessário enviar o comprovante de pagamento no campo informado ao final do formulário para confirmar sua inscrição. <br>
                        -Pode haver necessidade de realocação das suas escolhas de comitês ou representações de acordo com a
                        disponibilidade e necessidade da simulação. Faremos o possível para acomodar suas preferências, mas mudanças podem ser necessárias. <br>
                        -As informações fornecidas neste formulário são verdadeiras e precisas. Qualquer informação falsa pode resultar na desqualificação da inscrição. <br>
                        -Concordo em participar do evento presencialmente, durante os dias 21 à 23 de junho, no IFMG - Campus Ouro Branco,
                        localizado na Rua Afonso Sardinha 90, Minas Talco - Ouro Branco, Minas Gerais <br>
                        Ao marcar a caixa abaixo, você confirma que leu e concorda com os termos e condições acima mencionados. <br>
                        <div class="terms">
                            <input type="checkbox" id="EscolaMun_input" name="EscolaMun" value="">
                            <label for="EscolaMun_input" >Li e Concordo com os Termos e Condições</label>
                        </div>
                        <label> <strong>PAGAMENTO</strong> <br>
                            DADOS BANCÁRIOS <br>
                            Favorecido: Thaissa Azevedo Resende <br>
                            Agência: 2042-7 <br>
                            Conta corrente: 21719-0 <br>
                            Chave PIX: 31998828052 <br>
                            Valor: R$25,00 <br>

                        </label>
                        <label > <strong>Insira o comprovante do pagamento a
                        baixo</strong></label>
                        <label> Qualquer dúvida ou imprevisto contate o secretariado: unif.ourobranco@ifmg.edu.br</label>

                        <label for="fileUpload">Envie seu arquivo (PNG ou PDF):</label>
                        <input type="file" id="fileUpload" name="fileUpload" accept=".png, .pdf">
                    </label>

                    <label>
                        <input type="radio" id="outraInst" name="escola" value="outraInst" onclick="hide('EscolaMun_label','EscolaMun_input'); show('outraInst_label', 'outraInst_input'); hide('outraInstCad_label', 'outraInstCad_input')"> Outra Instituição
                    </label>
                    <label id="outraInst_label" style="display: none;">
                    <strong>TERMOS E CONDIÇÕES</strong>
                    Ao prosseguir com a inscrição na VIII UNIF, você concorda com os seguintes termos e condições: <br>
                    -Será cobrada uma taxa no valor de R$40,00 para confirmar sua inscrição na UNIF. O pagamento deverá ser realizado
                    conforme instruções fornecidas no final deste formulário. <br>
                    -É necessário enviar o comprovante de pagamento no campo informado ao final do formulário para confirmar sua inscrição.<br>
                    -Pode haver necessidade de realocação das suas escolhas de comitês ou representações de acordo com a disponibilidade e necessidade da
                    simulação. Faremos o possível para acomodar suas preferências, mas mudanças podem ser necessárias. <br>
                    -As informações fornecidas neste formulário são verdadeiras e precisas. Qualquer informação falsa pode resultar na desqualificação da inscrição. 
                    -Concordo em participar do evento presencialmente, durante os dias 21 à 23 de junho, no IFMG - Campus Ouro Branco, localizado na Rua Afonso Sardinha
                    90,Minas Talco - Ouro Branco, Minas Gerais<br>
                    Ao marcar a caixa abaixo, você confirma que leu e concorda com os termos e condições acima mencionados.<br>
                    <div class="terms">
                            <input type="checkbox" id="outraInst_input" name="outraInst" value="">
                            <label for="outraInst_input" >Li e Concordo com os Termos e Condições</label>
                        </div>
                        <br>
                        <label> <strong>PAGAMENTO</strong> <br>
                            DADOS BANCÁRIOS <br>
                            Favorecido: Thaissa Azevedo Resende <br>
                            Agência: 2042-7 <br>
                            Conta corrente: 21719-0 <br>
                            Chave PIX: 31998828052 <br>
                            Valor: R$40,00 <br>

                        </label>
                        <label > <strong>Insira o comprovante do pagamento a
                        baixo</strong></label>
                        <label> Qualquer dúvida ou imprevisto contate o secretariado: unif.ourobranco@ifmg.edu.br</label>

                        <label for="fileUpload">Envie seu arquivo (PNG ou PDF):</label>
                        <input type="file" id="fileUpload" name="fileUpload" accept=".png, .pdf">
                    </label>
                    <label>
                        <input type="radio" id="outraInstCad" name="escola" value="outraInstCad" onclick="hide('EscolaMun_label','EscolaMun_input'); hide('outraInst_label', 'outraInst_input'); show('outraInstCad_label', 'outraInstCad_input')"> Outra Instituição com CadÚnico
                    </label>
                    <label  id="outraInstCad_label" style="display: none;">
                    <strong>Pagamento CadÚnico</strong><br>
                    A UNIF está comprometida em apoiar todos os alunos que desejam participar de nosso evento, e, 
                    por isso, os alunos que possuem Cadastro Único para Programas Sociais (CadÚnico) receberão um 
                    desconto especial na taxa de inscrição. Em vez de pagar R$40, o valor da inscrição será de apenas R$25 para os alunos com CadÚnico. <br>
                    Para validar o desconto, anexe o comprovante de Cadastro Único ao final do formulário. Para finalizar a inscrição, por favor, leia os termos e 
                    condições abaixo e prossiga para o pagamento. <br>
                    <strong>TERMOS E CONDIÇÕES</strong> <br>
                    Ao prosseguir com a inscrição na VIII UNIF, você concorda com os seguintes termos e condições: <br>
                    -Será cobrada uma taxa no valor de R$25,00 para confirmar sua inscrição na UNIF; valor especial e único para alunos
                    que possuem o Cadastro Único para Programas Sociais. O pagamento deverá ser realizado conforme instruções fornecidas no final deste formulário. <br>
                    -É necessário enviar o comprovante de pagamento no campo informado ao final do formulário para confirmar sua inscrição. <br>
                    -Pode haver necessidade de realocação das suas escolhas de comitês ou representações de acordo com a disponibilidade e necessidade da
                    simulação. Faremos o possível para acomodar suas preferências, mas mudanças podem ser necessárias.<br>
                    -As informações fornecidas neste formulário são verdadeiras e precisas. Qualquer informação falsa pode resultar
                    na desqualificação da inscrição.<br>
                    -Concordo em participar do evento presencialmente, durante os dias 21 à 23 de junho, no IFMG - Campus Ouro Branco,
                    localizado na Rua Afonso Sardinha 90,Minas Talco - Ouro Branco, Minas Gerais<br>
                    Ao marcar a caixa abaixo, você confirma que leu e concorda com os termos e condições acima mencionados.<br>
                    <div class="terms">
                            <input type="checkbox" id="outraInstCad_input" name="outraInstCad" value="">
                            <label for="outraInstCad_input" >Li e Concordo com os Termos e Condições</label>
                        </div>
                        <label> <strong>PAGAMENTO</strong> <br>
                            DADOS BANCÁRIOS <br>
                            Favorecido: Thaissa Azevedo Resende <br>
                            Agência: 2042-7 <br>
                            Conta corrente: 21719-0 <br>
                            Chave PIX: 31998828052 <br>
                            Valor: R$25,00 <br>

                        </label>
                        <label > <strong>Insira o comprovante do pagamento a
                        baixo</strong></label>
                        <label> Qualquer dúvida ou imprevisto contate o secretariado: unif.ourobranco@ifmg.edu.br</label>

                        <label for="fileUpload">Envie seu arquivo (PNG ou PDF):</label>
                        <input type="file" id="fileUpload" name="fileUpload" accept=".png, .pdf">
                    </label>
                </div>


                <div class="button-container">
                    <button type="submit">Enviar</button>
                </div>
            </form>
        </div>
    </div>

    <script src="../script/pegar_representacoes.js"></script>

</body>

</html>