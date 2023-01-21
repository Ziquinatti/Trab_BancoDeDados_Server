<?php
    $_POST = json_decode(file_get_contents('php://input'), true);

    include "conexao.php";

    $turno = $_POST['turno'];
    $estado = $_POST['estado'];
    $cidade = $_POST['cidade'];
    $zona = $_POST['zona'];
    $secao = $_POST['secao'];

    $ano = date('Y');

    if($estado == 0){
        //TODOS OS VOTOS DO PAÍS
        $sql = "SELECT c.nome AS Candidato, SUM(v.num_votos) AS QtdeVotos FROM tmp_votos v
        INNER JOIN candidato c ON v.fk_idCandidato = c.idCandidato
        WHERE v.ano = '$ano' AND v.turno = '$turno' GROUP BY c.nome";
    }
    else if(strcmp($cidade, "Todos municípios") == 0){
        //TODOS OS VOTOS DE UM ESTADO
        $sql = "SELECT c.nome AS Candidato, SUM(v.num_votos) AS QtdeVotos FROM tmp_votos v
        INNER JOIN candidato c ON v.fk_idCandidato = c.idCandidato
        INNER JOIN secao s ON v.fk_idSecao = s.idSecao
        INNER JOIN zona z ON s.fk_idZona = z.idZona
        INNER JOIN cidade c2 ON z.fk_idCidade = c2.idCidade
        INNER JOIN estado e ON c2.fk_idEstado = e.idEstado
        WHERE v.ano = '$ano' AND v.turno = '$turno' AND e.idEstado = '$estado'
        GROUP BY c.nome";
    }
    else if(strcmp($zona, "Todas zonas") == 0){
        //TODOS OS VOTOS DE UM MUNICÍPIO
        $idCidade = buscaIdCidade($conn, $cidade, $estado);

        $sql = "SELECT c.nome AS Candidato, SUM(v.num_votos) AS QtdeVotos FROM tmp_votos v
        INNER JOIN candidato c ON v.fk_idCandidato = c.idCandidato
        INNER JOIN secao s ON v.fk_idSecao = s.idSecao
        INNER JOIN zona z ON s.fk_idZona = z.idZona
        INNER JOIN cidade c2 ON z.fk_idCidade = c2.idCidade
        WHERE v.ano = '$ano' AND v.turno = '$turno' AND c2.idCidade = '$idCidade'
        GROUP BY c.nome";
    }
    else if(strcmp($secao, "Todas secoes")){
        //TODOS OS VOTOS DE UMA ZONA
        $idCidade = buscaIdCidade($conn, $cidade, $estado);
        $idZona = buscaIdZona($conn, $zona, $idCidade);

        $sql = "SELECT c.nome AS Candidato, SUM(v.num_votos) AS QtdeVotos FROM tmp_votos v
        INNER JOIN candidato c ON v.fk_idCandidato = c.idCandidato
        INNER JOIN secao s ON v.fk_idSecao = s.idSecao
        INNER JOIN zona z ON s.fk_idZona = z.idZona
        WHERE v.ano = '$ano' AND v.turno = '$turno' AND z.idZona = '$idZona'
        GROUP BY c.nome";
    }
    else {
        //TODOS OS VOTOS DE UMA SEÇÃO
        $idCidade = buscaIdCidade($conn, $cidade, $estado);
        $idZona = buscaIdZona($conn, $zona, $idCidade);
        $idSecao = buscaIdSecao($conn, $secao, $idZona);

        $sql = "SELECT c.nome AS Candidato, SUM(v.num_votos) AS QtdeVotos FROM tmp_votos v
        INNER JOIN candidato c ON v.fk_idCandidato = c.idCandidato
        INNER JOIN secao s ON v.fk_idSecao = s.idSecao
        WHERE v.ano = '$ano' AND v.turno = '$turno' AND s.idSecao = '$idSecao'
        GROUP BY c.nome";
    }

    $result = $conn->query($sql);
    if($result->num_rows > 0){
        //SUCESSO
        $rows = array();
        while($r = mysqli_fetch_assoc($result)) {
            $array = array(0 => $r['Candidato'], 1 => $r['QtdeVotos']);
            $rows[] = $array;
        }
        $data = array("BUSCA"=>"OK", "VOTOS"=>$rows);
    } else {
        //ERRO
        $data = array("BUSCA"=>"ERRO");
    }

    echo json_encode($data);

    function buscaIdSecao($conn, $secao, $zona){
        $sql = "SELECT idSecao FROM secao WHERE numero = '$secao' AND fk_idZona = '$zona'";
        $result = $conn->query($sql);
        $row = $result->fetch_assoc();
        return $row['idSecao'];
    }

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