<?php



function mensagensSucessNoSession($texto){
    
    echo"
    <div class='alert alert-success text-center'>
        <div class='container'>
        <div class='alert-icon'>
            <i class='material-icons'>check</i>
        </div>
        <button type='button' class='close' data-dismiss='alert' aria-label='Close'>
            <span aria-hidden='true'><i class='material-icons'>clear</i></span>
        </button>
        <b></b> <h4> $texto</h4>

        </div>
    </div>";    

  }
function mensagensWarningNoSession($texto){
    
    echo"
    <div class='alert alert-warning text-center'>
        <div class='container'>
        <div class='alert-icon'>
            <i class='material-icons'>warning</i>
        </div>
        <button type='button' class='close' data-dismiss='alert' aria-label='Close'>
            <span aria-hidden='true'><i class='material-icons'>clear</i></span>
        </button>
        <b></b> <h4> $texto</h4>

        </div>
    </div>";    

  }
function mensagensDangerNoSession($texto){
    
    echo"
    <div class='alert alert-danger text-center'>
        <div class='container'>
        <div class='alert-icon'>
            <i class='material-icons'>danger</i>
        </div>
        <button type='button' class='close' data-dismiss='alert' aria-label='Close'>
            <span aria-hidden='true'><i class='material-icons'>clear</i></span>
        </button>
        <b></b> <h4> $texto</h4>

        </div>
    </div>";    

  }

function mensagensInfoNoSession($texto){
    
    echo"
    <div class='alert alert-info text-center'>
        <div class='container'>
        <div class='alert-icon'>
            <i class='material-icons'>info</i>
        </div>
        <button type='button' class='close' data-dismiss='alert' aria-label='Close'>
            <span aria-hidden='true'><i class='material-icons'>clear</i></span>
        </button>
        <b></b> <h4 class='text-secondary'> $texto</h4>

        </div>
    </div>";    

  }
