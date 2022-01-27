<?php
//VERIFICACAO DE SESSOES E INCLUDES NECESSARIOS E CONEXAO AO BANCO DE DADOS
include_once("./includes/header.php");
if($_SESSION['nivelAcesso'] !== ADMINISTRADOR) {
  header("location: index.php");

}
$idPasseioGet = filter_input(INPUT_GET, 'id', FILTER_SANITIZE_NUMBER_FLOAT);
$queryBuscaDespesa = "SELECT DISTINCT d.valorIngresso, d.valorOnibus, d.valorMicro, d.valorVan, d.valorEscuna, d.valorAlmocoCliente, d.valorAlmocoMotorista, d.valorEstacionamento, d.valorGuia, d.valorAutorizacaoTransporte,
                          d.valorTaxi, d.valorKitLanche, d.valorMarketing, d.valorImpulsionamento, d.valorPulseira, d.valorSeguroViagem, d.valorHospedagem, d.valorAereo, d.valorServicos, d.outros, d.idPasseio,  d.idDespesa, d.quantidadeIngresso, d.quantidadeOnibus, d.quantidadeMicro, d.quantidadeVan, d.quantidadeEscuna,
                          d.quantidadeAlmocoCliente, d.quantidadeAlmocoMotorista, d.quantidadeEstacionamento, d.quantidadeGuia, d.quantidadeAutorizacaoTransporte, d.quantidadeTaxi, d.quantidadeKitLanche, d.quantidadeMarketing, d.quantidadeImpulsionamento, d.quantidadePulseira, d.quantidadeSeguroViagem,
                          d.quantidadeHospedagem, d.quantidadeAereo, d.quantidadeServicos, p.nomePasseio, p.dataPasseio   
                          FROM despesa d, passeio p WHERE d.idpasseio='$idPasseioGet' AND d.idPasseio=p.idPasseio";
$resultadoBuscaDespesa = mysqli_query($conexao, $queryBuscaDespesa);
$rowDespesa = mysqli_fetch_assoc($resultadoBuscaDespesa);
$dataPasseio =  date_create($rowDespesa['dataPasseio']);
/* -----------------------------------------------------------------------------------------------------  */

/* -----------------------------------------------------------------------------------------------------  */
if (!empty($idPasseioGet)) {
  $queryTotalDespesas = "SELECT (valorAereo * quantidadeAereo) + (valorAlmocoCliente * quantidadeAlmocoCliente) + (valorAlmocoMotorista * quantidadeAlmocoMotorista) + (valorAutorizacaoTransporte * quantidadeAutorizacaoTransporte) + 
                        (valorEscuna * quantidadeEscuna) + (valorEstacionamento * quantidadeEstacionamento) + (valorGuia * quantidadeGuia) + (valorHospedagem * quantidadeHospedagem) + (valorImpulsionamento * quantidadeImpulsionamento) + 
                        (valorIngresso * quantidadeIngresso) + (valorKitLanche * quantidadeKitLanche)+ (valorMarketing * quantidadeMarketing) + (valorMicro * quantidadeMicro) + (valorOnibus * quantidadeOnibus) + (valorPulseira * quantidadePulseira) + 
                        (valorSeguroViagem * quantidadeSeguroViagem) + (valorServicos * quantidadeServicos) + (valorTaxi * quantidadeTaxi) + (valorVan * quantidadeVan) + outros AS totalDespesas 
                        FROM despesa WHERE idPasseio=$idPasseioGet";

  $resultadoTotalDespesas = mysqli_query($conexao, $queryTotalDespesas);
  $rowTotalDespesa = mysqli_fetch_assoc($resultadoTotalDespesas);
  $valorTotalDespesas = $rowTotalDespesa['totalDespesas'] /* + $valorTotalSeguroViagem */;
}
/* -----------------------------------------------------------------------------------------------------  */

?>
<!DOCTYPE html>
<html lang="PT-BR">

<head>
<?php include_once("./includes/mdbcss.php"); ?>

  <title>ATUALIZAR DESPESAS</title>
</head>

<body>
  <!-- INCLUSÃO DA NAVBAR -->
  <?php include_once("./includes/htmlElements/navbar.php"); ?>


  <div class="row py-5">
    <div class="col-md-10 mx-auto">
      <div class="card rounded shadow border-0">
        <p class="h2 text-center">EDIÇÃO DE DESPESAS</p>
        <div class="card-body p-5 bg-white rounded ">
          <!-- INCLUSÃO DE MENSAGENS DE ERRO E SUCESSO -->
          <?php include_once("./includes/servicos/servicoSessionMsg.php"); ?>
          <form action="SCRIPTS/atualizaDespesas.php" autocomplete="off" method="POST" onkeydown="calculoDespesas()" class="block-form">
            <?php
            mensagensInfoNoSession("" . $rowDespesa['nomePasseio'] . " " . date_format($dataPasseio, "d/m/Y"));
            ?>
            <div class='form-row'>
              <label class='col-sm-2 col-form-label' for='valorAereo'>AÉREO</label>
              <div class='col-sm-6'>
                <input type='text' class='campo-monetario form-control' name='valorAereo' id='valorAereo' placeholder='AEREO' value='<?php echo $rowDespesa['valorAereo']; ?>' >
              </div>
              <div class='col-sm-1'>
                <input type='number' class='form-control' name='quantidadeAereo' id='quantidadeAereo' placeholder='QTD' value='<?php echo $rowDespesa['quantidadeAereo']; ?>' >
              </div>
              <div class='col-sm-2'>
                <input type='text' readonly class='form-control col-sm-8' name='valorTotalAereo' id='valorTotalAereo' placeholder='TOTAL' value='0' >
              </div>
            </div>

            <div class='form-row my-4'>
              <label class='col-sm-2 col-form-label' for='valorAlmocoCliente'>ALMOCO CLIENTE</label>
              <div class='col-sm-6'>
                <input type='text' class='campo-monetario form-control' name='valorAlmocoCliente' id='valorAlmocoCliente' placeholder='ALMOCO CLIENTE' value='<?php echo number_format((float)$rowDespesa['valorAlmocoCliente'], 2, '.', '') ?>' >
              </div>
              <div class='col-sm-1'>
                <input type='number' class='form-control' name='quantidadeAlmocoCliente' id='quantidadeAlmocoCliente' placeholder='QTD' value='<?php echo $rowDespesa['quantidadeAlmocoCliente']; ?>' >
              </div>
              <div class='col-sm-2'>
                <input type='text' readonly class='form-control col-sm-8' name='valorTotalAlmocoCliente' id='valorTotalAlmocoCliente' placeholder='TOTAL' value='0' >
              </div>
            </div>

            <div class='form-row my-4'>
              <label class='col-sm-2 col-form-label' for='valorAlmocoMotorista'>ALMOCO MOTORISTA</label>
              <div class='col-sm-6'>
                <input type='text' class='campo-monetario form-control' name='valorAlmocoMotorista' id='valorAlmocoMotorista' placeholder='ALMOCO MOTORISTA' value='<?php echo number_format((float)$rowDespesa['valorAlmocoMotorista'], 2, '.', '') ?>' >
              </div>
              <div class='col-sm-1'>
                <input type='number' class='form-control' name='quantidadeAlmocoMotorista' id='quantidadeAlmocoMotorista' placeholder='QTD' value='<?php echo $rowDespesa['quantidadeAlmocoMotorista']; ?>' >
              </div>
              <div class='col-sm-2'>
                <input type='text' readonly class='form-control col-sm-8' name='valorTotalAlmocoMotorista' id='valorTotalAlmocoMotorista' placeholder='TOTAL' value='0' >
              </div>
            </div>

            <div class='form-row my-4'>
              <label class='col-sm-2 col-form-label' for='valorAutorizacaoTransporte'>AUTORIZAÇÃO</label>
              <div class='col-sm-6'>
                <input type='text' class='campo-monetario form-control' name='valorAutorizacaoTransporte' id='valorAutorizacaoTransporte' placeholder='AUTORIZACAO TRANSPORTE' value='<?php echo number_format((float)$rowDespesa['valorAutorizacaoTransporte'], 2, '.', '') ?>' >
              </div>
              <div class='col-sm-1'>
                <input type='number' class='form-control' name='quantidadeAutorizacaoTransporte' id='quantidadeAutorizacaoTransporte' placeholder='QTD' value='<?php echo $rowDespesa['quantidadeAutorizacaoTransporte']; ?>' >
              </div>
              <div class='col-sm-2'>
                <input type='text' readonly class='form-control col-sm-8' name='valorTotalTransporte' id='valorTotalTransporte' placeholder='TOTAL' value='0' >
              </div>
            </div>

            <div class='form-row my-4'>
              <label class='col-sm-2 col-form-label' for='valorEscuna'>ESCUNA</label>
              <div class='col-sm-6'>
                <input type='text' class='campo-monetario form-control' name='valorEscuna' id='valorEscuna' placeholder='VALOR DO ESCUNA' value='<?php echo number_format((float)$rowDespesa['valorEscuna'], 2, '.', '') ?>' >
              </div>
              <div class='col-sm-1'>
                <input type='number' class='form-control' name='quantidadeEscuna' id='quantidadeEscuna' placeholder='QTD' value='<?php echo $rowDespesa['quantidadeEscuna']; ?>' >
              </div>
              <div class='col-sm-2'>
                <input type='text' readonly class='form-control col-sm-8' name='valorTotalEscuna' id='valorTotalEscuna' placeholder='TOTAL' value='0' >
              </div>
            </div>

            <div class='form-row my-4'>
              <label class='col-sm-2 col-form-label' for='valorEstacionamento'>ESTACIONAMENTO</label>
              <div class='col-sm-6'>
                <input type='text' class='campo-monetario form-control' name='valorEstacionamento' id='valorEstacionamento' placeholder='ESTACIONAMENTO' value='<?php echo number_format((float)$rowDespesa['valorEstacionamento'], 2, '.', '') ?>' >
              </div>
              <div class='col-sm-1'>
                <input type='number' class='form-control' name='quantidadeEstacionamento' id='quantidadeEstacionamento' placeholder='QTD' value='<?php echo $rowDespesa['quantidadeEstacionamento']; ?>' >
              </div>
              <div class='col-sm-2'>
                <input type='text' readonly class='form-control col-sm-8' name='valorTotalEstacionamento' id='valorTotalEstacionamento' placeholder='TOTAL' value='0' >
              </div>
            </div>

            <div class='form-row my-4'>
              <label class='col-sm-2 col-form-label' for='valorGuia'>GUIA</label>
              <div class='col-sm-6'>
                <input type='text' class='campo-monetario form-control' name='valorGuia' id='valorGuia' placeholder='VALOR GUIA' value='<?php echo number_format((float)$rowDespesa['valorGuia'], 2, '.', '') ?>' >
              </div>
              <div class='col-sm-1'>
                <input type='number' class='form-control' name='quantidadeGuia' id='quantidadeGuia' placeholder='QTD' value='<?php echo $rowDespesa['quantidadeGuia']; ?>' >
              </div>
              <div class='col-sm-2'>
                <input type='text' readonly class='form-control col-sm-8' name='valorTotalGuia' id='valorTotalGuia' placeholder='TOTAL' value='0' >
              </div>
            </div>

            <div class='form-row my-4'>
              <label class='col-sm-2 col-form-label' for='valorHospedagem'>HOSPEDAGEM</label>
              <div class='col-sm-6'>
                <input type='text' class='campo-monetario form-control' name='valorHospedagem' id='valorHospedagem' placeholder='HOSPEDAGEM' value='<?php echo $rowDespesa['valorHospedagem']; ?>' >
              </div>
              <div class='col-sm-1'>
                <input type='number' class='form-control' name='quantidadeHospedagem' id='quantidadeHospedagem' placeholder='QTD' value='<?php echo $rowDespesa['quantidadeHospedagem']; ?>' >
              </div>
              <div class='col-sm-2'>
                <input type='text' readonly class='form-control col-sm-8' name='valorTotalHospedagem' id='valorTotalHospedagem' placeholder='TOTAL' value='0' >
              </div>
            </div>

            <div class='form-row my-4'>
              <label class='col-sm-2 col-form-label' for='valorImpulsionamento'>IMPULSIONAMENTO</label>
              <div class='col-sm-6'>
                <input type='text' class='campo-monetario form-control' name='valorImpulsionamento' id='valorImpulsionamento' placeholder='INMPULSIONAMENTO' value='<?php echo number_format((float)$rowDespesa['valorImpulsionamento'], 2, '.', '') ?>' >
              </div>
              <div class='col-sm-1'>
                <input type='number' class='form-control' name='quantidadeImpulsionamento' id='quantidadeImpulsionamento' placeholder='QTD' value='<?php echo $rowDespesa['quantidadeImpulsionamento']; ?>' >
              </div>
              <div class='col-sm-2'>
                <input type='text' readonly class='form-control col-sm-8' name='valorTotalImpulsionamento' id='valorTotalImpulsionamento' placeholder='TOTAL' value='0' >
              </div>
            </div>

            <div class='form-row my-4'>
              <label class='col-sm-2 col-form-label' for='valorIngresso'>INGRESSO</label>
              <div class='col-sm-6'>
                <input type='text' class='campo-monetario form-control' name='valorIngresso' id='valorIngresso' placeholder='VALOR DO INGRESSO' value='<?php echo number_format((float)$rowDespesa['valorIngresso'], 2, '.', '') ?>' >
              </div>
              <div class='col-sm-1'>
                <input type='number' class='form-control' name='quantidadeIngresso' id='quantidadeIngresso' placeholder='QTD' value='<?php echo $rowDespesa['quantidadeIngresso']; ?>' >
              </div>
              <div class='col-sm-2'>
                <input type='text' readonly class='form-control col-sm-8' name='valorTotalIngresso' id='valorTotalIngresso' placeholder='TOTAL' value='0' >
              </div>
            </div>



            <div class='form-row my-4'>
              <label class='col-sm-2 col-form-label' for='valorKitLanche'>KIT LANCHE</label>
              <div class='col-sm-6'>
                <input type='text' class='campo-monetario form-control' name='valorKitLanche' id='valorKitLanche' placeholder='KIT LANCHE' value='<?php echo number_format((float)$rowDespesa['valorKitLanche'], 2, '.', '') ?>' >
              </div>
              <div class='col-sm-1'>
                <input type='number' class='form-control' name='quantidadeKitLanche' id='quantidadeKitLanche' placeholder='QTD' value='<?php echo $rowDespesa['quantidadeKitLanche']; ?>' >
              </div>
              <div class='col-sm-2'>
                <input type='text' readonly class='form-control col-sm-8' name='valorTotalKitLanche' id='valorTotalKitLanche' placeholder='TOTAL' value='0' >
              </div>
            </div>

            <div class='form-row my-4'>
              <label class='col-sm-2 col-form-label' for='valorMarketing'>MARKETING</label>
              <div class='col-sm-6'>
                <input type='text' class='campo-monetario form-control' name='valorMarketing' id='valorMarketing' placeholder='MARKETING' value='<?php echo number_format((float)$rowDespesa['valorMarketing'], 2, '.', '') ?>' >
              </div>
              <div class='col-sm-1'>
                <input type='number' class='form-control' name='quantidadeMarketing' id='quantidadeMarketing' placeholder='QTD' value='<?php echo $rowDespesa['quantidadeMarketing']; ?>' >
              </div>
              <div class='col-sm-2'>
                <input type='text' readonly class='form-control col-sm-8' name='valorTotalMarketing' id='valorTotalMarketing' placeholder='TOTAL' value='0' >
              </div>
            </div>

            <div class='form-row my-4'>
              <label class='col-sm-2 col-form-label' for='valorMicro'>MICRO</label>
              <div class='col-sm-6'>
                <input type='text' class='campo-monetario form-control' name='valorMicro' id='valorMicro' placeholder='VALOR DO MICRO' value='<?php echo number_format((float)$rowDespesa['valorMicro'], 2, '.', '') ?>' >
              </div>
              <div class='col-sm-1'>
                <input type='number' class='form-control' name='quantidadeMicro' id='quantidadeMicro' placeholder='QTD' value='<?php echo $rowDespesa['quantidadeMicro']; ?>' >
              </div>
              <div class='col-sm-2'>
                <input type='text' readonly class='form-control col-sm-8' name='valorTotalMicro' id='valorTotalMicro' placeholder='TOTAL' value='0' >
              </div>
            </div>

            <div class='form-row my-4'>
              <label class='col-sm-2 col-form-label' for='valorOnibus'>ONIBUS</label>
              <div class='col-sm-6'>
                <input type='text' class='campo-monetario form-control' name='valorOnibus' id='valorOnibus' placeholder='VALOR DO ONIBUS' value='<?php echo number_format((float)$rowDespesa['valorOnibus'], 2, '.', '') ?>' >
              </div>
              <div class='col-sm-1'>
                <input type='number' class='form-control' name='quantidadeOnibus' id='quantidadeOnibus' placeholder='QTD' value='<?php echo $rowDespesa['quantidadeOnibus']; ?>' >
              </div>
              <div class='col-sm-2'>
                <input type='text' readonly class='form-control col-sm-8' name='valorTotalOnibus' id='valorTotalOnibus' placeholder='TOTAL' value='0' >
              </div>
            </div>


            <div class='form-row my-4'>
              <label class='col-sm-2 col-form-label' for='valorPulseira'>PULSEIRAS</label>
              <div class='col-sm-6'>
                <input type='text' class='campo-monetario form-control' name='valorPulseira' id='valorPulseira' placeholder='PULSEIRA' value='<?php echo $rowDespesa['valorPulseira']; ?>' >
              </div>
              <div class='col-sm-1'>
                <input type='number' class='form-control' name='quantidadePulseira' id='quantidadePulseira' placeholder='QTD' value='<?php echo $rowDespesa['quantidadePulseira']; ?>' >
              </div>
              <div class='col-sm-2'>
                <input type='text' readonly class='form-control col-sm-8' name='valorTotalPulseira' id='valorTotalPulseira' placeholder='TOTAL' value='0' >
              </div>
            </div>

            <div class='form-row my-4'>
              <label class='col-sm-2 col-form-label' for='valorSeguroViagem'>SEGURO VIAGEM</label>
              <div class='col-sm-6'>
                <input type='text' class='campo-monetario form-control' name='valorSeguroViagem' id='valorSeguroViagem' placeholder='VALOR DO SEGURO VIAGEM' value='<?php echo number_format((float)$rowDespesa['valorSeguroViagem'], 2, '.', '') ?>' >
              </div>
              <div class='col-sm-1'>
                <input type='number' class='form-control' name='quantidadeSeguroViagem' id='quantidadeSeguroViagem' placeholder='QTD' value='<?php echo $rowDespesa['quantidadeSeguroViagem']; ?>' >
              </div>
              <div class='col-sm-2'>
                <input type='text' readonly class='form-control col-sm-8' name='valorTotalSeguroViagem' id='valorTotalSeguroViagem' placeholder='TOTAL' value='0' >
              </div>
            </div>

            <div class='form-row my-4'>
              <label class='col-sm-2 col-form-label' for='valorServicos'>SERVIÇOS</label>
              <div class='col-sm-6'>
                <input type='text' class='campo-monetario form-control' name='valorServicos' id='valorServicos' placeholder='SERVIÇOS' value='<?php echo $rowDespesa['valorServicos']; ?>' >
              </div>
              <div class='col-sm-1'>
                <input type='number' class='form-control' name='quantidadeServicos' id='quantidadeServicos' placeholder='QTD' value='<?php echo $rowDespesa['quantidadeServicos']; ?>' >
              </div>
              <div class='col-sm-2'>
                <input type='text' readonly class='form-control col-sm-8' name='valorTotalServicos' id='valorTotalServicos' placeholder='TOTAL' value='0' >
              </div>
            </div>

            <div class='form-row my-4'>
              <label class='col-sm-2 col-form-label' for='valorTaxi'>TAXI</label>
              <div class='col-sm-6'>
                <input type='text' class='campo-monetario form-control' name='valorTaxi' id='valorTaxi' placeholder='TAXI' value='<?php echo number_format((float)$rowDespesa['valorTaxi'], 2, '.', '') ?>' >
              </div>
              <div class='col-sm-1'>
                <input type='number' class='form-control' name='quantidadeTaxi' id='quantidadeTaxi' placeholder='QTD' value='<?php echo $rowDespesa['quantidadeTaxi']; ?>' >
              </div>
              <div class='col-sm-2'>
                <input type='text' readonly class='form-control col-sm-8' name='valorTotalTaxi' id='valorTotalTaxi' placeholder='TOTAL' value='0' >
              </div>
            </div>

            <div class='form-row my-4'>
              <label class='col-sm-2 col-form-label' for='valorVan'>VAN</label>
              <div class='col-sm-6'>
                <input type='text' class='campo-monetario form-control' name='valorVan' id='valorVan' placeholder='VALOR DO VAN' value='<?php echo number_format((float)$rowDespesa['valorVan'], 2, '.', '') ?>' >
              </div>
              <div class='col-sm-1'>
                <input type='number' class='form-control' name='quantidadeVan' id='quantidadeVan' placeholder='QTD' value='<?php echo $rowDespesa['quantidadeVan']; ?>' >
              </div>
              <div class='col-sm-2'>
                <input type='text' readonly class='form-control col-sm-8' name='valorTotalVan' id='valorTotalVan' placeholder='TOTAL' value='0' >
              </div>
            </div>

            <div class='form-row my-4'>
              <label class='col-sm-2 col-form-label' for='outros'>OUTROS</label>
              <div class='col-sm-6'>
                <input type='text' class='campo-monetario form-control' name='outros' id='outros' placeholder='OUTROS' value='<?php echo number_format((float)$rowDespesa['outros'], 2, '.', '') ?>' >
              </div>
            </div>

            <div class='form-row my-4'>
              <label class='col-sm-2 col-form-label' for='totalDespesas'>TOTAL DESPESAS</label>
              <div class='col-sm-6'>
                <input type='text' class='campo-monetario form-control' name='totalDespesas' id='totalDespesas' placeholder='TOTAL DESPESAS' value='<?php echo $valorTotalDespesas; ?>' readonly='readonly' >
              </div>
            </div>

            <button type='submit' name='cadastrarClienteBtn' id='submit' class='btn btn-info btn-lg'>ATUALIZAR</button>

            <input type="hidden" class="form-control col-sm-1 ml-3" name="idPasseioSelecionado" id="idPasseioSelecionado" value="<?php echo $rowDespesa['idPasseio'] ?>">
            <input type="hidden" class="form-control col-sm-1 ml-3" name="idDespesa" id="idDespesa" value="<?php echo $rowDespesa['idDespesa'] ?>">
            <input type="hidden" class="form-control col-sm-1 ml-3" name="nomePassseio" id="nomePasseio" value="<?php echo  $rowDespesa['nomePasseio'] ?>">
            <input type="hidden" class="form-control col-sm-1 ml-3" name="dataPasseio" id="dataPasseio" value="<?php echo $rowDespesa['dataPasseio'] ?>">

          </form>
        </div>
      </div>
    </div>
  </div>
  <?php include_once("./includes/mdbJs.php"); ?>
  <script src="config/novoScript.js"></script>
</body>

</html>