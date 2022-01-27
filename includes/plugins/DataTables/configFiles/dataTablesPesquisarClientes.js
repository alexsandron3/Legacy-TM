$(document).ready(function () {
    $.fn.dataTable.moment('DD/MM/YYYY');    //Formatação sem Hora
    $('#tabelaPesquisarCliente').DataTable({
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
$(document).ready(function () {
    var table = $('#tabelaPesquisarCliente').DataTable();

    $("#hide_show_all").on("change", function () {
        var hide = $(this).is(":checked");
        $(".hide_show").prop("checked", hide);

        if (hide) {
            $('#tabelaPesquisarCliente tr th').hide(100);
            $('#tabelaPesquisarCliente tr td').hide(100);
        } else {
            $('#tabelaPesquisarCliente tr th').show(100);
            $('#tabelaPesquisarCliente tr td').show(100);
        }
    });

    $(".hide_show").on("change", function () {
        var hide = $(this).is(":checked");

        var all_ch = $(".hide_show:checked").length == $(".hide_show").length;

        $("#hide_show_all").prop("checked", all_ch);

        var ti = $(this).index(".hide_show");

        $('#tabelaPesquisarCliente tr').each(function () {
            if (hide) {
                $('td:eq(' + ti + ')', this).hide(100);
                $('th:eq(' + ti + ')', this).hide(100);
            } else {
                $('td:eq(' + ti + ')', this).show(100);
                $('th:eq(' + ti + ')', this).show(100);
            }
        });

    });


    $('#myInput').keyup(function () {
        table.draw();
    });
    $('input.column_filter').on('keyup click', function () {
        filterColumn($(this).parents('tr').attr('data-column'));
    });

});