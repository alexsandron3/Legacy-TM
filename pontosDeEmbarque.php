<?php
//VERIFICACAO DE SESSOES E INCLUDES NECESSARIOS E CONEXAO AO BANCO DE DADOS
include_once("./includes/header.php");

/* -----------------------------------------------------------------------------------------------------  */
$idPasseioGet = filter_input(INPUT_GET, 'id', FILTER_SANITIZE_NUMBER_INT);
/* -----------------------------------------------------------------------------------------------------  */

$queryBuscaPeloIdPasseio = "SELECT  p.nomePasseio, p.idPasseio, c.nomeCliente, c.idCliente, c.poltrona, pp.localEmbarque, pp.anotacoes, c.referencia, pp.transporte, pp.idPagamento
                              FROM passeio p, pagamento_passeio pp, cliente c WHERE pp.idPasseio='$idPasseioGet' AND pp.idPasseio=p.idPasseio AND pp.idCliente=c.idCliente AND pp.statusPagamento NOT IN(0) AND pp.clienteDesistente NOT IN(1) ORDER BY localEmbarque";
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



  <title>PONTO DE EMBARQUE </title>
</head>

<body>
  <!-- INCLUSÃO DA NAVBAR -->
  <?php include_once("./includes/htmlElements/navbar.php"); ?>
  <div class="row py-2">
    <div class="col-md-10 mx-auto">
      <div class="card rounded shadow border-0">
        <div class="card-body p-5 bg-white rounded ml-1">
          <p class="h2 text-center mb-5">PONTOS DE EMBARQUE</p>

          <!-- INCLUSÃO DE MENSAGENS DE ERRO E SUCESSO -->
          <?php include_once("./includes/servicos/servicoSessionMsg.php"); ?>
          <div class="table ml-1">

            <?php
            mensagensInfoNoSession($nomePasseioTitulo . " " . date_format($dataPasseio, "d/m/Y"));
            ?>
            <script>
              var nomePasseio = '<?php echo $nomePasseioTitulo ?>';
              var dataPasseio = '<?php echo date_format($dataPasseio, "d/m/Y") ?>';
              document.title = "PONTOS DE EMBARQUE " + nomePasseio + " " + dataPasseio;
            </script>
            <table style="width:100%" class="table table-striped table-hover table-bordered" id="tabelaPontosDeEmbarque">
              <thead>
                <tr>
                  <th>NOME</th>
                  <th>PONTO EMBARQUE</th>
                  <th>IDADE</th>
                  <th>ANOTAÇÕES</th>
                  <th>REFERENCIA</th>
                  <th>POLTRONA</th>
                  <th>TRANSPORTE</th>
                </tr>
              </thead>

              <tbody>
                <?php

                while ($rowBuscaPasseio = mysqli_fetch_assoc($resultadoBuscaPasseio)) {



                ?>
                  <tr>
                    <td><a href="editarPagamento.php?id=<?php echo $rowBuscaPasseio['idPagamento'] ?>" target="BLANK">
                        <?php echo $rowBuscaPasseio['nomeCliente'] . "<BR/>"; ?>
                      </a></td>
                    <td>
                      <?php echo $rowBuscaPasseio['localEmbarque'] . "<BR/>"; ?>
                    </td>
                    <td>
                      <?php $idade = calcularIdade($rowBuscaPasseio['idCliente'], $conn, "");
                      echo $idade . "<BR/>"; ?>
                    </td>
                    <td>
                      <?php echo $rowBuscaPasseio['anotacoes'] . "<BR/>"; ?>
                    </td>
                    <td>
                      <?php echo $rowBuscaPasseio['referencia'] . "<BR/>"; ?>
                    </td>
                    <td>
                      <?php echo $rowBuscaPasseio['poltrona'] . "<BR/>"; ?>
                    </td>
                    <td>
                      <?php echo $rowBuscaPasseio['transporte'] . "<BR/>"; ?>
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
  </div>

  <?php include_once("./includes/mdbJs.php"); ?>

  <script src="includes/plugins/DataTables/configFiles/dataTablesPontosDeEmbarque.js"> </script>
  <script src="config/novoScript.js"></script>
</body>

</html>