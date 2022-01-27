<?php
//VERIFICACAO DE SESSOES E INCLUDES NECESSARIOS E CONEXAO AO BANCO DE DADOS
include_once("./includes/header.php");

/* -----------------------------------------------------------------------------------------------------  */
$idPasseioGet   = filter_input(INPUT_GET, 'id',            FILTER_SANITIZE_NUMBER_INT);
$ordemPesquisa  = filter_input(INPUT_GET, 'ordemPesquisa', FILTER_SANITIZE_STRING);
if (empty($ordemPesquisa)) {
  $ordemPesquisa = 'nomeCliente';
}
/* -----------------------------------------------------------------------------------------------------  */

$queryBuscaPeloIdPasseio = "SELECT  p.nomePasseio, p.idPasseio, p.lotacao, c.nomeCliente, c.rgCliente, c.dataCpfConsultado, c.telefoneCliente, c.orgaoEmissor, c.idadeCliente, c.referencia, c.cpfCliente, c.dataNascimento,
                              pp.statusPagamento, pp.idPagamento, pp.idCliente, pp.valorPago, pp.valorVendido, pp.clienteParceiro, pp.dataPagamento, pp.clienteDesistente, pp.valorPendente 
                              FROM passeio p, pagamento_passeio pp, cliente c WHERE pp.idPasseio='$idPasseioGet' AND pp.idPasseio=p.idPasseio AND pp.idCliente=c.idCliente ORDER BY $ordemPesquisa ";
$resultadoBuscaPasseio = mysqli_query($conexao, $queryBuscaPeloIdPasseio);
/* -----------------------------------------------------------------------------------------------------  */

$pegarNomePasseio = "SELECT nomePasseio, lotacao, dataPasseio FROM passeio WHERE idPasseio='$idPasseioGet'";
$resultadopegarNomePasseio = mysqli_query($conexao, $pegarNomePasseio);
$rowpegarNomePasseio = mysqli_fetch_assoc($resultadopegarNomePasseio);
$nomePasseioTitulo = $rowpegarNomePasseio['nomePasseio'];
$dataPasseio = date_create($rowpegarNomePasseio['dataPasseio']);
$lotacao = $rowpegarNomePasseio['lotacao'];
/* -----------------------------------------------------------------------------------------------------  */
?>



<!DOCTYPE html>
<html lang="PT-BR">

<head>
  <?php include_once("./includes/mdbcss.php"); ?>


  <title>LISTA CLIENTES </title>
</head>

<body onload="tituloDetalhesListagem()">
  <!-- INCLUSÃO DA NAVBAR -->
  <?php include_once("./includes/htmlElements/navbar.php"); ?>

  <div class="row py-2">
    <div class="col-md-10 mx-auto">
      <div class="card rounded shadow border-0">
        <p class="h2 text-center">LISTA DE CLIENTES</p>

        <div class="card-body p-5 bg-white rounded">
          <!-- INCLUSÃO DE MENSAGENS DE ERRO E SUCESSO -->
          <?php include_once("./includes/servicos/servicoSessionMsg.php"); ?>
          <div>
            <?php
            mensagensInfoNoSession(" PASSEIO: " . $nomePasseioTitulo . " " . date_format($dataPasseio, "d/m/Y") . " <br/>
          
          <span class='h5'> LOTAÇÃO: $lotacao </span> 
         | <span class='h5' id='confirmados' >  CONFIRMADOS </span> 
         | <span class='h5' id='interessados'>  INTERESSADOS </span>
         | <span class='h5' id='criancas'>  CRIANÇAS </span>
         | <span class='h5' id='parceiros'>  PARCEIROS </span>
         | <span class='h5' id='desistentes'>  DESISTENTES </span>
         | <span class='h5' id='vagasDisponiveis'>  VAGAS DISPONÍVEIS </span>  ");
            ?>
            <div class="table-responsive">
              <div class="table-reponsive">
                <?php esconderTabela(10); ?>
              </div>
              <table class="table table-striped table-bordered" id="tabelaListaPasseio">
                <thead>
                  <tr>
                    <th> NOME </th>
                    <th> RG </th>
                    <th> DATA DE NASCIMENTO </th>
                    <th> ORGÃO EMISSOR RG </th>
                    <th> REFERÊNCIA </th>
                    <th> STATUS </th>
                    <th> NUMERO CPF </th>
                    <th> V. PAGO </th>
                    <th> V. VENDIDO </th>
                    <th> V. PENDENTE </th>
                    <th> AÇÃO </th>
                  </tr>
                </thead>

                <tbody>
                  <?php
                  $controleListaPasseio = 0;
                  $interessados = 0;
                  $quantidadeClienteParceiro = 0;
                  $confirmados = 0;
                  $criancas = 0;
                  $desistentes = 0;
                  while ($rowBuscaPasseio = mysqli_fetch_assoc($resultadoBuscaPasseio)) {

                    $idPagamento = $rowBuscaPasseio['idPagamento'];
                    $dataCpfConsultado = (empty($rowBuscaPasseio['dataCpfConsultado']) or $rowBuscaPasseio['dataCpfConsultado'] == "0000-00-00") ? "" : date_create($rowBuscaPasseio['dataCpfConsultado']);
                    $dataCpfConsultadoFormatado = (empty($dataCpfConsultado) or $dataCpfConsultado == "0000-00-00") ? "" : date_format($dataCpfConsultado, "d/m/Y");

                    $idCliente = $rowBuscaPasseio['idCliente'];
                    $idPasseio = $rowBuscaPasseio['idPasseio'];
                    $idadeCliente = $rowBuscaPasseio['idadeCliente'];
                    $clienteParceiro = $rowBuscaPasseio['clienteParceiro'];
                    $statusCliente = $rowBuscaPasseio['statusPagamento'];
                    $clienteDesistente = $rowBuscaPasseio['clienteDesistente'];
                    $dataNascimento = date_create($rowBuscaPasseio['dataNascimento']);


                    if ($clienteDesistente) {
                      $controleListaPasseio = 1;
                      $desistentes += 1;
                      $statusPagamento = "DESISTENTE";
                    } else {

                      switch ($statusCliente) {
                        case CLIENTE_INTERESSADO:
                          $controleListaPasseio = 1;
                          $interessados = $interessados + 1;
                          $statusPagamento = "INTERESSADO";
                          break;

                        case PAGAMENTO_QUITADO:
                          $controleListaPasseio = 1;
                          $confirmados = $confirmados + 1;
                          $statusPagamento = "QUITADO";
                          break;

                        case CLIENTE_CONFIRMADO:
                          $controleListaPasseio = 1;
                          $confirmados = $confirmados + 1;
                          $statusPagamento = "PARCIAL";
                          break;

                        case CLIENTE_PARCEIRO:
                          $controleListaPasseio = 1;
                          $quantidadeClienteParceiro = $quantidadeClienteParceiro + 1;
                          $statusPagamento = "PARCEIRO";
                          break;

                        case CLIENTE_CRIANCA:
                          $controleListaPasseio = 1;
                          $criancas = $criancas + 1;
                          $statusPagamento = "CRIANÇA";
                          break;

                        default:
                          $statusPagamento = "DESCONHECIDO";
                          break;
                      }
                      $nomePasseio = $rowBuscaPasseio['nomePasseio'];
                    }
                  ?>
                    <tr class="text-bold odd">
                      <td><?php $nomeCliente = $rowBuscaPasseio['nomeCliente'];
                          echo $nomeCliente  . "<BR/>"; ?></td>
                      <td><?php echo $rowBuscaPasseio['rgCliente'] . "<BR/>"; ?></td>
                      <td><?php echo date_format($dataNascimento, "d/m/Y");
                          ?></td>
                      <td><?php echo $rowBuscaPasseio['orgaoEmissor'];
                          ?></td>
                      <td><?php echo $rowBuscaPasseio['referencia'] . "<BR/>"; ?></td>

                      <td><?php echo $statusPagamento . "<BR/>"; ?></td>
                      <td> <?php echo $rowBuscaPasseio['cpfCliente'] . "<BR/>"; ?></td>
                      <?php
                      $valorPago = (empty($rowBuscaPasseio['valorPago']) ? $valorPago = 0.00 : $valorPago =  $rowBuscaPasseio['valorPago']);
                      if ($_SESSION['nivelAcesso'] == 1 or $_SESSION['nivelAcesso'] == 0) {
                        if ($rowBuscaPasseio['valorPago'] == 0) {
                          $opcao = "DELETAR";
                          $corTexto = "btn btn-danger";
                        } else {
                          $corTexto = "btn btn-warning";
                          $opcao = "TRANSFERIR";
                        }
                      } else {
                        $opcao = "";
                      }
                      ?>
                      <td><?php echo "R$: " . number_format($valorPago, 2, '.', '') . "<BR/>" ?></td>
                      <td><?php echo "R$: " . $rowBuscaPasseio['valorVendido'] . "<BR/>"; ?></td>
                      <td><?php
                          if ($rowBuscaPasseio['valorPendente'] == 0) {
                            echo "R$: " . $rowBuscaPasseio['valorPendente'];
                          } else {

                            echo "R$: " . $rowBuscaPasseio['valorPendente'] * -1;
                          }
                          ?>
                      </td>
                      <td class="td-actions">
                        <a data-toggle="tooltip" data-placement="top" title="EDITAR PAGAMENTO" red='noopener noreferrer' class="btn btn-info btn-just-icon btn-sm" href="editarPagamento.php?id=<?php echo $idPagamento; ?>">
                          <i class="material-icons"> edit </i>
                        </a>

                        <a data-toggle="tooltip" data-placement="top" title="TRANSFERIR OU DELETAR PAGAMENTO" rel='noopener noreferrer' class="btn <?php echo $corTexto; ?> btn-just-icon btn-sm" href="SCRIPTS/apagarPagamento.php?idPagamento=<?php echo $idPagamento; ?>&idPasseio=<?php echo $idPasseio; ?>&opcao=<?php echo $opcao ?>&confirmar=0&nomeCliente=<?php echo $nomeCliente; ?>&dataPasseio=<?php echo $rowpegarNomePasseio['dataPasseio'] ?>&nomePasseio=<?php echo $nomePasseioTitulo; ?>&valorPago=<?php echo number_format($valorPago, 2, '.', ''); ?>">
                          <i class="material-icons"><?php $iconAcao = ($opcao == "DELETAR") ? 'delete_forever' : 'swap_horiz';
                                                    echo $iconAcao; ?> </i>
                        </a>
                        <a data-toggle="tooltip" data-placement="top" title="ENVIAR UMA MENSAGEM NO WHATS APP" class='btn btn-success btn-just-icon btn-sm' href="https://wa.me/55<?php echo $rowBuscaPasseio['telefoneCliente']; ?> ">
                          <i class="material-icons"> perm_phone_msg </i>
                        </a>
                      </td>

                    </tr>
                  <?php
                  }
                  ?>
                  <input class="text-invisble" type="text" name="" id="idPasseio" onclick="Export()" disabled="disabled" value="<?php echo $idPasseioGet;  ?>">
                  <input class="text-invisble" type="text" name="" id="clientesConfirmados" disabled="disabled" value="<?php echo $confirmados;  ?>">
                  <input class="text-invisble" type="text" name="" id="clientesCriancas" disabled="disabled" value="<?php echo $criancas;  ?>">
                  <input class="text-invisble" type="text" name="" id="clientesInteressados" disabled="disabled" value="<?php echo $interessados;  ?>">
                  <input class="text-invisble" type="text" name="" id="clientesParceiros" disabled="disabled" value="<?php echo $quantidadeClienteParceiro;  ?>">
                  <input class="text-invisble" type="text" name="" id="clientesDesistentes" disabled="disabled" value="<?php echo $desistentes;  ?>">
                  <input class="text-invisble" type="text" name="" id="totalVagasDisponiveis" disabled="disabled" value="<?php $vagasDisponiveis = $lotacao - $confirmados - $quantidadeClienteParceiro;
                                                                                                                          echo $vagasDisponiveis;  ?>">
                </tbody>
              </table>
            </div>
            <?php
            if ($controleListaPasseio == 0) {
              mensagensWarningNoSession("Nenhum PAGAMENTO foi cadastrado até o momento");
            }

            ?>

          </div>
        </div>
      </div>
    </div>
  </div>
  <?php include_once("./includes/mdbJs.php"); ?>
  <script src="config/novoScript.js"></script>
  <script src="includes/plugins/DataTables/configFiles/dataTablesListaPasseio.js"> </script>
  <script>
    function apagarPagamento() {
      var abrirJanela;
      var conf = confirm("APAGAR PAGAMENTO??");
      if (conf == true) {}
    }
  </script>
</body>

</html>