<?php
    $_POST = json_decode(file_get_contents('php://input'), true);

    include "conexao.php";

    $estado = $_POST['estado'];
    $cidade = $_POST['cidade'];
    $zona = $_POST['zona'];

    $idCidade = buscaIdCidade($conn, $cidade, $estado);
    $idZona = buscaIdZona($conn, $zona, $idCidade);

    $sql = "SELECT numero FROM secao WHERE fk_idZona = '$idZona'";
    $result = $conn->query($sql);

    if($result->num_rows > 0){
        //echo "sucesso";
        $rows = array();
        while($r = mysqli_fetch_assoc($result)) {
            $rows[] = $r['numero'];
        }
        $data = array("BUSCA"=>"OK", "SECOES"=>$rows);
    } else {
        //echo "erro";
        $data = array("BUSCA"=>"ERRO");
    }

    echo json_encode($data);

    function buscaIdZona($conn, $zona, $cidade){
        $sql = "SELECT idZona FROM zona WHERE numero = '$zona' AND fk_idCidade = '$cidade'";
        $result = $conn->query($sql);
        $row = $result->fetch_assoc();
        return $row['idZona'];
    }

    function buscaIdCidade($conn, $cidade, $estado){
        $sql = "SELECT idCidade FROM cidade WHERE fk_idEstado = '$estado' AND nome = '$cidade'";
        $result = $conn->query($sql);
        $row = $result->fetch_assoc();
        return $row['idCidade'];
    }
?>