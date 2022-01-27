<?php
//VERIFICACAO DE SESSOES E INCLUDES NECESSARIOS E CONEXAO AO BANCO DE DADOS
include_once("./includes/header.php");

/* -----------------------------------------------------------------------------------------------------  */
$idPasseioGet   = filter_input(INPUT_GET, 'id',            FILTER_SANITIZE_NUMBER_INT);

/* -----------------------------------------------------------------------------------------------------  */

$queryBuscaPeloIdPasseio = "SELECT  p.nomePasseio, p.idPasseio, c.nomeCliente, c.rgCliente, c.orgaoEmissor, c.idadeCliente, c.idCliente, c.dataNascimento, pp.idPagamento, pp.valorPago  
                              FROM passeio p, pagamento_passeio pp, cliente c WHERE pp.idPasseio='$idPasseioGet' AND pp.idPasseio=p.idPasseio AND pp.idCliente=c.idCliente AND pp.statusPagamento NOT IN(0) ";
$resultadoBuscaPasseio = mysqli_query($conexao, $queryBuscaPeloIdPasseio);
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

  <title>LISTA DE PASSAGEIROS </title>

</head>

<body>
  <!-- INCLUSÃO DA NAVBAR -->
  <?php include_once("./includes/htmlElements/navbar.php"); ?>
  <div class="row py-2">
    <div class="col-md-10 mx-auto">
      <div class="card rounded shadow border-0">
        <div class="card-body p-5 bg-white rounded ">
          <p class="h2 text-center mb-5">LISTA DE PASSAGEIROS</p>
          <!-- INCLUSÃO DE MENSAGENS DE ERRO E SUCESSO -->
          <?php include_once("./includes/servicos/servicoSessionMsg.php"); ?>
          <div class="table ml-1">

            <?php
            mensagensInfoNoSession("" . $nomePasseioTitulo . " " . date_format($dataPasseio, "d/m/Y")); ?>
            <script>
              var nomePasseio = '<?php echo $nomePasseioTitulo ?>';
              var dataPasseio = '<?php echo date_format($dataPasseio, "d/m/Y") ?>';
              document.title = "LISTA DE PASSAGEIROS " + nomePasseio + " " + dataPasseio;
            </script>

            <table style="width:100%" class="table table-striped table-bordered" id="tabelaListaClientes">
              <thead>
                <tr>
                  <th class="text-center">Nº ORDEM</th>
                  <th> NOME </th>
                  <th> IDADE </th>
                  <th> Nº IDENTIDADE </th>
                  <th> ORGÃO EMISSOR</th>
                </tr>
              </thead>

              <tbody>

                <?php
                $contador = 0;
                $controleListaPasseio = 0;
                while ($rowBuscaPasseio = mysqli_fetch_assoc($resultadoBuscaPasseio)) {
                  $idCliente     = $rowBuscaPasseio['idCliente'];
                  $data          = $rowBuscaPasseio['dataNascimento'];
                  $idPagamento   = $rowBuscaPasseio['idPagamento'];
                  $idPasseioAcao  = $rowBuscaPasseio['idPasseio'];
                  if (empty($rowBuscaPasseio['dataCpfConsultado'])) {
                    $dataCpfConsultado = "0000-00-00";
                  } else {
                    $dataCpfConsultado =  date_create($rowBuscaPasseio['dataCpfConsultado']);
                  }

                  $idadeCliente = $rowBuscaPasseio['idadeCliente'];
                  $nomePasseio = $rowBuscaPasseio['nomePasseio'];


                ?>
                  <tr>
                    <td class="text-center"><?php echo ++$contador; ?></td>
                    <td><?php echo $rowBuscaPasseio['nomeCliente'] . "<BR/>"; ?></td>
                    <td><?php $idade = calcularIdade($idCliente, $conn, $data);
                        echo $idade; ?></td>
                    <td><?php echo $rowBuscaPasseio['rgCliente'] . "<BR/>"; ?> </td>
                    <td><?php echo $rowBuscaPasseio['orgaoEmissor']; ?></td>
                    <?php
                    if ($rowBuscaPasseio['valorPago'] == 0) {
                      $opcao = "DELETAR";
                    } else {
                      $opcao = "TRANSFERIR";
                    }
                    ?>
                  </tr>

                <?php


                }
                $controleListaPasseio = mysqli_num_rows($resultadoBuscaPasseio);
                ?>

              </tbody>

            </table>
            <?php
            if ($controleListaPasseio > 0) {
              echo "<div class='text-center'>";
              echo "<p class='h5 text-center alert-warning text-dark'>TOTAL DE " . $controleListaPasseio . " CLIENTES </p>";

              echo "</div>";
            } else {

              echo "<div class='text-center'>";
              echo "<p class='h5 text-center alert-warning text-dark'>Nenhum PAGAMENTO foi cadastrado até o momento</p>";
              echo "</div>";
            }


            ?>
          </div>
        </div>

      </div>
    </div>
  </div>
  </div>
  <?php include_once("./includes/mdbJs.php"); ?>
  <script src="includes/plugins/DataTables/configFiles/dataTablesListaClientes.js"> </script>
  <script src="config/novoScript.js"></script>
</body>

</html>