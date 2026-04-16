<?php
require 'conexao.php';

session_start();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $login = $_POST['NomeUsertxt'];
    $senha = $_POST['Senhatxt'];

    // Consulta para pegar id, nome_user, senha e foto
    $stmt = $conn->prepare("SELECT id, nome_user, senha, foto FROM usuario WHERE nome_user = ? OR email = ?");
    $stmt->bind_param("ss", $login, $login);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows > 0) {
        $stmt->bind_result($usuario_id, $nome_user, $senhaArmazenada, $foto);
        $stmt->fetch();

        if (password_verify($senha, $senhaArmazenada)) {
            // Armazenar id, nome_user e foto na sessão
            $_SESSION['user_id'] = $usuario_id;
            $_SESSION['nome_user'] = $nome_user;
            $_SESSION['foto'] = $foto; // Armazenar foto na sessão

            // Verifica se a foto existe
            if (!empty($foto)) {
                // Converte a imagem binária para base64 e exibe
                $fotoBase64 = base64_encode($foto);
                $fotoUrl = 'data:image/jpeg;base64,' . $fotoBase64; // Ajuste conforme o tipo da imagem
            } else {
                $fotoUrl = null;
            }

            // Redirecionar
            echo "<script>
                    window.location.href = '../index.php';
            </script>";

        } else {
            echo "<script>alert('Senha incorreta.'); window.history.back();</script>";
        }
    } else {
        echo "<script>alert('Usuário não encontrado.'); window.history.back();</script>";
    }

    $stmt->close();
}
?>

<!-- HTML para exibir o nome de usuário e foto -->
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Perfil do Usuário</title>
</head>
<body>
    <h1>Bem-vindo, <?php echo isset($nome_user) ? htmlspecialchars($nome_user) : ''; ?>!</h1>

    <div>
        <h2>Foto do Usuário:</h2>
        <?php
        if (isset($fotoUrl)) {
            echo "<img src='" . $fotoUrl . "' alt='Foto do usuário' width='150' height='150' />";
        } else {
            echo "<p>Foto não disponível.</p>";
        }
        ?>
    </div>
</body>
</html>
