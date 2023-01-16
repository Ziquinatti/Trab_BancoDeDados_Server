<?php
    if(isset($_POST['nome']) && isset($_POST['email']) && isset($_POST['senha'])){
        include "conexao.php";

        $nome = $_POST['nome'];
        $email = $_POST['email'];
        $senha = $_POST['senha'];

        //$nome = "TestBot";
        //$email = "testbot@teste.com";
        //$senha = "12345";

        $sql = "INSERT INTO usuario (nome, email, senha) VALUES('$nome', '$email', '". md5($senha) ."')";

        if(!$conn->query($sql)){
            echo "erro";
        } else {
            echo "sucesso";
        }
    }
?>