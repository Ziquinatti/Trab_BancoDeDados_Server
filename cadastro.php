<?php
    include "conexao.php";

    $nome = $_POST['nome'];
    $email = $_POST['email'];
    $senha = $_POST['senha'];

    $sql_insert = "INSERT INTO usuario (nome, email, senha) VALUES (:NOME, :EMAIL, :SENHA)";

    $stmt = $PDO->prepare($sql_insert);

    $stmt->bindParam(':NOME', $nome);
    $stmt->bindParam(':EMAIL', $email);
    $stmt->bindParam(':SENHA', $senha);

    if($stmt->execute()){
        $id = $PDO->lastInsertId();
        $dados = array("CADASTRO"=>"OK", "ID"=>$id);
    } else {
        $dados = array("CADASTRO"=>"ERRO");
    }

    echo json_encode($dados);
?>