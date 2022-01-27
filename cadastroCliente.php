<?php
//VERIFICACAO DE SESSOES E INCLUDES NECESSARIOS E CONEXAO AO BANCO DE DADOS
include_once("./includes/header.php");

?>
<!DOCTYPE html>
<html lang="PT-BR">

<head>
<?php include_once("./includes/mdbcss.php"); ?>

  <title>CADASTRAR CLIENTE</title>
</head>

<body>
  <!-- INCLUSÃO DA NAVBAR -->
  <?php include_once("./includes/htmlElements/navbar.php"); ?>


  <div class="row py-5">
    <div class="col-md-10 mx-auto">
      <div class="card rounded shadow border-0">
        <p class="h2 text-center">CADASTRO DE CLIENTE</p>
        <div class="card-body p-5 bg-white rounded ">
          <!-- INCLUSÃO DE MENSAGENS DE ERRO E SUCESSO -->
          <?php include_once("./includes/servicos/servicoSessionMsg.php"); ?>
          <form action="SCRIPTS/registroCliente.php" autocomplete="off" method="POST">
            <div class="form-row">
              <div class="col">
                <label class=" col-form-label text-dark" for="nomeCliente">NOME: </label>
                <input type="text" class="block-form campos-de-texto form-control" name="nomeCliente" id="nomeCliente" required="required" onkeydown="upperCaseF(this)">
              </div>
            </div>

            <div class="form-row my-4">
              <div class="col">
                <label class="col-form-label text-dark" for="emailCliente">EMAIL: </label>
                <input type="email" class="block-form campo-de-email form-control" name="emailCliente" id="emailCliente" onkeydown="upperCaseF(this)">
              </div>
            </div>

            <div class="form-row my-4">
              <div class="col">
                <label class=" col-form-label text-dark" for="rgCliente">RG: </label>
                <input data-toggle="tooltip" data-placement="left" title="RG DO CLIENTE" type="text" class="block-form rg form-control" name="rgCliente" id="rgCliente">
              </div>
            </div>

            <div class="form-row my-4">
              <div class="col">
                <label class=" col-form-label text-dark" for="orgaoEmissor">EMISSOR: </label>
                <input type="text" class="block-form campos-de-texto form-control" name="orgaoEmissor" id="orgaoEmissor" autocomplete="ON" onkeydown="upperCaseF(this)">
              </div>
            </div>

            <div class="form-row my-4">
              <div class="col">
                <label class="  col-form-label text-dark" for="cpfCliente">CPF: </label>
                <input data-toggle="tooltip" data-placement="left" title="CPF DO CLIENTE" type="text" class="block-form form-control cpf " name="cpfCliente" id="cpfCliente">
              </div>
            </div>

            <div class="form-row my-4">
              <div class="col">
                <label class=" col-form-label text-dark" for="telefoneCliente">TELEFONE: </label>
                <input data-toggle="tooltip" data-placement="left" title="TELEFONE DO CLIENTE" type="text" class="block-form telefone form-control" name="telefoneCliente" id="telefoneCliente">
              </div>
            </div>

            <div class="form-row my-4">
              <div class="col">
                <label class="col-form-label text-dark" for="dataNascimento">NASCIMENTO: </label>
                <input type="date" class="block-form form-control col-6 " name="dataNascimento" id="dataNascimento" onblur="ageCount(dataNascimento.value)">
              </div>
            </div>

            <div class="form-row my-4">
              <div class="col">
                <label class=" col-form-label text-dark" for="idadeCliente">IDADE DO CLIENTE: </label>
                <input type="text" class="block-form form-control col-3" name="idadeCliente" id="idadeCliente" readonly="readonly" onblur="ageCount()">
              </div>
            </div>

            <div class="block-form form-row my-4">
              <div class="col">
                <label class="col-form-label text-dark" for="estadoCivil">ESTADO CIVIL</label>
                <select class="form-control col-6" id="estadoCivil" name="estadoCivil">
                  <option>Solteiro(a)</option>
                  <option>Casado(a)</option>
                  <option>Divorciado(a)</option>
                  <option>Viúvo(a)</option>
                  <option>Separado(a)</option>
                </select>
              </div>
            </div>

            <div class="form-row my-4">
              <div class="col">
                <label class="col-form-label text-dark" for="profissao">PROFISSÃO</label>
                <input type="text" class="block-form campos-de-texto form-control col-6" id="profissao" name="profissao" onkeydown="upperCaseF(this)">
              </div>
            </div>

            <div class="form-row my-4">
              <div class="col">
                <label class="col-form-label text-dark" for="nacionalidade">NACIONALIDADE</label>
                <input type="text" class="block-form campos-de-texto form-control col-6" id="nacionalidade" name="nacionalidade" onkeydown="upperCaseF(this)">
              </div>
            </div>
            <div class="form-row my-4">
              <div class="col">
                <label class="col-form-label text-dark" for="poltrona">POLTRONA</label>
                <input type="text" class="block-form text-area form-control col-6" id="poltrona" name="poltrona" value="" onkeydown="upperCaseF(this)">
              </div>
            </div>
            <fieldset class="block-form form-group">
              <div class="row">
                <label class="col-form-label text-dark col-lg-3 pt-0 text-dark">CPF CONSULTADO: </label>
                <div class="col">
                  <input class="form-check-input" type="radio" name="cpfConsultado" id="cpfConsultadoSim" value="1" onclick="changeInputDate()">
                  <label class="form-check-label text-dark" for="cpfConsultadoSim">
                    SIM
                  </label>
                  <div class="col-1 p-0 m-0">
                    <input class="form-check-input" type="radio" name="cpfConsultado" id="cpfConsultadoNao" value="0" onclick="changeInputDate()">
                    <label class="form-check-label text-dark" for="cpfConsultadoNao">
                      NÃO
                    </label>

                  </div>
                </div>
                <div class="col">
                  <label class=" col-form-label text-dark" for="dataCpfConsultado">DATA DA CONSULTA: </label>
                  <input type="date" class="block-form form-control" name="dataCpfConsultado" id="dataCpfConsultado" onclick="setInputDate()">
                </div>
              </div>
            </fieldset>

            <div class="form-group">
              <div class="row">
                <div class="col-6">
                  <label class="col-form-label text-dark" for="enderecoCliente">ENDEREÇO: </label>
                  <textarea data-toggle="tooltip" data-placement="left" title="ENDEREÇO DO CLIENTE" class="text-area form-control" name="enderecoCliente" id="enderecoCliente" rows="3" onkeydown="upperCaseF(this)"></textarea>
                </div>
                <div class="col-6">
                  <label class="col-form-label text-dark" for="referenciaCliente">REFERÊNCIA: </label>
                  <textarea class="text-area form-control" name="referenciaCliente" id="referenciaCliente" rows="3" onkeydown="upperCaseF(this)"></textarea>
                </div>
              </div>
              <div class="block-form form-group row">
                <div class="col">
                  <label class=" col-form-label text-dark" for="telefoneContato">TELEFONE PARA CONTATO: </label>
                  <input class="telefone form-control " type="tel" name="telefoneContato" id="telefoneContato" data-toggle="tooltip" data-placement="left" title="TELEFONE PARA CONTATO">
                </div>
                <div class="col">
                  <label class=" col-form-label text-dark" for="nomeContato">QUEM CONTATAR: </label>
                  <input class="form-control campos-de-texto" type="text" name="nomeContato" id="nomeContato" data-toggle="tooltip" data-placement="left" title="QUEM CONTATAR" onkeydown="upperCaseF(this)">
                </div>
              </div>
              <div class="form-group row">
                <div class="col">
                  <label class="col-form-label text-dark" for="redeSocial">REDES SOCIAIS: </label>
                  <textarea class="form-control " name="redeSocial" id="redeSocial" cols="3" rows="1" onkeydown="upperCaseF(this)"></textarea>
                </div>
                <div class="col">
                  <div class="row">
                    <label class="col-form-label text-dark">REDES SOCIAIS: </label>
                    <div class="col ml-5">
                      <input class="form-check-input" type="radio" name="clienteRedeSocial" id="clienteRedeSocialSim" value="1">
                      <label class="form-check-label text-dark" for="clienteRedeSocialSim">
                        SIM
                      </label>
                      <div class="col-1 p-0 m-0">
                        <input class="form-check-input" type="radio" name="clienteRedeSocial" id="clienteRedeSocialNao" value="0">
                        <label class="form-check-label text-dark" for="clienteRedeSocialNao">
                          NÃO
                        </label>

                      </div>
                    </div>
                  </div>
                </div>
              </div>
              <button type="submit" name="cadastrarClienteBtn" id="submit" class="btn btn-info btn-md">CADASTRAR</button>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
  <?php include_once("./includes/mdbJs.php"); ?>
  <script src="config/novoScript.js"></script>
</body>

</html>