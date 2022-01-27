<?php
    //VERIFICACAO DE SESSOES E INCLUDES NECESSARIOS E CONEXAO AO BANCO DE DADOS
    include_once("../includes/header.php");
    
    //RECEBENDO E VALIDANDO VALORES
    $idCliente              = filter_input(INPUT_POST, 'idCliente',             FILTER_SANITIZE_NUMBER_INT);
    $nome                   = filter_input(INPUT_POST, 'nomeCliente',           FILTER_SANITIZE_STRING);
    $email                  = filter_input(INPUT_POST, 'emailCliente',          FILTER_SANITIZE_EMAIL);
    $rg                     = filter_input(INPUT_POST, 'rgCliente',             FILTER_SANITIZE_STRING);
    $emissor                = filter_input(INPUT_POST, 'orgaoEmissor',          FILTER_SANITIZE_STRING);
    $cpf                    = filter_input(INPUT_POST, 'cpfCliente',            FILTER_SANITIZE_STRING); 
    $telefoneCliente        = filter_input(INPUT_POST, 'telefoneCliente',       FILTER_SANITIZE_STRING);
    $dataNascimento         = filter_input(INPUT_POST, 'dataNascimento',        FILTER_SANITIZE_STRING);
    $cpfConsultado          = filter_input(INPUT_POST, 'cpfConsultado',         FILTER_VALIDATE_BOOLEAN);
    $dataConsulta           = filter_input(INPUT_POST, 'dataCpfConsultado',     FILTER_SANITIZE_STRING);
    $referenciaCliente      = filter_input(INPUT_POST, 'referenciaCliente',     FILTER_SANITIZE_STRING);
    $enderecoCliente        = filter_input(INPUT_POST, 'enderecoCliente',       FILTER_SANITIZE_STRING);
    $telefoneContato        = filter_input(INPUT_POST, 'telefoneContato',       FILTER_SANITIZE_STRING); 
    $nomeContato            = filter_input(INPUT_POST, 'nomeContato',           FILTER_SANITIZE_STRING);
    $redeSocial             = filter_input(INPUT_POST, 'redeSocial',            FILTER_SANITIZE_STRING);
    $nacionalidade          = filter_input(INPUT_POST, 'nacionalidade',         FILTER_SANITIZE_STRING);
    $poltrona               = filter_input(INPUT_POST, 'poltrona',       FILTER_SANITIZE_STRING);
    $profissao              = filter_input(INPUT_POST, 'profissao',             FILTER_SANITIZE_STRING);
    $estadoCivil            = filter_input(INPUT_POST, 'estadoCivil',           FILTER_SANITIZE_STRING);
    $clienteRedeSocial      = filter_input(INPUT_POST, 'clienteRedeSocial',     FILTER_VALIDATE_BOOLEAN);
    $idUser                 = $_SESSION['id'];

    //FUNCAO DE CÁLCULO DE IDADE
    $idade = calcularIdade($idCliente, $conn, $dataNascimento);

    /* -----------------------------------------------------------------------------------------------------  */

    $queryUpdateCliente = "UPDATE cliente SET 
                            nomeCliente='$nome', emailCliente='$email', rgCliente='$rg', orgaoEmissor='$emissor', cpfCliente='$cpf', telefoneCliente='$telefoneCliente', dataNascimento='$dataNascimento', idadeCliente='$idade', 
                            cpfConsultado='$cpfConsultado', dataCpfConsultado='$dataConsulta', referencia='$referenciaCliente', enderecoCliente='$enderecoCliente', telefoneContato='$telefoneContato', pessoaContato='$nomeContato', redeSocial='$redeSocial',
                            nacionalidade='$nacionalidade', poltrona= '$poltrona', profissao='$profissao', estadoCivil='$estadoCivil', clienteRedeSocial='$clienteRedeSocial'
                            WHERE idCliente='$idCliente'";
    /* -----------------------------------------------------------------------------------------------------  */
    
    //ATUALIZANDO E GERANDO LOG
    atualizar($queryUpdateCliente, $conexao, "CLIENTE", "editarCliente", $idCliente);
    gerarLog("CLIENTE", $conexao, $idUser, $nome, null, null, null, "ATUALIZAR" , 0);

    
    


?>