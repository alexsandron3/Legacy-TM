<?php
//VERIFICACAO DE SESSOES E INCLUDES NECESSARIOS E CONEXAO AO BANCO DE DADOS
include_once("./includes/header.php");
if($_SESSION['nivelAcesso'] !== ADMINISTRADOR) {
  header("location: index.php");

}
/* -----------------------------------------------------------------------------------------------------  */
$idPasseio = filter_input(INPUT_GET, 'id', FILTER_SANITIZE_NUMBER_INT);

/* -----------------------------------------------------------------------------------------------------  */
if (!empty($idPasseio)) {
  $nenhumPasseioSelecionado = false;
  $decoraçãoLink = '';
  //echo"SITUAÇÃO 1";


  /* -----------------------------------------------------------------------------------------------------  */
  $pesquisaIdPasseio = "SELECT DISTINCT p.idPasseio, p.nomePasseio,SUM(pp.valorPago) AS somarValorPago, SUM(pp.valorPendente) AS valorPendente, COUNT(pp.idPagamento) AS qtdCliente,
                                                    FORMAT(SUM(taxaPagamento), 2) AS totalTaxaPagamento, p.nomePasseio, p.dataPasseio, p.valorPasseio 
                                                    FROM pagamento_passeio pp, passeio p  WHERE pp.idPasseio=p.idPasseio AND pp.idPasseio=$idPasseio AND statusPagamento NOT IN(0)";
  $resultadPesquisaIdPasseio = mysqli_query($conexao, $pesquisaIdPasseio);
  $pesquisaValorMedioVendido = "SELECT DISTINCT AVG(pp.valorVendido) AS valorMediaVendido 
                                      FROM pagamento_passeio pp, passeio p WHERE pp.idPasseio=p.idPasseio AND pp.idPasseio=$idPasseio AND statusPagamento NOT IN(0,3)";
  $resultadoValorMedioVendido = mysqli_query($conexao, $pesquisaValorMedioVendido);
  $rowMediaVendido            = mysqli_fetch_assoc($resultadoValorMedioVendido);
  $valorMediaVendido          = $rowMediaVendido['valorMediaVendido'];
  while ($rowPesquisaIdPasseio      = mysqli_fetch_assoc($resultadPesquisaIdPasseio)) {


    $lucroBruto                    = $rowPesquisaIdPasseio['somarValorPago'];
    $valorPendente                 = $rowPesquisaIdPasseio['valorPendente'];
    $valorPendente                 = number_format((float) $valorPendente, 2, '.', '') * -1;
    $qtdCliente                    = $rowPesquisaIdPasseio['qtdCliente'];
    $valorPasseio                  = $rowPesquisaIdPasseio['valorPasseio'];
    $taxaPagamento                 = $rowPesquisaIdPasseio['totalTaxaPagamento'];
    $nomePasseio                   = $rowPesquisaIdPasseio['nomePasseio'];
  }
  /* -----------------------------------------------------------------------------------------------------  */

  $totalDespesas =        "SELECT SUM(d.totalDespesas) AS totalDespesas, p.dataPasseio FROM  despesa d, passeio p WHERE d.idPasseio=p.idPasseio AND p.idPasseio=$idPasseio ";

  $resultadoTotalDespesas = mysqli_query($conexao, $totalDespesas);
  while ($rowTotalDespesa = mysqli_fetch_assoc($resultadoTotalDespesas)) {

    $dataPasseio = date_create($rowTotalDespesa['dataPasseio']);

    $valorTotalDespesas             = $rowTotalDespesa['totalDespesas']/* + $valorTotalSeguroViagem */;

    /* -----------------------------------------------------------------------------------------------------  */

    $lucroLiquido                   = $lucroBruto + $valorPendente;
    $lucroDespesas                  = $lucroBruto - $valorTotalDespesas;
    $lucroEstimado                  = $valorPendente + $lucroBruto - $valorTotalDespesas;
    /* -----------------------------------------------------------------------------------------------------  */
  }



  /* -----------------------------------------------------------------------------------------------------  */


  /* -----------------------------------------------------------------------------------------------------  */
} else {
  //echo"SITUAÇÃO 2";
  $nenhumPasseioSelecionado = true;
  $decoraçãoLink = 'text-reset text-decoration-none';
}
?>

<!DOCTYPE html>
<html lang="PT-BR">

<head>
<?php include_once("./includes/mdbcss.php"); ?>

  <title>LUCROS</title>
</head>

<body>
  <!-- INCLUSÃO DA NAVBAR -->
  <?php include_once("./includes/htmlElements/navbar.php"); ?>


  <div class="row py-2">
    <div class="col-md-10 mx-auto">

      <div class="card rounded shadow border-0">
        <p class="h2 text-center">LUCROS</p>
        <!-- INCLUSÃO DE MENSAGENS DE ERRO E SUCESSO -->
        <?php include_once("./includes/servicos/servicoSessionMsg.php"); ?>
        <div class="card-body p-5 bg-white rounded">
          <?php
          if ($nenhumPasseioSelecionado) {
            $valorPendente            = 0;
            $lucroBruto               = 0;
            $valorMediaVendido        = 0;
            $lucroLiquido             = 0;
            $lucroDespesas            = 0;
            $totalDespesas            = 0;
            $qtdCliente               = 0;
            $lucroEstimado            = 0;
            $valorTotalDespesas       = 0;
            $valorPasseio             = 0;
            $taxaPagamento            = 0;

          ?>
            <form action='' method='GET' autocomplete='OFF'>
              <div class='form-row '>
                <div class='col'>
                  <input data-toggle='tooltip' data-placement='top' title='SELECIONE O INÍCIO DO PERÍODO' type='date' class='form-control' name='inicioDataPasseio' id='inicioDataPasseio'>
                </div>
                <div class='col'>
                  <input data-toggle='tooltip' data-placement='top' title='SELECIONE O FIM DO PERÍODO ' type='date' class='form-control' name='fimDataPasseio' id='fimDataPasseio'>
                </div>
              </div>
              <div class='form-row mt-3'>
                <input type='submit' class='btn btn-info btn-md' value='CARREGAR INFORMAÇÕES' name='buttonEviaDataPasseio'>
              </div>
            </form>
          <?php
            /* -----------------------------------------------------------------------------------------------------  */
            $buttonEviaDataPasseio = filter_input(INPUT_GET, 'buttonEviaDataPasseio', FILTER_SANITIZE_STRING);
            $inicioDataPasseio     = filter_input(INPUT_GET, 'inicioDataPasseio', FILTER_SANITIZE_STRING);
            $fimDataPasseio        = filter_input(INPUT_GET, 'fimDataPasseio', FILTER_SANITIZE_STRING);
            /* -----------------------------------------------------------------------------------------------------  */
            if ($buttonEviaDataPasseio) {
              if (!empty($inicioDataPasseio) && !empty($fimDataPasseio)) {
                //echo"SITUAÇÃO 3";
                $decoraçãoLink = 'text-reset text-decoration-none';
                /* -----------------------------------------------------------------------------------------------------  */
                $pesquisaIntervaloData = "SELECT DISTINCT p.idPasseio, p.nomePasseio, SUM(pp.valorPago) AS somarValorPago, SUM(pp.valorPendente) AS valorPendente, COUNT(pp.idPagamento) AS qtdCliente,
                                            FORMAT(SUM(taxaPagamento), 2) AS totalTaxaPagamento, p.nomePasseio, p.dataPasseio, p.valorPasseio 
                                            FROM pagamento_passeio pp, passeio p  WHERE pp.idPasseio=p.idPasseio AND dataPasseio BETWEEN '$inicioDataPasseio' AND '$fimDataPasseio' AND statusPagamento NOT IN(0)";
                $resultadPesquisaIntervaloData = mysqli_query($conexao, $pesquisaIntervaloData);

                $pesquisaValorMedioVendido = "SELECT DISTINCT AVG(pp.valorVendido) AS valorMediaVendido 
                                                  FROM pagamento_passeio pp, passeio p WHERE pp.idPasseio=p.idPasseio AND dataPasseio BETWEEN '$inicioDataPasseio' AND '$fimDataPasseio' AND statusPagamento NOT IN(0,3)";
                $resultadoValorMedioVendido = mysqli_query($conexao, $pesquisaValorMedioVendido);
                $rowMediaVendido            = mysqli_fetch_assoc($resultadoValorMedioVendido);
                $valorMediaVendido             = $rowMediaVendido['valorMediaVendido'];
                while ($rowPesquisaIntervaloData      = mysqli_fetch_assoc($resultadPesquisaIntervaloData)) {


                  $lucroBruto                    = $rowPesquisaIntervaloData['somarValorPago'];
                  $valorPendente                 = $rowPesquisaIntervaloData['valorPendente'];
                  $valorPendente                   = number_format((float) $valorPendente, 2, '.', '') * -1;

                  $qtdCliente                    = $rowPesquisaIntervaloData['qtdCliente'];
                  $valorPasseio                  = $rowPesquisaIntervaloData['valorPasseio'];
                  $taxaPagamento                 = $rowPesquisaIntervaloData['totalTaxaPagamento'];

                  /* -----------------------------------------------------------------------------------------------------  */
                }
                /* -----------------------------------------------------------------------------------------------------  */

                $totalDespesas =        "SELECT SUM(d.totalDespesas) AS totalDespesas FROM  despesa d, passeio p WHERE d.idPasseio=p.idPasseio AND p.dataPasseio BETWEEN '$inicioDataPasseio' AND '$fimDataPasseio'";
                $resultadoTotalDespesas = mysqli_query($conexao, $totalDespesas);
                while ($rowTotalDespesa = mysqli_fetch_assoc($resultadoTotalDespesas)) {


                  $valorTotalDespesas             = $rowTotalDespesa['totalDespesas']/* + $valorTotalSeguroViagem */;

                  /* -----------------------------------------------------------------------------------------------------  */

                  $lucroLiquido                   = $lucroBruto + $valorPendente;
                  $lucroDespesas                  = $lucroBruto - $valorTotalDespesas;
                  $lucroEstimado                  = $valorPendente + $lucroBruto - $valorTotalDespesas;
                  /* -----------------------------------------------------------------------------------------------------  */
                }
                $inicioDataPasseioFormatado = date_create($inicioDataPasseio);
                $fimDataPasseioFormatado = date_create($fimDataPasseio);
                mensagensInfoNoSession("PERÍODO SELECIONADO:  " . date_format($inicioDataPasseioFormatado, "d/m/Y") . " => " . date_format($fimDataPasseioFormatado, "d/m/Y") . " <i class='material-icons'> <a data-toggle='tooltip' data-placement='top' title='LISTA DOS PASSEIOS INCLUÍDOS ' href='listaRelatorioPasseios.php?inicioDataPasseio=" . $inicioDataPasseio . "&fimDataPasseio=" . $fimDataPasseio . "&mostrarPasseiosExcluidos=1'> info_ountline</a></i>");
              } else {
                //echo"SITUAÇÃO 4";
                $inicioDataPasseioPadrao = '2000-01-01';
                $fimDataPasseioPadrao    = '2099-01-01';
                $decoraçãoLink = 'text-reset text-decoration-none';
                /* -----------------------------------------------------------------------------------------------------  */
                $pesquisaIntervaloData = "SELECT DISTINCT p.idPasseio, p.nomePasseio, SUM(pp.valorPago) AS somarValorPago, SUM(pp.valorPendente) AS valorPendente, COUNT(pp.idPagamento) AS qtdCliente, AVG(pp.valorVendido) AS valorMediaVendido,
                                            FORMAT(SUM(taxaPagamento), 2) AS totalTaxaPagamento, p.nomePasseio, p.dataPasseio, p.valorPasseio 
                                            FROM pagamento_passeio pp, passeio p  WHERE pp.idPasseio=p.idPasseio AND dataPasseio BETWEEN '$inicioDataPasseioPadrao' AND '$fimDataPasseioPadrao' AND statusPagamento NOT IN(0)";
                $resultadPesquisaIntervaloData = mysqli_query($conexao, $pesquisaIntervaloData);

                $pesquisaValorMedioVendido = "SELECT DISTINCT AVG(pp.valorVendido) AS valorMediaVendido 
                                                  FROM pagamento_passeio pp, passeio p WHERE pp.idPasseio=p.idPasseio AND dataPasseio BETWEEN '$inicioDataPasseioPadrao' AND '$fimDataPasseioPadrao' AND statusPagamento NOT IN(0,3)";
                $resultadoValorMedioVendido = mysqli_query($conexao, $pesquisaValorMedioVendido);
                $rowMediaVendido            = mysqli_fetch_assoc($resultadoValorMedioVendido);
                $valorMediaVendido             = $rowMediaVendido['valorMediaVendido'];

                while ($rowPesquisaIntervaloData      = mysqli_fetch_assoc($resultadPesquisaIntervaloData)) {


                  $lucroBruto                    = $rowPesquisaIntervaloData['somarValorPago'];
                  $valorPendente                 = $rowPesquisaIntervaloData['valorPendente'];
                  $valorPendente                 = number_format((float) $valorPendente, 2, '.', '') * -1;
                  $qtdCliente                    = $rowPesquisaIntervaloData['qtdCliente'];
                  $valorPasseio                  = $rowPesquisaIntervaloData['valorPasseio'];
                  $taxaPagamento                 = $rowPesquisaIntervaloData['totalTaxaPagamento'];

                  /* -----------------------------------------------------------------------------------------------------  */
                }

                /* -----------------------------------------------------------------------------------------------------  */


                $totalDespesas =        "SELECT SUM(d.totalDespesas) AS totalDespesas  FROM  despesa d, passeio p WHERE d.idPasseio=p.idPasseio AND p.dataPasseio BETWEEN '$inicioDataPasseioPadrao' AND '$fimDataPasseioPadrao'";

                $resultadoTotalDespesas = mysqli_query($conexao, $totalDespesas);
                while ($rowTotalDespesa = mysqli_fetch_assoc($resultadoTotalDespesas)) {


                  $valorTotalDespesas             = $rowTotalDespesa['totalDespesas'] /* + $valorTotalSeguroViagem */;

                  /* -----------------------------------------------------------------------------------------------------  */
                  $lucroLiquido                   = $lucroBruto + $valorPendente;

                  $lucroDespesas                  = $lucroBruto - $valorTotalDespesas;
                  $lucroEstimado                  = $valorPendente + $lucroBruto - $valorTotalDespesas;
                  /* -----------------------------------------------------------------------------------------------------  */
                }
                if ($inicioDataPasseioPadrao == '2000-01-01' && $fimDataPasseioPadrao == '2099-01-01') {
                  mensagensInfoNoSession("EXIBINDO INFORMAÇÕES SOBRE TODOS OS PASSEIOS <i class='material-icons mb-2'> <a  data-toggle='tooltip' data-placement='top' title='LISTA DOS PASSEIOS INCLUÍDOS ' href='listaRelatorioPasseios.php?inicioDataPasseio=&fimDataPasseio=&mostrarPasseiosExcluidos=1'> info_outline </a></i>");
                } else {
                  //
                }
              }
            } else {
              //
            }
          } else {

            mensagensInfoNoSession($nomePasseio . " " . date_format($dataPasseio, "d/m/Y"));
          }
          ?>
          </p>



          <div class="form-row mt-3">
            <div class="col">
              <label class="col-form-label" data-toggle="tooltip" data-placement="top" title="SOMA DE TODO VALOR NÃO PAGO PELOS CLIENTES" for="valorPendente">VALOR PENDENTE</label>
              <input type="text" class="form-control " name="valorPendente" id="valorPendente" placeholder="0" value="<?php echo number_format((float) $valorPendente, 2, '.', '') ?>" readonly>
            </div>
            <div class="col">
              <label class="col-form-label" data-toggle="tooltip" data-placement="top" title="TAXAS DE PAGAMENTO COMO PARCELAMENTO E OUTROS" for="taxaPagamento">TAXAS DE PAGAMENTO</label>
              <input type="text" class="form-control " name="taxaPagamento" id="taxaPagamento" placeholder="0" value="<?php echo number_format((float) $taxaPagamento, 2, '.', '') ?>" readonly>
            </div>
          </div>

          <div class="form-row">
            <div class="col">
              <label class="col-form-label" data-toggle="tooltip" data-placement="top" title="SOMA DE TODO VALOR PAGO PELOS CLIENTES SEM DESCONTOS" for="lucroBruto">RECEBIMENTOS</label>
              <input type="text" class="form-control " name="lucroBruto" id="lucroBruto" placeholder="0" value="<?php echo number_format((float) $lucroBruto, 2, '.', '') ?>" readonly>
            </div>
            <div class="col">
              <label class="col-form-label" data-toggle="tooltip" data-placement="top" title="EXCLUÍDOS PAGAMENTOS DE CRIANÇAS E PARCEIROS" for="valorMediaVendido">VALOR MÉDIO VENDIDO</label>
              <input type="text" class="form-control " name="valorMediaVendido" id="valorMediaVendido" placeholder="0" value="<?php echo number_format((float) $valorMediaVendido, 2, '.', '') ?>" readonly>
            </div>
          </div>

          <div class="form-row">
            <div class="col">
              <label class="col-form-label" data-toggle="tooltip" data-placement="top" title="RECEBIMENTOS - TOTAL DAS DESPESAS" for="lucroDespesas">LUCRO REAL</label>
              <input type="text" class="form-control " name="lucroDespesas" id="lucroDespesas" placeholder="0" value="<?php echo number_format((float) $lucroDespesas, 2, '.', '') ?>" readonly>
            </div>
            <div class="col">
              <?php
              if (empty($idPasseio)) { ?>
                <label class="col-form-label" data-toggle="tooltip" data-placement="top" title="DESPESAS PASSEIO + SEGURO VIAGEM" for="totalDespesas"> TOTAL DESPESAS</label>

                <input type="text" class="form-control " name="totalDespesas" id="totalDespesas" placeholder="0" value="<?php echo number_format((float) $valorTotalDespesas, 2, '.', '') ?>" readonly>
              <?php } else {
              ?>

                <a class="<?php echo $decoraçãoLink ?> " rel="noopener noreferrer" href="editaDespesas.php?id=<?php echo $idPasseio ?>">TOTAL DESPESAS</a> </label>

                <input type="text" class="form-control " name="totalDespesas" id="totalDespesas" placeholder="0" value="<?php echo number_format((float) $valorTotalDespesas, 2, '.', '') ?>" readonly>
              <?php } ?>
            </div>
          </div>

          <div class="form-row">
            <div class="col-6">
              <?php
              if (empty($idPasseio)) { ?>
                <label class="col-form-label" data-toggle="tooltip" data-placement="top" title="QTD DE CLIENTES QUE FIZERAM UM PAGAMENTO" for="qtdCliente"> QTD DE CLIENTES </label>
                <input type="text" class="form-control " name="qtdCliente" id="qtdCliente" placeholder="0" value="<?php echo number_format((float) $qtdCliente, 2, '.', '') ?>" readonly>

              <?php } else {

              ?>
                <label class="col-form-label" data-toggle="tooltip" data-placement="top" title="QTD DE CLIENTES QUE FIZERAM UM PAGAMENTO" for="qtdCliente"> <a class="<?php echo $decoraçãoLink ?> " rel="noopener noreferrer" href="listaPasseio.php?id=<?php echo $idPasseio ?>"> QTD DE CLIENTES</a></label>

                <input type="text" class="form-control " name="qtdCliente" id="qtdCliente" placeholder="0" value="<?php echo number_format((float) $qtdCliente, 2, '.', '') ?>" readonly>
              <?php } ?>
            </div>
          </div>

          <div class="form-row">
            <div class="col">
              <label class="col-form-label" data-toggle="tooltip" data-placement="top" title="VALOR PENDENTE + RECEBIMENTOS - TOTAL DESPESAS" for="lucroEstimado">LUCROS ESTIMADOS</label>
              <input type="text" class="form-control " name="lucroEstimado" id="lucroEstimado" placeholder="0" value="<?php echo number_format((float) $lucroEstimado, 2, '.', '') ?>" readonly>
            </div>
            <div class="col">
              <label class="col-form-label" data-toggle="tooltip" data-placement="top" title="VALOR DO PASSEIO INSERIDO NO ATO DO CADASTRO DO PASSEIO" for="valorPasseio">VALOR DO PASSEIO</label>
              <input type="text" class="form-control " name="valorPasseio" id="valorPasseio" placeholder="0" value="<?php echo number_format((float) $valorPasseio, 2, '.', '')  ?>" readonly>
            </div>
          </div>

        </div>
      </div>
    </div>
    <?php include_once("./includes/mdbJs.php"); ?>
    <script src="assets/js/material-kit.js?v=2.0.7" type="text/javascript"></script>
    
</body>

</html>