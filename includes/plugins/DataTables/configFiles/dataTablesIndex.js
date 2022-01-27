$(document).ready(function () {
    $.fn.dataTable.moment('DD/MM/YYYY');    //Formatação sem Hora

    $('#relatorioDeVendasIndexTable').DataTable({
        "footerCallback": function (row, data, start, end, display) {
            var api = this.api(), data;

            // Remove the formatting to get integer data for summation
            var intVal = function (i) {
                return typeof i === 'string' ?
                    i.replace(/[\R$,]/g, '') * 1 :
                    typeof i === 'number' ?
                        i : 0;
            };

            // Total over all pages
            total = api
                .column(5)
                .data()
                .reduce(function (a, b) {
                    return intVal(a) + intVal(b);
                }, 0);

            // Total over this page
            pageTotal = api
                .column(5, { page: 'current' })
                .data()
                .reduce(function (a, b) {
                    return intVal(a) + intVal(b);
                }, 0);

            // Update footer
            $(api.column(5).footer()).html(

                ' R$' + (Math.round((total + Number.EPSILON) * 100) / 100) + ' total'
            );
        },
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