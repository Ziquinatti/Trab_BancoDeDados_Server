<?php
    $_POST = json_decode(file_get_contents('php://input'), true);

    include "conexao.php";

    $email = $_POST['email'];
    $senha = $_POST['senha'];

    //$email = "testbot@teste.com";
    //$senha = "12345";

    $sql = "SELECT idUsuario, nome FROM usuario WHERE email = '$email' AND senha = '". md5($senha) ."'";
    $result = $conn->query($sql);

    if($result->num_rows > 0){
        //echo "sucesso";
        $row = $result->fetch_assoc();
        $data = array("LOGIN"=>"OK", "ID"=>$row['idUsuario'], "NOME"=>$row['nome']);
    } else {
        //echo "erro";
        $data = array("LOGIN"=>"ERRO");
    }

    echo json_encode($data);
?>