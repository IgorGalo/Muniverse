<?php
// Exibir erros para depuração
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

session_start(); // Iniciar a sessão

require 'conexao.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nome_completo = $_POST['txtNomeC'];
    $nome_usuario = $_POST['txtNomeUser'];
    $email = $_POST['txtEmail'];
    $senha = $_POST['txtSenha'];
    $data_nascimento = $_POST['txtData'];
    $cpf = $_POST['txtCpf'];
    
    $fotoPath = "../image/User.jpg";
    $fotoContent = file_get_contents($fotoPath);

    $presenca = 0; // Define um valor padrão para o campo 'presenca'

    // Verifica campos obrigatórios
    if (!$nome_completo || !$nome_usuario || !$email || !$senha || !$data_nascimento || !$cpf) {
        echo "<script>alert('Por favor, preencha todos os campos obrigatórios.'); window.history.back();</script>";
        exit;
    }

    // Cria o hash da senha
    $senha_hash = password_hash($senha, PASSWORD_DEFAULT);

    // Verifica se o nome de usuário já existe
    $stmt = $conn->prepare("SELECT id FROM usuario WHERE nome_user = ?");
    $stmt->bind_param("s", $nome_usuario);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows > 0) {
        echo "<script>alert('Nome de usuário já está em uso. Escolha outro nome.'); window.history.back();</script>";
        $stmt->close();
        exit;
    }
    $stmt->close();

    // Inserindo o usuário no banco
    $stmt = $conn->prepare("INSERT INTO usuario (nome, nome_user, email, senha, data_nasc, cpf, foto, presenca) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("ssssssss", $nome_completo, $nome_usuario, $email, $senha_hash, $data_nascimento, $cpf, $fotoContent, $presenca);

    if ($stmt->execute()) {
        // Armazena o ID do último usuário inserido
        $user_id = $conn->insert_id;

        // Armazenar id, nome_user e foto na sessão
        $_SESSION['user_id'] = $user_id;
        $_SESSION['nome_user'] = $nome_usuario;
        $_SESSION['foto'] = $fotoContent; // Armazenar foto na sessão

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


        // Redireciona para a página inicial
        header("Location: ../index.php");
        exit;
    } else {
        echo "<script>alert('Erro ao inserir o registro: " . $stmt->error . "'); window.history.back();</script>";
    }
    $stmt->close();
}
?>
