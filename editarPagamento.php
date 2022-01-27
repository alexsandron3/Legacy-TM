<?php
//VERIFICACAO DE SESSOES E INCLUDES NECESSARIOS E CONEXAO AO BANCO DE DADOS
include_once("./includes/header.php");

/* -----------------------------------------------------------------------------------------------------  */
$idPagamento = filter_input(INPUT_GET, 'id', FILTER_SANITIZE_NUMBER_INT);
/* -----------------------------------------------------------------------------------------------------  */
$queryBuscaIdPagamento = "    SELECT DISTINCT c.nomeCliente, c.referencia, c.idadeCliente , p.idPasseio, p.nomePasseio, p.dataPasseio, pp.idPagamento, pp.transporte , pp.idPasseio, pp.valorPago, pp.valorVendido, 
                                  pp.previsaoPagamento, pp.anotacoes, pp.valorPendente, pp.statusPagamento, pp.seguroViagem, pp.taxaPagamento, pp.localEmbarque, pp.clienteParceiro, pp.historicoPagamento, pp.idCliente, pp.clienteDesistente 
                                  FROM cliente c, passeio p, pagamento_passeio pp WHERE idPagamento='$idPagamento' AND pp.idPasseio=p.idPasseio AND pp.idCliente=c.idCliente";
$resultadoIdPagamento = mysqli_query($conexao, $queryBuscaIdPagamento);
$rowIdPagamento = mysqli_fetch_assoc($resultadoIdPagamento);
/* -----------------------------------------------------------------------------------------------------  */
$idPasseio = $rowIdPagamento['idPasseio'];
$statusSeguroViagem = $rowIdPagamento['seguroViagem'];
$clienteParceiro = $rowIdPagamento['clienteParceiro'];
$transporte = $rowIdPagamento['transporte'];


?>
<!DOCTYPE html>
<html lang="PT-BR">

<head>
<?php include_once("./includes/mdbcss.php"); ?>

  <title>EDITAR PAGAMENTO</title>
</head>

<body onload="verificaDePrevisaoPagamento()">
  <div class="modal fade" id="basicExampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Mensagem</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          Hoje é o dia do pagamento
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Fechar</button>
        </div>
      </div>
    </div>
  </div>
  <!-- INCLUSÃO DA NAVBAR -->
  <?php include_once("./includes/htmlElements/navbar.php"); ?>
  <div class="row py-5">
    <div class="col-md-10 mx-auto">
      <div class="card rounded shadow border-0">
        <div class="card-body p-5 bg-white rounded ">
          <!-- INCLUSÃO DE MENSAGENS DE ERRO E SUCESSO -->
          <?php include_once("./includes/servicos/servicoSessionMsg.php"); ?>
          <form action="SCRIPTS/atualizaPagamento.php" method="post" autocomplete="OFF" onblur="calculoPagamento()">
            <div class="form-group-row">
              <?php
              $dataPasseio = date_create($rowIdPagamento['dataPasseio']);

              $nomePasseioSelelecionado = $rowIdPagamento['nomePasseio'];
              $valorVendido  = $rowIdPagamento['valorVendido'];
              $anotacoes  = $rowIdPagamento['anotacoes'];
              $valorPago     = $rowIdPagamento['valorPago'];
              $valorPendente = $rowIdPagamento['valorPendente'];
              $taxaPagamento = $rowIdPagamento['taxaPagamento'];
              $localEmbarque = $rowIdPagamento['localEmbarque'];
              $historicoPagamento = $rowIdPagamento['historicoPagamento'];
              $clienteParceiro = $rowIdPagamento['clienteParceiro'];
              $idCliente = $rowIdPagamento['idCliente'];
              $idadeCliente = calcularIdade($idCliente, $conn, "");
              mensagensInfoNoSession("" . $rowIdPagamento['nomeCliente'] . " | " . $rowIdPagamento['nomePasseio'] . " " . date_format($dataPasseio, "d/m/Y"));
              ?>
              <div class='form-row my-4'>
                <label class='col-sm-2 col-form-label' for='valorVendido'>VALOR VENDIDO</label>
                <div class='col-6'>
                  <input type='text' class='block-form campo-monetario form-control' name='valorVendido' id='valorVendido' placeholder='VALOR VENDIDO' value='<?php echo $valorVendido ?>' onblur="calculoPagamento()">
                </div>
              </div>
              <div class='form-row my-4'>
                <label class='col-sm-2 col-form-label' for='valorPago'>VALOR PAGO</label>
                <div class='col-6'>
                  <input type='text' class='block-form campo-monetario form-control' name='valorPago' id='valorPago' placeholder='VALOR PAGO' value='<?php echo $valorPago ?>' onblur="calculoPagamento()" readonly="readonly">
                </div>
                <div class='col-sm-2'>
                  <input type='text' class='block-form campo-monetario form-control' name='novoValorPago' id='novoValorPago' placeholder='NOVO PAGAMENTO' value=' 0' onblur="gerarHistorico()">
                  <input type='hidden' class='form-control' name='valorAntigo' id='valorAntigo' placeholder='valorAntigo' value='<?php echo $valorPago ?>' onblur="calculoPagamento()">
                  <input type='hidden' class='form-control' name='idCliente' id='idCliente' placeholder='idCliente' value='<?php echo $idCliente ?>'>
                </div>
              </div>
              <div class='form-row my-4'>
                <label class='col-sm-2 col-form-label' for='valorPendenteCliente'>VALOR PENDENTE</label>
                <div class='col-6'>
                  <input type='text' class='form-control' name='valorPendenteCliente' id='valorPendenteCliente' placeholder='VALOR PENDENTE' value='<?php echo $valorPendente ?>' onblur="calculoPagamento()" readonly='readonly'>
                </div>
              </div>
              <div class='form-row my-4'>
                <label class='col-sm-2 col-form-label' for='taxaPagamento'>TAXA DE PAGAMENTO</label>
                <div class='col-6'>
                  <input type='text' class='block-form campo-monetario form-control' name='taxaPagamento' id='taxaPagamento' value='<?php echo $taxaPagamento ?>' placeholder='TAXA DE PAGAMENTO' onblur="calculoPagamento(); gerarHistorico()">
                </div>
              </div>
              <div class='form-row my-4'>
                <label class='col-sm-2 col-form-label' for='localEmbarque'>LOCAL DE EMBARQUE</label>
                <div class='col-6'>
                  <input type='text' class='block-form  form-control' name='localEmbarque' id='localEmbarque' placeholder='LOCAL DE EMBARQUE' value='<?php echo $localEmbarque ?>' required='required' autocomplete='on' onkeydown="upperCaseF(this)">
                </div>
              </div>
              <div class='form-row my-4'>
                <label class='col-sm-2 col-form-label' for='previsaoPagamento'>PREVISÃO PAGAMENTO</label>
                <div class='col-sm-3'>
                  <input type='date' class='block-form form-control' name='previsaoPagamento' id='previsaoPagamento' value='<?php echo $rowIdPagamento['previsaoPagamento']  ?>' placeholder='PREVISÃO PAGAMENTO' onblur='verificaDataDePrevisaoPagamento()'>
                </div>
              </div>
              <div class='form-row my-4'>
                <label class='col-sm-2 col-form-label' for='meioTransporte'>TRANSPORTE</label>
                <div class='col-sm-3'>
                  <input type='text' class='block-form campos-de-texto form-control' name='meioTransporte' id='meioTransporte' value='<?php echo $transporte   ?>' placeholder='TRANSPORTE' autocomplete='on' onkeydown="upperCaseF(this)">
                </div>
              </div>
              <div class='form-row my-4'>
                <label class='col-sm-2 col-form-label' for='idadeCliente'>IDADE</label>
                <div class='col-sm-1'>
                  <input type='text' class='block-form campo-monetario form-control' name='idadeCliente' id='idadeCliente' placeholder='' value='<?php echo $idadeCliente ?>'>
                </div>
              </div>
              <input type='hidden' class='form-control' name='statusPagamento' id='statusPagamento' placeholder='statusPagamento'>

              <div class='form-row my-4'>
                <label class='col-sm-2 col-form-label' for='referenciaCliente'>REFERÊNCIA</label>
                <textarea class='text-area form-control ml-3' name='referenciaCliente' id='referenciaCliente' cols='60' rows='3' disabled='disabled' placeholder='INFORMAÇÕES'> <?php echo $rowIdPagamento['referencia'] ?></textarea>
              </div>

              <fieldset class='form-group'>
                <?php
                $statusSeguroViagemtrue = '';
                $statusSeguroViagemfalse = '';
                if ($statusSeguroViagem == 1) {
                  $statusSeguroViagemtrue = 'checked';
                } else {
                  $statusSeguroViagemfalse = 'checked';
                } ?>

                <div class='block-form row'>
                  <legend class='col-form-label col-sm-2 pt-0 text-muted'>SEGURO VIAGEM</legend>
                  <div class='col-sm-5'>
                    <div class='col'>
                      <input class='form-check-input' type='radio' name='seguroViagemCliente' id='seguroViagemClienteSim' value='1' <?php echo $statusSeguroViagemtrue; ?>>
                      <label class='form-check-label' for='seguroViagemClienteSim'>
                        SIM
                      </label>
                    </div>
                    <div class='col'>
                      <input class='form-check-input' type='radio' name='seguroViagemCliente' id='seguroViagemClientenao' value='0' <?php echo $statusSeguroViagemfalse; ?>>
                      <label class='form-check-label' for='seguroViagemClientenao'>
                        NÃO
                      </label>
                    </div>
                  </div>
                </div>
                <input type='hidden' class='form-control' name='idadeCliente' id='idadeCliente' placeholder='idadeCliente' value='<?php echo $idadeCliente; ?>'>
                <input type='hidden' class='form-control' name='idPasseioSelecionado' id='idPasseioSelecionado' placeholder='idPasseioSelecionado' value='<?php echo $idPasseio ?>'>
                <?php
                $clienteDesistenteTrue = '';
                $clienteDesistenteFalse = '';
                if ($rowIdPagamento['clienteDesistente'] == 1) {
                  $clienteDesistenteTrue = 'checked';
                } else {
                  $clienteDesistenteFalse = 'checked';
                }
                ?>
                <div class='block-form row'>
                  <legend class='col-form-label col-sm-2 pt-0 text-muted'>DESISTENTE</legend>
                  <div class='col-sm-5'>
                    <div class='col'>
                      <input class='form-check-input' type='radio' name='clienteDesistente' id='clienteDesistenteSim' value='1' <?php echo $clienteDesistenteTrue ?>>
                      <label class='form-check-label' for='clienteDesistenteSim'>
                        SIM
                      </label>
                    </div>
                    <div class='col'>
                      <input class='form-check-input' type='radio' name='clienteDesistente' id='clienteDesistenteoNao' value='0' <?php echo $clienteDesistenteFalse ?>>
                      <label class='form-check-label' for='clienteDesistenteNao'>
                        NÃO
                      </label>
                    </div>
                  </div>
                </div>

                <?php
                $clienteParceiroTrue = '';
                $clienteParceiroFalse = '';

                if ($clienteParceiro == 1) {
                  $clienteParceiroTrue = 'checked';
                } else {
                  $clienteParceiroFalse = 'checked';
                } ?>
                <div class='block-form row'>
                  <legend class='col-form-label col-sm-2 pt-0 text-muted'>CLIENTE PARCEIRO</legend>
                  <div class='col-sm-5'>
                    <div class='col'>
                      <input class='form-check-input' type='radio' name='clienteParceiro' id='clienteParceiroSim' value='1' <?php echo $clienteParceiroTrue ?>>
                      <label class='form-check-label' for='clienteParceiroSim'>
                        SIM
                      </label>
                    </div>
                    <div class='col'>
                      <input class='form-check-input' type='radio' name='clienteParceiro' id='clienteParceironao' value='0' <?php echo $clienteParceiroFalse ?>>
                      <label class='form-check-label' for='clienteParceironao'>
                        NÃO
                      </label>
                    </div>
                  </div>
                </div>
              </fieldset>
              <div class='form-row my-4'>
                <label class='col-sm-2 col-form-label' for='anotacoes'>ANOTAÇÕES</label>
                <textarea class='text-area form-control ml-3' name='anotacoes' id='anotacoes' cols='20' rows='3' placeholder='ANOTAÇÕES' maxlength='500'> <?php echo $anotacoes ?></textarea>
                <label class='col-sm-2 col-form-label' for='anotacoes'>HISTÓRICO</label>
                <textarea class='form-control ml-3' name='historicoPagamento' id='historicoPagamento' cols='30' rows='3' placeholder='historicoPagamento' maxlength='500'> <?php echo $historicoPagamento ?> </textarea>
                <textarea style='display:none;' class='form-control col-sm-3 ml-3' name='historicoPagamentoAntigo' id='historicoPagamentoAntigo' cols='6' rows='3' placeholder='historicoPagamentoAntigo' maxlength='500' disabled='disabled' onblur='(new calculoPagamentoCliente()).novoValorPago()'> <?php echo $historicoPagamento ?> </textarea>
              </div>

            </div>
            <input type="hidden" id="statusFormulario" value="1">
            <input type="submit" class="btn btn-info btn-sm" value="FINALIZAR PAGAMENTO" name="buttonFinalizarPagamento" id="buttonFinalizarPagamento">
            <input type="hidden" class="form-control col-sm-1 ml-3" name="idPagamento" id="idPagamento" readonly="readonly" value="<?php echo $idPagamento ?>">
          </form>
        </div>
      </div>
    </div>
  </div>
  <?php include_once("./includes/mdbJs.php"); ?>
  <script src="config/novoScript.js"></script>
  <script src="config/calculoPagamentoCliente.js"></script>

</body>

</html>