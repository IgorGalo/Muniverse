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
    <title>Inscrição Staff</title>
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
        color: #006270;
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
            <h2>Inscrição de Staff</h2>

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

            <script>
                 function show(id1, id2) {
                 document.getElementById(id1).style.display = 'block';
                 document.getElementById(id2).style.display = 'block';
             }

                 function hide(id1, id2) {
                 document.getElementById(id1).style.display = 'none';
                 document.getElementById(id2).style.display = 'none';
            }
            </script>

            <form action="../php/cad_staff.php?id=<?php echo htmlspecialchars($id_edicao); ?>" method="POST" id="form_staff" enctype="multipart/form-data">
                <label>Os STAFF são essenciais para que a UNIF seja um sucesso, portanto, eles são de extrema 
                importância para nós. <br>
                Vocês serão nossos braços e nossas mãos e nos ajudarão na organização dos lanches, das salas, 
                da logística do evento. <br>
                ATENÇÃO: Os STAFFs não simulam, não participam dos comitês e ficam mais nos bastidores. <br> 
                Se você tem interesse em nos ajudar, se inscreva para uma das vagas de STAFF no formulário a seguir. <br>
                Lembramos que são poucas vagas e que os nomes selecionados recebem certifcado de 
                participação da UNIF, sem precisar pagar a taxa de inscrição do evento. <br>
                Os selecionados serão convocados para a próxima etapa avaliativa, fiquem atento aos canais de comunicação. <br> </label>
                
                <div>
                    <label>
                        <strong> Ano e turma </strong></label>
                    <label>
                        <input type="radio" id="ADM_1" name="turma" value="ADM 1" > ADM 1
                    </label>
                    <label>
                        <input type="radio" id="ADM_2" name="turma" value="ADM 2" > ADM 2
                    </label>
                    <label>
                        <input type="radio" id="ADM_3" name="turma" value="ADM 3" > ADM 3
                    </label>
                    <label>
                        <input type="radio" id="INFO_1" name="turma" value="INFO 1" > INFO 1
                    </label>
                    <label>
                        <input type="radio" id="INFO_2" name="turma" value="INFO 2" > INFO 2
                    </label>
                    <label>
                        <input type="radio" id="INFO_3" name="turma" value="INFO 3" > INFO 3
                    </label>
                    <label>
                        <input type="radio" id="MET_1" name="turma" value="MET 1" > MET 1
                    </label>
                    <label>
                        <input type="radio" id="MET_2" name="turma" value="MET 2" > MET 2
                    </label>
                    <label>
                        <input type="radio" id="MET_3" name="turma" value="MET 3" > MET 3
                    </label>
                    
                </div>
                <div>
                <label>
                        <strong>Já participou da UNIF? Como?</strong></label>
                    <label>
                        <input type="checkbox" id="partNunca" name="participacao" value="partNunca" > Nunca participei
                    </label>
                    <label>
                        <input type="checkbox" id="partStaff" name="participacao" value="partStaff" > Staff
                    </label>
                    <label>
                        <input type="checkbox" id="partDiretor" name="participacao" value="partDiretor" > Diretor                                      
                    </label>
                    <label>
                        <input type="checkbox" id="partDelegado" name="participacao" value="partDelegado" > Delegado
                    </label>
                    <label>
                        <input type="checkbox" id="partMock" name="participacao" value="partMock" > Mock
                    </label>
                    <label>
                        <input type="checkbox" id="partSecretariado" name="participacao" value="partSecretariado" > Secretariado
                    </label>
                </div>

                <div>
                    <label>
                        <strong> Qual função você gostaria de assumir? </strong></label>
                    <label>
                        <input type="radio" id="funcaoLog" name="funcao" value="logistica" onclick="hide('comite_label', 'comite_input'); hide('outra_label', 'outra_input')"> Logística
                    </label>
                    <label>
                        <input type="radio" id="funcaoDeco" name="funcao" value="decoracao" onclick="hide('comite_label', 'comite_input'); hide('outra_label', 'outra_input')"> Decoração
                    </label>
                    <label>
                        <input type="radio" id="funcaoCozi" name="funcao" value="cozinha" onclick="hide('comite_label', 'comite_input'); hide('outra_label', 'outra_input')"> Cozinha
                    </label>
                    <label>
                        <input type="radio" id="funcaoComi" name="funcao" value="comite" onclick="show('comite_label', 'comite_input'); hide('outra_label', 'outra_input')"> Comitê
                    </label>
                    <label for="outra">Outra:</label>
                    <input type="text" id="outra_funcao" name="outra_funcao">
                    
                </div>

                <label>
                <strong>Por que você deve ser escolhido para trabalhar como STAFF na UNIF?</strong></label>
                <input type="text" id="justStaff" name="justificativa" value="" > 

                <div>
                    
                </div>
                
                <div class="button-container">
                    <button type="submit">Enviar</button>
                </div>
            </form>
        </div>
    </div>
</body>
</html>