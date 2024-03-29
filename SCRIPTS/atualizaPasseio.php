<?php
    //VERIFICACAO DE SESSOES E INCLUDES NECESSARIOS E CONEXAO AO BANCO DE DADOS
    include_once("../includes/header.php");

    //RECEBENDO E VALIDANDO VALORES
    $idPasseio           = filter_input(INPUT_POST, 'idPasseio',            FILTER_SANITIZE_NUMBER_INT);
    $nomePasseio         = filter_input(INPUT_POST, 'nomePasseio',          FILTER_SANITIZE_STRING);
    $localPasseio        = filter_input(INPUT_POST, 'localPasseio',         FILTER_SANITIZE_STRING);
    $valorPasseio        = filter_input(INPUT_POST, 'valorPasseio',         FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION);
    $lotacao             = filter_input(INPUT_POST, 'lotacao',              FILTER_SANITIZE_NUMBER_INT);
    $dataPasseio         = filter_input(INPUT_POST, 'dataPasseio',          FILTER_SANITIZE_STRING);
    $anotacoes           = filter_input(INPUT_POST, 'anotacoesPasseio',     FILTER_SANITIZE_STRING);
    $idadeIsencao        = filter_input(INPUT_POST, 'idadeIsencao',         FILTER_SANITIZE_NUMBER_INT);
    $statusPasseio       = filter_input(INPUT_POST, 'statusPasseio',        FILTER_VALIDATE_BOOLEAN);
    $dataLancamentoPasseio= filter_input(INPUT_POST, 'dataLancamentoPasseio',FILTER_SANITIZE_STRING);
    $idUser              = $_SESSION['id'];

    /* -----------------------------------------------------------------------------------------------------  */

    $queryAtualizaPasseio = "UPDATE passeio SET
                            nomePasseio='$nomePasseio', localPasseio='$localPasseio', valorPasseio='$valorPasseio', lotacao='$lotacao', dataPasseio='$dataPasseio', anotacoes='$anotacoes', 
                            idadeIsencao='$idadeIsencao', statusPasseio='$statusPasseio', dataLancamento='$dataLancamentoPasseio'
                            WHERE idPasseio='$idPasseio'";
    /* -----------------------------------------------------------------------------------------------------  */
    //ATUALIZANDO E GERANDO LOG
    atualizar($queryAtualizaPasseio, $conexao, "PASSEIO", "editarPasseio", $idPasseio);
    gerarLog("PASSEIO", $conexao, $idUser, null, $nomePasseio, $dataPasseio, null, "ATUALIZAR" , 0);



?>