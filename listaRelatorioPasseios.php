<?php
//VERIFICACAO DE SESSOES E INCLUDES NECESSARIOS E CONEXAO AO BANCO DE DADOS
include_once("./includes/header.php");

$inicioDataPasseio           = filter_input(INPUT_GET, 'inicioDataPasseio',       FILTER_SANITIZE_STRING);
$fimDataPasseio              = filter_input(INPUT_GET, 'fimDataPasseio',          FILTER_SANITIZE_STRING);
$mostrarPasseiosExcluidos    = filter_input(INPUT_GET, 'mostrarPasseiosExcluidos', FILTER_VALIDATE_BOOLEAN);
$inicioDataPasseioPadrao = '2000-01-01';
$fimDataPasseioPadrao    = '2099-01-01';

$exibePasseio = (empty($mostrarPasseiosExcluidos) or is_null($mostrarPasseiosExcluidos)) ? false : true;
$queryExibePasseio = ($exibePasseio == false) ? 'AND statusPasseio NOT IN (0)' : ' ';


if (!empty($inicioDataPasseio) and !empty($fimDataPasseio)) {
  $pesquisaIntervaloData = "SELECT  p.idPasseio, p.nomePasseio, p.dataPasseio
                                    FROM  passeio p  WHERE dataPasseio BETWEEN '$inicioDataPasseio' AND '$fimDataPasseio'  $queryExibePasseio ORDER BY  dataPasseio";

  $resultadPesquisaIntervaloData = mysqli_query($conexao, $pesquisaIntervaloData);
} else {
  $pesquisaIntervaloData = "SELECT  p.idPasseio, p.nomePasseio, p.dataPasseio
                                    FROM passeio p  WHERE dataPasseio BETWEEN '$inicioDataPasseioPadrao' AND '$fimDataPasseioPadrao'  $queryExibePasseio ORDER BY  dataPasseio";
  $resultadPesquisaIntervaloData = mysqli_query($conexao, $pesquisaIntervaloData);
}
/* -----------------------------------------------------------------------------------------------------  */
?>

<!DOCTYPE html>
<html lang="PT-BR">

<head>
<?php include_once("./includes/mdbcss.php"); ?>

  <title>LISTA DE PASSEIOS</title>
</head>

<body>
  <!-- INCLUSÃO DA NAVBAR -->
  <?php include_once("./includes/htmlElements/navbar.php"); ?>
  <?php

  $contador = 0;
  ?>
  <div class="row py-2">
    <div class="col-md-10 mx-auto">
      <div class="card rounded shadow border-0">

        <div class="card-body p-5 bg-white rounded">
          <div class="table-responsive">
            <!-- INCLUSÃO DE MENSAGENS DE ERRO E SUCESSO -->
            <?php include_once("./includes/servicos/servicoSessionMsg.php"); ?>
            <p class="h2 text-center">LISTA DE PASSEIOS </p>


            <div class="table-reponsive">
              <?php esconderTabela(4); ?>
            </div>
            <table style="width:100%" class="table table-striped table-bordered" id="tabelaListaRelatoriosPasseio">
              <thead>
                <tr>
                  <th class="text-center">Nº DE ORDEM</th>
                  <th>Passeio</th>
                  <th>Data</th>
                  <th class="text-right">Ações</th>
                </tr>
              </thead>
              <tbody>
                <?php

                while ($rowPesquisaIntervaloData      = mysqli_fetch_assoc($resultadPesquisaIntervaloData)) {
                  $dataPasseio = (empty($rowPesquisaIntervaloData['dataPasseio'])) ? "" : date_create($rowPesquisaIntervaloData['dataPasseio']);
                  $dataPasseioFromatada = (empty($dataPasseio)) ? "" : date_format($dataPasseio, "d/m/Y");

                  /* -----------------------------------------------------------------------------------------------------  */
                ?>
                  <tr class="text-bold">
                    <td class="text-center"><?php echo ++$contador; ?></td>
                    <td><?php echo $rowPesquisaIntervaloData['nomePasseio']; ?></td>
                    <td>
                     

                      <?php echo $dataPasseioFromatada;
                      $linkListaPassageiros     = "listaPasseio.php?id=" . $rowPesquisaIntervaloData['idPasseio'];
                      $linkEditarDespesas       = "editaDespesas.php?id=" . $rowPesquisaIntervaloData['idPasseio'];
                      $linkRelatoriosDoPasseio  = "relatoriosDoPasseio.php?id=" . $rowPesquisaIntervaloData['idPasseio'];
                      $linkLucrosDoPasseio      = "relatoriosPasseio.php?id=" . $rowPesquisaIntervaloData['idPasseio'];
                      ?>
                    </td>
                    <td class="td-actions text-right">
                    <p class="d-none"><?php echo identificarMes($dataPasseio); ?></p>
                      <button class='btn btn-info btn-just-icon btn-sm' onclick="novaJanela('<?php echo $linkListaPassageiros; ?>')" data-toggle='tooltip' data-placement='top' title='LISTA DE PASSAGEIROS'><i class='material-icons'>groups</i></button>
                      <button class='btn btn-success btn-just-icon btn-sm' onclick="novaJanela('<?php echo $linkLucrosDoPasseio; ?>')" data-toggle='tooltip' data-placement='top' title='LUCROS'><i class='material-icons'>price_check</i></button>
                      <button class='btn btn-danger btn-just-icon btn-sm' onclick="novaJanela('<?php echo $linkEditarDespesas; ?>')" data-toggle='tooltip' data-placement='top' title='DESPESAS'><i class='material-icons'>money_off</i></button>
                      <button class='btn btn-dark btn-just-icon btn-sm' onclick="novaJanela('<?php echo $linkRelatoriosDoPasseio; ?>')" data-toggle='tooltip' data-placement='top' title='RELATÓRIOS DO PASSEIO'><i class='material-icons'>summarize</i></button>

                    </td>
                  </tr>
                <?php } ?>
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>
  </div>
  </div>
  <?php include_once("./includes/mdbJs.php"); ?>
  <script src="includes/plugins/DataTables/configFiles/dataTablesListaRelarioPasseios.js"> </script>
  <script src="config/novoScript.js"></script>
  <script>
    function novaJanela(linkListaPassageiros) {
      var abrirNovaJanela = window.open(linkListaPassageiros, "nova aba");
    }
  </script>

</body>

</html>