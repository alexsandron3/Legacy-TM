
$(document).ready(function() {
  // $.fn.dataTable.moment('DD/MM/YYYY'); //Formatação sem Hora
  // const value = $('#inicio').val();
  // console.log(value);

  const table = $('#relatorioVendasTable').DataTable(
    {
    "processing": true,
    "serverSide": true,
    // "searching": false,
    "filter": true,
    language: {
      url: '//cdn.datatables.net/plug-ins/1.11.1/i18n/pt_br.json'
    },
    "ajax": {
      "url": "./teste-backend-search.php",
      "type": "POST",
      "datatype": "json",
      
      data: {
        "inicio": function (data) {
          console.log(data);
          // Lendo valores
          const inicio = $('#inicio').val();
          const today = new Date();
          const inputDate = new Date(inicio);
          today.setHours(0,0,0,0)
          inputDate.setHours(0,0,0,0)
          inputDate.setDate(inputDate.getDate() +1)
          if (moment(inputDate).isAfter(today)){
            return moment(today).format('YYYY-MM-DD');
          }
          return inicio;
          
        },
        "fim": "2030-09-06"
      },
      dataSrc: '',
    },
    "columns": [
      {"data": "nomePasseio"},
      {"data": "dataPasseio"},
      {"data": "NVendas"},
      {"data": "ValorVenda"},
      {"data": "ValorPago"},
    ]
  });
  
  $('#inicio').change(function () {
    table.draw();
  })
});