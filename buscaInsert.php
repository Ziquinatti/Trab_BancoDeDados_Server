<?php
    $_POST = json_decode(file_get_contents('php://input'), true);

    include "conexao.php";

    $id = $_POST['idVotos'];
    //$id = 1;

    $sql = "SELECT u.nome AS user, tv.ano AS ano, tv.turno AS turno, e.nome AS estado, c2.nome AS cidade, z.numero AS zona, s.numero AS secao, c.nome AS candidato, tv.num_votos AS votos
    FROM tmp_votos tv
    INNER JOIN candidato c ON tv.fk_idCandidato = c.idCandidato
    INNER JOIN secao s ON tv.fk_idSecao = s.idSecao
    INNER JOIN zona z ON s.fk_idZona = z.idZona
    INNER JOIN cidade c2 ON z.fk_idCidade = c2.idCidade
    INNER JOIN estado e ON c2.fk_idEstado = e.idEstado
    INNER JOIN usuario u ON tv.fk_idUsuario = u.idUsuario
    WHERE tv.idTmp_Votos = '$id'";

    $result = $conn->query($sql);

    //echo $result->num_rows;

    if($result->num_rows > 0){
        //echo "sucesso";
        $r = $result->fetch_assoc();
        $rows = array(
            0 => $r['user'],
            1 => $r['ano'],
            2 => $r['turno'],
            3 => $r['estado'],
            4 => $r['cidade'],
            5 => $r['zona'],
            6 => $r['secao'],
            7 => $r['candidato'],
            8 => $r['votos']
        );

        $data = array("BUSCA"=>"OK", "RESULT"=>$rows);
    } else {
        //echo "erro";
        $data = array("BUSCA"=>"ERRO");
    }

    echo json_encode($data);
?>