<?php
session_start();
if (isset($_POST['comite'])) {
    $_SESSION['comite'] = $_POST['comite'];
    echo "Comitê atualizado para: " . $_SESSION['comite'];
}
?>
