<?php
    $dsn = "mysql:host=localhost;dbname=trab_finalbd;charset=utf8";
    $user = "root";
    $senha = "12345";

    try{

        $PDO = new PDO($dsn, $user, $senha);

        //echo "<h1>Conectado com sucesso</h1>";

    } catch(PDOException $erro) {

        //echo "<h1>Ocorreu um erro</h1>";
        //echo $erro->getMessage();

    }
?>