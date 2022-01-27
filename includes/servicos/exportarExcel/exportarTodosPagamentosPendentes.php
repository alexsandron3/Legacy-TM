<?php
    //VERIFICACAO DE SESSOES E INCLUDES NECESSARIOS E CONEXAO AO BANCO DE DADOS
    include_once("../../../includes/header.php");

   /* -----------------------------------------------------------------------------------------------------  */
  //SCRIPT PARA EXPORTAR ARQUIVO EXCEL

  

    $query = "  SELECT c.nomeCliente, c.idCliente, pp.idPagamento, pp.valorPendente, pp.previsaoPagamento, p.idPasseio, p.nomePasseio, p.dataPasseio 
                FROM pagamento_passeio pp, cliente c, passeio p 
                WHERE statusPagamento NOT IN (0,3) AND valorPendente < 0  AND c.idCliente = pp.idCliente AND p.idPasseio= pp.idPasseio ORDER BY nomeCliente
            ";
   /* -----------------------------------------------------------------------------------------------------  */
   $executaQuery = mysqli_query($conexao, $query);
  
  $dados = '';
  echo "NOME" . "\t". "PASSEIO" ."\t". "PENDENTE". "\t". "PREVISAO PAGAMENTO" . "\n";
   /* -----------------------------------------------------------------------------------------------------  */
  
  while($rowDados = mysqli_fetch_array($executaQuery)){
    $nomePasseio = $rowDados['nomePasseio'];
    $dataPasseio = date_create($rowDados['dataPasseio']);
    $tituloPasseio = "$nomePasseio " . date_format($dataPasseio, "d/m/Y"); 
    $filename = "PAGAMENTOS_PENDENTES_ ".date( "d/m/Y");
    $nomeCliente = $rowDados['nomeCliente'];
    $valorPendente = $rowDados['valorPendente'];
    $dataPrevisaoPagamento = '';
    if($rowDados['previsaoPagamento'] != "0000-00-00"){
        $previsaoPagamento =  date_create($rowDados['previsaoPagamento']);
        $dataPrevisaoPagamento = date_format($previsaoPagamento, "d/m/Y");
    }


    $dados = $nomeCliente . "\t" . $tituloPasseio . "\t" . number_format($valorPendente * -1.00, 2, '.', ''). "\t". $dataPrevisaoPagamento . "\t" . "\n"; 
    

    print $dados;

  }
  /* -----------------------------------------------------------------------------------------------------  */

header('Content-Encoding: UTF-8');
header('Content-type: text/csv; charset=UTF-8');
header('Content-Disposition: attachment; filename='.$filename.'.xls');
?> 

        


