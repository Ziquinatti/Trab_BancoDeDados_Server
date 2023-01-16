<?php
    $_POST = json_decode(file_get_contents('php://input'), true);

    include "conexao.php";

    $nome = $_POST['nome'];
    $email = $_POST['email'];
    $senha = $_POST['senha'];

    //$nome = "TestBot";
    //$email = "testbot@teste.com";
    //$senha = "12345";

    $sql = "INSERT INTO usuario (nome, email, senha) VALUES('$nome', '$email', '". md5($senha) ."')";

    if(!$conn->query($sql)){
        //echo "erro";
        $data = array("CADASTRO"=>"ERRO");
    } else {
        //echo "sucesso";
        $lastId = $conn->insert_id;
        $data = array("CADASTRO"=>"OK", "ID"=>$lastId);
    }

    echo json_encode($data);
?>