//CALCULO PAGAMENTO CLIENTE
function calculoPagamento() {
    //recebendo valores
    var valorVendido = parseFloat(document.getElementById('valorVendido').value);
    var valorAntigoPago = parseFloat(document.getElementById('valorAntigo').value);
    var novoValorPago = parseFloat(document.getElementById('novoValorPago').value);
    var taxaDePagamento = parseFloat(document.getElementById('taxaPagamento').value);

    var statusFormulario = document.getElementById('statusFormulario').value;

    //calculos
    var valorPendente = parseFloat((valorAntigoPago + taxaDePagamento + novoValorPago) - valorVendido).toFixed(2);
    //verificações
    if (valorPendente > 0 || valorPendente < (valorVendido * -1) || Number.isNaN(valorPendente) || novoValorPago > valorVendido) {
        document.getElementById('valorPendenteCliente').value = "VALOR INCORRETO OU CAMPOS NÃO PREENCHIDOS";
        document.getElementById('statusFormulario').value = 0;
        document.getElementById('novoValorPago').value = 0;
        statusFormulario = 0;
    } else {
        document.getElementById('valorPendenteCliente').value = parseFloat(valorPendente).toFixed(2);
        document.getElementById('valorPago').value = parseFloat(valorAntigoPago + novoValorPago).toFixed(2);
        document.getElementById('statusFormulario').value = 1;
        statusFormulario = 1;

    }
    //mudando botão
    if (statusFormulario == false) {
        document.getElementById('buttonFinalizarPagamento').value = "VALORES INCORRETOS";
        document.getElementById('buttonFinalizarPagamento').classList.remove('btn-info')
        document.getElementById('buttonFinalizarPagamento').classList.add('btn-danger')
        document.getElementById('buttonFinalizarPagamento').disabled = true;
    } else {
        document.getElementById('buttonFinalizarPagamento').value = "FINALIZAR PAGAMENTO";
        document.getElementById('buttonFinalizarPagamento').classList.remove('btn-danger')
        document.getElementById('buttonFinalizarPagamento').classList.add('btn-info')
        document.getElementById('buttonFinalizarPagamento').disabled = false;
    }
    //console.log();
    return statusFormulario;
}

function gerarHistorico() {
    var statusFormulario = calculoPagamento();
    var historicoPagamentoAntigo = document.getElementById('historicoPagamentoAntigo').value;
    var novoValorPago = parseFloat(document.getElementById('novoValorPago').value);
    var data = new Date();
    var anoAtual = data.getFullYear();
    var mesAtual = data.getMonth();
    var diaAtual = data.getDate();
    if (statusFormulario == true) {
        document.getElementById('historicoPagamento').innerHTML = historicoPagamentoAntigo + "\n " + diaAtual + "-" + (mesAtual + 1) + "-" + anoAtual + " R$: " + novoValorPago;
    } else {
        document.getElementById('historicoPagamento').innerHTML = historicoPagamentoAntigo;
    }
}