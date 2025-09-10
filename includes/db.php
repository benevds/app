<?php
require_once __DIR__ . '/../config.php';

$link = mysqli_connect(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_NAME);

if($link === false){
    die("ERRO: Não foi possível conectar. " . mysqli_connect_error());
}
?>
