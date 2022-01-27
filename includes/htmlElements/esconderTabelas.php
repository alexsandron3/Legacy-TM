<?php


function esconderTabela($quantidade){
    $contador = 1;
    while($contador <= $quantidade){
        if($contador != $quantidade){
            echo"<input type='hidden' class='hide_show'>";
        }else{
            
            echo"
                <input type='checkbox' class='hide_show' name='checkForm' id='checkForm'>
                <label class='form-check-label ' for='checkForm'>
                    <span class='ml-1'>Esconder Ações </span>          
                </label>
            ";
        }
        
        $contador++;
    }
}
?>