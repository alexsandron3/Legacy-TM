<?php
//VERIFICACAO DE SESSOES E INCLUDES NECESSARIOS E CONEXAO AO BANCO DE DADOS
include_once("./includes/header.php");

/* -----------------------------------------------------------------------------------------------------  */
$idCliente = filter_input(INPUT_GET, 'id', FILTER_SANITIZE_NUMBER_INT);
/* -----------------------------------------------------------------------------------------------------  */
$queryBuscaIdCliente = "SELECT nomeCliente, idadeCliente, referencia FROM cliente WHERE idCliente = '$idCliente'";
$resultadoIdCliente = mysqli_query($conexao, $queryBuscaIdCliente);
$rowIdCliente = mysqli_fetch_assoc($resultadoIdCliente);
/* -----------------------------------------------------------------------------------------------------  */
$idadeCliente = calcularIdade($idCliente, $conn, "");
?>
<!DOCTYPE html>
<html lang="PT-BR">

<head>
<?php include_once("./includes/mdbcss.php"); ?>

  <title>PAGAMENTO</title>
</head>

<body>
  <!-- INCLUSÃO DA NAVBAR -->
  <?php include_once("./includes/htmlElements/navbar.php"); ?>
  <div class="row py-2">
    <div class="col-md-10 mx-auto">
      <div class="card rounded shadow border-0">
        <div class="card-body p-5 bg-white rounded">
          <!-- INCLUSÃO DE MENSAGENS DE ERRO E SUCESSO -->
          <?php include_once("./includes/servicos/servicoSessionMsg.php"); ?>
          <form action="" autocomplete="off" method="POST" onkeydown="calculoPagamentoCliente()">
            <?php
            if ($idCliente == 0) {
              mensagensInfoNoSession("POR FAVOR, SELECIONE UM CLIENTE");
              #echo "<p class='h4 text-center alert-danger'>POR FAVOR, SELECIONE UM CLIENTE </p>";
            } else {
              mensagensInfoNoSession("CLIENTE: " . $rowIdCliente['nomeCliente']);
              #echo "<p class='h4 text-center alert-primary'>CLIENTE: " . $rowIdCliente['nomeCliente'] . "</p>";
            }
            ?>
            <div class="form-row">
              <label class="col-form-label" for="nomePasseio">PASSEIO</label>


              <select class="form-control ml-3 col-sm-3" name="passeiosLista" id="selectIdPasseio">
                <option value="0">SELECIONAR</option>

                <?php

                if ($idCliente > 0) {
                  $resultadoBuscaNomePasseio = "SELECT nomePasseio, dataPasseio, idPasseio FROM passeio WHERE statusPasseio NOT IN(0) ORDER BY  dataPasseio";
                  $resultadoNomePasseio = mysqli_query($conexao, $resultadoBuscaNomePasseio);
                  while ($rowNomePasseio = mysqli_fetch_assoc($resultadoNomePasseio)) {
                    $dataPasseio = (empty($rowNomePasseio['dataPasseio']) or $rowNomePasseio == "0000-00-00") ? "" : date_create($rowNomePasseio['dataPasseio']);
                    $dataPasseioFormatada = (empty($dataPasseio) or  $dataPasseio == "0000-00-00") ? "" : date_format($dataPasseio, "d/m/Y");
                ?>
                    <option value="<?php echo $rowNomePasseio['idPasseio']; ?>"><?php echo $rowNomePasseio['nomePasseio'];
                                                                                echo " ";
                                                                                echo $dataPasseioFormatada; ?> </option>
                <?php }
                }
                ?>
                <input type="submit" class="btn btn-info btn-sm ml-2" value="CARREGAR INFORMAÇÕES" name="buttonCarregarInformacoes">
                <input type="hidden" class="form-control col-sm-1 ml-3" name="passeioSelecionado" id="passeioSelecionado" onblur="idPasseioSelecionado()" readonly="readonly">
            </div>
          </form>
          <form action="SCRIPTS/realizaPagamento.php" method="post" autocomplete="OFF"  onblur="calculoPagamento()">
            <div class="form-group-row">
              <?php
              /* -----------------------------------------------------------------------------------------------------  */
              $idPasseioSelecionado = filter_input(INPUT_POST, 'passeiosLista', FILTER_SANITIZE_NUMBER_INT);
              /* -----------------------------------------------------------------------------------------------------  */
              $queryBuscarPasseioPeloId = "SELECT nomePasseio, dataPasseio FROM passeio WHERE idPasseio='$idPasseioSelecionado'";
              $resultadoPasseioSelecionado = mysqli_query($conexao, $queryBuscarPasseioPeloId);
              $rowPasseioSelecionado = mysqli_fetch_assoc($resultadoPasseioSelecionado);
              /* -----------------------------------------------------------------------------------------------------  */
              $buttonCarregarInformacoes = filter_input(INPUT_POST, 'buttonCarregarInformacoes', FILTER_SANITIZE_STRING);
              $idPasseio = $idPasseioSelecionado;
              /* -----------------------------------------------------------------------------------------------------  */

              $queryBuscaSeJaExistePagamento = "SELECT idPagamento FROM pagamento_passeio WHERE idCliente='$idCliente' AND idPasseio='$idPasseio'";
              $resultadoqueryBuscaSeJaExistePagamento = mysqli_query($conexao, $queryBuscaSeJaExistePagamento);
              /* ----------------------------
                -------------------------------------------------------------------------  */
              if ($idCliente > 0) {
                if (empty($idPasseioSelecionado)) {
                  mensagensWarningNoSession("POR FAVOR, SELECIONE UM PASSEIO");
                  $buttonFinalizarPagamento = 'disabled="disabled"';
                } else {
                  $buttonFinalizarPagamento = '';
                  if ($buttonCarregarInformacoes) {
                    if ($idPasseioSelecionado == 0) {
                      echo "NENHUM PASSEIO SELECIONADO";
                    } else {
                      if (mysqli_num_rows($resultadoqueryBuscaSeJaExistePagamento) == 0) {
                        /* -----------------------------------------------------------------------------------------------------  */
                        $verificaSeExisteDespesa = "SELECT d.idPasseio, p.idPasseio FROM despesa d, passeio p WHERE d.idPasseio=p.idPasseio AND d.idPasseio='$idPasseioSelecionado'";
                        $resultadoVerificaSeExisteDespesa = mysqli_query($conexao, $verificaSeExisteDespesa);
                        /* -----------------------------------------------------------------------------------------------------  */
                        if (mysqli_num_rows($resultadoVerificaSeExisteDespesa) != 0) {
                          $dataPasseioSelecionado = (empty($rowPasseioSelecionado['dataPasseio']) or $rowPasseioSelecionado == "0000-00-00") ? "" : date_create($rowPasseioSelecionado['dataPasseio']);
                          $dataPasseioSelecionadoPadrao = (empty($dataPasseioSelecionado) or  $dataPasseioSelecionado == "0000-00-00") ? "" : date_format($dataPasseioSelecionado, "d/m/Y");
                          mensagensInfoNoSession("PASSEIO: " . $rowPasseioSelecionado['nomePasseio'] . " " . $dataPasseioSelecionadoPadrao); ?>
                          <div class='form-row'>
                            <label class=' col-sm-2 col-form-label' for='valorVendido'>VALOR VENDIDO</label>
                            <div class='col-6'>
                              <input type='text' class='block-form campo-monetario form-control' name='valorVendido' id='valorVendido' placeholder='VALOR VENDIDO' value='0' onblur="calculoPagamento()" required >
                            </div>
                          </div>
                          <div class='form-row my-4'>
                            <label class='col-sm-2 col-form-label' for='valorPago'>VALOR PAGO</label>
                            <div class='col-6'>
                              <input type='text' class='block-form campo-monetario form-control' name='valorPago' id='valorPago' placeholder='VALOR PAGO' value='0'  onblur="calculoPagamento()" readonly='readonly'>
                            </div>

                            <div class='col-sm-2'>
                              <input type='text' class='block-form campo-monetario form-control' name='novoValorPago' id='novoValorPago' placeholder='NOVO PAGAMENTO' value='0' onblur="gerarHistorico()">
                            </div>
                            <input type='hidden' class='form-control' name='valorAntigo' id='valorAntigo' placeholder='valorAntigo' value='0' onblur="calculoPagamento()">
                          </div>

                          <div class='form-row my-4'>
                            <label class='col-sm-2 col-form-label' for='valorPendenteCliente'>VALOR PENDENTE</label>
                            <div class='col-6'>
                              <input type='text' class='block-form campo-monetario form-control' name='valorPendenteCliente' id='valorPendenteCliente' placeholder='VALOR PENDENTE' onblur="calculoPagamento()" readonly='readonly' >
                            </div>
                          </div>

                          <div class='form-row my-4'>
                            <label class='col-sm-2 col-form-label' for='taxaPagamento'>TAXA DE PAGAMENTO</label>
                            <div class='col-6'>
                              <input type='text' class='block-form campo-monetario form-control' name='taxaPagamento' id='taxaPagamento' value='0' placeholder='TAXA DE PAGAMENTO' onblur="calculoPagamento(); gerarHistorico()">
                            </div>
                          </div>
                          <div class='form-row my-4'>
                            <label class='col-sm-2 col-form-label' for='localEmbarque'>LOCAL DE EMBARQUE</label>
                            <div class='col-6'>
                              <input type='text' class='block-form campos-de-texto form-control' name='localEmbarque' id='localEmbarque' placeholder='LOCAL DE EMBARQUE' required='required' autocomplete='on' >
                            </div>
                          </div>
                          <div class='form-row my-4'>
                            <label class='col-sm-2 col-form-label' for='previsaoPagamento'>PREVISÃO PAGAMENTO</label>
                            <div class='col-sm-3'>
                              <input type='date' class='block-form form-control' name='previsaoPagamento' id='previsaoPagamento' placeholder='PREVISÃO PAGAMENTO'>
                            </div>
                          </div>

                          <div class='form-row my-4'>
                            <label class='col-sm-2 col-form-label' for='meioTransporte'>TRANSPORTE</label>
                            <div class='col-sm-3'>
                              <input type='text' class='block-form campos-de-texto form-control' name='meioTransporte' id='meioTransporte' placeholder='TRANSPORTE' autocomplete='on'>
                            </div>
                          </div>

                          <div class='form-row my-4'>
                            <label class='col-sm-2 col-form-label' for='idadeCliente'>IDADE</label>
                            <div class='col-sm-1'>
                              <input type='text' class='block-form form-control' name='idadeCliente' id='idadeCliente' placeholder='' value='<?php echo $idadeCliente ?>'>
                            </div>
                          </div>

                          <input type='hidden' class='form-control' name='statusPagamento' id='statusPagamento' placeholder='statusPagamento' >
                          <input type='hidden' class='form-control' name='idadeCliente' id='idadeCliente' placeholder='idadeCliente' value='<?php echo $rowIdCliente['idadeCliente'] ?>'>


                          <div class='form-row my-4'>
                            <label class='col-sm-2 col-form-label' for='referenciaCliente'>REFERÊNCIA</label>
                            <textarea class='text-area form-control ' name='referenciaCliente' id='referenciaCliente' cols='60' rows='3' disabled='disabled' placeholder='INFORMAÇÕES'  maxlength='100'><?php echo $rowIdCliente['referencia'] ?></textarea>
                          </div>


                          <fieldset class='block-form form-group'>
                            <div class='row'>
                              <legend class='col-form-label col-sm-2 pt-0 text-muted'>SEGURO VIAGEM</legend>
                              <div class='col-sm-5 '>
                                <div class='col'>
                                  <input class='form-check-input ' type='radio' name='seguroViagemCliente' id='seguroViagemClienteSim' value='1' required>
                                  <label class='form-check-label' for='seguroViagemClienteSim'>
                                    SIM
                                  </label>
                                </div>
                                <div class='col'>
                                  <input class='form-check-input' type='radio' name='seguroViagemCliente' id='seguroViagemClientenao' value='0'>
                                  <label class='form-check-label' for='seguroViagemClientenao'>
                                    NÃO
                                  </label>
                                </div>
                              </div>
                          </fieldset>

                          <fieldset class='block-form form-group'>
                            <div class='row'>
                              <legend class='col-form-label col-sm-2 pt-0 text-muted'>CLIENTE PARCEIRO</legend>
                              <div class='col-sm-5'>
                                <div class='col'>
                                  <input class='form-check-input' type='radio' name='clienteParceiro' id='clienteParceiroSim' value='1' required onclick='calculoPagamentoCliente()'>
                                  <label class='form-check-label' for='clienteParceiroSim'>
                                    SIM
                                  </label>
                                </div>
                                <div class='col'>
                                  <input class='form-check-input' type='radio' name='clienteParceiro' id='clienteParceironao' value='0' onclick='calculoPagamentoCliente()' checked>
                                  <label class='form-check-label' for='clienteParceironao'>
                                    NÃO
                                  </label>
                                </div>
                              </div>
                            </div>
                          </fieldset>
                          <div class='form-row my-4' >
                            <label class='col-3 col-form-label' for='anotacoes'>ANOTAÇÕES</label>
                            <textarea class='text-area form-control  ml-3' name='anotacoes' id='anotacoes' cols='20' rows='3' placeholder='ANOTAÇÕES'  maxlength='500'></textarea>
                            <label class='col-form-label' for='anotacoes'>HISTÓRICO</label>
                            <textarea class='form-control ml-3' name='historicoPagamento' id='historicoPagamento' cols='30' rows='3' placeholder='historicoPagamento' maxlength='500'>  </textarea>
                            <textarea style='display:none;' class='form-control col-sm-3 ml-3' name='historicoPagamentoAntigo' id='historicoPagamentoAntigo' cols='6' rows='3' placeholder='historicoPagamentoAntigo' maxlength='500' disabled='disabled' onblur='(new calculoPagamentoCliente()).novoValorPago()'>  </textarea>
                          </div>
              <?php
                        } else {
                          mensagensWarningNoSession("VOCÊ PRECISA CRIAR AS DESPESAS DESTE PASSEIO, REDIRECIONANDO PARA A ÁREA DE CRIAÇÃO DE DESPESAS");
                          echo " <script>
                                setTimeout(function () {
                                  window.location.href = 'cadastroDespesas.php';
                              }, 3000);
                            </script>
                      ";
                        }
                      } else {
                        mensagensInfoNoSession("PASSEIO: " . $rowPasseioSelecionado['nomePasseio'] . " " . $rowPasseioSelecionado['dataPasseio']);
                        mensagensWarningNoSession("ESTE CLIENTE JÁ REALIZOU O PAGAMENTO PARA ESTE PASSEIO, REDIRECIONANDO PARA A ÁREA DE PAGAMENTO");
                        echo " <script>
                              setTimeout(function () {
                                window.location.href = 'listaPasseio.php?id=" . $idPasseio . "';
                            }, 5000);
                          </script>
                    ";
                      }
                    }
                  }
                }
              }
              ?>

              </select>
            </div>
            <input type="hidden" id="statusFormulario" value="1">
            <input type="submit" class="btn btn-info btn-sm" value="FINALIZAR PAGAMENTO" id="buttonFinalizarPagamento" name="buttonFinalizarPagamento" <?php echo $buttonFinalizarPagamento; ?>>
            <input type="hidden" class="form-control col-sm-1 ml-3" name="idClienteSelecionado" id="idCliente" readonly="readonly" value="<?php echo $idCliente ?>">
            <input type="hidden" class="form-control col-sm-1 ml-3" name="idPasseioSelecionado" id="idPasseio" readonly="readonly" value="<?php echo $idPasseioSelecionado ?>">
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