<?php
$conn = new mysqli($_ENV['dbHost'], $_ENV['dbUser'], $_ENV['dbPass'], $_ENV['dbName']);
        if($conn->connect_errno){
            echo"FALHA AO SE CONECTAR COM O MYSQL: " . $conn->connect_error;
            exit();
        }
