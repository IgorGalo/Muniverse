<?php
$host = '127.0.0.1';
$dbname = 'muniverse_db';
$username = 'muniverse';
$password = '_}+b6yxj^F';

$conn = new mysqli($host, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Falha na conexão: " . $conn->connect_error);
} else {
    
}
?>
