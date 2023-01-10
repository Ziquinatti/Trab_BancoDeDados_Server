<?php
    include("conexao.php");

    $email = $_POST['email'];
    $senha = $_POST['senha'];
    // $email = "winglisson@teste.com";
    // $senha = "123456";

    $sql_read = "SELECT id, nome FROM usuario WHERE email = :EMAIL AND senha = :SENHA";

    $stmt = $PDO->prepare($sql_read);

    $stmt->bindParam(':EMAIL', $email);
    $stmt->bindParam(':SENHA', $senha);

    if($stmt->execute()){
        $dados = $stmt->fetch();
        $result = array("LOGIN"=>"OK", "ID"=>$dados['id'], "NOME"=>$dados['nome']);
    } else {
        $result = array("LOGIN"=>"ERRO");
    }

    echo json_encode($result);
?>