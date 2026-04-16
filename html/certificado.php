<html lang="pt-br">

<head>
  <meta charset="utf-8" />
  <script src="../script/scriptGeral.js"></script>
  <script src="https://unpkg.com/pdf-lib@1.4.0"></script>
  <script src="https://unpkg.com/downloadjs@1.4.7"></script>
  <script src="https://cdn.emailjs.com/dist/email.min.js"></script>
  <link rel="stylesheet" href="../formatacao.css">
  <link rel="stylesheet" href="../css/menu.css">
</head>

<body class="BodyCertificado">
  <div id="barrinha">
    <img id="logoNaDireita" src="../image/logoBarra.png" alt="logo">
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

  <br><br>
  <div id="divcertificado">
    <h1 id="titulo-certificado">Selecione ou Crie um Modelo</h1>

    <?php
    // Incluir o arquivo de conexão
    include('../php/conexao.php');

    // Consultar os nomes dos comitês na tabela 'comite'
    $query = "SELECT nome_comite FROM comite";
    $result = mysqli_query($conn, $query);

    // Verificar se a consulta retornou resultados
    if ($result) {
        // Gerar o código do <select> dinamicamente
        echo '<select id="comite-select" class="comite-select" data-nome="${delegado.nome}">';
        echo '<option value="" selected hidden>Escolha um Comite</option>';
        echo "<option value=\"\">Todos os Delegados</option>";
        // Percorrer os resultados e criar as opções
        while ($row = mysqli_fetch_assoc($result)) {
            $nome_comite = $row['nome_comite'];
            echo "<option value=\"$nome_comite\">$nome_comite</option>";
        }
        echo '</select>';
    } else {
        echo "Erro ao buscar comitês: " . mysqli_error($conn);
    }
    ?>

    <br>
    <img style="margin-left: 5rem;" class="imagemcertificado" src="../image/ModeloDeCertificadoSec.png" alt="">
    <br>
    <pre style="margin-left: 7.5rem" class="text-certificado">
Modelo com assinatura do
Secretario Geral
    </pre>
    <img style="align-self: center;" class="imagemcertificado" src="../image/ModeloDeCertificado.png" alt="">
    <br>
    <pre style="align-self: center;" class="text-certificado">
Modelo com assinatura do
Secretário Geral e do Diretor da
Instituição
    </pre>
    <a href="" style="align-self: end; margin-right: 5rem;" class="imagemcertificado">
      <img src="../image/AddModelo.png" style="width: 25rem; height: 18rem;" alt="">
    </a>
    <br>
    <pre style="align-self: end; margin-right: 7.5rem;" class="text-certificado">
Insira seu próprio modelo
    </pre>
  </div>

  <?php
  include('../php/conexao.php');
  session_start();
  echo '<script>
document.getElementById("comite-select").addEventListener("change", function() {
   const selectedValue = this.value;
   console.log("Comitê selecionado:", selectedValue);

   // Enviar valor ao PHP via fetch
   fetch("../php/atualizar_comite.php", {
      method: "POST",
      headers: {
         "Content-Type": "application/x-www-form-urlencoded"
      },
      body: "comite=" + selectedValue
   })
   .then(response => response.text()) // A resposta do PHP
   .then(data => {
      console.log(data); // Exibe a resposta do servidor no console
   })
   .catch(error => {
      console.error("Erro:", error);
   });
});
</script>';
  ?>

  <button id="GerarPdfBtn">Gerar Certificados</button>

  <script src="../script/scriptCertificado.js"></script>
</body>

</html>
