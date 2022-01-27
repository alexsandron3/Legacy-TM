<?php
//VERIFICACAO DE SESSOES E INCLUDES NECESSARIOS E CONEXAO AO BANCO DE DADOS
include_once("./includes/header.php");

?>
<!DOCTYPE html>
<html lang="PT-BR">

<head>
  <?php include_once("./includes/mdbcss.php"); ?>

  <title>PESQUISAR PASSEIO</title>
</head>

<body>
  <!-- INCLUSÃO DA NAVBAR -->
  <?php include_once("./includes/htmlElements/navbar.php"); ?>


  <div class="row py-2">
    <div class="col-md-10 mx-auto">
      <div class="card rounded shadow border-0">
        <div class="card-body p-5 bg-white rounded">
          <!-- INCLUSÃO DE MENSAGENS DE ERRO E SUCESSO -->
          <?php include_once("./includes/servicos/servicoSessionMsg.php"); ?>

          <p class="h2 text-center">PESQUISAR PASSEIO</p>

          <form action="" autocomplete="off" method="GET">
            <div class="form-row">
              <div class="col">
                <input type="text" class="campos-de-texto form-control" name="valorPesquisaPasseio" id="" placeholder="NOME OU LOCAL">
              </div>
              <div class="col">
                <input type="date" class="form-control" name="dataPasseio" id="dataPasseio">
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
                <input type="submit" value="PESQUISAR" name="enviaPesqNome" class="btn btn-info btn-md">
              </div>
              <div class="col">
                <input type="submit" value="PESQUISAR" name="enviaPesqData" class="btn btn-info btn-md float-right">
              </div>
            </div>
          </form>

          <div class="table mt-5">
            <table style="width:100%" class="table table-striped table-bordered" id="tabelaPesquisarPasseio">
              <thead>
                <tr>
                  <th>ID</th>
                  <th>NOME</th>
                  <th>DATA</th>
                  <th>LOCAL</th>
                  <th>VAGAS</th>
                  <th>AÇÕES</th>
                </tr>
              </thead>
              <div class="table-reponsive">
                <?php esconderTabela(6); ?>
              </div>
              <tbody>
                <?php
                /* -----------------------------------------------------------------------------------------------------  */
                $enviaPesqNome = filter_input(INPUT_GET, 'enviaPesqNome', FILTER_SANITIZE_STRING);
                $enviaPesqData = filter_input(INPUT_GET, 'enviaPesqData', FILTER_SANITIZE_STRING);
                $mostrarPasseiosExcluidos = filter_input(INPUT_GET, 'mostrarPasseiosExcluidos', FILTER_VALIDATE_BOOLEAN);
                $exibePasseio = (empty($mostrarPasseiosExcluidos) or is_null($mostrarPasseiosExcluidos)) ? false : true;
                $queryExibePasseio = ($exibePasseio == false) ? 'AND statusPasseio NOT IN (0) ' : ' ';

                /* -----------------------------------------------------------------------------------------------------  */
                if ($enviaPesqNome) {
                  /* -----------------------------------------------------------------------------------------------------  */
                  $valorPesquisaPasseio     = filter_input(INPUT_GET, 'valorPesquisaPasseio', FILTER_SANITIZE_STRING);
                  $valorPesquisaData     = filter_input(INPUT_GET, 'dataPasseio', FILTER_SANITIZE_STRING);

                  /* -----------------------------------------------------------------------------------------------------  */
                  $queryPesquisaPasseio = "SELECT p.idPasseio, p.nomePasseio, p.dataPasseio, p.localPasseio, p.idPasseio, p.lotacao 
                                      FROM passeio p WHERE  p.nomePasseio LIKE '%$valorPesquisaPasseio%' $queryExibePasseio OR p.localPasseio LIKE '%$valorPesquisaPasseio%' $queryExibePasseio ORDER BY dataPasseio";
                  $resultadoPesquisaPasseio = mysqli_query($conexao, $queryPesquisaPasseio);
                  while ($valorPesquisaPasseio = mysqli_fetch_assoc($resultadoPesquisaPasseio)) {
                    $dataPasseio =  date_create($valorPesquisaPasseio['dataPasseio']);
                    $idPasseio = $valorPesquisaPasseio['idPasseio'];
                ?>
                    <tr>
                      <td><?php echo $valorPesquisaPasseio['idPasseio'] . "<BR/>"; ?></td>
                      <td><?php echo $valorPesquisaPasseio['nomePasseio'] . "<BR/>"; ?></td>
                      <p class="d-none"><?php echo identificarMes($dataPasseio); ?></p>
                      <td>
                        <?php echo date_format($dataPasseio, "d/m/Y") . "<BR/>"; ?></td>
                      <td>

                        <?php


                        echo $valorPesquisaPasseio['localPasseio'] . "<BR/>";
                        ?>
                      </td>
                      <td></td>
                      <td>

                        <?php
                        $linkListaPassageiros = "listaPasseio.php?id=" . $valorPesquisaPasseio['idPasseio'];
                        $linkLucrosPasseio = "relatoriosPasseio.php?id=" . $valorPesquisaPasseio['idPasseio'];
                        $linkRelatoriosPasseio = "relatoriosDoPasseio.php?id=" . $valorPesquisaPasseio['idPasseio'];
                        $linkEditarPasseio = "editarPasseio.php?id=" . $valorPesquisaPasseio['idPasseio'];
                        $linkDeletarPasseio = "SCRIPTS/apagarPasseio.php?id=" . $valorPesquisaPasseio['idPasseio'];

                        ?>
                        <button class='btn btn-info btn-just-icon btn-sm ' onclick="novaJanela('<?php echo $linkListaPassageiros; ?>')"><i class='material-icons' data-toggle='tooltip' data-placement='top' title='LISTA DE CLIENTES'>groups</i></button>
                        <button class='btn btn-success btn-just-icon btn-sm ' onclick="novaJanela('<?php echo $linkLucrosPasseio ?>')"><i class='material-icons' data-toggle='tooltip' data-placement='top' title='LUCROS'>price_check</i></button>
                        <button class='btn btn-dark btn-just-icon btn-sm ' onclick="novaJanela('<?php echo $linkRelatoriosPasseio ?>')"><i class='material-icons' data-toggle='tooltip' data-placement='top' title='RELATÓRIOS DO PASSEIO'>summarize</i></button>
                        <button class='btn btn-warning btn-just-icon btn-sm ' onclick="novaJanela('<?php echo $linkEditarPasseio ?>')"><i class='material-icons' data-toggle='tooltip' data-placement='top' title='EDITAR PASSEIO'>edit</i></button>
                        <button class='btn btn-danger btn-just-icon btn-sm ' onclick="javascript:confirmationDeletePasseio($(this));return false;" href="<?php echo $linkDeletarPasseio; ?>" data-toggle='tooltip' data-placement='top' title='APAGAR PASSEIO'><i class='material-icons'>delete_forever</i></button>

                      </td>
                    </tr>
                  <?php
                  }
                } elseif ($enviaPesqData) {
                  $valorPesquisaPasseioData = filter_input(INPUT_GET, 'dataPasseio',          FILTER_SANITIZE_STRING);
                  $queryPesquisaPasseio = "SELECT p.idPasseio, p.nomePasseio, p.dataPasseio, p.localPasseio, p.idPasseio, p.lotacao 
                                      FROM passeio p WHERE p.dataPasseio='$valorPesquisaPasseioData' $queryExibePasseio ORDER BY dataPasseio";
                  $resultadoPesquisaPasseio = mysqli_query($conexao, $queryPesquisaPasseio);
                  while ($valorPesquisaPasseio = mysqli_fetch_assoc($resultadoPesquisaPasseio)) {
                    $dataPasseio =  date_create($valorPesquisaPasseio['dataPasseio']);
                    $idPasseio = $valorPesquisaPasseio['idPasseio'];
                    $linkListaPassageiros = "listaPasseio.php?id=" . $valorPesquisaPasseio['idPasseio'];
                    $linkLucrosPasseio = "relatoriosPasseio.php?id=" . $valorPesquisaPasseio['idPasseio'];
                    $linkRelatoriosPasseio = "relatoriosDoPasseio.php?id=" . $valorPesquisaPasseio['idPasseio'];
                    $linkEditarPasseio = "editarPasseio.php?id=" . $valorPesquisaPasseio['idPasseio'];
                    $linkDeletarPasseio = "SCRIPTS/apagarPasseio.php?id=" . $valorPesquisaPasseio['idPasseio'];
                  ?>
                    <tr>
                      <td><?php echo $valorPesquisaPasseio['idPasseio'] . "<BR/>"; ?></td>
                      <td><?php echo $valorPesquisaPasseio['nomePasseio'] . "<BR/>"; ?></td>
                      <p class="d-none"><?php echo identificarMes($dataPasseio); ?></p>
                      <td>
                        <?php echo date_format($dataPasseio, "d/m/Y") . "<BR/>"; ?></td>
                      <td>

                        <?php


                        echo $valorPesquisaPasseio['localPasseio'] . "<BR/>";
                        ?>
                      </td>
                      <td></td>
                      <td>

                        <?php
                        $linkListaPassageiros = "listaPasseio.php?id=" . $valorPesquisaPasseio['idPasseio'];
                        $linkLucrosPasseio = "relatoriosPasseio.php?id=" . $valorPesquisaPasseio['idPasseio'];
                        $linkRelatoriosPasseio = "relatoriosDoPasseio.php?id=" . $valorPesquisaPasseio['idPasseio'];
                        $linkEditarPasseio = "editarPasseio.php?id=" . $valorPesquisaPasseio['idPasseio'];
                        $linkDeletarPasseio = "SCRIPTS/apagarPasseio.php?id=" . $valorPesquisaPasseio['idPasseio'];

                        ?>
                        <button class='btn btn-info btn-just-icon btn-sm ' onclick="novaJanela('<?php echo $linkListaPassageiros; ?>')"><i class='material-icons' data-toggle='tooltip' data-placement='top' title='LISTA DE CLIENTES'>groups</i></button>
                        <button class='btn btn-success btn-just-icon btn-sm ' onclick="novaJanela('<?php echo $linkLucrosPasseio ?>')"><i class='material-icons' data-toggle='tooltip' data-placement='top' title='LUCROS'>price_check</i></button>
                        <button class='btn btn-dark btn-just-icon btn-sm ' onclick="novaJanela('<?php echo $linkRelatoriosPasseio ?>')"><i class='material-icons' data-toggle='tooltip' data-placement='top' title='RELATÓRIOS DO PASSEIO'>summarize</i></button>
                        <button class='btn btn-warning btn-just-icon btn-sm ' onclick="novaJanela('<?php echo $linkEditarPasseio ?>')"><i class='material-icons' data-toggle='tooltip' data-placement='top' title='EDITAR PASSEIO'>edit</i></button>
                        <button class='btn btn-danger btn-just-icon btn-sm ' onclick="javascript:confirmationDeletePasseio($(this));return false;" href="<?php echo $linkDeletarPasseio; ?>" data-toggle='tooltip' data-placement='top' title='APAGAR PASSEIO'><i class='material-icons'>delete_forever</i></button>

                      </td>
                    </tr>
                <?php
                  }
                };
                ?>
              </tbody>
            </table>
          </div>

        </div>
      </div>
    </div>
  </div>
  <?php include_once("./includes/mdbJs.php"); ?>
  <script src="includes/plugins/DataTables/configFiles/dataTablesPesquisarPasseio.js"> </script>
  <script src="config/novoScript.js"></script>

  <script>
    function novaJanela(linkListaPassageiros) {
      var abrirNovaJanela = window.open(linkListaPassageiros, "nova aba");
    }
  </script>
</body>

</html>