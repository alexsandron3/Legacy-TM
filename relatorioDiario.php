<?php
//VERIFICACAO DE SESSOES E INCLUDES NECESSARIOS E CONEXAO AO BANCO DE DADOS
include_once("./includes/header.php");
// 
?>

<!DOCTYPE html>
<html lang="en">

<head>
<?php include_once("./includes/mdbcss.php"); ?>
  <title>RELATÓRIO DE VENDAS</title>
</head>

<body>
  <!-- INCLUSÃO DA NAVBAR -->
  <?php include_once("./includes/htmlElements/navbar.php"); ?>
  <div class="row py-3 container-fluid">
    <div class="col-md-10 mx-auto">
      <div class="card rounded shadow border-0">
        <!-- INCLUSÃO DE MENSAGENS DE ERRO E SUCESsSO -->
        <?php include_once("./includes/servicos/servicoSessionMsg.php"); ?>
        <div class="card-body p-5 bg-white rounded">
          <p class="h2 text-center">RELATÓRIO DE VENDAS</p>
          <form action='' method='GET' autocomplete='OFF'>
            <div class="form-row">

              <div class="col">
                <input data-toggle="tooltip" data-placement="top" title="SELECIONE O INÍCIO DO PERÍODO" type='date' class='form-control' name='inicioDataPasseio' id='inicioDataPasseio' value="">
              </div>

              <div class="col">
                <input data-toggle="tooltip" data-placement="top" title="SELECIONE O FIM DO PERÍODO" type='date' class='form-control' name='fimDataPasseio' id='fimDataPasseio' value="">
              </div>

            </div>
            <div class="form-row">
              <div class="col">
                <input type='submit' class='btn btn-info btn-md' value='CARREGAR INFORMAÇÕES' name='buttonEviaDataPasseio' id="buttonEviaDataPasseio">
              </div>
            </div>
            <p class="text-center" id="refreshText"> </p>
          </form>
          <div class="table-responsive mt-3">
            <table style="width:100%" class="table table-striped table-bordered" id="relatorioVendasTable">
              <thead>
                <tr>
                  <th scope="col">PASSEIO</th>
                  <th scope="col">DATA</th>
                  <th scope="col">Nº VENDAS</th>
                  <th scope="col">VALOR VENDA</th>
                  <th scope="col">VALOR PAGO</th>
                </tr>
              </thead>
              <tbody id="tbodyTeste">

              </tbody>
          </div>
        </div>
      </div>
    </div>
  </div>

  <script type="text/javascript" src="./includes/MDB/js/mdb.min.js"></script>

<!-- DATATABLES -->
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/pdfmake.min.js"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/vfs_fonts.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/v/dt/jq-3.3.1/jszip-2.5.0/dt-1.11.1/af-2.3.7/b-2.0.0/b-colvis-2.0.0/b-html5-2.0.0/b-print-2.0.0/cr-1.5.4/date-1.1.1/fc-3.3.3/fh-3.1.9/kt-2.6.4/r-2.2.9/rg-1.1.3/rr-1.2.8/sc-2.0.5/sb-1.2.0/sp-1.4.0/sl-1.3.3/datatables.min.js"></script>
<script src="//cdnjs.cloudflare.com/ajax/libs/moment.js/2.11.2/moment.min.js"></script>
<script src="//cdn.datatables.net/plug-ins/1.10.12/sorting/datetime-moment.js"></script>

<script type="text/javascript" src="https://momentjs.com/downloads/moment-with-locales.js"></script>

<!-- JQUERY PLUGINS -->
<script src="./includes/plugins/jqueryMask/src/jquery.mask.js"></script>
<script src="./includes/plugins/JqueryRestrict/jquery.alphanum.js"> </script>
  <!-- <script src="includes/plugins/DataTables/configFiles/dataTablesRelVendas.js"> </script> -->
  <script src="script.js"></script>

</body>

</html>