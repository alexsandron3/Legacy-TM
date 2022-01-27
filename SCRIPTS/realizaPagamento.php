<?php
    //VERIFICACAO DE SESSOES E INCLUDES NECESSARIOS E CONEXAO AO BANCO DE DADOS
    include_once("../includes/header.php");

    //RECEBENDO E VALIDANDO VALORES

    $idCliente                   = filter_input(INPUT_POST, 'idClienteSelecionado',   FILTER_SANITIZE_NUMBER_INT);
    $idPasseio                   = filter_input(INPUT_POST, 'idPasseioSelecionado',   FILTER_SANITIZE_NUMBER_INT); 
    $valorVendido                = filter_input(INPUT_POST, 'valorVendido',           FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION);
    $valorPago                   = filter_input(INPUT_POST, 'valorPago',              FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION);
    $previsaoPagamento           = filter_input(INPUT_POST, 'previsaoPagamento',      FILTER_SANITIZE_STRING);
    $anotacoes                   = filter_input(INPUT_POST, 'anotacoes',              FILTER_SANITIZE_STRING);
    $seguroViagemCliente         = filter_input(INPUT_POST, 'seguroViagemCliente',    FILTER_VALIDATE_BOOLEAN);
    $transporteCliente           = filter_input(INPUT_POST, 'meioTransporte',         FILTER_SANITIZE_STRING);
    $taxaPagamento               = filter_input(INPUT_POST, 'taxaPagamento',          FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION);
    $localEmbarque               = filter_input(INPUT_POST, 'localEmbarque',          FILTER_SANITIZE_STRING);
    $clienteParceiro             = filter_input(INPUT_POST, 'clienteParceiro',        FILTER_VALIDATE_BOOLEAN);
    $historicoPagamento          = filter_input(INPUT_POST, 'historicoPagamento',     FILTER_SANITIZE_STRING);
    $idUser                      = $_SESSION['id'];


    if(empty($taxaPagamento)){
        $taxaPagamento = 0;
    }
    if(empty($clienteParceiro)){
        $clienteParceiro = 0;
    }

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
    // echo $valorPendente . " -> PENDENTE </BR>";
    // echo $valorPago . " -> PAGO </BR>";
    // echo $idadeCliente . " -> I. CLIENTE </BR>";
    // echo $idadeIsencao . " -> ISENCAO </BR>";
    // echo $clienteParceiro . " -> PARCEIRO </BR>";
    // echo $statusPagamento . " -> STATUS </BR>";
    $getStatusPagamento       = "SELECT statusPagamento AS qtdConfirmados FROM pagamento_passeio WHERE idPasseio=$idPasseio AND statusPagamento NOT IN (0,4)";
    $resultadoStatusPagamento = mysqli_query($conexao, $getStatusPagamento);
    $qtdClientesConfirmados   = mysqli_num_rows($resultadoStatusPagamento);


    $queryInformacoesCliente        = "SELECT nomeCliente FROM cliente WHERE idCliente=$idCliente";
    $executaQueryInformacoesCliente = mysqli_query($conexao, $queryInformacoesCliente);
    $rowInformacoesCliente          = mysqli_fetch_assoc($executaQueryInformacoesCliente);
    $nomeCliente                    = $rowInformacoesCliente['nomeCliente'];
    /* -----------------------------------------------------------------------------------------------------  */

    

    $queryEnviaPagamentoCliente = "INSERT INTO pagamento_passeio 
                                (idCliente, idPasseio, valorVendido, valorPago, previsaoPagamento, anotacoes, valorPendente, statusPagamento, transporte, seguroViagem, taxaPagamento, localEmbarque, clienteParceiro, historicoPagamento, dataPagamento, createdAt)  
                                VALUES ('$idCliente', '$idPasseio', '$valorVendido', '$valorPago', '$previsaoPagamento', '$anotacoes', '$valorPendente', '$statusPagamento', '$transporteCliente', '$seguroViagemCliente', 
                                '$taxaPagamento', '$localEmbarque', '$clienteParceiro', '$historicoPagamento', NOW(), NOW())
                                ";
 
    // echo $queryEnviaPagamentoCliente;
    /* -----------------------------------------------------------------------------------------------------  */
    //VERIFICANDO NIVEL DE ACESSO, ALERTAS, CADASTRANDO PAGAMENTOS E GERANDO LOG

    define('PORCENTAGEM_VAGAS_OCUPADAS', '0.20');
    define('VAGA_ATUAL', '1');

    $alertaParaVagasRestantes = $lotacaoPasseio * PORCENTAGEM_VAGAS_OCUPADAS;

    $vagasRestantes = ($lotacaoPasseio - $qtdClientesConfirmados) -VAGA_ATUAL;
    
    if($_SESSION['nivelAcesso'] == 1 OR $_SESSION['nivelAcesso'] == 0 ){
        if($lotacaoPasseio <= $qtdClientesConfirmados){
            mensagensWarning("LIMITE DE VAGAS PARA ESTE PASSEIO ATINGIDO");
            #$_SESSION['msg'] = "<p class='h5 text-center alert-danger'>LIMITE DE VAGAS PARA ESTE PASSEIO ATINGIDO</p>";
            redirecionamento("pagamentoCliente", $idCliente);
            
        }elseif($lotacaoPasseio > $qtdClientesConfirmados){
            $executaQueryEnviaPagamentoCliente = mysqli_query($conexao, $queryEnviaPagamentoCliente);

            if(mysqli_insert_id($conexao)){
                if(($qtdClientesConfirmados + VAGA_ATUAL) >= $lotacaoPasseio){
                    echo '  <script type="text/JavaScript">  
                                alert("LIMITE DE VAGAS ATINGIDO"); 
                            </script>' 
                    ; 
                    mensagensSucess("PAGAMENTO realizado com sucesso.");
                    #$_SESSION['msg'] = "<p class='h5 text-center alert-success'>PAGAMENTO realizado com sucesso.</p>";
                    redirecionamento("pagamentoCliente", $idCliente);
                    
                }else{
                    mensagensSucess("PAGAMENTO realizado com sucesso.");
                    #$_SESSION['msg'] = "<p class='h5 text-center alert-success'>PAGAMENTO realizado com sucesso</p>";
                    redirecionamento("pagamentoCliente", $idCliente);
                    
                }

            }else{
                mensagensWarning("PAGAMENTO NÃO REALIZADO");
                #$_SESSION['msg'] = "<p class='h5 text-center alert-danger'>PAGAMENTO NÃO REALIZADO </p>";
                redirecionamento("pagamentoCliente", $idCliente);
                
            }
            if($vagasRestantes > 0 AND $vagasRestantes <= floor($alertaParaVagasRestantes)){
                if($statusPagamento == 0 OR $statusPagamento == 4){
                    $vagasRestantes = ($lotacaoPasseio - $qtdClientesConfirmados);
                }
                mensagensInfo("EXISTEM APENAS $vagasRestantes VAGAS DISPONÍVEIS");
                #$_SESSION['msg'] = "<p class='h5 text-center alert-warning'>EXISTEM APENAS ". $vagasRestantes ." VAGAS DISPONÍVEIS</p>";

            }
        }
        gerarLog("PAGAMENTO", $conexao, $idUser, $nomeCliente, $nomePasseio, $dataPasseio, $valorPago, "CADASTRAR" , 0);

    }else{
        mensagensDanger("PAGAMENTO NÃO foi REALIZADO(A), VOCÊ NÃO PODE REALIZAR ALTERAÇÕES DEVIDO A FALTA DE PERMISSÃO.");
        #$_SESSION['msg'] = "<p class='h5 text-center alert-danger'> PAGAMENTO NÃO foi REALIZADO(A), VOCÊ NÃO PODE REALIZAR ALTERAÇÕES DEVIDO A FALTA DE PERMISSÃO. </p>";
        redirecionamento("pagamentoCliente", $idCliente);
        gerarLog("PAGAMENTO", $conexao, $idUser, $nomeCliente, $nomePasseio, $dataPasseio, $valorPago, "CADASTRAR" , 0);

    }




?>