<?php
//VERIFICACAO DE SESSOES E INCLUDES NECESSARIOS E CONEXAO AO BANCO DE DADOS
include_once("./includes/header.php");
include_once("./includes/constantes.php");
if($_SESSION['nivelAcesso'] !== ADMINISTRADOR) {
    header("location: index.php");
  
  }
// =================================================================================================================================
$query = " SELECT pp.historicoPagamento, pp.idPagamento, c.nomeCliente, p.nomePasseio, p.dataPasseio 
            FROM pagamento_passeio pp, cliente c, passeio p 
            WHERE pp.idCliente=c.idCliente AND pp.idPasseio=p.idPasseio AND historicoPagamento REGEXP '\r\n'";
$executaQuery = mysqli_query($conn, $query);

?>

<!DOCTYPE html>
<html lang="PT-BR">

<head>

<?php include_once("./includes/mdbcss.php"); ?>

    <title>PAGAMENTOS REALIZADOS</title>
</head>

<body>
    <!-- INCLUSÃO DA NAVBAR -->
    <?php include_once("./includes/htmlElements/navbar.php"); ?>
    <link rel="stylesheet" href="./config/style.css">
    <div class="row py-3">
        <div class="col-lg-10 mx-auto">
            <div class="card rounded shadow border-0">
                <!-- INCLUSÃO DE MENSAGENS DE ERRO E SUCESSO -->
                <?php include_once("./includes/servicos/servicoSessionMsg.php"); ?>
                <div class="card-body p-5 bg-white rounded">
                    <p class="h2 text-center">PAGAMENTOS REALIZADOS</p>
                    <div class="table-responsive">
                        <table style="width:100%" class="table table-striped table-bordered" id="tabelaPesquisarPagamentos">
                            <thead>
                                <tr>
                                    <th scope="col">Nome</th>
                                    <th scope="col">Data do último pagamento</th>
                                    <th scope="col">Último pagamento</th>
                                    <th scope="col">Passeio</th>
                                    <th scope="col" style="display: none;">MÊS</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $indexHistoricoPagamento = 0;
                                while ($resultadoQuery = mysqli_fetch_assoc($executaQuery)) {
                                    $ultimaLinha = substr_count($resultadoQuery['historicoPagamento'], "\n");
                                    $string = $resultadoQuery['historicoPagamento'];
                                    $nomeCliente = $resultadoQuery['nomeCliente'];
                                    $passeio = $resultadoQuery['nomePasseio'];
                                    list($sentence[]) = array_slice(explode(PHP_EOL, $string), -1, $ultimaLinha);
                                ?>
                                    <tr>
                                        <td><?php
                                            echo $nomeCliente;
                                            ?>
                                        </td>
                                        <td><?php
                                            $pesquisarData = $sentence[$indexHistoricoPagamento];
                                            $data  = substr($sentence[$indexHistoricoPagamento],0, strpos($sentence[$indexHistoricoPagamento], "R$"));
                                            $valor = strstr($sentence[$indexHistoricoPagamento], 'R$');
                                            $dataFormatada = new DateTime($data);
                                            echo $dataFormatada ->format('d/m/Y');
                                            $dataFormatada = $dataFormatada->format('n');
                                            

                                            ?>
                                        </td>
                                        <td><?php
                                            echo $valor;
                                            $indexHistoricoPagamento++;                         

                                            ?>
                                        </td>
                                        <td><?php
                                            echo $passeio;
                                            ?>
                                        </td>
                                        <td style="display: none;"> 
                                            <?php echo MESES_DO_ANO[$dataFormatada-1] ?>
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
    <?php include_once("./includes/mdbJs.php"); ?>

    <script src="includes/plugins/DataTables/configFiles/dataTablesPesquisarPagamentos.js"> </script>
  <script src="config/novoScript.js"></script>
</body>

</html>