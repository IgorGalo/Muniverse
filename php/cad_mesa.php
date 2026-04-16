<?php
include_once 'conexao.php';

if ($conn->connect_error) {
    die("Falha na conexão: " . $conn->connect_error);
}

function redimensionarImagem($arquivo, $larguraMaxima, $alturaMaxima) {
    list($larguraOriginal, $alturaOriginal, $tipo) = getimagesize($arquivo);

    // Calcula as proporções para redimensionar
    $proporcaoOriginal = $larguraOriginal / $alturaOriginal;
    if ($larguraMaxima / $alturaMaxima > $proporcaoOriginal) {
        $larguraFinal = $alturaMaxima * $proporcaoOriginal;
        $alturaFinal = $alturaMaxima;
    } else {
        $larguraFinal = $larguraMaxima;
        $alturaFinal = $larguraMaxima / $proporcaoOriginal;
    }

    // Cria uma nova imagem baseada no tipo
    switch ($tipo) {
        case IMAGETYPE_JPEG:
            $imagemOriginal = imagecreatefromjpeg($arquivo);
            break;
        case IMAGETYPE_PNG:
            $imagemOriginal = imagecreatefrompng($arquivo);
            break;
        case IMAGETYPE_GIF:
            $imagemOriginal = imagecreatefromgif($arquivo);
            break;
        default:
            throw new Exception('Formato de imagem não suportado.');
    }

    // Cria a nova imagem redimensionada
    $imagemRedimensionada = imagecreatetruecolor($larguraFinal, $alturaFinal);
    imagecopyresampled(
        $imagemRedimensionada, 
        $imagemOriginal, 
        0, 0, 0, 0, 
        $larguraFinal, 
        $alturaFinal, 
        $larguraOriginal, 
        $alturaOriginal
    );

    // Salva a imagem redimensionada em um buffer
    ob_start();
    imagejpeg($imagemRedimensionada, null, 90); // Qualidade 90%
    $conteudoImagem = ob_get_clean();

    // Libera memória
    imagedestroy($imagemOriginal);
    imagedestroy($imagemRedimensionada);

    return $conteudoImagem;
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    // INSCRIÇÃO COMITE
    $nome_comite = $conn->real_escape_string($_POST['nome']);
    $desc_comite = $conn->real_escape_string($_POST['desc']);
    $email_comite = $conn->real_escape_string($_POST['email']);
    $orgao_comite = $conn->real_escape_string($_POST['orgao']);
    $tema_comite = $conn->real_escape_string($_POST['tema']);
    $quando_comite = $conn->real_escape_string($_POST['quando']);
    $num_deleg = $conn->real_escape_string($_POST['deleg']);
    $questao_comite = $conn->real_escape_string($_POST['topico']);
    $motivacao_tema = $conn->real_escape_string($_POST['motivoTema']);

    $carater_comite = isset($_POST['carater_comite']) ? $_POST['carater_comite'] : null;
    $tipo_comite = isset($_POST['tipo_comite']) ? $_POST['tipo_comite'] : null;
    $idioma_comite = isset($_POST['idioma_comite']) ? $_POST['idioma_comite'] : null;
    $guia_comite = isset($_POST['guia_comite']) ? $_POST['guia_comite'] : null;
    $decor_comite = isset($_POST['decor_comite']) ? $_POST['decor_comite'] : null;
    $dossie_comite = isset($_POST['dossie_comite']) ? $_POST['dossie_comite'] : null;

    // Verifica se o parâmetro 'id' está presente na URL
    if (isset($_GET['id'])) {
        // Obtém o valor do 'id' diretamente da URL
        $id_edicao = intval($_GET['id']); // Use intval para garantir que seja um número
      echo "<script>console.log('ID da edição obtido da URL: $id_edicao');</script>";
    } else {
     // Exibe uma mensagem de erro se o ID não estiver na URL
     $id_edicao = 0; // Use intval para garantir que seja um número
     echo "<script>console.log('ID da edição não encontrado na URL');</script>";
    }

    if ($carater_comite === null || $tipo_comite === null || $idioma_comite === null || $guia_comite === null || $decor_comite === null || $dossie_comite === null) {
        exit;
    }

    if (isset($_FILES['proposta']) && $_FILES['proposta']['error'] === UPLOAD_ERR_OK) {
        $proposta_comite = file_get_contents($_FILES['proposta']['tmp_name']);
        $proposta_comite = $conn->real_escape_string($proposta_comite);
    } else {
        $proposta_comite = null;
    }

    // Redimensiona a imagem ou usa a imagem padrão
    if (isset($_FILES['foto']) && $_FILES['foto']['error'] == UPLOAD_ERR_OK) {
        $foto_comite = redimensionarImagem($_FILES['foto']['tmp_name'], 800, 600);
    } else {
        $foto_comite = redimensionarImagem('../image/semIMG.png', 800, 600);
    }

    $foto_comite = $conn->real_escape_string($foto_comite);


    $sql = "INSERT INTO `comite` (`aprovacao`,`email_comite`, `proposta_comite`, `orgao_comite`,
    `carater_comite`, `tema_comite`, `tipo_comite`, `quando_comite`, `idioma_comite`,
    `num_deleg`, `questao_comite`, `motivacao_tema`, `guia_comite`, `decor_comite`,
    `dossie_comite`, `nome_comite`, `id_edicao`, `foto_comite`, `descricao`) 
    VALUES (FALSE,'$email_comite', '$proposta_comite', '$orgao_comite', '$carater_comite',
    '$tema_comite', '$tipo_comite', '$quando_comite', '$idioma_comite', 
    '$num_deleg', '$questao_comite', '$motivacao_tema', '$guia_comite',
    '$decor_comite', '$dossie_comite', '$nome_comite', '$id_edicao', '$foto_comite', '$desc_comite')";

    if ($conn->query($sql) === TRUE) {
        echo "<script>console.log('Cadastro realizado com sucesso!');</script>";
    } else {
        echo "<script>
                console.log('Erro na execução do SQL: " . $conn->error . "');
              </script>";
        echo "Erro: " . $sql . "<br>" . $conn->error;
    }

    // INSCRIÇÃO DIRETORES
    $num_dir = $conn->real_escape_string($_POST['quantDire']);

    for ($i = 1; $i <= $num_dir; $i++) {
        $contato = $conn->real_escape_string($_POST["contato-$i"]);
        $nome = $conn->real_escape_string($_POST["nome-$i"]);
        $idade = $conn->real_escape_string($_POST["idade-$i"]);
        $instituicao = $conn->real_escape_string($_POST["InstEns-$i"]);
        $historico = $conn->real_escape_string($_POST["historico-$i"]);
        $motivacao = $conn->real_escape_string($_POST["motivacao-$i"]);

        // Monta a consulta por comite
        $sql2 = "SELECT id FROM comite WHERE nome_comite = '$nome_comite'";

        // Executa a consulta
        $result = $conn->query($sql2);

        // Verifica se encontrou algum registro
        if ($result->num_rows > 0) {
            // Extrai o valor do id
            $row = $result->fetch_assoc();
            $id_edicao = $row['id'];
            echo "<script>console.log('Comitê encontrado: $id_edicao');</script>";
        } else {
            echo "<script>
            console.log('Nenhum comitê encontrado com o nome: $nome_comite');
            </script>";
        }


        $sql3 = "INSERT INTO `tb_diretor`( `contato`, `nome`, `idade`, `instituicao`,
        `historico`, `motivacao`, `id_comite`)
        VALUES ('$contato','$nome','$idade','$instituicao',
        '$historico','$motivacao', '$id_edicao')";

        

        if ($conn->query($sql3) === TRUE) {
            echo "<script>console.log('Cadastro de Diretores realizado com sucesso!');</script>";
        } else {
            echo "<script>
                    console.log('Erro na execução do SQL: " . $conn->error . "');
                  </script>";
            echo "Erro: " . $sql3 . "<br>" . $conn->error;
        }
    }

    echo "<script>
                window.location.href = '../index.php';
              </script>";

    // Fecha a conexão
    $conn->close();
}
?>
