<?php
//VERIFICACAO DE SESSOES E INCLUDES NECESSARIOS E CONEXAO AO BANCO DE DADOS
include_once("./includes/header.php");

/* -----------------------------------------------------------------------------------------------------  */
$idClienteGet = filter_input(INPUT_GET, 'id', FILTER_SANITIZE_NUMBER_INT);
/* -----------------------------------------------------------------------------------------------------  */
$queryBuscaPeloIdCliente = "SELECT * FROM cliente WHERE idCliente='$idClienteGet'";
$resultadoBuscaPeloIdCliente = mysqli_query($conexao, $queryBuscaPeloIdCliente);
$rowResultadoBuscaPeloIdCliente = mysqli_fetch_assoc($resultadoBuscaPeloIdCliente);
/* -----------------------------------------------------------------------------------------------------  */
?>
<!DOCTYPE html>
<html lang="PT-BR">

<head>
  <?php include_once("./includes/mdbcss.php"); ?>

  <title>EDITAR CLIENTE</title>
</head>

<body>
  <!-- INCLUSÃO DA NAVBAR -->
  <?php include_once("./includes/htmlElements/navbar.php"); ?>

  <div class="row py-5">
    <div class="col-md-10 mx-auto">
      <div class="card rounded shadow border-0">
        <p class="h2 text-center">EDIÇÃO DE CLIENTE</p>
        <div class="card-body p-5 bg-white rounded ">
          <!-- INCLUSÃO DE MENSAGENS DE ERRO E SUCESSO -->
          <?php include_once("./includes/servicos/servicoSessionMsg.php"); ?>
          <form action="SCRIPTS/atualizaCliente.php" autocomplete="off" method="POST">
            <input type="hidden" name="idCliente" id="idCliente" value="<?php echo $rowResultadoBuscaPeloIdCliente['idCliente'] ?>">

            <div class="form-row">
              <div class="col">
                <label class=" col-form-label text-dark" for="nomeCliente">NOME: </label>
                <input type="text" class="block-form campos-de-texto form-control" name="nomeCliente" id="nomeCliente" value="<?php echo $rowResultadoBuscaPeloIdCliente['nomeCliente']; ?>" onkeydown="upperCaseF(this)">
              </div>
            </div>
            <div class="form-row my-4">
              <div class="col">
                <label class=" col-form-label text-dark" for="emailCliente">EMAIL: </label>
                <input type="email" class="block-form campo-de-email form-control" name="emailCliente" id="emailCliente" value="<?php echo $rowResultadoBuscaPeloIdCliente['emailCliente']; ?>" onkeydown="upperCaseF(this)">
              </div>
            </div>
            <div class="form-row my-4">
              <div class="col">
                <label class=" col-form-label text-dark" for="rgCliente">RG: </label>
                <input type="text" class="block-form rg form-control" name="rgCliente" id="rgCliente" value="<?php echo $rowResultadoBuscaPeloIdCliente['rgCliente']; ?>" data-toggle="tooltip" data-placement="left" title="RG DO CLIENTE">
              </div>
            </div>
            <div class="form-row my-4">
              <div class="col">
                <label class=" col-form-label text-dark" for="orgaoEmissor">EMISSOR: </label>

                <input type="text" class="block-form campos-de-texto form-control" name="orgaoEmissor" id="orgaoEmissor" autocomplete="ON" value="<?php echo $rowResultadoBuscaPeloIdCliente['orgaoEmissor']; ?>" onkeydown="upperCaseF(this)">
              </div>
            </div>
            <div class="form-row my-4">
              <div class="col">
                <label class=" col-form-label text-dark" for="cpfCliente">CPF: </label>
                <input type="text" class="block-form cpf form-control " name="cpfCliente" id="cpfCliente" value="<?php echo $rowResultadoBuscaPeloIdCliente['cpfCliente']; ?>" data-toggle="tooltip" data-placement="left" title="CPF DO CLIENTE">
              </div>
            </div>
            <div class="form-row my-4">
              <div class="col">
                <label class="col-form-label text-dark" for="telefoneCliente">TELEFONE: </label>
                <input type="text" class="block-form telefone form-control" name="telefoneCliente" id="telefoneCliente" value="<?php echo $rowResultadoBuscaPeloIdCliente['telefoneCliente']; ?>" data-toggle="tooltip" data-placement="left" title="TELEFONE DO CLIENTE">
              </div>
            </div>
            <div class="form-row my-4">
              <div class="col">
                <label class="col-form-label" for="dataNascimento">NASCIMENTO</label>

                <input type="date" class="block-form form-control col-6" name="dataNascimento" id="dataNascimento" value="<?php echo $rowResultadoBuscaPeloIdCliente['dataNascimento']; ?>" onblur="ageCount(dataNascimento.value)">
              </div>
            </div>

            <div class="form-row my-4">
              <div class="col">
                <label class=" col-form-label" for="idadeCliente">IDADE DO CLIENTE</label>
                <div class="col">
                </div>
                <input type="text" class="block-form form-control col-3" name="idadeCliente" id="idadeCliente" readonly="readonly" onblur="ageCount()">
              </div>
            </div>
            <div class="block-form form-row my-4">
              <div class="col">
                <label class="col-form-label text-dark" for="estadoCivil">ESTADO CIVIL</label>
                <select class="form-control col-6" id="estadoCivil" name="estadoCivil">
                  <option><?php echo $rowResultadoBuscaPeloIdCliente['estadoCivil'] ?></option>
                  <option>------------------------------------------------</option>
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
                <input type="text" class="block-form text-area form-control col-6" id="profissao" name="profissao" value="<?php echo $rowResultadoBuscaPeloIdCliente['profissao'] ?>" onkeydown="upperCaseF(this)">
              </div>
            </div>

            <div class="form-row my-4">
              <div class="col">
                <label class="col-form-label text-dark" for="nacionalidade">NACIONALIDADE</label>
                <input type="text" class="block-form campos-de-texto form-control col-6" id="nacionalidade" name="nacionalidade" value="<?php echo $rowResultadoBuscaPeloIdCliente['nacionalidade'] ?>" onkeydown="upperCaseF(this)">
              </div>
            </div>
            <div class="form-row my-4">
              <div class="col">
                <label class="col-form-label text-dark" for="poltrona">POLTRONA</label>
                <input type="text" class="block-form text-area form-control col-6" id="poltrona" name="poltrona" value="<?php echo $rowResultadoBuscaPeloIdCliente['poltrona'] ?>" onkeydown="upperCaseF(this)">
              </div>
            </div>
            <fieldset class="block-form form-group">
              <div class="row">
                <legend class="col-form-label col-3 pt-0 ">CPF CONSULTADO</legend>
                <div class="col ">
                  <?php
                  if ($rowResultadoBuscaPeloIdCliente['cpfConsultado'] == 1) { ?>

                    <div class='ml-3'>
                      <input class='form-check-input ' type='radio' name='cpfConsultado' id='cpfConsultadoSim' value='1' checked>
                      <label class='form-check-label' for='cpfConsultadoSim'>
                        SIM
                      </label>
                    </div>
                    <div class='ml-3'>
                      <input class='form-check-input' type='radio' name='cpfConsultado' id='cpfConsultadoNao' value='0'>
                      <label class='form-check-label' for='cpfConsultadoNao'>
                        NÃO
                      </label>
                    </div>
                  <?php
                  } else { ?>

                    <div class='ml-3'>
                      <input class='form-check-input' type='radio' name='cpfConsultado' id='cpfConsultadoSim' value='1' onclick="changeInputDate()">
                      <label class='form-check-label' for='cpfConsultadoSim'>
                        SIM
                      </label>
                    </div>
                    <div class='ml-3'>
                      <input class='form-check-input' type='radio' name='cpfConsultado' id='cpfConsultadoNao' value='0' onclick="changeInputDate()" checked>
                      <label class='form-check-label' for='cpfConsultadoNao'>
                        NÃO
                      </label>
                    </div>
                  <?php } ?>

                </div>
                <div class="col">
                  <label class=" col-form-label" for="dataCpfConsultado ">DATA DA CONSULTA</label>
                  <input type="date" class="block-form form-control" name="dataCpfConsultado" id="dataCpfConsultado" onclick="setInputDate()" value="<?php echo $rowResultadoBuscaPeloIdCliente['dataCpfConsultado'] ?>">
                </div>
              </div>
            </fieldset>

            <div class="form-group my-4">
              <div class="row">
                <div class="col-6">
                  <label class="col-form-label text-dark" for="enderecoCliente">ENDEREÇO: </label>
                  <textarea class="text-area form-control" name="enderecoCliente" id="enderecoCliente" rows="3" data-toggle="tooltip" data-placement="left" title="ENDEREÇO DO CLIENTE" onkeydown="upperCaseF(this)"><?php echo $rowResultadoBuscaPeloIdCliente['enderecoCliente'] ?></textarea>
                </div>
                <div class="col-6">
                  <label class="col-form-label text-dark" for="referenciaCliente">REFERÊNCIA: </label>
                  <textarea class="text-area form-control" name="referenciaCliente" id="referenciaCliente" rows="3" onkeydown="upperCaseF(this)"> <?php echo $rowResultadoBuscaPeloIdCliente['referencia'] ?> </textarea>
                </div>
              </div>
            </div>

            <div class="form-group row my-4">
              <div class="col">
                <label class=" col-form-label text-dark" for="telefoneContato">TELEFONE PARA CONTATO: </label>
                <input data-toggle="tooltip" data-placement="left" title="TELEFONE PARA CONTATO" class="block-form telefone form-control " type="tel" name="telefoneContato" id="telefoneContato" value="<?php echo $rowResultadoBuscaPeloIdCliente['telefoneContato']; ?>">
              </div>
              <div class="col">
                <label class=" col-form-label text-dark" for="nomeContato">QUEM CONTATAR: </label>
                <input class="block-form campos-de-texto form-control" type="text" name="nomeContato" id="nomeContato" value="<?php echo $rowResultadoBuscaPeloIdCliente['pessoaContato']; ?>" data-toggle="tooltip" data-placement="left" title="QUEM CONTATAR" onkeydown="upperCaseF(this)">
              </div>
            </div>

            <div class="form-group row">
              <div class="col">
                <label class="col-form-label text-dark" for="redeSocial">REDES SOCIAIS: </label>
                <textarea class="text-area form-control " name="redeSocial" id="redeSocial" cols="10" rows="5" onkeydown="upperCaseF(this)"> <?php echo $rowResultadoBuscaPeloIdCliente['redeSocial'] ?></textarea>
              </div>
              <div class="col">
                <div class="row">
                  <label class="col-form-label text-dark ">REDES SOCIAIS</legend>
                    <?php
                    if ($rowResultadoBuscaPeloIdCliente['clienteRedeSocial'] == 1) { ?>
                      <div class="col ml-5">
                        <input class="form-check-input" type="radio" name="clienteRedeSocial" id="clienteRedeSocialSim" value="1" checked>
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
                    <?php
                    } else { ?>
                      <div class="col ml-5">
                        <input class="form-check-input" type="radio" name="clienteRedeSocial" id="clienteRedeSocialSim" value="1">
                        <label class="form-check-label text-dark" for="clienteRedeSocialSim">
                          SIM
                        </label>
                        <div class="col-1 p-0 m-0">
                          <input class="form-check-input" type="radio" name="clienteRedeSocial" id="clienteRedeSocialNao" value="0" checked>
                          <label class="form-check-label text-dark" for="clienteRedeSocialNao">
                            NÃO
                          </label>

                        </div>
                      </div>
                    <?php } ?>
                </div>
              </div>
            </div>

            <button type="submit" name="cadastrarClienteBtn" id="submit" class="btn btn-info btn-md">ATUALIZAR</button>
            <!-- Button trigger modal -->
            <button type="button" class="btn btn-info" data-bs-toggle="modal" data-bs-target="#exampleModal">
              HISTÓRICO
            </button>

            <!-- Modal -->
            <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
              <div class="modal-dialog">
                <div class="modal-content">
                  <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">PAGAMENTOS DESTE CLIENTE</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                  </div>
                  <div class="modal-body">
                    <table class="table table-hover table-dark">
                      <thead>
                        <tr>
                          <th>PASSEIO</th>
                          <th>DATA</th>
                          <th>STATUS</th>
                        </tr>
                      </thead>
                      <tbody>

                        <?php
                        $queryBuscaPagamentoCliente = "SELECT pp.idPasseio, pp.statusPagamento, p.nomePasseio, p.dataPasseio FROM pagamento_passeio pp, passeio p WHERE idCliente=$idClienteGet AND pp.idPasseio=p.idPasseio ORDER BY p.dataPasseio DESC ";
                        $resultadoBuscaPagamentoCliente = mysqli_query($conexao, $queryBuscaPagamentoCliente);
                        while ($rowPagamentoCliente = mysqli_fetch_assoc($resultadoBuscaPagamentoCliente)) {
                          $dataPasseio =  date_create($rowPagamentoCliente['dataPasseio']);
                          if ($rowPagamentoCliente['statusPagamento'] == 0) {
                            $statusPagamento = "QUITADO";
                          } else {
                            $statusPagamento = "NÃO QUITADO";
                          }
                        ?>
                          <tr>
                            <th><?php echo $rowPagamentoCliente['nomePasseio'] . "</br>"; ?></th>
                            <td><?php echo date_format($dataPasseio, "d/m/Y") . "</br>"; ?></td>
                            <td><?php echo $statusPagamento . "</br>"; ?></td>
                          </tr>
                        <?php
                        }
                        ?>
                      </tbody>
                    </table>
                  </div>
                  <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fechar</button>
                  </div>
                </div>
              </div>
            </div>
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