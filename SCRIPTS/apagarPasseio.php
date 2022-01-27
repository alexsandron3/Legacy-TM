<?php
    //VERIFICACAO DE SESSOES E INCLUDES NECESSARIOS E CONEXAO AO BANCO DE DADOS
    include_once("../includes/header.php");
    
    //RECEBENDO E VALIDANDO VALORES
    $nomePasseio = filter_input(INPUT_GET , 'nomePasseio', FILTER_SANITIZE_STRING);
    $dataPasseio = filter_input(INPUT_GET , 'dataPasseio', FILTER_SANITIZE_STRING);
    $idPasseio   = filter_input(INPUT_GET, 'id', FILTER_SANITIZE_NUMBER_INT);
    $idUser      = $_SESSION['id'];
    
    //VERFICANDO SE O ID FOI ENVIADO
    if(!empty($idPasseio)){

        //VERIFICANDO SE EXISTEM PAGAMENTOS NO PASSEIO
        $queryVerificaSeExistePagamamento           = "SELECT idPagamento FROM pagamento_passeio WHERE idPasseio =$idPasseio";
        $executaQueryVerificaSeExistePagamamento    = mysqli_query($conexao, $queryVerificaSeExistePagamamento);
        $quantidadePagamentoExistentes              = mysqli_num_rows($executaQueryVerificaSeExistePagamamento);
        

        //DELETANDO UM PASSEIO E DESPESAS
        if($quantidadePagamentoExistentes == 0){
            $queryDeletaDespesa = "DELETE FROM despesa WHERE idPasseio ='$idPasseio'";
            $executaQueryDeletaDespesa = mysqli_query ($conexao, $queryDeletaDespesa);

            $queryDeletaPasseio = "DELETE FROM passeio WHERE idPasseio ='$idPasseio'";
            $executaQueryDeletaPasseio = mysqli_query ($conexao, $queryDeletaPasseio);
            if(mysqli_affected_rows($conexao)){
                mensagensSucess("Passeio APAGADO com sucesso");
                #$_SESSION['msg'] = "<p class='h5 text-center alert-success'>Passeio APAGADO com sucesso</p>";
                redirecionamento("pesquisarPasseio", null);
            
            }else{
                mensagensWarning("Passeio NÃO foi APAGADO ");
                #$_SESSION['msg'] = "<p class='h5 text-center alert-danger'>Passeio NÃO foi APAGADO </p>";
                redirecionamento("pesquisarPasseio", null);
                
            }
            gerarLog("DELETAR PASSEIO", $conexao, $idUser, null, $nomePasseio, $dataPasseio, null, null , 0);
        }else{
            mensagensInfo("RESOLVA OS PAGAMENTOS FEITOS NESSE PASSEIO ANTES DE DELETAR");
            #$_SESSION['msg'] = "<p class='h5 text-center alert-danger'>RESOLVA OS PAGAMENTOS FEITOS NESSE PASSEIO ANTES DE DELETAR</p>";
            redirecionamento("pesquisarPasseio", null);
            gerarLog("DELETAR PASSEIO", $conexao, $idUser, null, $nomePasseio, $dataPasseio, null, null , 1);
        }


    }

?>