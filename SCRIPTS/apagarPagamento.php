<?php
//VERIFICACAO DE SESSOES E INCLUDES NECESSARIOS E CONEXAO AO BANCO DE DADOS
include_once("../includes/header.php");

//RECEBENDO E VALIDANDO VALORES
$idPasseio                     = filter_input(INPUT_GET, 'idPasseio',   FILTER_SANITIZE_NUMBER_INT);
$idPagamento                   = filter_input(INPUT_GET, 'idPagamento', FILTER_SANITIZE_NUMBER_INT);
$deletarOuTransferirPagamento  = filter_input(INPUT_GET, 'opcao',       FILTER_SANITIZE_STRING);
$nomeCliente                   = filter_input(INPUT_GET, 'nomeCliente', FILTER_SANITIZE_STRING);
$nomePasseio                   = filter_input(INPUT_GET, 'nomePasseio', FILTER_SANITIZE_STRING);
$dataPasseio                   = filter_input(INPUT_GET, 'dataPasseio', FILTER_SANITIZE_STRING);
$valorPago                     = filter_input(INPUT_GET, 'valorPago', FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION);
$confirmaApagarPagamento       = filter_input(INPUT_GET, 'confirmar',   FILTER_SANITIZE_NUMBER_INT);
$idUser                        = $_SESSION['id'];
if (empty($confirmaApagarPagamento)) {
    $confirmaApagarPagamento = 0;
}
/* -----------------------------------------------------------------------------------------------------  */
$queryDeletaPagamento = "DELETE FROM pagamento_passeio WHERE idPagamento='$idPagamento' AND idPasseio='$idPasseio'";


//VERIFICANDO NIVEL DE ACESSO E SE A CONFIRMACAO DE DELECAO FOI FEITA
if ($_SESSION['nivelAcesso'] == 1 or $_SESSION['nivelAcesso'] == 0) {
    if ($deletarOuTransferirPagamento == "DELETAR" and $confirmaApagarPagamento == 0) { ?>
        <!DOCTYPE html>
        <html lang='pt-br'>

        <head>
            <?php
            include_once("../includes/head.php"); ?>

            <title>DELETAR PAGAMENTO?</title>
            <script type='text/javascript' src='https://code.jquery.com/jquery-3.4.1.slim.min.js'></script>
            <script type='text/javascript'>
                <?php
                echo "
                        function confirmaDeletarPagamento() {
                            window.location.href='apagarPagamento.php?idPagamento=$idPagamento&idPasseio=$idPasseio&opcao=$deletarOuTransferirPagamento&confirmar=1&nomeCliente=$nomeCliente&nomePasseio=$nomePasseio&dataPasseio=$dataPasseio&valorPago=$valorPago';
                            return false;
                        }
                        
                        ";
                ?>
            </script>
        </head>

        <body>
            <div class="row py-5">
                <div class="col-lg-11 mx-auto">
                    <div class="card rounded shadow border-0">
                        <p class="h2 text-center">RELATÓRIOS DO PASSEIO</p>
                        <div class="card-body p-5 bg-white rounded ">
                            <?php mensagensDangerNoSession("APAGAR PAGAMENTO FEITO POR: $nomeCliente | NO PASSEIO:  $nomePasseio | NA DATA: $dataPasseio | COM VALOR PAGO DE: $valorPago ?"); ?>
                            <a class="btn btn-danger" href='javascript:confirmaDeletarPagamento()' onclick=''> CONFIRMAR </a>
                        </div>
                    </div>
                </div>
            </div>
        </body>

        </html>

<?php } elseif ($deletarOuTransferirPagamento == "DELETAR" and $confirmaApagarPagamento == 1) {
        apagar($queryDeletaPagamento, $conexao, "PAGAMENTO", $idPagamento, $idPasseio, "index");
        gerarLog("DELETAR PAGAMENTO", $conexao, $idUser, $nomeCliente, $nomePasseio, $dataPasseio, $valorPago, null, 0);
    } else {
        header("refresh:0.5; url=../transferirPagamento.php?idPasseioAntigo=$idPasseio&idPagamentoAntigo=$idPagamento");
    }
} else {
    mensagensDanger("PAGAMENTO NÃO foi ATUALIZADO(A), VOCÊ NÃO PODE REALIZAR ALTERAÇÕES DEVIDO A FALTA DE PERMISSÃO.");
    #$_SESSION['msg'] = "<p class='h5 text-center alert-danger'> PAGAMENTO NÃO foi ATUALIZADO(A), VOCÊ NÃO PODE REALIZAR ALTERAÇÕES DEVIDO A FALTA DE PERMISSÃO. </p>";
    redirecionamento("listaPasseio", $idPasseio);
    gerarLog("DELETAR PAGAMENTO", $conexao, $idUser, $nomeCliente, $nomePasseio, $dataPasseio, $valorPago, null, 0);
}

?>