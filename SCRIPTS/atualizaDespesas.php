<?php
    //VERIFICACAO DE SESSOES E INCLUDES NECESSARIOS E CONEXAO AO BANCO DE DADOS
    include_once("../includes/header.php");
    
    //RECEBENDO E VALIDANDO VALORES
     $idPasseio                       = filter_input(INPUT_POST, 'idPasseioSelecionado',         FILTER_SANITIZE_NUMBER_INT);
     $idDespesa                       = filter_input(INPUT_POST, 'idDespesa',                    FILTER_SANITIZE_NUMBER_INT);

     $valorIngresso                   = filter_input(INPUT_POST, 'valorIngresso',                    FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION);
     $valorOnibus                     = filter_input(INPUT_POST, 'valorOnibus',                      FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION);
     $valorMicro                      = filter_input(INPUT_POST, 'valorMicro',                       FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION);
     $valorVan                        = filter_input(INPUT_POST, 'valorVan',                         FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION);
     $valorEscuna                     = filter_input(INPUT_POST, 'valorEscuna',                      FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION);
     $valorSeguroViagem               = filter_input(INPUT_POST, 'valorSeguroViagem',                FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION);
     $valorAlmocoCliente              = filter_input(INPUT_POST, 'valorAlmocoCliente',               FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION);
     $valorAlmocoMotorista            = filter_input(INPUT_POST, 'valorAlmocoMotorista',             FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION);
     $valorEstacionamento             = filter_input(INPUT_POST, 'valorEstacionamento',              FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION);
     $valorGuia                       = filter_input(INPUT_POST, 'valorGuia',                        FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION);
     $valorAutorizacaoTransporte      = filter_input(INPUT_POST, 'valorAutorizacaoTransporte',       FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION);
     $valorTaxi                       = filter_input(INPUT_POST, 'valorTaxi',                        FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION);
     $valorKitLanche                  = filter_input(INPUT_POST, 'valorKitLanche',                   FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION);
     $valorMarketing                  = filter_input(INPUT_POST, 'valorMarketing',                   FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION);
     $valorImpulsionamento            = filter_input(INPUT_POST, 'valorImpulsionamento',             FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION);
     $valorPulseira                   = filter_input(INPUT_POST, 'valorPulseira',                    FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION);
     $valorHospedagem                 = filter_input(INPUT_POST, 'valorHospedagem',                  FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION);
     $valorAereo                      = filter_input(INPUT_POST, 'valorAereo',                       FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION);
     $valorServicos                   = filter_input(INPUT_POST, 'valorServicos',                    FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION);
     $outros                          = filter_input(INPUT_POST, 'outros',                           FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION);
     $totalDespesas                   = filter_input(INPUT_POST, 'totalDespesas',                    FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION);
 
     $quantidadeIngresso              = filter_input(INPUT_POST, 'quantidadeIngresso',               FILTER_SANITIZE_NUMBER_INT);
     $quantidadeOnibus                = filter_input(INPUT_POST, 'quantidadeOnibus',                 FILTER_SANITIZE_NUMBER_INT);
     $quantidadeMicro                 = filter_input(INPUT_POST, 'quantidadeMicro',                  FILTER_SANITIZE_NUMBER_INT);
     $quantidadeVan                   = filter_input(INPUT_POST, 'quantidadeVan',                    FILTER_SANITIZE_NUMBER_INT);
     $quantidadeEscuna                = filter_input(INPUT_POST, 'quantidadeEscuna',                 FILTER_SANITIZE_NUMBER_INT);
     $quantidadeAlmocoCliente         = filter_input(INPUT_POST, 'quantidadeAlmocoCliente',          FILTER_SANITIZE_NUMBER_INT);
     $quantidadeAlmocoMotorista       = filter_input(INPUT_POST, 'quantidadeAlmocoMotorista',        FILTER_SANITIZE_NUMBER_INT);
     $quantidadeEstacionamento        = filter_input(INPUT_POST, 'quantidadeEstacionamento',         FILTER_SANITIZE_NUMBER_INT);
     $quantidadeGuia                  = filter_input(INPUT_POST, 'quantidadeGuia',                   FILTER_SANITIZE_NUMBER_INT);
     $quantidadeAutorizacaoTransporte = filter_input(INPUT_POST, 'quantidadeAutorizacaoTransporte',  FILTER_SANITIZE_NUMBER_INT);
     $quantidadeTaxi                  = filter_input(INPUT_POST, 'quantidadeTaxi',                   FILTER_SANITIZE_NUMBER_INT);
     $quantidadeMarketing             = filter_input(INPUT_POST, 'quantidadeMarketing',              FILTER_SANITIZE_NUMBER_INT);
     $quantidadeKitLanche             = filter_input(INPUT_POST, 'quantidadeKitLanche',              FILTER_SANITIZE_NUMBER_INT);
     $quantidadeImpulsionamento       = filter_input(INPUT_POST, 'quantidadeImpulsionamento',        FILTER_SANITIZE_NUMBER_INT);
     $quantidadePulseira              = filter_input(INPUT_POST, 'quantidadePulseira',               FILTER_SANITIZE_NUMBER_INT);
     $quantidadeHospedagem            = filter_input(INPUT_POST, 'quantidadeHospedagem',             FILTER_SANITIZE_NUMBER_INT);
     $quantidadeAereo                 = filter_input(INPUT_POST, 'quantidadeAereo',                  FILTER_SANITIZE_NUMBER_INT);
     $quantidadeServicos              = filter_input(INPUT_POST, 'quantidadeServicos',               FILTER_SANITIZE_NUMBER_INT);
     $quantidadeSeguroViagem          = filter_input(INPUT_POST, 'quantidadeSeguroViagem',           FILTER_SANITIZE_NUMBER_INT);
     $nomePasseio                     = filter_input(INPUT_POST, 'nomePasseio',                      FILTER_SANITIZE_STRING);
     $dataPasseio                     = filter_input(INPUT_POST, 'dataPasseio',                      FILTER_SANITIZE_STRING);
     $idUser                          = $_SESSION['id'];
    /* -----------------------------------------------------------------------------------------------------  */
    $queryUpdateDespesa = "UPDATE despesa SET
                            valorIngresso='$valorIngresso', valorOnibus='$valorOnibus', valorMicro='$valorMicro', valorVan='$valorVan', valorEscuna='$valorEscuna', valorSeguroViagem='$valorSeguroViagem', valorAlmocoCliente='$valorAlmocoCliente', 
                            valorAlmocoMotorista='$valorAlmocoMotorista', valorEstacionamento='$valorEstacionamento', valorGuia='$valorGuia', valorAutorizacaoTransporte='$valorAutorizacaoTransporte', valorTaxi='$valorTaxi', valorKitLanche='$valorKitLanche', 
                            valorMarketing='$valorMarketing', valorImpulsionamento='$valorImpulsionamento', outros='$outros', quantidadeIngresso='$quantidadeIngresso', quantidadeOnibus='$quantidadeOnibus', quantidadeMicro='$quantidadeMicro', quantidadeVan='$quantidadeVan', 
                            quantidadeEscuna='$quantidadeEscuna', quantidadeAlmocoCliente='$quantidadeAlmocoCliente', quantidadeAlmocoMotorista='$quantidadeAlmocoMotorista', quantidadeEstacionamento='$quantidadeEstacionamento', quantidadeGuia='$quantidadeGuia', 
                            quantidadeAutorizacaoTransporte='$quantidadeAutorizacaoTransporte', quantidadeTaxi='$quantidadeTaxi', quantidadeMarketing='$quantidadeMarketing', quantidadeKitLanche='$quantidadeKitLanche', quantidadeImpulsionamento='$quantidadeImpulsionamento', 
                            quantidadeSeguroViagem='$quantidadeSeguroViagem', totalDespesas='$totalDespesas', valorPulseira='$valorPulseira', quantidadePulseira='$quantidadePulseira', valorHospedagem='$valorHospedagem', quantidadeHospedagem='$quantidadeHospedagem',
                            valorAereo='$valorAereo', quantidadeAereo='$quantidadeAereo', valorServicos='$valorServicos', quantidadeServicos='$quantidadeServicos'
                            WHERE idDespesa='$idDespesa'
                            ";
    /* -----------------------------------------------------------------------------------------------------  */
    //ATUALIZANDO E GERANDO LOG
    atualizar($queryUpdateDespesa, $conexao, "DESPESAS", "editaDespesas", $idPasseio);
    gerarLog("DESPESAS", $conexao, $idUser, null, $nomePasseio, $dataPasseio, null, "ATUALIZAR" , 0);

    

?>