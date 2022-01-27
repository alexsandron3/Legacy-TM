<?php
    //VERIFICACAO DE SESSOES E INCLUDES NECESSARIOS E CONEXAO AO BANCO DE DADOS
    include_once("../includes/header.php");

    //RECEBENDO E VALIDANDO VALORES
    $nome                   = filter_input(INPUT_POST, 'nomeCliente',           FILTER_SANITIZE_STRING);
    $email                  = filter_input(INPUT_POST, 'emailCliente',          FILTER_SANITIZE_EMAIL);
    $rg                     = filter_input(INPUT_POST, 'rgCliente',             FILTER_SANITIZE_STRING);
    $emissor                = filter_input(INPUT_POST, 'orgaoEmissor',          FILTER_SANITIZE_STRING);
    $cpf                    = filter_input(INPUT_POST, 'cpfCliente',            FILTER_SANITIZE_STRING); 
    $telefoneCliente        = filter_input(INPUT_POST, 'telefoneCliente',       FILTER_SANITIZE_STRING); 
    $dataNascimento         = filter_input(INPUT_POST, 'dataNascimento',        FILTER_SANITIZE_STRING);
    $idade                  = filter_input(INPUT_POST, 'idadeCliente',          FILTER_SANITIZE_NUMBER_INT);
    $cpfConsultado          = filter_input(INPUT_POST, 'cpfConsultado',         FILTER_VALIDATE_BOOLEAN);
    $dataConsulta           = filter_input(INPUT_POST, 'dataCpfConsultado',     FILTER_SANITIZE_STRING);
    $referenciaCliente      = filter_input(INPUT_POST, 'referenciaCliente',     FILTER_SANITIZE_STRING);
    $enderecoCliente        = filter_input(INPUT_POST, 'enderecoCliente',       FILTER_SANITIZE_STRING);
    $meioTransporte         = filter_input(INPUT_POST, 'meioTransporte',        FILTER_SANITIZE_STRING);
    $telefoneContato        = filter_input(INPUT_POST, 'telefoneContato',       FILTER_SANITIZE_STRING); 
    $nomeContato            = filter_input(INPUT_POST, 'nomeContato',           FILTER_SANITIZE_STRING);
    $redeSocial             = filter_input(INPUT_POST, 'redeSocial',            FILTER_SANITIZE_STRING);
    $nacionalidade          = filter_input(INPUT_POST, 'nacionalidade',         FILTER_SANITIZE_STRING);
    $poltrona               = filter_input(INPUT_POST, 'poltrona'       ,         FILTER_SANITIZE_STRING);
    $profissao              = filter_input(INPUT_POST, 'profissao',             FILTER_SANITIZE_STRING);
    $estadoCivil            = filter_input(INPUT_POST, 'estadoCivil',           FILTER_SANITIZE_STRING);
    $clienteRedeSocial      = filter_input(INPUT_POST, 'clienteRedeSocial',     FILTER_VALIDATE_BOOLEAN);
    $statusCliente          = 1;
    $idUser                 = $_SESSION['id'];

    /* -----------------------------------------------------------------------------------------------------  */
    
    $queryCadastraCliente = "INSERT INTO 
                            cliente (nomeCliente, emailCliente, rgCliente, orgaoEmissor, cpfCliente, telefoneCliente, dataNascimento, idadeCliente, cpfConsultado, dataCpfConsultado, referencia, enderecoCliente,telefoneContato, pessoaContato,  redeSocial, statusCliente,
                                     nacionalidade, poltrona, profissao, estadoCivil, clienteRedeSocial )
                            VALUES  ('$nome', '$email', '$rg', '$emissor', '$cpf', '$telefoneCliente', '$dataNascimento', '$idade', '$cpfConsultado', '$dataConsulta', '$referenciaCliente', '$enderecoCliente', '$telefoneContato', '$nomeContato','$redeSocial', '$statusCliente',
                                     '$nacionalidade', '$poltrona', '$profissao', '$estadoCivil', '$clienteRedeSocial')
                            ";

    /* -----------------------------------------------------------------------------------------------------  */

    $queryVerificaSeClienteExiste               = "SELECT c.cpfCliente, c.nomeCliente, c.idCliente FROM cliente c WHERE c.cpfCliente='$cpf' AND c.nomeCliente='$nome'";
    $executaQueryVerificaSeClienteExiste        = mysqli_query($conexao, $queryVerificaSeClienteExiste);
    $rowResultadoVerificaSeClienteExiste        = mysqli_fetch_assoc($executaQueryVerificaSeClienteExiste);

    /* -----------------------------------------------------------------------------------------------------  */
    //CADASTRANDO E GERANDO LOG
    if(mysqli_num_rows($executaQueryVerificaSeClienteExiste) == 0 OR $cpf == NULL){
        /* -----------------------------------------------------------------------------------------------------  */
        cadastro($queryCadastraCliente, $conexao, "CLIENTE", "cadastroCliente");
        $idUltimoClienteCadastrado = mysqli_insert_id($conexao);
        redirecionamento("pagamentoCliente", $idUltimoClienteCadastrado);
        gerarLog("CLIENTE", $conexao, $idUser, $nome, null, null, null, "CADASTRAR" , 0);

        /* -----------------------------------------------------------------------------------------------------  */
    }else{
        $idCliente = $rowResultadoVerificaSeClienteExiste ['idCliente'];
        mensagensWarning("JÁ EXISTE UM CLIENTE CADASTRADO COM ESTE CPF");
        redirecionamento("editarCliente", $idCliente);
        gerarLog("CLIENTE", $conexao, $idUser, $nome, null, null, null, "CADASTRAR" , 0);
    }
