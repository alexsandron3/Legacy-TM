<?php
function mensagensSucess($texto){
    
  $_SESSION['msg'] ="
  <div class='alert alert-success'>
      <div class='container'>
      <div class='alert-icon'>
          <i class='material-icons'>check</i>
      </div>
      <button type='button' class='close' data-dismiss='alert' aria-label='Close'>
          <span aria-hidden='true'><i class='material-icons'>clear</i></span>
      </button>
      <b></b><h4> $texto</h4>

      </div>
  </div>";    

}
function mensagensWarning($texto){
  
  $_SESSION['msg'] ="
  <div class='alert alert-warning'>
      <div class='container'>
      <div class='alert-icon'>
          <i class='material-icons'>warning</i>
      </div>
      <button type='button' class='close' data-dismiss='alert' aria-label='Close'>
          <span aria-hidden='true'><i class='material-icons'>clear</i></span>
      </button>
      <b></b><h4> $texto</h4>

      </div>
  </div>";    

}
function mensagensDanger($texto){
  
  $_SESSION['msg'] ="
  <div class='alert alert-danger'>
      <div class='container'>
      <div class='alert-icon'>
          <i class='material-icons'>danger</i>
      </div>
      <button type='button' class='close' data-dismiss='alert' aria-label='Close'>
          <span aria-hidden='true'><i class='material-icons'>clear</i></span>
      </button>
      <b></b><h4> $texto</h4>

      </div>
  </div>";    

}

function mensagensInfo($texto){
  
  $_SESSION['msg'] ="
  <div class='alert alert-info'>
      <div class='container'>
      <div class='alert-icon'>
          <i class='material-icons'>info</i>
      </div>
      <button type='button' class='close' data-dismiss='alert' aria-label='Close'>
          <span aria-hidden='true'><i class='material-icons'>clear</i></span>
      </button>
      <b></b><h4> $texto</h4>

      </div>
  </div>";    

}

  ?>