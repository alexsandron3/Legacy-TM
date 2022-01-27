<?php
    //CHARSET

use Dotenv\Dotenv;

header("Content-type: text/html; charset=utf-8");

    // VERIFICAÇÃO DE SESSÃO
    if(!isset($_SESSION)) 
    { 
        session_start(); 
    } 
    // VERIFICANDO SE USUÁRIO ESTÁ LOGADO
    if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
        header("location: login.php");
        exit;
    }
    // use Dotenv\Dotenv;

    require  __DIR__.'../../vendor/autoload.php';
    
    $dotenv = \Dotenv\Dotenv::createImmutable(__DIR__);
    $dotenv->load();

    //ARQUIVOS NECESSÁRIOS PARA UM INCLUDE
    include_once("conexao.php");
    include_once("pdoCONEXAO.php");
    include_once("functions.php");
    include_once("servicos/servicoValidacaoPermissao.php");
    include_once("servicos/servicoRedirecionamento.php");
    include_once("servicos/servicoMsgText.php");
    include_once("servicos/servicoMensagens.php");
    include_once("constantes.php");
    include_once("htmlElements/esconderTabelas.php"); 


?>