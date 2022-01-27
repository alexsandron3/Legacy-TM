<?php
//VERIFICACAO DE SESSOES E INCLUDES NECESSARIOS E CONEXAO AO BANCO DE DADOS
include_once("./includes/header.php");

/* -----------------------------------------------------------------------------------------------------  */
$idPasseioGet   = filter_input(INPUT_GET, 'id',            FILTER_SANITIZE_NUMBER_INT);
$ordemPesquisa  = filter_input(INPUT_GET, 'ordemPesquisa', FILTER_SANITIZE_STRING);
if (empty($ordemPesquisa)) {
  $ordemPesquisa = 'referencia';
}
/* -----------------------------------------------------------------------------------------------------  */

$queryBuscaPeloIdPasseio = "SELECT  p.nomePasseio, p.idPasseio, c.nomeCliente, c.idCliente, c.referencia, pp.valorPendente , pp.anotacoes, pp.statusPagamento, pp.idPagamento
                              FROM passeio p, pagamento_passeio pp, cliente c WHERE pp.idPasseio='$idPasseioGet' AND pp.idPasseio=p.idPasseio AND pp.idCliente=c.idCliente AND pp.statusPagamento NOT IN(1) AND pp.clienteDesistente NOT IN(1) ORDER BY $ordemPesquisa";
$resultadoBuscaPasseio = mysqli_query($conexao, $queryBuscaPeloIdPasseio);
$queryValorPendenteTotal = "SELECT SUM(valorPendente) AS valorPendenteTotal FROM pagamento_passeio WHERE idPasseio=$idPasseioGet AND statusPagamento NOT IN (1) AND clienteDesistente NOT IN(1)";
$resultadoTotalPendente = mysqli_query($conexao, $queryValorPendenteTotal);
$rowTotalPendente = mysqli_fetch_assoc($resultadoTotalPendente);
/* -----------------------------------------------------------------------------------------------------  */

$pegarNomePasseio = "SELECT nomePasseio, lotacao, dataPasseio FROM passeio WHERE idPasseio='$idPasseioGet'";
$resultadopegarNomePasseio = mysqli_query($conexao, $pegarNomePasseio);
$rowpegarNomePasseio = mysqli_fetch_assoc($resultadopegarNomePasseio);
$nomePasseioTitulo = $rowpegarNomePasseio['nomePasseio'];
$lotacao = $rowpegarNomePasseio['lotacao'];
$dataPasseio = date_create($rowpegarNomePasseio['dataPasseio']);

/* -----------------------------------------------------------------------------------------------------  */
?>



<!DOCTYPE html>
<html lang="PT-BR">

<head>
<?php include_once("./includes/mdbcss.php"); ?>


  <title>PAGAMENTOS PENDENTES </title>
</head>

<body>
  <!-- INCLUSÃO DA NAVBAR -->
  <?php include_once("./includes/htmlElements/navbar.php"); ?>

  <div class="row py-2">
    <div class="col-md-10 mx-auto">
      <div class="card rounded shadow border-0">
        <div class="card-body p-5 bg-white rounded ">
          <p class="h2 text-center mb-5">PAGAMENTOS PENDENTES </p>
          <!-- INCLUSÃO DE MENSAGENS DE ERRO E SUCESSO -->
          <?php include_once("./includes/servicos/servicoSessionMsg.php"); ?>
          <div class="table ml-1"> <?php
                                    mensagensInfoNoSession($nomePasseioTitulo . " " . date_format($dataPasseio, "d/m/Y"));
                                    ?>
            <script>
              var nomePasseio = '<?php echo $nomePasseioTitulo ?>';
              var dataPasseio = '<?php echo date_format($dataPasseio, "d/m/Y") ?>';
              document.title = "PAGAMENTOS PENDENTES" + nomePasseio + " " + dataPasseio;
            </script>
            <table style="width:100%" class="table table-striped table-bordered" id="tabelaPagamentosPendentes">
              <thead>
                <tr>
                  <th> NOME </th>
                  <th> REFERENCIA </th>
                  <th> PAGTO PENDENTE</th>
                  <th> ANOTAÇÕES </th>
                </tr>
              </thead>

              <tbody>
                <?php
                $controleListaPasseio = 0;
                while ($rowBuscaPasseio = mysqli_fetch_assoc($resultadoBuscaPasseio)) {
                  $nomePasseio = $rowBuscaPasseio['nomePasseio'];
                  if ($rowBuscaPasseio['statusPagamento'] == 4 and $rowBuscaPasseio['valorPendente'] == 0) {
                  } else {
                ?>
                    <tr>
                      <td><a target="blank" href="editarCliente.php?id=<?php echo $rowBuscaPasseio['idCliente'] ?>"> <?php echo $rowBuscaPasseio['nomeCliente'] . "<BR/>"; ?> </a></td>
                      <td><?php echo $rowBuscaPasseio['referencia'] . "<BR/>"; ?></td>
                      <td> <a href="editarPagamento.php?id=<?php echo $rowBuscaPasseio['idPagamento']?>" target="blank"> <?php
                                                              $operador = ($rowBuscaPasseio['valorPendente'] < 0) ? -1 : 1;
                                                              echo "R$" . number_format($rowBuscaPasseio['valorPendente'] * $operador, 2, '.', ''); ?> </a></td>
                      <td><?php echo $rowBuscaPasseio['anotacoes'] . "<BR/>"; ?></td>
                    </tr>

                <?php


                  }
                }
                $controleListaPasseio = mysqli_num_rows($resultadoBuscaPasseio);
                ?>
              </tbody>
              <tfoot>
                <tr>
                  <th colspan="2" style="text-align:right">Pendente:</th>
                  <th></th>
                </tr>
              </tfoot>
            </table>
          </div>
        </div>
      </div>
    </div>
  </div>
  <?php include_once("./includes/mdbJs.php"); ?>
  <script src="includes/plugins/DataTables/configFiles/dataTablesPagamentosPendentes.js"> </script>
  <script src="config/novoScript.js"></script>
</body>

</html>