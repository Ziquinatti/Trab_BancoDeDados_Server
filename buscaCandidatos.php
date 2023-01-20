<?php
    include "conexao.php";

    $sql = "SELECT nome FROM candidato";
    $result = $conn->query($sql);

    if($result->num_rows > 0){
        //echo "sucesso";
        $rows = array();
        while($r = mysqli_fetch_assoc($result)) {
            $rows[] = $r['nome'];
        }
        $data = array("BUSCA"=>"OK", "CANDIDATOS"=>$rows);
    } else {
        //echo "erro";
        $data = array("BUSCA"=>"ERRO");
    }

    echo json_encode($data);
?>