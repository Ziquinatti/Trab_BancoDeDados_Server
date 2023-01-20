<?php
    $_POST = json_decode(file_get_contents('php://input'), true);

    include "conexao.php";

    $turno = $_POST['turno'];               // 0 ou 1
    $estado = $_POST['estado'];             //Inteiro
    $cidade = $_POST['cidade'];             //String com o nome
    $zona = $_POST['zona'];                 //String com número
    $secao = $_POST['secao'];               //String com número
    $candidatos = $_POST['candidatos'];     //ArrayList<ArrayList<String>> [candidato, num_votos]
    $idUser = $_POST['user'];               //String com número

    $idCidade = buscaIdCidade($conn, $cidade, $estado);
    $idZona = buscaIdZona($conn, $zona, $idCidade);
    $idSecao = buscaIdSecao($conn, $secao, $idZona);

    for($i=0; $i<count($candidatos); $i++){
        $idCandidato = buscaIdCandidato($conn, $candidatos[$i][0]);
        $numVotos = $candidatos[$i][1];
        $ano = date("Y");
        $sql = "INSERT INTO tmp_votos (num_votos, turno, ano, fk_idSecao, fk_idCandidato, fk_idUsuario) VALUES('$numVotos', '$turno', '$ano', '$idSecao', '$idCandidato', '$idUser')";
        if(!$conn->query($sql)){
            //ERRO
            $ok = false;
            $data = array("CADVOTOS" => "ERRO", "ERRO" => $conn->error);
        }
    }
    
    if($ok){
        $data = array("CADVOTOS" => "OK");
    }
    echo json_encode($data);

    function buscaIdCidade($conn, $cidade, $estado){
        $sql = "SELECT idCidade FROM cidade WHERE fk_idEstado = '$estado' AND nome = '$cidade'";
        $result = $conn->query($sql);
        $row = $result->fetch_assoc();
        return $row['idCidade'];
    }

    function buscaIdZona($conn, $numero, $fk_cidade){
        $sql = "SELECT idZona FROM zona WHERE fk_idCidade = '$fk_cidade' AND numero = '$numero'";
        $result = $conn->query($sql);
        if($result->num_rows > 0){
            $row = $result->fetch_assoc();
            return $row['idZona'];
        } else {
            $sql = "INSERT INTO zona (numero, fk_idCidade) VALUES ('$numero', '$fk_cidade')";
            if(!$conn->query($sql)){
                //ERRO
            } else {
                //SUCESSO
                $lastId = $conn->insert_id;
                return $lastId;
            }
        }
    }

    function buscaIdSecao($conn, $numero, $fk_zona){
        $sql = "SELECT idSecao FROM secao WHERE fk_idZona = '$fk_zona' AND numero = '$numero'";
        $result = $conn->query($sql);
        if($result->num_rows > 0){
            $row = $result->fetch_assoc();
            return $row['idSecao'];
        } else {
            $sql = "INSERT INTO secao (numero, fk_idZona) VALUES ('$numero', '$fk_zona')";
            if(!$conn->query($sql)){
                //ERRO
            } else {
                //SUCESSO
                $lastId = $conn->insert_id;
                return $lastId;
            }
        }
    }

    function buscaIdCandidato($conn, $nome_candidato){
        $sql = "SELECT idCandidato FROM candidato WHERE nome = '$nome_candidato'";
        $result = $conn->query($sql);
        $row = $result->fetch_assoc();
        return $row['idCandidato'];
    }
?>