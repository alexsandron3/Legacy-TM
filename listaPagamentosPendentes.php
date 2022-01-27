<?php
//VERIFICACAO DE SESSOES E INCLUDES NECESSARIOS E CONEXAO AO BANCO DE DADOS
include_once("./includes/header.php");
if($_SESSION['nivelAcesso'] !== ADMINISTRADOR) {
  header("location: index.php");

}
$ordemPesquisa = filter_input(INPUT_GET, 'ordemPesquisa', FILTER_SANITIZE_STRING);
$ordemPesquisa = (empty($ordemPesquisa)) ? "nomeCliente" : $ordemPesquisa;

?>

<!DOCTYPE html>
<html lang="PT-BR">

<head>
<?php include_once("./includes/mdbcss.php"); ?>

  <title>LISTA DE PAGAMENTOS PENDENTES</title>
  <style>
    .dropdown-submenu {
      position: relative;
    }

    .dropdown-submenu>.dropdown-menu {
      top: 0;
      left: 100%;
      margin-top: -6px;
      margin-left: -1px;
      -webkit-border-radius: 0 6px 6px 6px;
      -moz-border-radius: 0 6px 6px;
      border-radius: 0 6px 6px 6px;
    }

    .dropdown-submenu:hover>.dropdown-menu {
      display: block;
    }

    .dropdown-submenu>a:after {
      display: block;
      content: " ";
      float: right;
      width: 0;
      height: 0;
      border-color: transparent;
      border-style: solid;
      border-width: 5px 0 5px 5px;
      border-left-color: #ccc;
      margin-top: 5px;
      margin-right: -10px;
    }

    .dropdown-submenu:hover>a:after {
      border-left-color: #fff;
    }

    .dropdown-submenu.pull-left {
      float: none;
    }

    .dropdown-submenu.pull-left>.dropdown-menu {
      left: -100%;
      margin-left: 10px;
      -webkit-border-radius: 6px 0 6px 6px;
      -moz-border-radius: 6px 0 6px 6px;
      border-radius: 6px 0 6px 6px;
    }
  </style>
</head>

<body>
  <!-- INCLUSÃO DA NAVBAR -->
  <?php include_once("./includes/htmlElements/navbar.php"); ?>



  <?php
  $contador = 0;
  $query = " SELECT c.nomeCliente, c.idCliente, c.referencia, pp.anotacoes , pp.idPagamento, pp.valorPendente, pp.previsaoPagamento, pp.statusPagamento, p.idPasseio, p.nomePasseio, p.dataPasseio 
           FROM  pagamento_passeio pp, cliente c, passeio p 
           WHERE statusPagamento NOT IN (1) AND valorPendente < 0  AND c.idCliente = pp.idCliente AND p.idPasseio= pp.idPasseio ORDER BY $ordemPesquisa";
  $executaQuery = mysqli_query($conexao, $query);
  $quantidadePagamentoPendente = mysqli_num_rows($executaQuery);
  $queryValorTotalPendente = "SELECT SUM(valorPendente) AS valorTotalPendente 
                                    FROM pagamento_passeio pp, cliente c, passeio p 
                                    WHERE statusPagamento NOT IN (1) AND valorPendente < 0  AND c.idCliente = pp.idCliente AND p.idPasseio= pp.idPasseio ";
  $executaQueryValorTotalPendente = mysqli_query($conexao, $queryValorTotalPendente);
  $rowValorTotalPendente = mysqli_fetch_assoc($executaQueryValorTotalPendente);
  ?>
  <div class="row py-2">
    <div class="col-md-10 mx-auto">
      <div class="card rounded shadow border-0">
        <p class="h2 text-center">PAGAMENTOS PENDENTES</p>

        <div class="card-body p-5 bg-white rounded">
          <!-- INCLUSÃO DE MENSAGENS DE ERRO E SUCESSO -->
          <?php include_once("./includes/servicos/servicoSessionMsg.php"); ?>
          <div class="table ml-1">
            <?php
            mensagensInfoNoSession("QUANTIDADE DE PAGAMENTOS PENDENTES:  " . $quantidadePagamentoPendente);
            ?>

            <div class="table-reponsive">
              <?php esconderTabela(10); ?>
            </div>
            <div class="table-responsive">
              <table style="width:100%" class="table table-striped table-bordered" id="tabelaTodosPagamentosPendentes">
                <thead>
                  <tr>
                    <th> Nº DE ORDEM </th>
                    <th> NOME </th>
                    <th> REFERÊNCIA </th>
                    <th> Nº PEDIDO </th>
                    <th> PASSEIO </th>
                    <th> PENDENTE </th>
                    <th> PREVISÃO PAGAMENTO </th>
                    <th> ANOTAÇÕES </th>
                    <th>STATUS</th>
                    <th class="text-right"> AÇÕES </th>
                  </tr>
                </thead>

                <tbody>
                  <?php


                  while ($rowPagamentosPendentes = mysqli_fetch_assoc($executaQuery)) {



                  ?>
                    <tr class="text-bold">

                      <td class="text-center"><?php echo ++$contador; ?></td>
                      <td scope="row"> <?php echo  $rowPagamentosPendentes['nomeCliente']; ?></td>
                      <td scope="row"> <?php echo  $rowPagamentosPendentes['referencia']; ?></td>
                      <td><?php echo $rowPagamentosPendentes['idPagamento']; ?></td>

                      <td><?php
                          $dataPasseio = date_create($rowPagamentosPendentes['dataPasseio']);
                          echo $rowPagamentosPendentes['nomePasseio'] . " | " . date_format($dataPasseio, "d/m/Y");
                          ?>
                      </td>
                      <td><?php echo "R$" . number_format($rowPagamentosPendentes['valorPendente'] * -1.00, 2, '.', ''); ?></td>

                      <td> <?php
                            if ($rowPagamentosPendentes['previsaoPagamento'] != "0000-00-00") {
                              $dataPagamento = date_create($rowPagamentosPendentes['previsaoPagamento']);

                              echo date_format($dataPagamento, 'd/m/Y');
                            }
                            ?>

                      </td>
                      <td><?php echo $rowPagamentosPendentes['anotacoes'] ?></td>
                      <td><?php
                          switch ($rowPagamentosPendentes['statusPagamento']) {
                            case CLIENTE_INTERESSADO:

                              $statusPagamento = "INTERESSADO";
                              break;

                            case PAGAMENTO_QUITADO:
                              $statusPagamento = "QUITADO";
                              break;

                            case CLIENTE_CONFIRMADO:
                              $statusPagamento = "PARCIAL";
                              break;

                            case CLIENTE_PARCEIRO:
                              $statusPagamento = "PARCEIRO";
                              break;

                            case CLIENTE_CRIANCA:
                              $statusPagamento = "CRIANÇA";
                              break;

                            default:
                              $statusPagamento = "DESCONHECIDO";
                              break;
                          }
                          echo $statusPagamento;
                          ?></td>
                      <td class="td-actions text-right">
                        <a data-toggle="tooltip" data-placement="top" title="EDITAR CLIENTE" href="editarCliente.php?id=<?php echo $rowPagamentosPendentes['idCliente']; ?>" class="btn btn-warning btn-just-icon btn-sm">
                          <i class="material-icons">edit</i>
                        </a>
                        <a data-toggle="tooltip" data-placement="top" title="EDITAR PAGAMENTO" href="editarPagamento.php?id=<?php echo $rowPagamentosPendentes['idPagamento']; ?>" class="btn btn-warning btn-just-icon btn-sm">
                          <i class="material-icons">payment</i>
                        </a>
                        <a data-toggle="tooltip" data-placement="top" title="LISTA DE PASSAGEIROS" href="listaPasseio.php?id=<?php echo $rowPagamentosPendentes['idPasseio']; ?>" class="btn btn-info btn-just-icon btn-sm">
                          <i class="material-icons">groups</i>
                        </a>
                      </td>
                    </tr>
                  <?php
                  }
                  ?>
                <tfoot>
                  <tr>
                    <th colspan="5" style="text-align:right">Total:</th>
                    <th></th>
                  </tr>
                </tfoot>
                </tbody>

              </table>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  <?php include_once("./includes/mdbJs.php"); ?>

  <script src="includes/plugins/DataTables/configFiles/dataTablesTodosPagamentosPendentes.js"> </script>

</body>

</html>