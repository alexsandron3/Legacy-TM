<?php
//VERIFICACAO DE SESSOES E INCLUDES NECESSARIOS E CONEXAO AO BANCO DE DADOS
include_once("./includes/header.php");

/* -----------------------------------------------------------------------------------------------------  */
$idPasseioGet = filter_input(INPUT_GET, 'id', FILTER_SANITIZE_NUMBER_INT);
/* -----------------------------------------------------------------------------------------------------  */

$queryBuscaPeloIdPasseio = "SELECT * FROM passeio p WHERE idPasseio='$idPasseioGet'";
$resultadoBuscaPasseio = mysqli_query($conexao, $queryBuscaPeloIdPasseio);
$rowBuscaPasseio = mysqli_fetch_assoc($resultadoBuscaPasseio);

$passeioAtivo = ($rowBuscaPasseio['statusPasseio'] == 1) ? "checked" : " ";
$passeioInativo = ($rowBuscaPasseio['statusPasseio'] == 0) ? "checked" : " ";

/* -----------------------------------------------------------------------------------------------------  */
?>
<!DOCTYPE html>
<html lang="PT-BR">

<head>
  <?php include_once("./includes/mdbcss.php"); ?>
  <title>EDITAR PASSEIO</title>
</head>

<body>
  <!-- INCLUSÃO DA NAVBAR -->
  <?php include_once("./includes/htmlElements/navbar.php"); ?>


  <div class="row py-5">
    <div class="col-md-10 mx-auto">
      <div class="card rounded shadow border-0">
        <p class="h2 text-center">EDIÇÃO DE PASSEIO</p>
        <div class="card-body p-5 bg-white rounded ">
          <!-- INCLUSÃO DE MENSAGENS DE ERRO E SUCESSO -->
          <?php include_once("./includes/servicos/servicoSessionMsg.php"); ?>
          <form action="SCRIPTS/atualizaPasseio.php" autocomplete="off" method="POST">
            <div class="form-row">
              <div class="col">
                <label class="col-form-label text-dark" for="nomePasseio">PASSEIO</label>
                <input type="text" class="block-form campos-de-texto form-control" name="nomePasseio" id="latinTextBox" placeholder="" required="required" value="<?php echo $rowBuscaPasseio['nomePasseio'] ?>" data-toggle="tooltip" data-placement="left" title="NOME DO PASSEIO" onkeydown="upperCaseF(this)">
              </div>
            </div>
            <div class="form-row my-4">
              <div class="col">
                <label class="col-form-label text-dark" for="localPasseio">LOCAL </label>
                <input type="text" class="block-form campos-de-texto form-control" name="localPasseio" id="LocalPasseiolatinTextBox" placeholder="" value="<?php echo $rowBuscaPasseio['localPasseio'] ?>" data-toggle="tooltip" data-placement="left" title="LOCAL DO PASSEIO" onkeydown="upperCaseF(this)">
              </div>
            </div>
            <div class="form-row my-4 justify-content-between">
              <div class="col-md-3">
                <label class="col-form-label text-dark" for="valorPasseio">VALOR DO PASSEIO</label>
                <input type="text" class="block-form campo-monetario form-control" name="valorPasseio" id="currencyTextBox" placeholder="VALOR DO PASSEIO" value="<?php echo $rowBuscaPasseio['valorPasseio'] ?>" data-toggle="tooltip" data-placement="top" title="VALOR DO PASSEIO">
              </div>
              <div class="col-md-3">
                <label class="col-form-label text-dark" for="lotacao"> LOTAÇÃO</label>
                <input type="number" min="1" max="200" class="block-form form-control" name="lotacao" id="intLimitTextBox" placeholder="1-200" value="<?php echo $rowBuscaPasseio['lotacao'] ?>" data-toggle="tooltip" data-placement="left" title="LOTAÇÃO DO PASSEIO" required="required">
              </div>
              <div class="col-md-3">
                <label class="col-form-label text-dark" for="idadeIsencao"> ISENÇÃO</label>
                <input type="number" min="0" max="99" class="block-form form-control" name="idadeIsencao" id="idadeIsencao" placeholder="0-99" required="required" value="<?php echo $rowBuscaPasseio['idadeIsencao'] ?>" data-toggle="tooltip" data-placement="left" title="IDADE MÍNIMA PARA ISENÇÃO" required="required">
              </div>
            </div>
            <div class="form-row my-4">
              <div class="col-lg-6">
                <label class="col-form-label text-dark mb-1 pt-3 " for="dataPasseio">DATA DO PASSEIO</label>
                <input type="date" class="block-form form-control col-lg-5 mt-4 pb-2" name="dataPasseio" id="dataPasseio" required="required" value="<?php echo $rowBuscaPasseio['dataPasseio'] ?>" data-toggle="tooltip" data-placement="left" title="DATA DE REALIZAÇÃO DO PASSEIO">
              </div>
              <div class="col-lg-6">
                <label class="col-form-label text-dark" for="anotacoesPasseio">ANOTAÇÕES</label>
                <textarea class="form-control" name="anotacoesPasseio" id="anotacoesPasseio" rows="3" value="" placeholder="" data-toggle="tooltip" data-placement="left" title="ANOTAÇÕES DO PASSEIO" onkeydown="upperCaseF(this)"> <?php echo $rowBuscaPasseio['anotacoes'] ?></textarea>
              </div>
            </div>


            <fieldset class='block-form form-group'>
              <div class='row'>
                <legend class='col-form-label col-sm-2 pt-0 text-muted'>STATUS DO PASSEIO</legend>
                <div class='col-sm-5 '>
                  <div class='col'>
                    <input class='form-check-input ' type='radio' name='statusPasseio' id='statusPasseioAtivo' value='1' <?php echo $passeioAtivo ?>>
                    <label class='form-check-label' for='statusPasseioAtivo'>
                      ATIVO
                    </label>
                  </div>
                  <div class='col'>
                    <input class='form-check-input' type='radio' name='statusPasseio' id='statusPasseioInativo' value='0' <?php echo $passeioInativo ?>>
                    <label class='form-check-label' for='statusPasseioInativo'>
                      ENCERRADO
                    </label>
                  </div>
                </div>
                <div class="col-lg-6">
                  <label class=" col-form-label text-dark pt-3" for="dataLancamentoPasseio">DATA DE LANÇAMENTO:</label>
                  <input type="date" class="block-form form-control col-lg-5  pb-2" name="dataLancamentoPasseio" id="dataLancamentoPasseio" required="required" data-toggle="tooltip" data-placement="left" title="DATA DE LANÇAMENTO DO PASSEIO" value="<?php echo $rowBuscaPasseio['dataLancamento'] ?>">
                </div>
            </fieldset>
            <input type="hidden" name="idPasseio" id="idPasseio" value="<?php echo $rowBuscaPasseio['idPasseio'] ?>">
            <button type="submit" name="cadastrarClienteBtn" id="submit" class="btn btn-info btn-lg">ATUALIZAR</button>
          </form>
        </div>
      </div>
    </div>
  </div>
  <?php include_once("./includes/mdbJs.php"); ?>
  <script src="config/novoScript.js"></script>
</body>

</html>