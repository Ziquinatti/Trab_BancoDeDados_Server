<?php
    $_POST = json_decode(file_get_contents('php://input'), true);

    include "conexao.php";

    $id_estado = $_POST['estado'];

    $sql = "SELECT nome FROM cidade WHERE fk_idEstado = '$id_estado'";
    $result = $conn->query($sql);

    if($result->num_rows > 0){
        //echo "sucesso";
        $rows = array();
        while($r = mysqli_fetch_assoc($result)) {
            $rows[] = $r['nome'];
        }
        $data = array("BUSCA"=>"OK", "CIDADES"=>$rows);
    } else {
        //echo "erro";
        $data = array("BUSCA"=>"ERRO");
    }

    echo json_encode($data);
?>