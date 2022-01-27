<?php
    
        if(!isset($_SESSION)) 
        { 
            session_start(); 
        } 

    function validarNivelAceso(){
        if($_SESSION['nivelAcesso'] == ADMINISTRADOR ){
            $operacoesPermitidas = array(
                "gerarLog"      => true,
                "cadastrar"     => true,
                "atualizar"     => true,
                "visualizar"    => true,
                "apagar"        => true,
                "transferir"    => true,
                "visualizarLog" => true

            );

            
        }else if ($_SESSION['nivelAcesso'] == USUARIO_CHEFE){
            $operacoesPermitidas = array(
                "gerarLog"      => true,
                "cadastrar"     => true,
                "atualizar"     => true,
                "visualizar"    => true,
                "apagar"        => true,
                "transferir"    => true,
                "visualizarLog" => false

            );
        }else if ($_SESSION['nivelAcesso'] == USUARIO_SIMPLES){
            $operacoesPermitidas = array(
                "gerarLog"      => true,
                "cadastrar"     => false,
                "atualizar"     => false,
                "visualizar"    => true,
                "apagar"        => false,
                "transferir"    => false,
                "visualizarLog" => false

            );
        }
        return $operacoesPermitidas;
    }
    
    function retornaPermissao ($opcao){
        $operacoesPermitidas = validarNivelAceso();
        switch ($opcao) {
            case 'gerarLog':
                $permissao = $operacoesPermitidas ['gerarLog'];
                $permissao = ($permissao == true) ?  $permissao = true:  $permissao = false;
                
            
            case 'cadastrar':
                $permissao = $operacoesPermitidas ['cadastrar'];
                $permissao = ($permissao == true) ?  $permissao = true:  $permissao = false;
                break;

            case 'atualizar':
                $permissao = $operacoesPermitidas ['atualizar'];
                $permissao = ($permissao == true) ?  $permissao = true:  $permissao = false;
                break;                
            
            case 'visualizar':
                $permissao = $operacoesPermitidas ['visualizar'];
                $permissao = ($permissao == true) ?  $permissao = true:  $permissao = false;
                break;                
            
            case 'apagar':
                $permissao = $operacoesPermitidas ['apagar'];
                $permissao = ($permissao == true) ?  $permissao = true:  $permissao = false;
                break;                
            
            case 'transferir':
                $permissao = $operacoesPermitidas ['transferir'];
                $permissao = ($permissao == true) ?  $permissao = true:  $permissao = false;
                break;                
            
            case 'visualizarLog':
                $permissao = $operacoesPermitidas ['visualizarLog'];
                $permissao = ($permissao == true) ?  $permissao = true:  $permissao = false;
                break;
            default:
                $permissao = false;
            break;
        
        }
    return $permissao;
          
    }






