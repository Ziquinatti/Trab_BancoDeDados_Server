<?php
    $server = "localhost";
    $username = "root";
    $password = "12345";
    $database = "trab_finalbd";

    $conn = new mysqli($server, $username, $password, $database);

    if($conn->connect_error){
        die("Conexão falhou: " . $conn->connect_error);
    } 
    /*else {
        echo "Conexão funcionando";
    }*/
?>