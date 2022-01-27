<?php
//VERIFICACAO DE SESSOES E INCLUDES NECESSARIOS E CONEXAO AO BANCO DE DADOS
include_once("./includes/header.php");

?>
<!DOCTYPE html>
<html lang="PT-BR">

<head>
  <?php include_once("./includes/mdbcss.php"); ?>

  <title>CADASTRAR PASSEIO</title>
</head>

<body>
  <!-- INCLUSÃO DA NAVBAR -->
  <?php include_once("./includes/htmlElements/navbar.php"); ?>

  <!-- INCLUSÃO DE MENSAGENS DE ERRO E SUCESSO -->
  <?php include_once("./includes/servicos/servicoMensagens.php"); ?>


  <div class="row py-5">
    <div class="col-md-10 mx-auto">
      <div class="card rounded shadow border-0">
        <p class="h2 text-center">CADASTRO DE PASSEIO</p>

        <!-- INCLUSÃO DE MENSAGENS DE ERRO E SUCESSO -->
        <?php include_once("./includes/servicos/servicoSessionMsg.php"); ?>
        <div class="card-body p-5 bg-white rounded ">
          <form action="SCRIPTS/registroPasseio.php" autocomplete="off" method="POST">
            <div class="form-row">
              <div class="col">
                <label class=" col-form-label text-dark" for="nomeCliente">PASSEIO: </label>
                <input type="text" class="block-form campos-de-texto form-control" name="nomePasseio" id="nomePasseio" placeholder="" required="required" data-toggle="tooltip" data-placement="left" title="NOME DO PASSEIO" onkeydown="upperCaseF(this)">
              </div>
            </div>
            <div class="form-row my-4">
              <div class="col">
                <label class=" col-form-label text-dark" for="nomeCliente">LOCAL: </label>
                <input type="text" class="block-form campos-de-texto form-control" name="localPasseio" id="LocalPasseiolatinTextBox" data-toggle="tooltip" data-placement="left" title="LOCAL DO PASSEIO" onkeydown="upperCaseF(this)">
              </div>
            </div>
            <div class="form-row my-4 justify-content-between">
              <div class="col-md-3">
                <label class="col-form-label text-dark" for="valorPasseio">VALOR DO PASSEIO:</label>
                <input type="text" class="block-form campo-monetario form-control" name="valorPasseio" id="valorPasseio" placeholder="VALOR DO PASSEIO" value="0" data-toggle="tooltip" data-placement="top" title="VALOR DO PASSEIO">
              </div>
              <div class="col-md-3">
                <label class=" col-form-label text-dark" for="lotacao"> LOTAÇÃO:</label>
                <input type="number" min="1" max="200" class="block-form form-control" name="lotacao" id="intLimitTextBox" placeholder="1-200" data-toggle="tooltip" data-placement="left" title="LOTAÇÃO DO PASSEIO" required="required">
              </div>
              <div class="col-md-3">
                <label class=" col-form-label text-dark" for="idadeIsencao"> ISENÇÃO:</label>
                <input type="number" min="0" max="99" class="block-form form-control" name="idadeIsencao" id="idadeIsencao" placeholder="0-99" data-toggle="tooltip" data-placement="left" title="IDADE MÍNIMA PARA ISENÇÃO" required="required">
              </div>
            </div>
            <div class="form-row my-4">
              <div class="col-lg-6">
                <label class=" col-form-label text-dark mb-1 pt-3" for="dataPasseio">DATA DO PASSEIO:</label>
                <input type="date" class="block-form form-control col-lg-5 mt-4 pb-2" name="dataPasseio" id="dataPasseio" required="required" onblur="verificaDataPasseio()" data-toggle="tooltip" data-placement="left" title="DATA DE REALIZAÇÃO DO PASSEIO">
              </div>
              <div class="col-lg-6">
                <label class=" col-form-label text-dark" for="nomeCliente">ANOTAÇÕES: </label>
                <textarea class="form-control" name="anotacoesPasseio" id="anotacoesPasseio" rows="3" data-toggle="tooltip" data-placement="left" title="ANOTAÇÕES DO PASSEIO" onkeydown="upperCaseF(this)"></textarea>
              </div>
            </div>
            <div class="form-row my-4">

            </div>
            <fieldset class='block-form form-group'>
              <div class='row'>
                <legend class='col-form-label col-sm-2 pt-0 text-dark'>STATUS DO PASSEIO:</legend>
                <div class='col-sm-5 '>
                  <div class='col'>
                    <input class='form-check-input ' type='radio' name='statusPasseio' id='statusPasseioAtivo' value='1' checked>
                    <label class='form-check-label' for='statusPasseioAtivo'>
                      ATIVO
                    </label>
                  </div>
                  <div class='col'>
                    <input class='form-check-input' type='radio' name='statusPasseio' id='statusPasseioInativo' value='0'>
                    <label class='form-check-label' for='statusPasseioInativo'>
                      INATIVO
                    </label>
                  </div>
                </div>
                <div class="col-lg-6">
                  <label class=" col-form-label text-dark pt-3" for="dataLancamentoPasseio">DATA DE LANÇAMENTO:</label>
                  <input type="date" class="block-form form-control col-lg-5  pb-2" name="dataLancamentoPasseio" id="dataLancamentoPasseio" required="required" data-toggle="tooltip" data-placement="left" title="DATA DE LANÇAMENTO DO PASSEIO">
                </div>
            </fieldset>

            <button type="submit" name="cadastrarClienteBtn" id="submit" class="btn btn-info btn-lg">CADASTRAR</button>
          </form>
        </div>
      </div>
    </div>
  </div>
  <?php include_once("./includes/mdbJs.php"); ?>
  <script src="config/novoScript.js"></script>
</body>

</html>