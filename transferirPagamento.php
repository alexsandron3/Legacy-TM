<?php
//VERIFICACAO DE SESSOES E INCLUDES NECESSARIOS E CONEXAO AO BANCO DE DADOS
include_once("./includes/header.php");

$idPasseioAntigo   = filter_input(INPUT_GET, 'idPasseioAntigo', FILTER_SANITIZE_NUMBER_INT);
$idPagamentoAntigo = filter_input(INPUT_GET, 'idPagamentoAntigo', FILTER_SANITIZE_NUMBER_INT);

?>
<!DOCTYPE html>
<html lang="PT-BR">

<head>
  <?php include_once("./includes/mdbcss.php"); ?>

  <title>TRANSFERIR PAGAMENTO</title>
</head>

<body>
  <!-- INCLUSÃO DA NAVBAR -->
  <?php include_once("./includes/htmlElements/navbar.php"); ?>

  <div class="row py-2">
    <div class="col-md-10 mx-auto">
      <div class="card rounded shadow border-0">

        <div class="card-body p-5 bg-white rounded">
          <div class="table-responsive">
            <!-- INCLUSÃO DE MENSAGENS DE ERRO E SUCESSO -->
            <?php include_once("./includes/servicos/servicoSessionMsg.php"); ?>
            <p class="h2 text-center">LISTA DE PASSEIO </p>

            <form action="" method="POST" autocomplete="OFF">
              <label class="col-sm-2 col-form-label" for="nomePasseio">PASSEIO</label>
              <input type="hidden" name="nomePasseio" value=" ">

              <select class="form-control ml-3 col-sm-3" name="idPasseioLista" id="selectIdPasseio" onchange="idPasseioSelecionadoFun()">
                <option value="1">SELECIONAR</option>

                <?php
                $queryBuscaIdCliente = "SELECT idCliente FROM pagamento_passeio WHERE idPagamento='$idPagamentoAntigo' AND idPasseio='$idPasseioAntigo'";
                $resultadoBuscaIdCliente = mysqli_query($conexao, $queryBuscaIdCliente);
                $rowBuscaIdCliente = mysqli_fetch_assoc($resultadoBuscaIdCliente);
                $idCliente = $rowBuscaIdCliente['idCliente'];

                $nomePasseioPost = filter_input(INPUT_POST, 'nomePasseio', FILTER_SANITIZE_STRING);
                $queryBuscaPeloNomePasseio = "SELECT p.idPasseio, p.nomePasseio, p.dataPasseio FROM passeio p WHERE statusPasseio NOT IN(0)  ORDER BY dataPasseio";
                /* -----------------------------------------------------------------------------------------------------  */
                $resultadoNomePasseio = mysqli_query($conexao, $queryBuscaPeloNomePasseio);
                /* -----------------------------------------------------------------------------------------------------  */
                while ($rowNomePasseio = mysqli_fetch_assoc($resultadoNomePasseio)) {
                  $dataPasseioLista =  date_create($rowNomePasseio['dataPasseio']);
                ?>
                  <option value="<?php echo $rowNomePasseio['idPasseio']; ?>"><?php echo $rowNomePasseio['nomePasseio'];
                                                                              echo " ";
                                                                              echo date_format($dataPasseioLista, "d/m/Y"); ?> </option>
                <?php
                }

                ?>
                <input type="submit" class="btn btn-info btn-md ml-2" value="SELECIONAR PASSEIO" name="buttonEnviaNomePasseio">
                <input type="hidden" class="form-control col-sm-1 ml-3" name="idPasseioSelecionado" id="idPasseioSelecionado" onchange="idPasseioSelecionadoFun()" readonly="readonly">
                <input type="hidden" class="form-control col-sm-1 ml-3" name="idPasseioAntigo" id="idPasseioAntigo" value="<?php echo $idPasseioAntigo; ?>" readonly="readonly">
                <input type="hidden" class="form-control col-sm-1 ml-3" name="idPagamentoAntigo" id="idPagamentoAntigo" value="<?php echo $idPagamentoAntigo; ?>" readonly="readonly">
                <input type="hidden" class="form-control col-sm-1 ml-3" name="idCliente" id="idCliente" value="<?php echo $idCliente; ?>" readonly="readonly">
              </select>


            </form>

            <form action="SCRIPTS/transferePagamento.php" method="POST" autocomplete="off">
              <?php
              $buttonCarregarInformacoes = filter_input(INPUT_POST, 'buttonEnviaNomePasseio', FILTER_SANITIZE_STRING);
              $idPasseioSelecionado = filter_input(INPUT_POST, 'idPasseioLista', FILTER_SANITIZE_NUMBER_INT);
              $idCliente = filter_input(INPUT_POST, 'idCliente', FILTER_SANITIZE_NUMBER_INT);

              if ($idPasseioSelecionado == 1) {
                mensagensWarningNoSession("SELECIONE UM PASSEIO");
              } else {


                if ($buttonCarregarInformacoes) {
                  $queryBuscaSeJaExistePagamento = "SELECT idPagamento FROM pagamento_passeio WHERE idCliente='$idCliente' AND idPasseio='$idPasseioSelecionado'";
                  $resultadoqueryBuscaSeJaExistePagamento = mysqli_query($conexao, $queryBuscaSeJaExistePagamento);
                  if (mysqli_num_rows($resultadoqueryBuscaSeJaExistePagamento) == 0) {
                    mensagensSucessNoSession("TRANSFERÊNCIA LIBERADA, CLIQUE EM 'FINALIZAR TRANSFERÊNCIA' PARA FINALIZAR O PROCESSO");
                    #echo "<p class='h5 text-center alert-info'>  </p>";
              ?> <input type='submit' class='btn btn-info btn-md' value='FINALIZAR TRASNSFERÊNCIA' name='buttonFinalizarPagamento'>
              <?php } else {
                    mensagensWarningNoSession("TRANSFERÊNCIA NÃO LIBERADA POR ESSE CLIENTE JÁ TER UM PAGAMENTO NESTE PASSEIO");
                  }
                }
              }
              ?>
              <input type="hidden" class="form-control col-sm-1 ml-3" name="idPasseioSelecionado" id="idPasseioSelecionado" value="<?php echo $idPasseioSelecionado; ?>" onchange="idPasseioSelecionadoFun()" readonly="readonly">
              <input type="hidden" class="form-control col-sm-1 ml-3" name="idPasseioAntigo" id="idPasseioAntigo" value="<?php echo $idPasseioAntigo; ?>" readonly="readonly">
              <input type="hidden" class="form-control col-sm-1 ml-3" name="idPagamentoAntigo" id="idPagamentoAntigo" value="<?php echo $idPagamentoAntigo; ?>" readonly="readonly">
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>
  <?php include_once("./includes/mdbJs.php"); ?>
  <script src="config/novoScript.js"></script>
</body>

</html>