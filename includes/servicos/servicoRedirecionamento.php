<?php


    function redirecionamento($paginaRedirecionamento, $id){
        if(!empty($paginaRedirecionamento)){
            if(empty($id)){
                header("refresh:3.0; url=../$paginaRedirecionamento.php");
            }else{
                header("refresh:3.0; url=../$paginaRedirecionamento.php?id=$id");

            }
        }else{
            header("refresh:3.0; url=../index.php");
            
        }
    }



?>