<?php
//VERIFICACAO DE SESSOES E INCLUDES NECESSARIOS E CONEXAO AO BANCO DE DADOS
include_once("./includes/header.php");
$idPasseioGet = filter_input(INPUT_GET, 'id', FILTER_SANITIZE_NUMBER_INT);

?>

<!DOCTYPE html>
<html lang="PT-BR">

<head>
<?php include_once("./includes/mdbcss.php"); ?>
  <title>RELATORIOS PASSEIO</title>
</head>

<body>
  <!-- INCLUSÃO DA NAVBAR -->
  <?php include_once("./includes/htmlElements/navbar.php"); ?>

  <div class="row py-5">
    <div class="col-lg-11 mx-auto">
      <div class="card rounded shadow border-0">
        <p class="h2 text-center">RELATÓRIOS DO PASSEIO</p>
        <div class="card-body p-5 bg-white rounded ">
          <!-- INCLUSÃO DE MENSAGENS DE ERRO E SUCESSO -->
          <?php include_once("./includes/servicos/servicoSessionMsg.php"); ?>

          <div class="text-center">
          <a  href="listaAniversariantesMes.php?id=<?php echo $idPasseioGet ?>" class="btn btn-info btn-round">ANIVERSARIANTES</a>
            <a  href="listaClientes.php?id=<?php echo $idPasseioGet ?>" class="btn btn-info btn-round">LISTA DE PASSAGEIROS</a>
            <a  href="pagamentosPendentes.php?id=<?php echo $idPasseioGet ?>" class="btn btn-info btn-round">PAGAMENTOS PENDENTES</a>
            <a  href="pontosDeEmbarque.php?id=<?php echo $idPasseioGet ?>" class="btn btn-info btn-round">PONTOS DE EMBARQUE</a>
            <a  href="SCRIPTS/exportarExcel.php?id=<?php echo $idPasseioGet ?>" class="btn btn-info btn-round"> <i class="material-icons mr-2">save_alt</i> SEGURO VIAGEM</a>
          </div>
        </div>
      </div>
    </div>
  </div>
  <?php include_once("./includes/mdbJs.php"); ?>

</body>


</html>