<?php
    //VERIFICACAO DE SESSOES E INCLUDES NECESSARIOS E CONEXAO AO BANCO DE DADOS
    include_once("../includes/header.php");

    //RECEBENDO E VALIDANDO VALORES
    $idPagamento                    = filter_input(INPUT_POST, 'idPagamento',            FILTER_SANITIZE_NUMBER_INT);
    $idPasseio                      = filter_input(INPUT_POST, 'idPasseioSelecionado',   FILTER_SANITIZE_NUMBER_INT); 
    $idCliente                      = filter_input(INPUT_POST, 'idCliente',              FILTER_SANITIZE_NUMBER_INT); 
    $valorVendido                   = filter_input(INPUT_POST, 'valorVendido',           FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION);
    $valorPago                      = filter_input(INPUT_POST, 'valorPago',              FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION);
    $previsaoPagamento              = filter_input(INPUT_POST, 'previsaoPagamento',      FILTER_SANITIZE_STRING);
    $anotacoes                      = filter_input(INPUT_POST, 'anotacoes',              FILTER_SANITIZE_STRING);
    $historicoPagamento             = filter_input(INPUT_POST, 'historicoPagamento',     FILTER_SANITIZE_STRING);
    $clienteParceiro                = filter_input(INPUT_POST, 'clienteParceiro',        FILTER_VALIDATE_BOOLEAN);
    $clienteDesistente              = filter_input(INPUT_POST, 'clienteDesistente',      FILTER_VALIDATE_BOOLEAN);
    $statusEditaSeguroViagemCliente = filter_input(INPUT_POST, 'seguroViagemCliente',    FILTER_VALIDATE_BOOLEAN);
    $transporteCliente              = filter_input(INPUT_POST, 'meioTransporte',         FILTER_SANITIZE_STRING);
    $localEmbarque                  = filter_input(INPUT_POST, 'localEmbarque',          FILTER_SANITIZE_STRING);
    $valorPagoAtual                 = filter_input(INPUT_POST, 'valorPagoAtual',         FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION);
    $taxaPagamento                  = filter_input(INPUT_POST, 'taxaPagamento',          FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION);
    $idUser                         = $_SESSION['id'];

    $clienteParceiro = (empty($clienteParceiro))? 0: $clienteParceiro;
    $clienteDesistente = (empty($clienteDesistente))? 0: $clienteDesistente;
    $statusEditaSeguroViagemCliente = (empty($statusEditaSeguroViagemCliente))? 0: $statusEditaSeguroViagemCliente;
    $taxaPagamento = (empty($taxaPagamento))? 0: $taxaPagamento;
    $valorPendente                  = round(-$valorVendido + $valorPago + $taxaPagamento, 2);
    


    /* -----------------------------------------------------------------------------------------------------  */
    //BUSCANDO INFORMACOES PARA VALIDAR O PAGAMENTO

    $queryInformacoesPasseio        = "SELECT lotacao, idadeIsencao, nomePasseio, dataPasseio FROM passeio WHERE idPasseio='$idPasseio'";
    $executaQueryInformacoesPasseio = mysqli_query($conexao, $queryInformacoesPasseio);
    $rowInformacoesPasseio          = mysqli_fetch_assoc($executaQueryInformacoesPasseio);
    $lotacaoPasseio                 = $rowInformacoesPasseio['lotacao']; 
    $idadeIsencao                   = $rowInformacoesPasseio['idadeIsencao'];
    $nomePasseio                    = $rowInformacoesPasseio['nomePasseio']; 
    $dataPasseio                    = $rowInformacoesPasseio['dataPasseio']; 

    $idadeCliente                   = calcularIdade($idCliente, $conn, "");
    $statusPagamento                = statusPagamento($valorPendente, $valorPago, $idadeCliente, $idadeIsencao, $clienteParceiro);

    $queryInformacoesCliente        = "SELECT nomeCliente FROM cliente WHERE idCliente=$idCliente";
    $executaQueryInformacoesCliente = mysqli_query($conexao, $queryInformacoesCliente);
    $rowInformacoesCliente          = mysqli_fetch_assoc($executaQueryInformacoesCliente);
    $nomeCliente                    = $rowInformacoesCliente['nomeCliente'];
    
    /* -----------------------------------------------------------------------------------------------------  */

    $queryUpdatePagamentoCliente    =  "UPDATE pagamento_passeio SET    
                                    valorVendido='$valorVendido', valorPago='$valorPago', previsaoPagamento='$previsaoPagamento', anotacoes='$anotacoes', historicoPagamento='$historicoPagamento', statusPagamento='$statusPagamento', clienteParceiro='$clienteParceiro' ,valorPendente='$valorPendente', seguroViagem='$statusEditaSeguroViagemCliente',
                                    transporte='$transporteCliente', taxaPagamento='$taxaPagamento', localEmbarque='$localEmbarque', dataPagamento=NOW(), lastModified=NOW(), clienteDesistente='$clienteDesistente'
                                    WHERE idPagamento='$idPagamento'
                                    ";

                                    // echo $queryUpdatePagamentoCliente;

    /* -----------------------------------------------------------------------------------------------------  */

    //VERIFICANDO NIVEL DE ACESSO, VERIFICANDO SE ALTERACOES FORAM FEITAS E GERANDO LOG
    if($_SESSION['nivelAcesso'] == 1 OR $_SESSION['nivelAcesso'] == 0 ){
        $executaQueryUpdatePagamentoCliente = mysqli_query($conexao, $queryUpdatePagamentoCliente);

        if(mysqli_affected_rows($conexao)){
            mensagensSucess("pagamento ATUALIZADO com sucesso");
            #$_SESSION['msg'] = "<p class='h5 text-center alert-success'>pagamento ATUALIZADO com sucesso</p>";
            redirecionamento("editarPagamento", $idPagamento);
            

        }else{
            mensagensWarning("pagamento não foi ATUALIZADO");
            #$_SESSION['msg'] = "<p class='h5 text-center alert-danger'>pagamento não foi ATUALIZADO </p>";
            redirecionamento("editarPagamento", $idPagamento);
            
        }
        gerarLog("PAGAMENTO", $conexao, $idUser, $nomeCliente, $nomePasseio, $dataPasseio, $valorPago, "ATUALIZAR" , 0);
    }else{
        mensagensDanger("PAGAMENTO NÃO foi ATUALIZADO(A), VOCÊ NÃO PODE REALIZAR ALTERAÇÕES DEVIDO A FALTA DE PERMISSÃO.");
        #$_SESSION['msg'] = "<p class='h5 text-center alert-danger'> PAGAMENTO NÃO foi ATUALIZADO(A), VOCÊ NÃO PODE REALIZAR ALTERAÇÕES DEVIDO A FALTA DE PERMISSÃO. </p>";
        redirecionamento("editarPagamento", $idPagamento);
        gerarLog("PAGAMENTO", $conexao, $idUser, $nomeCliente, $nomePasseio, $dataPasseio, $valorPago, "ATUALIZAR" , 1);

    }

?>
