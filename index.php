<?php
//VERIFICACAO DE SESSOES E INCLUDES NECESSARIOS E CONEXAO AO BANCO DE DADOS
include_once("./includes/header.php");
?>

<!DOCTYPE html>
<html lang="PT-BR">

<head>
  <?php include_once("./includes/mdbcss.php"); ?>
  
  <title>INÍCIO</title>
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
          <p class="h2 text-center">RELATÓRIO GERENCIAL DE VENDAS</p>
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
              <div class="col ml-3 mt-2">
                <input class="form-check-input " type="checkbox" name="mostrarPasseiosExcluidos" value="1" id="mostrarPasseiosExcluidos">
                <label class="form-check-label " for="mostrarPasseiosExcluidos">
                  EXIBE PASSEIOS ENCERRADOS
                </label>
              </div>
            </div>
            <div class="form-row">
              <div class="col">
                <input type='submit' class='btn btn-info btn-md' value='CARREGAR INFORMAÇÕES' name='buttonEviaDataPasseio'>
              </div>
            </div>
          </form>
          <div class="table-responsive mt-3">
            <table style="width:100%" class="table table-striped table-bordered" id="relatorioDeVendasIndexTable">
              <thead>
                <tr>
                  <th scope="col">PASSEIO</th>
                  <th scope="col">DATA</th>
                  <th scope="col">RESERVADOS</th>
                  <th scope="col">INTERESSADOS</th>
                  <th scope="col">PARCEIROS</th>
                  <th scope="col">CRIANÇAS</th>
                  <th scope="col">META DE VENDA</th>
                  <th scope="col">VAGAS DISPONÍVEIS</th>
                </tr>
              </thead>
              <tbody>

                <?php
                /* -----------------------------------------------------------------------------------------------------  */
                $buttonEviaDataPasseio    = filter_input(INPUT_GET, 'buttonEviaDataPasseio', FILTER_SANITIZE_STRING);
                $inicioDataPasseio        = filter_input(INPUT_GET, 'inicioDataPasseio', FILTER_SANITIZE_STRING);
                $fimDataPasseio           = filter_input(INPUT_GET, 'fimDataPasseio', FILTER_SANITIZE_STRING);
                $mostrarPasseiosExcluidos = filter_input(INPUT_GET, 'mostrarPasseiosExcluidos', FILTER_VALIDATE_BOOLEAN);


                $inicioDataPasseioFormatado = date_create($inicioDataPasseio);
                $fimDataPasseioFormatado = date_create($fimDataPasseio);
                $exibePasseio = (empty($mostrarPasseiosExcluidos) or is_null($mostrarPasseiosExcluidos)) ? false : true;
                $queryExibePasseio = ($exibePasseio == false) ? 'AND statusPasseio NOT IN (0)' : ' ';
                $mensagemExibeExcluidos = ($exibePasseio == true) ? 'EXBINDO TODOS OS PASSEIOS, INCLUSIVE ENCERRADOS ' : ' EXIBINDO SOMENTE PASSEIOS ATIVOS';


                if ($buttonEviaDataPasseio) {
                  if (empty($inicioDataPasseio) or empty($fimDataPasseio)) { ?>
                    <div class='alert alert-warning'>
                      <div class='container text-center'>
                        <div class='alert-icon'>
                          <i class='material-icons'>warning</i>
                        </div>
                        <button type='button' class='close' data-dismiss='alert' aria-label='Close'>
                          <span aria-hidden='true'><i class='material-icons'>clear</i></span>
                        </button>
                        <span class='h4 text-center'>PERÍODO SELECIONADO INVÁLIDO</b></span>

                      </div>
                    <?php
                  } else { ?>
                      <div class='alert alert-success'>
                        <div class='container text-center'>
                          <div class='alert-icon'>
                            <i class='material-icons'>check</i>
                          </div>
                          <button type='button' class='close' data-dismiss='alert' aria-label='Close'>
                            <span aria-hidden='true'><i class='material-icons'>clear</i></span>
                          </button>
                          <?php
                          $linkPasseiosFiltrados = "listaRelatorioPasseios.php?inicioDataPasseio=" . $inicioDataPasseio . "&fimDataPasseio=" . $fimDataPasseio . "&mostrarPasseiosExcluidos=" . $mostrarPasseiosExcluidos;

                          echo "<span class='h4 text-center'> " . "PERÍODO SELECIONADO: " . date_format($inicioDataPasseioFormatado, "d/m/Y") . " => " . date_format($fimDataPasseioFormatado, "d/m/Y")  ?>
                          <a href="#!" onclick="novaJanela('<?php echo $linkPasseiosFiltrados; ?>')" data-toggle='tooltip' data-placement='top' title='LISTA DOS PASSEIOS INCLUÍDOS'><i class='material-icons mb-2'>info_outline</i></a>

                          </a></br>
                          <?php
                          echo $mensagemExibeExcluidos . "
                          </span>";
                          ?>

                        </div>
                      </div>
                    <?php
                  }
                } else { ?>
                    <div class='alert alert-info'>
                      <div class='container text-center'>
                        <div class='alert-icon'>
                          <i class='material-icons'>warning</i>
                        </div>
                        <button type='button' class='close' data-dismiss='alert' aria-label='Close'>
                          <span aria-hidden='true'><i class='material-icons'>clear</i></span>
                        </button>
                        <span class='h4 text-center'>
                          <h4>SELECIONE O PERÍODO</h4></br>
                        </span>

                      </div>
                    <?php
                  }
                  /* -----------------------------------------------------------------------------------------------------  */
                  $listaPasseios = "SELECT idPasseio, dataPasseio FROM passeio WHERE dataPasseio BETWEEN '$inicioDataPasseio' AND '$fimDataPasseio' $queryExibePasseio ORDER BY dataPasseio";
                  $resultadoListaPasseio = mysqli_query($conexao, $listaPasseios);

                  while ($rowResultadoListaPasseio = mysqli_fetch_assoc($resultadoListaPasseio)) {
                    $idPasseio = $rowResultadoListaPasseio['idPasseio'];
                    $pagamentosUltimoDia = "SELECT dataPagamento, statusPagamento FROM pagamento_passeio WHERE dataPagamento >= NOW() - INTERVAL 1 DAY AND idPasseio = $idPasseio ";
                    $resultadoPagamentosUltimoDia = mysqli_query($conexao, $pagamentosUltimoDia);
                    $qtdPagamento = mysqli_num_rows($resultadoPagamentosUltimoDia);
                    $interessadosUltimoDia = 0;
                    $quitadosUltimoDia = 0;
                    $parciaisUltimoDia = 0;
                    $parceirosUltimoDia = 0;
                    $criancasUltimoDia = 0;
                    $confirmadosUltimoDia = 0;
                    while ($rowPagamentosUltimoDia = mysqli_fetch_assoc($resultadoPagamentosUltimoDia)) {
                      switch ($rowPagamentosUltimoDia['statusPagamento']) {
                        case CLIENTE_INTERESSADO:
                          $interessadosUltimoDia += 1;
                          break;
                        case PAGAMENTO_QUITADO:
                          $quitadosUltimoDia += 1;
                          $confirmadosUltimoDia += 1;
                          break;
                        case CLIENTE_CONFIRMADO:
                          $parciaisUltimoDia += 1;
                          $confirmadosUltimoDia += 1;
                          break;
                        case CLIENTE_PARCEIRO:
                          $parceirosUltimoDia += 1;
                          break;
                        case CLIENTE_CRIANCA:
                          $criancasUltimoDia += 1;
                          break;
                      }
                    }



                    $idPasseio = $rowResultadoListaPasseio['idPasseio'];
                    $pagamentosUltimaHora = "SELECT dataPagamento, statusPagamento FROM pagamento_passeio WHERE dataPagamento >= NOW() - INTERVAL 1 HOUR AND idPasseio = $idPasseio";
                    $resultadoPagamentosUltimaHora = mysqli_query($conexao, $pagamentosUltimaHora);
                    $qtdPagamentoHora = mysqli_num_rows($resultadoPagamentosUltimaHora);
                    $interessadosUltimaHora = 0;
                    $quitadosUltimaHora = 0;
                    $parciaisUltimaHora = 0;
                    $parceirosUltimaHora = 0;
                    $criancasUltimaHora = 0;
                    $confirmadosUltimaHora = 0;
                    while ($rowPagamentosUltimaHora = mysqli_fetch_assoc($resultadoPagamentosUltimaHora)) {

                      switch ($rowPagamentosUltimaHora['statusPagamento']) {
                        case CLIENTE_INTERESSADO:
                          $interessadosUltimaHora += 1;
                          break;
                        case PAGAMENTO_QUITADO:
                          $quitadosUltimaHora += 1;
                          $confirmadosUltimaHora += 1;
                          break;
                        case CLIENTE_CONFIRMADO:
                          $parciaisUltimaHora += 1;
                          $confirmadosUltimaHora += 1;
                          break;
                        case CLIENTE_PARCEIRO:
                          $parceirosUltimaHora += 1;
                          break;
                        case CLIENTE_CRIANCA:
                          $criancasUltimaHora += 1;
                          break;
                      }
                    }

                    $recebeLotacaoPasseio    = "SELECT lotacao, nomePasseio, dataPasseio FROM passeio WHERE idPasseio='$idPasseio'";
                    $resultadoLotacaoPasseio = mysqli_query($conexao, $recebeLotacaoPasseio);
                    $rowLotacaoPasseio       = mysqli_fetch_assoc($resultadoLotacaoPasseio);
                    $lotacaoPasseio          = $rowLotacaoPasseio['lotacao'];
                    $nomePasseio          = $rowLotacaoPasseio['nomePasseio'];
                    $dataPasseio          = date_create($rowLotacaoPasseio['dataPasseio']);

                    $getStatusPagamento       = "SELECT statusPagamento AS qtdConfirmados FROM pagamento_passeio WHERE idPasseio=$idPasseio AND statusPagamento NOT IN (0,4)";
                    $resultadoStatusPagamento = mysqli_query($conexao, $getStatusPagamento);
                    $qtdClientesConfirmados   = mysqli_num_rows($resultadoStatusPagamento);

                    $getStatusPagamentoCliente       = "SELECT statusPagamento FROM pagamento_passeio WHERE idPasseio=$idPasseio";
                    $resultadoStatusPagamentoCliente = mysqli_query($conexao, $getStatusPagamentoCliente);
                    $interessado = 0;
                    $quitado = 0;
                    $parcial = 0;
                    $parceiro = 0;
                    $crianca = 0;
                    $confirmados = 0;
                    $vagasRestantes = ($lotacaoPasseio - $qtdClientesConfirmados);
                    $porcentagemProgresso = ($vagasRestantes / $lotacaoPasseio - 1) * 100;


                    while ($rowGetStatusPagamentoCliente = mysqli_fetch_assoc($resultadoStatusPagamentoCliente)) {
                      $statusCliente = $rowGetStatusPagamentoCliente['statusPagamento'];


                      if ($statusCliente == CLIENTE_INTERESSADO) {
                        $interessado += 1;
                      } elseif ($statusCliente == PAGAMENTO_QUITADO) {
                        $quitado += 1;
                        $confirmados += 1;
                      } elseif ($statusCliente == CLIENTE_CONFIRMADO) {
                        $parcial += 1;
                        $confirmados += 1;
                      } elseif ($statusCliente == CLIENTE_PARCEIRO) {
                        $parceiro += 1;
                      } elseif ($statusCliente == CLIENTE_CRIANCA) {
                        $crianca += 1;
                      }
                    }
                    #----------------------------- STATUS -------------------------------------
                    if ($confirmadosUltimoDia > 0) {
                      $statusConfirmados = "text-warning";
                    } else {
                      $statusConfirmados = "";
                    }

                    if ($interessadosUltimoDia > 0) {
                      $statusInteressados = "text-warning";
                    } else {
                      $statusInteressados = "";
                    }

                    if ($parceirosUltimoDia > 0) {
                      $statusParceiros = "text-warning";
                    } else {
                      $statusParceiros = "";
                    }

                    if ($criancasUltimoDia > 0) {
                      $statusCriancas = "text-warning";
                    } else {
                      $statusCriancas = "";
                    }
                    #------------------------------------------------------------------------------

                    ?>
                      <tr>
                        <p class="d-none"><?php echo identificarMes($dataPasseio); ?></p>

                        <td><?php echo $nomePasseio ?></td>
                        <td >
                          <?php echo date_format($dataPasseio, "d/m/Y") ?>
                        </td>
                        <td id="" data-toggle="tooltip" data-placement="top" title="<?php echo "RESERVADOS NA ÚLTIMA HORA: " . $confirmadosUltimaHora ?>" class="text-center more_info "><span class="<?php echo $statusConfirmados ?>"><?php echo "         " . $confirmados ?></span></td>
                        <td data-toggle="tooltip" data-placement="top" title="<?php echo "INTERESSADOS NA ÚLTIMA HORA: " . $interessadosUltimaHora ?>" class="text-center more_info"> <span class="<?php echo $statusInteressados ?>"><?php echo "         " . $interessado ?> </span></td>
                        <td data-toggle="tooltip" data-placement="top" title="<?php echo "PARCEIROS NA ÚLTIMA HORA: " . $parceirosUltimaHora ?>" class="text-center more_info"><span class="<?php echo $statusParceiros  ?>"><?php echo "         " . $parceiro ?></span></td>
                        <td data-toggle="tooltip" data-placement="top" title="<?php echo "CRIANCAS NA ÚLTIMA HORA: " . $criancasUltimaHora ?>" class="text-center more_info"><span class="<?php echo $statusCriancas ?>"><?php echo "         " . $crianca ?></span></td>
                        <td class="text-center"><?php echo $lotacaoPasseio ?></td>
                        <td class="text-center" data-toggle="tooltip" data-placement="top" title="<?php echo number_format($porcentagemProgresso * -1, 2, '.', ''); ?>%">
                          <div class="progress progress-line-danger">
                            <div class="progress-bar progress-bar-success" style="width: <?php echo $porcentagemProgresso * -1; ?>%">
                              <span class="sr-only">35% Complete (success)</span>
                            </div>

                          </div>

                          <?php echo $vagasRestantes ?>
                        </td>

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

    <script>

    </script>
    <?php include_once("./includes/mdbJs.php"); ?>
    <script src="includes/plugins/DataTables/configFiles/dataTablesIndex.js"> </script>

</body>

</html>