//Tabelas padrão

$(document).ready(function () {
    $.fn.dataTable.moment('DD/MM/YYYY');
    $('#tabelasPadrao').DataTable( {
        "lengthMenu": [[15, 50, 100, -1], [15, 50, 100, "TUDO"]],
        "footerCallback": function ( row, data, start, end, display ) {
            var api = this.api(), data;
 
            // Remove the formatting to get integer data for summation
            var intVal = function ( i ) {
                return typeof i === 'string' ?
                    i.replace(/[\R$,]/g, '')*1 :
                    typeof i === 'number' ?
                        i : 0;
            };
 
            // Total over all pages
            total = api
                .column( 2 )
                .data()
                .reduce( function (a, b) {
                    return intVal(a) + intVal(b);
                }, 0 );
 
            // Total over this page
 
            // Update footer
            $( api.column( 2 ).footer() ).html(
               '  R$'+ total.toFixed(2) +' total'
            );
        },
        dom: 'Blfrtip',
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
                        columns: ':visible'
                    }

                },
                {
                    extend: 'print',
                    footer: 'true',
                    className: 'btn btn-info btn-sm ml-1',
                    exportOptions: {
                        columns: ':visible'
                    }
                },

            ]
        
    } );
} );

$(document).ready(function () {
    $.fn.dataTable.moment('DD/MM/YYYY');
    $('#pesquisarPagamento').DataTable( {
        "lengthMenu": [[15, 50, 100, -1], [15, 50, 100, "TUDO"]],
        "footerCallback": function ( row, data, start, end, display ) {
            var api = this.api(), data;
 
            // Remove the formatting to get integer data for summation
            var intVal = function ( i ) {
                return typeof i === 'string' ?
                    i.replace(/[\R$,]/g, '')*1 :
                    typeof i === 'number' ?
                        i : 0;
            };
 
            // Total over all pages
            total = api
                .column( 2 )
                .data()
                .reduce( function (a, b) {
                    return intVal(a) + intVal(b);
                }, 0 );
 
            // Total over this page
 
            // Update footer
            $( api.column( 2 ).footer() ).html(
               '  R$'+ total.toFixed(2) +' total'
            );
        },
        dom: 'Blfrtip',
        buttons:
            [
                {
                    extend: 'pdfHtml5',
                    className: 'btn btn-info btn-sm',
                    footer: 'true',
                    exportOptions: {
                        columns: [1,2,3,':visible'],
                        
                    }

                },
                {
                    extend: 'excel',
                    className: 'btn btn-info btn-sm',
                    footer: 'true',

                    exportOptions: {
                        columns: [1,2,3,':visible'],
                    }

                },
                {
                    extend: 'print',
                    footer: 'true',
                    className: 'btn btn-info btn-sm ml-1',
                    exportOptions: {
                        columns: [1,2,3,':visible'],
                    }
                },

            ]
        
    } );
} );









$(document).ready(function () {
    $.fn.dataTable.moment('DD/MM/YYYY');

    $('#userTable').DataTable({
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
        buttons:
            [
                {
                    extend: 'pdfHtml5',
                    className: 'btn btn-info btn-sm',
                    footer: 'true',
                    exportOptions: {
                        columns: ':visible'
                    }

                },
                {
                    extend: 'excel',
                    className: 'btn btn-info btn-sm',
                    footer: 'true',
                    exportOptions: {
                        columns: ':visible'
                    }

                },
                {
                    extend: 'print',
                    className: 'btn btn-info btn-sm ml-1',
                    footer: 'true',
                    exportOptions: {
                        columns: ':visible'
                    }
                },

            ]

    });
});

$(document).ready(function () {
    var table = $('#userTable').DataTable();

    $("#hide_show_all").on("change", function () {
        var hide = $(this).is(":checked");
        $(".hide_show").prop("checked", hide);

        if (hide) {
            $('#userTable tr th').hide(100);
            $('#userTable tr td').hide(100);
        } else {
            $('#userTable tr th').show(100);
            $('#userTable tr td').show(100);
        }
    });

    $(".hide_show").on("change", function () {
        var hide = $(this).is(":checked");

        var all_ch = $(".hide_show:checked").length == $(".hide_show").length;

        $("#hide_show_all").prop("checked", all_ch);

        var ti = $(this).index(".hide_show");

        $('#userTable tr').each(function () {
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
$(document).ready(function () {
    var table = $('#userTable').DataTable();

    $("#hide_show_all").on("change", function () {
        var hide = $(this).is(":checked");
        $(".hide_show").prop("checked", hide);

        if (hide) {
            $('#userTable tr th').hide(100);
            $('#userTable tr td').hide(100);
        } else {
            $('#userTable tr th').show(100);
            $('#userTable tr td').show(100);
        }
    });

    $(".hide_show").on("change", function () {
        var hide = $(this).is(":checked");

        var all_ch = $(".hide_show:checked").length == $(".hide_show").length;

        $("#hide_show_all").prop("checked", all_ch);

        var ti = $(this).index(".hide_show");

        $('#userTable tr').each(function () {
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





//TABELA ALTERNATIVA CASO A PRIMEIRA NÃO FUNCIONE
$(document).ready(function () {
    var api = this.api(), data;

    $.fn.dataTable.moment('DD/MM/YYYY');

    $('#simpleTable').DataTable({
        "lengthMenu": [[15, 50, 100, -1], [15, 50, 100, "TUDO"]],
        dom: 'Blfrtip',
        buttons:
            [
                {
                    extend: 'pdfHtml5',
                    className: 'btn btn-info btn-sm',
                    exportOptions: {
                        columns: ':visible'
                    }
    
                },
                {
                    extend: 'excel',
                    className: 'btn btn-info btn-sm',
                    exportOptions: {
                        columns: ':visible'
                    }
    
                },
                {
                    extend: 'print',
                    className: 'btn btn-info btn-sm ',
                    exportOptions: {
                        columns: ':visible'
                    }
                },
    
            ]
    
    });
});
