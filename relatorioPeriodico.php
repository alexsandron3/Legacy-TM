<?php
//VERIFICACAO DE SESSOES E INCLUDES NECESSARIOS E CONEXAO AO BANCO DE DADOS
include_once("./includes/header.php");
$queryTodosPasseio = "SELECT idPasseio, nomePasseio, dataPasseio, dataLancamento FROM passeio ORDER BY idPasseio";
$executaQueryTodosPasseio = mysqli_query($conexao, $queryTodosPasseio);

?>


<!DOCTYPE html>
<html lang="en">

<head>
<?php include_once("./includes/mdbcss.php"); ?>
  <title>Relatório Periódico de Vendas</title>
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
          <p class="h2 text-center">RELATÓRIO PERIÓDICO DE VENDAS</p>
          <div class="table-responsive">

            <table style="width:100%" class="table table-striped table-bordered" id="tabelaRelatorioPeriodico">
              <thead>
                <tr>
                  <th scope="col">Nome do Passeio</th>
                  <th scope="col">Data do Passeio</th>
                  <th scope="col">Primeira Venda</th>
                  <th scope="col">Última Venda</th>
                  <th scope="col">Data de Lançamento</th>
                  <th scope="col">Qtde Pessoas</th>
                  <th scope="col">Qtd Dias Em Venda</th>
                  <th scope="col">Qtd Dias 1° Venda</th>
                  <th scope="col">Qtd Total Dias de Venda</th>
                </tr>
              </thead>
              <tbody>
                <?php
                while ($rowQueryTodosPasseio = mysqli_fetch_assoc($executaQueryTodosPasseio)) {
                  $idPasseio = $rowQueryTodosPasseio['idPasseio'];
                  $nomePasseio = $rowQueryTodosPasseio['nomePasseio'];


                  $queryRelatorioPeriodico = "SELECT
                (SELECT DISTINCT pp.dataPagamento FROM passeio p, pagamento_passeio pp where p.idPasseio =$idPasseio AND pp.idPasseio= p.idPasseio AND pp.statusPagamento NOT IN (0, 4) ORDER BY pp.dataPagamento ASC LIMIT 1) AS 'primeiro_pagamento',
                (SELECT DISTINCT pp.dataPagamento FROM passeio p, pagamento_passeio pp where p.idPasseio =$idPasseio AND pp.idPasseio= p.idPasseio AND pp.statusPagamento NOT IN (0, 4) ORDER BY pp.dataPagamento DESC LIMIT 1) AS 'ultimo_pagamento',
                (SELECT COUNT(pp.idPagamento) FROM passeio p, pagamento_passeio pp WHERE p.idPasseio =$idPasseio AND pp.idPasseio= p.idPasseio AND pp.statusPagamento NOT IN (0, 4)) AS 'pagantes'";
                  $executaQuery = mysqli_query($conexao, $queryRelatorioPeriodico);
                  $rowQuery = mysqli_fetch_assoc($executaQuery);
                  $primeiraVenda = verifyDate($rowQuery['primeiro_pagamento']);
                  $ultimaVenda = verifyDate($rowQuery['ultimo_pagamento']);

                  $dataPasseio = new DateTime($rowQueryTodosPasseio['dataPasseio']);
                  $dataLancamento = verifyDate($rowQueryTodosPasseio['dataLancamento']);

                  $tempoTotalEmVenda = dateDiff($primeiraVenda, $ultimaVenda);
                  $tempoAtePrimeiraVenda = dateDiff($primeiraVenda, $dataLancamento);
                  $tempoTotalDeVenda = dateDiff($ultimaVenda, $dataLancamento);
                  if (!$dataLancamento->isEmpty) {
                  }
                  $totalPagantes = $rowQuery['pagantes'];
                ?>
                  <tr>
                    <!-- DADOS DO PASSEIO -->
                    <td> <?php echo $nomePasseio ?></td>
                    <td> <?php echo $dataPasseio->format('d/m/Y'); ?></td>
                    <td> <?php echo $primeiraVenda->dateFormated; ?></td>
                    <td> <?php echo $ultimaVenda->dateFormated; ?></td>
                    <td> <?php echo $dataLancamento->dateFormated; ?> </td>
                    <td> <?php echo $totalPagantes;?></td>
                    <!-- CÁLCULOS -->
                    <td> <?php echo $tempoTotalEmVenda; ?></td>
                    <td> <?php echo $tempoAtePrimeiraVenda; ?></td>
                    <td> <?php echo $tempoTotalDeVenda; ?></td>

                  </tr>
                <?php
                }
                ?>
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>
  </div>

  <?php include_once("./includes/mdbJs.php"); ?>
  <script src="includes/plugins/DataTables/configFiles/dataTablesRelPeriodVendas.js"> </script>

</body>

</html>