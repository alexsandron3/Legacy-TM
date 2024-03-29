<?php
    //VERIFICACAO DE SESSOES E INCLUDES NECESSARIOS E CONEXAO AO BANCO DE DADOS
    include_once("../includes/header.php");

    
    //RECEBENDO E VALIDANDO VALORES
    $idCliente     = filter_input(INPUT_GET, 'id',     FILTER_SANITIZE_NUMBER_INT);
    $clienteAtivo  = filter_input(INPUT_GET, 'status', FILTER_VALIDATE_BOOLEAN );
    $nomeCliente   = filteR_input(INPUT_GET, 'nomeCliente', FILTER_SANITIZE_STRING);
    $idUser        = $_SESSION['id'];

    //VERFICANDO SE O ID FOI ENVIADO
    if(!empty($idCliente)){

        
    /* -----------------------------------------------------------------------------------------------------  */
        //ALTERANDO STATUS DO CLIENTE 
        //0 INATIVO 
        //1 ATIVO
        if($clienteAtivo == 1){
            $queryUpdateStatus = "UPDATE cliente SET statusCliente=0 WHERE idCliente ='$idCliente'";
            $executaQueryUpdateStatus = mysqli_query ($conexao, $queryUpdateStatus);
            $tipoModificacao = "DESATIVAR";

        }else{
            $queryUpdateStatus = "UPDATE cliente SET statusCliente=1 WHERE idCliente ='$idCliente'";
            $executaQueryUpdateStatus = mysqli_query ($conexao, $queryUpdateStatus);
            $tipoModificacao = "ATIVAR";


        }
    /* -----------------------------------------------------------------------------------------------------  */
        //VERIFICANDO SE AS ALTERACOES FORAM ENVIADAS
        if( mysqli_affected_rows($conexao)){
            mensagensSucess("STATUS do CLIENTE alterado com SUCESSO");
            #$_SESSION['msg'] = "<p class='h5 text-center alert-success'>STATUS do CLIENTE alterado com SUCESSO</p>";
            redirecionamento("pesquisarCliente", null);
                    
        }else {
            mensagensWarning("STATUS do CLIENTE NÃO foi alterado");
            #$_SESSION['msg'] = "<p class='h5 text-center alert-danger'>STATUS do CLIENTE NÃO foi alterado </p>";
            redirecionamento("index", null);
            
        
        }


    }else {
        mensagensInfo("Necessário selecionar um usuário");
        #$_SESSION['msg'] = "<p class='h5 text-center alert-warning''>Necessário selecionar um usuário</p>";
        redirecionamento("pesquisarCliente", null);
        

    }
    gerarLog("CLIENTE", $conexao, $idUser, $nomeCliente, " ", " ", " ", $tipoModificacao, 0);

?>