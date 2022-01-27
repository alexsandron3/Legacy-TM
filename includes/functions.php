<?php

    include_once("header.php");
    include_once("constantes.php");


    //Função parar GERAR LOG das atividades realizadas no sistema
    function gerarLog($tipo, $conexao, $idUser,  $nomeCliente, $nomePasseio, $dataPasseio, $valorPago, $tipoModificacao, $sinalDeFalhaNaOperacao ){
        $status = (mysqli_affected_rows($conexao) AND $sinalDeFalhaNaOperacao == 0)? "SUCESSO" : "FALHA";
        switch ($tipo){
            case "CLIENTE":
                $queryLog = "INSERT INTO log (idUser, nomeCliente , tipoModificacao) VALUES ($idUser, '$nomeCliente', ' $status AO $tipoModificacao O USUARIO')";
                $insertData = mysqli_query($conexao, $queryLog);
            break;
            case "PAGAMENTO";
                $queryLog = "INSERT INTO log (idUser, nomeCliente, nomePasseio, dataPasseio, valorPago, tipoModificacao ) VALUES ($idUser, '$nomeCliente', '$nomePasseio','$dataPasseio',  $valorPago,  '$status AO $tipoModificacao O PAGAMENTO')";
                $insertData = mysqli_query($conexao, $queryLog);
            break;                
            case "DESPESAS";
                $queryLog = "INSERT INTO log (idUser, nomePasseio, dataPasseio, tipoModificacao ) VALUES ($idUser, '$nomePasseio', '$dataPasseio',  '$status AO $tipoModificacao A DESPESA')";
                $insertData = mysqli_query($conexao, $queryLog);
            break;
            case "PASSEIO";
                $queryLog = "INSERT INTO log (idUser, nomePasseio, dataPasseio, tipoModificacao ) VALUES ($idUser, '$nomePasseio', '$dataPasseio',  '$status AO $tipoModificacao O PASSEIO')";
                $insertData = mysqli_query($conexao, $queryLog);
            break;
            case "DELETAR PAGAMENTO";
                $queryLog = "INSERT INTO log (idUser, nomeCliente, nomePasseio, dataPasseio, valorPago, tipoModificacao ) VALUES ($idUser, '$nomeCliente', '$nomePasseio','$dataPasseio',  $valorPago, '$status AO DELETAR O PAGAMENTO')";
                $insertData = mysqli_query($conexao, $queryLog);
            break;                
            case "DELETAR PASSEIO";
                $queryLog = "INSERT INTO log (idUser, nomePasseio, dataPasseio, tipoModificacao) VALUES ($idUser, '$nomePasseio', '$dataPasseio' ,'$status AO DELETAR O PASSEIO')";
                $insertData = mysqli_query($conexao, $queryLog);
            break;    
            
        }
        return $queryLog;
    }

    //Função de CADASTRO com REDIRECT
    function cadastro($query, $conexao, $tipoCadastro, $paginaRedirecionamento) {
        $executaQuery = mysqli_query($conexao, $query);
        $permissaoParaCadatrar    = retornaPermissao('cadastrar');
        if($permissaoParaCadatrar){
            if(mysqli_insert_id($conexao)){
                mensagensSucess("$tipoCadastro CADASTRADO(A) com sucesso");
                
                redirecionamento($paginaRedirecionamento, null);
            }else{
                mensagensWarning("$tipoCadastro NÃO foi CADASTRADO(A), alguma informação não foi inserida dentro dos padrões.");
                
                redirecionamento($paginaRedirecionamento, null);
            }
        }else{
            mensagensDanger("$tipoCadastro NÃO foi CADASTRADO(A), VOCÊ NÃO PODE REALIZAR ALTERAÇÕES DEVIDO A FALTA DE PERMISSÃO.");
            
            redirecionamento($paginaRedirecionamento, null);
        }

    }

    //Função de ATUALIZAÇÃO com REDIRECT
    function atualizar($query, $conexao, $tipoAtualizacao, $paginaRedirecionamento, $id){
        $executaQuery = mysqli_query($conexao, $query);
        $permissaoParaAtualizar    = retornaPermissao('atualizar');
        if($permissaoParaAtualizar){
            if(mysqli_affected_rows($conexao)){
                mensagensSucess("$tipoAtualizacao ATUALIZADO(A) com sucesso");
                
                redirecionamento($paginaRedirecionamento, $id);
                
            }else{
                mensagensWarning("$tipoAtualizacao não foi ATUALIZADO(A)");
                
                redirecionamento($paginaRedirecionamento, $id);

            }
        }else{
            mensagensDanger("$tipoAtualizacao NÃO foi ATUALIZADO(A), VOCÊ NÃO PODE REALIZAR ALTERAÇÕES DEVIDO A FALTA DE PERMISSÃO.");
            
            redirecionamento($paginaRedirecionamento, $id);
        }
    }

    //Função para DELETAR registros COM REDIRECT
    function apagar($query, $conexao, $tipoDelete, $idPagamento, $idPasseio, $paginaRedirecionamento){
        $permissaoParaApagar    = retornaPermissao('cadastrar');
        if($permissaoParaApagar){
            if(!empty($idPagamento OR $idPasseio)){
                $executaQuery = mysqli_query ($conexao, $query );
                if( mysqli_affected_rows($conexao)){
                    mensagensSucess("$tipoDelete APAGADO(A) com sucesso");
                    
                    redirecionamento($paginaRedirecionamento, $idPasseio);

                }else {
                    mensagensWarning("$tipoDelete NÃO foi APAGADO(A)");
                    
                    redirecionamento($paginaRedirecionamento, $idPasseio);


                }
            }else {
                mensagensInfo("Necessário selecionar um $tipoDelete");
                
                redirecionamento($paginaRedirecionamento, $idPasseio);


            }
        }else{
            mensagensDanger("$tipoDelete NÃO foi APAGADO(A), VOCÊ NÃO PODE REALIZAR ALTERAÇÕES DEVIDO A FALTA DE PERMISSÃO.");
            
            redirecionamento($paginaRedirecionamento, $idPasseio);


        }
    }

    //Função para APAGAR registros SEM REDIRECT
    function apagarRegistros ($conexao, $tabela, $condicao ){
        $query = "DELETE FROM $tabela WHERE $condicao";
        $deletar = mysqli_query($conexao, $query);
    }

    //Função de cálculo de idade do cliente
    function calcularIdade ($idCliente, $conn, $data = ""){
        $queryBuscaDataNascimento = "SELECT dataNascimento FROM cliente WHERE idCliente =$idCliente";
        $resultadoBuscaDataNascimento = $conn->query($queryBuscaDataNascimento);
        $rowBuscaDataNascimento = $resultadoBuscaDataNascimento ->fetch_assoc();
        
        if(empty($data)){
            $dataNascimento = new DateTime ($rowBuscaDataNascimento['dataNascimento']);
        }else{
            $dataNascimento = new DateTime($data);
        }
        $hoje           = new DateTime();
        $diferenca      = $hoje->diff($dataNascimento);
        $idade          = $diferenca->y;

        return $idade;

    }

    //Função para calcular intervalo de tempo
    function calculaIntervaloTempo ($conn, $coluna, $tabela, $condicao, $data = ""){
        
        
        if(empty($data)){
            $queryBuscaData = "SELECT $tabela FROM $coluna WHERE $condicao";
            $resultadoBuscaData = $conn->query($queryBuscaData);
            $rowBuscaData = $resultadoBuscaData ->fetch_assoc();
            $data = new DateTime($rowBuscaData['dataLog']);
            $dataHoje = new DateTime();

        }else{
            $data = new DateTime($data);

            $dataHoje = new DateTime();
        }

        $diferenca = $dataHoje->diff($data);
        $dias = $diferenca->d;
        return $diferenca;
    }
    function statusPagamento($valorPendenteCliente, $valorPago, $idadeCliente, $idadeIsencao, $clienteParceiro){
        $statusPagamento = null;
        if($idadeCliente <= $idadeIsencao){
            $statusPagamento = CLIENTE_CRIANCA;
        }elseif($clienteParceiro == 1){
            $statusPagamento = CLIENTE_PARCEIRO; 
            
        }else{
            if($valorPendenteCliente < 0 AND $valorPago == 0 AND $clienteParceiro == 0){
                $statusPagamento = CLIENTE_INTERESSADO; 

            }elseif( $valorPendenteCliente == 0){
                $statusPagamento = PAGAMENTO_QUITADO; 

            }elseif($valorPendenteCliente < 0 AND $valorPago > 0 AND $clienteParceiro == 0){
                $statusPagamento = CLIENTE_CONFIRMADO; 
    
            }elseif($clienteParceiro == 1){
                $statusPagamento = CLIENTE_PARCEIRO; 
                
            }
        }
        return $statusPagamento;
    }
    function identificarMes($data){
        $mesAtual = $data->format('n') -1;
        return MESES_DO_ANO[$mesAtual];
  
      }

    function verifyDate($data) {
        $dataObject = new stdClass();
        if(empty($data) || $data === '0000-00-00') {
            $dataObject->dateOriginal = false;
            $dataObject->dateFormated = false;
            $dataObject->isEmpty = true;
            return $dataObject;
        }else {
            $data = new DateTime(($data));
            $dataObject->dateOriginal = $data;
            $dataObject->dateFormated = $data->format('d/m/Y');
            $dataObject->isEmpty = false;
            return $dataObject;
        }
    }

    function dateDiff($inicialDate, $finalDate) {
        if ($inicialDate->isEmpty || $finalDate->isEmpty) {
            return 0;
        } else {
            $startDateOriginal = $inicialDate->dateOriginal;
            $finalDateOriginal = $finalDate->dateOriginal;
            $startDateOriginal->setTime(0,0);
            $finalDateOriginal->setTime(0,0);
            $diff = $startDateOriginal->diff($finalDateOriginal);
            $diff = $diff->format('%R%a');
            return abs($diff) +1;
        }
    }
?>