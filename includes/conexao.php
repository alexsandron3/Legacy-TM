<?php 
//CRIANDO CONEXÃO
$conexao = mysqli_connect($_ENV['dbHost'], $_ENV['dbUser'], $_ENV['dbPass'], $_ENV['dbName']);

//VERIFICANDO CONEXÃO
if (!$conexao) {
    die("Conexão falhou: " . mysqli_connect_error());
}


?>


