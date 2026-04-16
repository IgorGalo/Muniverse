<?php 
// Inclui o arquivo de conexão
include_once 'conexao.php';

// Função para exibir erros na tela
function logErro($mensagem) {
    echo "<div style='background-color: #ffdddd; color: #a94442; border: 1px solid #a94442; padding: 10px; margin: 10px 0;'>
            <strong>Erro:</strong> {$mensagem}
          </div>";
}

// Função para redimensionar a imagem
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

// Verifique se o formulário foi enviado
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Coleta os dados do formulário
    $nome_edicao = $_POST['nome_edicao'];
    $descricao = $_POST['descricao'];
    $data_inicio = $_POST['data_inicio'];
    $data_fim = $_POST['data_fim'];
    $inicio_mesa = $_POST['inicio_mesa'];
    $fim_mesa = $_POST['fim_mesa'];
    $inicio_deleg = $_POST['inicio_deleg'];
    $fim_deleg = $_POST['fim_deleg'];


    try {
        // Redimensiona a imagem ou usa a imagem padrão
        if (isset($_FILES['foto']) && $_FILES['foto']['error'] == UPLOAD_ERR_OK) {
            $foto_edicao = redimensionarImagem($_FILES['foto']['tmp_name'], 800, 600);
        } else {
            $foto_edicao = redimensionarImagem('../image/semIMG.png', 800, 600);
        }

        if (isset($_FILES['fundo']) && $_FILES['fundo']['error'] == UPLOAD_ERR_OK) {
            $foto_fundo = redimensionarImagem($_FILES['fundo']['tmp_name'], 800, 600);
        } else {
            $foto_fundo = redimensionarImagem('../image/semIMG.png', 800, 600);
        }

        // Escapa os dados antes de inserir no banco
        $foto_edicao = $conn->real_escape_string($foto_edicao);
        $foto_fundo = $conn->real_escape_string($foto_fundo);

        // Insere os dados no banco de dados
        $sql = "INSERT INTO edicao (data_inicio, data_fim, nome, foto_edicao, descricao, foto_fundo, inicio_mesa, fim_mesa, inicio_deleg, fim_deleg) 
                VALUES ('$data_inicio', '$data_fim', '$nome_edicao', '$foto_edicao', '$descricao', '$foto_fundo', '$inicio_mesa', '$fim_mesa', '$inicio_deleg', '$fim_deleg')";

        if ($conn->query($sql) === TRUE) {
            echo "<script>
                    window.location.href = '../index.php';
                  </script>";
        } else {
            throw new Exception("Erro ao executar a consulta SQL: " . $conn->error);
        }
    } catch (Exception $e) {
        // Exibe o erro na tela
        logErro($e->getMessage());
    } finally {
        // Fecha a conexão
        $conn->close();
    }
}
?>
