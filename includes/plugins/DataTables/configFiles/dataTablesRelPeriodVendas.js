$(document).ready(function () {
  $.fn.dataTable.moment('DD/MM/YYYY');    //Formatação sem Hora
  $('#tabelaRelatorioPeriodico').DataTable({
      "lengthMenu": [[15, 50, 100, -1], [15, 50, 100, "TUDO"]],
      dom: 'Blfrtip',
      language: {
        url: '//cdn.datatables.net/plug-ins/1.11.1/i18n/pt_br.json'
      },
      buttons:
          [
              {
                  extend: 'pdfHtml5',
                  className: 'btn btn-info btn-sm',
                  footer: 'true',
                  exportOptions: {
                      columns: ':visible',

                  }

              },
              {
                  extend: 'excel',
                  className: 'btn btn-info btn-sm',
                  footer: 'true',
                  exportOptions: {
                      columns: ':visible',
                  }

              },
              {
                  extend: 'print',
                  className: 'btn btn-info btn-sm ml-1',
                  footer: 'true',
                  exportOptions: {
                      columns: ':visible',
                  }
              },

          ]

  });
});