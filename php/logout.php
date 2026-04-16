<?php
session_start();

// Verifica se há uma sessão ativa
if (isset($_SESSION['usuario_id'])) {
    // Destrói a sessão para deslogar o usuário
    session_unset();
    session_destroy();
}

// Redireciona para a página de login
header("Location: http://localhost/Muniverse/MUNIVERSE-main/html/login.html");
exit();
?>
