<?php
//VERIFICACAO DE SESSOES E INCLUDES NECESSARIOS E CONEXAO AO BANCO DE DADOS
include_once("./includes/header.php");


?>
<!DOCTYPE html>
<html lang="PT-BR">

<head>
<?php include_once("./includes/mdbcss.php"); ?>

  <title>PESQUISAR CLIENTE</title>
</head>

<body>

  <!-- INCLUSÃO DA NAVBAR -->
  <?php include_once("./includes/htmlElements/navbar.php"); ?>

  <!-- TODO FORM -->
  <div class="row py-2">
    <div class="col-md-10 mx-auto">
      <div class="card rounded shadow border-0">
        <div class="card-body p-5 bg-white rounded">
          <!-- INCLUSÃO DE MENSAGENS DE ERRO E SUCESSO -->
          <?php include_once("./includes/servicos/servicoSessionMsg.php"); ?>

          <p class="h2 text-center">PESQUISAR CLIENTE</p>
          <form action="" autocomplete="off" method="POST" name="formularioPesquisarCliente">

            <div class="form-row">
              <div class="col">
                <input type="text" class="campo-de-pesquisa form-control" name="valorPesquisaCliente" id="" placeholder="CPF, NOME, TELEFONE OU REFERÊNCIA">
                <input type="hidden" class="form-control" name="" id="paginaSelecionada" placeholder="página">
                <input type="submit" value="PESQUISAR" name="enviarPesqCliente" id="enviarPesqCliente" class="btn btn-info form-group ">
              </div>
            </div>
            <div class="table-reponsive">
              <div class="form-row">
                <div class="col ml-3 mt-2">
                  <input class="form-check-input " type="checkbox" name="mostrarClientesExcluidos" value="1" id="mostrarClientesExcluidos">
                  <label class="form-check-label " for="mostrarClientesExcluidos">
                    Exibir clientes inativos
                  </label>
                  <?php esconderTabela(8); ?>

                </div>
              </div>
            </div>
          </form>


          <div class="table-responsive">
            <table style="width:100%" class="table table-striped table-bordered" id="tabelaPesquisarCliente">
              <thead>
                <tr>
                  <th>NOME</th>
                  <th>NASCIMENTO</th>
                  <th>IDADE</th>
                  <th>REFERÊNCIA</th>
                  <th>TEL. CLIENTE</th>
                  <th>EMAIL</th>
                  <th>REDE SOCIAL</th>
                  <th>AÇÕES</th>
                </tr>
              </thead>
              <tbody>
                <?php
                /* -----------------------------------------------------------------------------------------------------  */
                $enviarPesqNome = filter_input(INPUT_POST, 'enviarPesqCliente', FILTER_SANITIZE_STRING);
                /* -----------------------------------------------------------------------------------------------------  */
                if ($enviarPesqNome) {

                  /* -----------------------------------------------------------------------------------------------------  */
                  $valorPesquisaCliente = filter_input(INPUT_POST, 'valorPesquisaCliente', FILTER_SANITIZE_STRING);
                  /* -----------------------------------------------------------------------------------------------------  */
                  if (empty($valorPesquisaCliente)) {
                    $vazio = true;
                    $queryPesquisaCliente = "     SELECT c.nomeCliente, c.dataNascimento, c.idadeCliente, c.referencia, c.telefoneCliente, c.emailCliente, c.emailCliente, c.redeSocial, c.cpfCliente, c.idCliente, c.statusCliente 
                                              FROM cliente c ORDER BY c.nomeCliente ";
                    $resultadoPesquisaCliente = mysqli_query($conexao, $queryPesquisaCliente);
                    $totalCliente = mysqli_num_rows($resultadoPesquisaCliente);



                    $quantidadePagina = 50;

                    $numeroPaginasTotal = ceil($totalCliente / $quantidadePagina);

                    #$inicio = ($quantidadePagina * $pagina) - $quantidadePagina;
                    $numeroPaginas = $numeroPaginasTotal;
                    $mostrarClientesExcluidos = filter_input(INPUT_POST, 'mostrarClientesExcluidos', FILTER_VALIDATE_BOOLEAN);
                    $exibeCliente = (empty($mostrarClientesExcluidos) or is_null($mostrarClientesExcluidos)) ? false : true;
                    $queryExibeCliente = ($exibeCliente == false) ? 'statusCliente NOT IN (0) ' : ' ';
                    $queryPesquisaCliente = "     SELECT c.nomeCliente, c.dataNascimento, c.idadeCliente, c.referencia, c.telefoneCliente, c.emailCliente, c.emailCliente, c.redeSocial, c.cpfCliente, c.idCliente, c.statusCliente 
                                              FROM cliente c  WHERE $queryExibeCliente ORDER BY c.nomeCliente";
                    $resultadoPesquisaCliente = mysqli_query($conexao, $queryPesquisaCliente);
                  } else {
                    $vazio = false;
                    $paginaPesquisa = 1;
                    $mostrarClientesExcluidos = filter_input(INPUT_POST, 'mostrarClientesExcluidos', FILTER_VALIDATE_BOOLEAN);
                    $exibeCliente = (empty($mostrarClientesExcluidos) or is_null($mostrarClientesExcluidos)) ? false : true;
                    $queryExibeCliente = ($exibeCliente == false) ? 'AND statusCliente NOT IN (0) ' : ' ';
                    $queryPesquisaCliente = "     SELECT c.nomeCliente, c.dataNascimento, c.idadeCliente, c.referencia, c.telefoneCliente, c.emailCliente, c.emailCliente, c.redeSocial, c.cpfCliente, c.idCliente, c.statusCliente 
                                              FROM cliente c WHERE upper(c.nomeCliente) LIKE '%$valorPesquisaCliente%' $queryExibeCliente OR c.cpfCliente LIKE '%$valorPesquisaCliente%' $queryExibeCliente OR c.telefoneCliente LIKE '%$valorPesquisaCliente%' $queryExibeCliente OR c.referencia LIKE '%$valorPesquisaCliente' $queryExibeCliente ORDER BY c.nomeCliente";
                    $resultadoPesquisaCliente = mysqli_query($conexao, $queryPesquisaCliente);
                    $totalCliente = mysqli_num_rows($resultadoPesquisaCliente);


                    $numeroPaginasTotal = 1;

                    $quantidadePagina = 500;
                    $queryPesquisaCliente = "     SELECT c.nomeCliente, c.dataNascimento, c.idadeCliente, c.referencia, c.telefoneCliente, c.emailCliente, c.emailCliente, c.redeSocial, c.cpfCliente, c.idCliente, c.statusCliente 
                                              FROM cliente c WHERE upper(c.nomeCliente) LIKE '%$valorPesquisaCliente%' $queryExibeCliente OR c.cpfCliente LIKE '%$valorPesquisaCliente%' $queryExibeCliente OR c.telefoneCliente LIKE '%$valorPesquisaCliente%' $queryExibeCliente OR c.referencia LIKE '%$valorPesquisaCliente' $queryExibeCliente ORDER BY c.nomeCliente";
                    $resultadoPesquisaCliente = mysqli_query($conexao, $queryPesquisaCliente);
                    $totalCliente = mysqli_num_rows($resultadoPesquisaCliente);
                  }



                  while ($valorPesquisaCliente = mysqli_fetch_assoc($resultadoPesquisaCliente)) {
                    $dataNascimento = (empty($valorPesquisaCliente['dataNascimento']) or $valorPesquisaCliente['dataNascimento'] == "0000-00-00") ? "" : date_create($valorPesquisaCliente['dataNascimento']);

                    $idCliente =  $valorPesquisaCliente['idCliente'];
                ?>
                    <tr>
                      <td><?php echo $valorPesquisaCliente['nomeCliente'] . "<BR/>"; ?></td>
                      <td>

                        <?php $dataNascimentoFormatada = (empty($dataNascimento) or $dataNascimento == "0000-00-00") ? "" : date_format($dataNascimento, "d/m/Y") . "<BR/>";
                        echo $dataNascimentoFormatada; ?>

                      </td>

                      <td><?php echo $valorPesquisaCliente['idadeCliente'] . "<BR/>"; ?></td>
                      <td><?php echo $valorPesquisaCliente['referencia'] . "<BR/>"; ?></td>
                      <td><?php echo $valorPesquisaCliente['telefoneCliente'] . "<BR/>"; ?></td>
                      <td><?php echo $valorPesquisaCliente['emailCliente'] . "<BR/>"; ?></td>
                      <td><?php echo $valorPesquisaCliente['redeSocial'] . "<BR/>"; ?></td>
                      <?php
                      $linkEditarCliente    = "editarCliente.php?id=" . $idCliente;
                      $linkGerarContrato    = "contrato.php?id=" . $idCliente;
                      $linkPagamentoCliente = "pagamentoCliente.php?id=" . $idCliente;
                      $linkAtivarCliente    = "SCRIPTS/apagarCliente.php?id=" . $idCliente . "& status=0&nomeCliente=" . $valorPesquisaCliente['nomeCliente'];
                      $linkDesativarCliente = "SCRIPTS/apagarCliente.php?id=" . $idCliente . "& status=1&nomeCliente=" . $valorPesquisaCliente['nomeCliente'];
                      ?>
                      <td>
                        <button class='btn btn-info btn-sm ' onclick="novaJanela('<?php echo $linkEditarCliente; ?>')" data-toggle='tooltip' data-placement='top' title='EDITAR CLIENTE'><i class='material-icons'>edit</i></button>
                        <?php
                        if ($valorPesquisaCliente['statusCliente'] == 1) {
                        ?>
                          <button class='btn btn-dark btn-sm' onclick="novaJanela('<?php echo $linkGerarContrato; ?>')" data-toggle='tooltip' data-placement='top' title='GERAR CONTRATO'><i class='material-icons'>description</i></button>
                          <button class='btn btn-success btn-sm' onclick="novaJanela('<?php echo $linkPagamentoCliente; ?>')" data-toggle='tooltip' data-placement='top' title='REALIZAR PAGAMENTO'><i class='material-icons'>shopping_cart</i></button>

                        <?php } ?>

                        <?php
                        if ($valorPesquisaCliente['statusCliente'] == 0) {
                        ?>
                          <button class='btn btn-success btn-sm ' onclick="javascript:confirmationDelete($(this));return false;" href="<?php echo $linkAtivarCliente; ?>" data-toggle='tooltip' data-placement='top' title='REATIVAR CLIENTE'><i class='material-icons'>person_add</i></button>
                        <?PHP
                        } else {
                        ?>
                          <button class='btn btn-danger btn-sm ' onclick="javascript:confirmationDelete($(this));return false;" href="<?php echo $linkDesativarCliente; ?>" data-toggle='tooltip' data-placement='top' title='DESATIVAR CLIENTE'><i class='material-icons'>person_remove</i></button>

                        <?php
                        }
                        ?>

                      </td>

                    </tr>
                <?php
                  }
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
  <script src="includes/plugins/DataTables/configFiles/dataTablesPesquisarClientes.js"> </script>
  <script src="config/novoScript.js"></script>
</body>

</html>