<?php
    if(isset($_POST['email']) && isset($_POST['senha'])){
        include "conexao.php";

        $email = $_POST['email'];
        $senha = $_POST['senha'];

        //$email = "testbot@teste.com";
        //$senha = "12345";

        $sql = "SELECT * FROM usuario WHERE email = '$email' AND senha = '". md5($senha) ."'";
        $result = $conn->query($sql);
        if($result->num_rows > 0){
            echo "sucesso";
        } else {
            echo "erro";
        }
    }
?>