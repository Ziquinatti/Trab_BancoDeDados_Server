<?php
    include "conexao.php";

    $sql = "SELECT tv.idTmp_Votos as id, u.nome as user, tv.ano as ano, tv.turno as turno FROM tmp_votos tv
    INNER JOIN usuario u ON tv.fk_idUsuario = u.idUsuario";
    $result = $conn->query($sql);

    if($result->num_rows > 0){
        //echo "sucesso";
        $rows = array();
        while($r = mysqli_fetch_assoc($result)) {
            $array = array(0 => $r['id'], 1 => $r['user'], 2 => $r['ano'], 3 => $r['turno']);
            $rows[] = $array;
        }
        $data = array("BUSCA"=>"OK", "VOTOS"=>$rows);
    } else {
        //echo "erro";
        $data = array("BUSCA"=>"ERRO");
    }

    echo json_encode($data);
?>