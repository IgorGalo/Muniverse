<?php

require 'conexao.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_FILES['arquivo'])) {
    $file = $_FILES['arquivo'];
    $fileName = $file['name'];
    $fileTmpName = $file['tmp_name'];
    $fileError = $file['error'];

    // Verificar se o parâmetro id_edicao foi passado na URL
    if (isset($_GET['id'])) {
        $id_comite = $_GET['id'];
    } else {
        echo "ID da edição não fornecido.";
        exit();
    }

    // Verificar se não houve erro no upload
    if ($fileError === 0) {
        // Verificar se o arquivo foi enviado
        if (is_uploaded_file($fileTmpName)) {
            // Ler o conteúdo do arquivo para armazenar no banco de dados
            $fileContent = file_get_contents($fileTmpName);
            if ($fileContent === false) {
                echo "Erro ao ler o conteúdo do arquivo.";
                exit();
            }

            // Verificar o tamanho do conteúdo
            $fileSize = strlen($fileContent);

            // Inserir o nome do arquivo, o conteúdo binário e o id_edicao no banco de dados
            $sql = "INSERT INTO arquivos (nome_arquivo, dados_arquivo, id_comite) VALUES (?, ?, ?)";
            $stmt = $conn->prepare($sql);
            if ($stmt === false) {
                echo "Erro na preparação da consulta: " . $conn->error;
                exit();
            }

            // Passar o conteúdo do arquivo e o id_edicao para a consulta
            $stmt->bind_param("ssi", $fileName, $fileContent, $id_comite); // Alterado para 'i' para o id_edicao

            $stmt->send_long_data(1, $fileContent); // Enviando o conteúdo binário

            if ($stmt->execute()) {
                header("Location: ../html/comite.php?id=$id_comite");
            } else {
                echo "Erro ao salvar no banco de dados: " . $stmt->error;
            }
        } else {
            echo "Arquivo não enviado.";
        }
    } else {
        echo "Erro ao enviar o arquivo: " . $fileError;
    }
}
