<?php
//VERIFICACAO DE SESSOES E INCLUDES NECESSARIOS E CONEXAO AO BANCO DE DADOS
include_once("./includes/header.php");
// 
?>

<!DOCTYPE html>
<html lang="en">

<head>
<?php include_once("./includes/mdbcss.php"); ?>
  <title>RELATÓRIO DE VENDAS</title>
</head>

<body>
  <!-- INCLUSÃO DA NAVBAR -->
  <?php include_once("./includes/htmlElements/navbar.php"); ?>
  <div class="row py-3">
    <div class="col-md-10 mx-auto">
      <div class="card rounded shadow border-0">
        <!-- INCLUSÃO DE MENSAGENS DE ERRO E SUCESsSO -->
        <?php include_once("./includes/servicos/servicoSessionMsg.php"); ?>
        <div class="card-body p-5 bg-white rounded">
          <p class="h2 text-center">RELATÓRIO DE VENDAS</p>
          <form action='' method='GET' autocomplete='OFF'>
            <div class="form-row">

              <div class="col">
                <input data-toggle="tooltip" data-placement="top" title="SELECIONE O INÍCIO DO PERÍODO" type='date' class='form-control' name='inicioDataPasseio' id='inicioDataPasseio' value="">
              </div>

              <div class="col">
                <input data-toggle="tooltip" data-placement="top" title="SELECIONE O FIM DO PERÍODO" type='date' class='form-control' name='fimDataPasseio' id='fimDataPasseio' value="">
              </div>

            </div>
            <div class="form-row">
              <div class="col">
                <input type='submit' class='btn btn-info btn-md' value='CARREGAR INFORMAÇÕES' name='buttonEviaDataPasseio'>
              </div>
            </div>
          </form>
          <div class="table-responsive mt-3">
            <table style="width:100%" class="table table-striped table-bordered" id="relatorioVendasTable">
              <thead>
                <tr>
                  <th scope="col">PASSEIO</th>
                  <th scope="col">DATA</th>
                  <th scope="col">Nº VENDAS</th>
                  <th scope="col">VALOR VENDA</th>
                  <th scope="col">VALOR PAGO</th>
                </tr>
              </thead>
              <tbody>
                <?php
                $buttonEviaDataPasseio    = filter_input(INPUT_GET, 'buttonEviaDataPasseio', FILTER_SANITIZE_STRING);
                $inicioDataPasseio        = filter_input(INPUT_GET, 'inicioDataPasseio', FILTER_SANITIZE_STRING);
                $fimDataPasseio           = filter_input(INPUT_GET, 'fimDataPasseio', FILTER_SANITIZE_STRING);
                if ($buttonEviaDataPasseio) {
                  $queryRelatorioVendas = "SELECT p.nomePasseio, p.dataPasseio, count(pp.idPagamento) AS 'NVendas',SUM(pp.valorVendido) AS 'ValorVenda', SUM(pp.valorPago) AS 'ValorPago' FROM pagamento_passeio pp, passeio p WHERE `createdAt` BETWEEN '$inicioDataPasseio' AND '$fimDataPasseio' AND p.idPasseio = pp.idPasseio GROUP BY pp.idPasseio;";
                  $executaQueryRelatorioVendas = mysqli_query($conexao, $queryRelatorioVendas);

                  while ($rowExecutaQueryRelatorioVendas = mysqli_fetch_assoc($executaQueryRelatorioVendas)) {
                    $nomePasseio = $rowExecutaQueryRelatorioVendas['nomePasseio'];
                    $dataPasseio = verifyDate($rowExecutaQueryRelatorioVendas['dataPasseio']);
                    $NVendas = $rowExecutaQueryRelatorioVendas['NVendas'];
                    $ValorVenda = $rowExecutaQueryRelatorioVendas['ValorVenda'];
                    $ValorPago = $rowExecutaQueryRelatorioVendas['ValorPago'];
                ?>
                    <tr>
                      <td> <?php echo $nomePasseio; ?></td>
                      <td> <?php echo $dataPasseio->dateFormated; ?></td>
                      <td> <?php echo $NVendas; ?></td>
                      <td> <?php echo $ValorVenda; ?></td>
                      <td> <?php echo $ValorPago; ?></td>
                    </tr>
                <?php }
                } ?>
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>
  </div>
  <?php include_once("./includes/mdbJs.php"); ?>

</body>

</html>