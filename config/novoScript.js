//INDEX.PHP

//ABRIR NOVA JANELA
function novaJanela(linkListaPassageiros) {
    var abrirNovaJanela = window.open(linkListaPassageiros, "nova aba");
}
//Mais informações Tooltip
$(".more_info").click(function() {
    var $title = $(this).find(".title");
    if (!$title.length) {
        $(this).append('<span class="title"> </br>' + $(this).attr("title") + '</span>');
    } else {
        $title.remove();
    }
});
//FORMATAÇÃO DOS FORMULÁRIOS
//Bloquear envio do fomr com ENTER
$(".block-form").bind("keypress", function(e) {
    if (e.keyCode == 13) {
        $("#buttonFinalizarPagamento").attr('value');
        //add more buttons here
        return false;
    }
});
//Jquery Mask
$(document).ready(function() {
    $('.cpf').mask('000.000.000-00');
    $('.telefone').mask('00000000000');
    //$('.campo-monetario').mask("###0.00", {reverse: true});
});
//Jquery Restrict KevinSheedy
$('.campos-de-texto').alpha({

    maxLength: 70,
});
$('.campo-de-pesquisa').alphanum({

    maxLength: 70,
    allow: '.-'
});
$('.campo-de-email').alphanum({
    allow: '@._',
    maxLength: 70,
});
$('.rg').alphanum({
    allow: '.-',
    maxLength: 70,
});
$('.text-area').alphanum({
    allow: '!@#$%^&*()+=[];,/{}|":<>?~`.- _'
});
$('.campo-monetario').numeric({
    allowMinus: true,
    maxDecimalPlaces: 2,
    disallow: '!@#$%^&*()+=[]\\\';,/{}|":<>?~` _'

});
//Cálculo de idade
function ageCount(dataNasc) {
    split = dataNasc.split('-');
    var ano_aniversario = split[0];
    var mes_aniversario = split[1];
    var dia_aniversario = split[2];
    var dataAtual = new Date;
    ano_atual = dataAtual.getFullYear();
    mes_atual = dataAtual.getMonth() + 1;
    dia_atual = dataAtual.getDate();

    quantos_anos = ano_atual - ano_aniversario;


    if (mes_atual < mes_aniversario || mes_atual == mes_aniversario && dia_atual < dia_aniversario) {
        quantos_anos--;
    }
    if (quantos_anos >= 0) {
        document.getElementById('idadeCliente').value = quantos_anos;
    }

}
//Alterar data com base no RADIO CPF CONSULTADO
//Recebendo data
function setInputDate(_id) {
    var _dat = document.querySelector(_id);
    var hoy = new Date(),
        d = hoy.getDate(),
        m = hoy.getMonth() + 1,
        y = hoy.getFullYear(),
        data;

    if (d < 10) {
        d = "0" + d;
    };
    if (m < 10) {
        m = "0" + m;
    };

    data = y + "-" + m + "-" + d;
    console.log(data);
    _dat.value = data;
};
//Enviando a data
function changeInputDate() {
    var radio = document.getElementsByName('cpfConsultado');

    for (var i = 0, length = radio.length; i < length; i++) {
        if (radio[0].checked) {
            setInputDate("#dataCpfConsultado");
            break;
        } else {
            document.getElementById('dataCpfConsultado').value = "mm/dd/yyyy";
            break;
        }
    }
}
//VERIFICAÇÃO DE DATA
function verificaDataPasseio() {
    anoPasseio = document.getElementById('dataPasseio').value;
    if (anoPasseio < "2017-01-01") {
        document.getElementById('dataPasseio').value = "yyyy-MM-dd";
        var confirmarData = confirm("DATA INVÁLIDA");
    }


}
//CÁLCULO DOS CAMPOS MONETÁRIOS 
function calculoDespesas() {
    //Seção do valores unitários

    var valorAereo = Number(document.getElementById('valorAereo').value);
    var valorAlmocoCliente = Number(document.getElementById('valorAlmocoCliente').value);
    var valorAlmocoMotorista = Number(document.getElementById('valorAlmocoMotorista').value);
    var valorAutorizacaoTransporte = Number(document.getElementById('valorAutorizacaoTransporte').value);
    var valorEscuna = Number(document.getElementById('valorEscuna').value);
    var valorEstacionamento = Number(document.getElementById('valorEstacionamento').value);
    var valorGuia = Number(document.getElementById('valorGuia').value);
    var valorHospedagem = Number(document.getElementById('valorHospedagem').value);
    var valorImpulsionamento = Number(document.getElementById('valorImpulsionamento').value);
    var valorIngresso = Number(document.getElementById('valorIngresso').value);
    var valorKitLanche = Number(document.getElementById('valorKitLanche').value);
    var valorMarketing = Number(document.getElementById('valorMarketing').value);
    var valorMicro = Number(document.getElementById('valorMicro').value);
    var valorOnibus = Number(document.getElementById('valorOnibus').value);
    var valorPulseira = Number(document.getElementById('valorPulseira').value);
    var valorSeguroViagem = Number(document.getElementById('valorSeguroViagem').value);
    var valorServicos = Number(document.getElementById('valorServicos').value);
    var valorTaxi = Number(document.getElementById('valorTaxi').value);
    var valorVan = Number(document.getElementById('valorVan').value);
    var outros = Number(document.getElementById('outros').value);

    //Seção de quantidade
    var quantidadeAereo = Number(document.getElementById('quantidadeAereo').value);
    var quantidadeAlmocoCliente = Number(document.getElementById('quantidadeAlmocoCliente').value);
    var quantidadeAlmocoMotorista = Number(document.getElementById('quantidadeAlmocoMotorista').value);
    var quantidadeAutorizacaoTransporte = Number(document.getElementById('quantidadeAutorizacaoTransporte').value);
    var quantidadeEscuna = Number(document.getElementById('quantidadeEscuna').value);
    var quantidadeEstacionamento = Number(document.getElementById('quantidadeEstacionamento').value);
    var quantidadeGuia = Number(document.getElementById('quantidadeGuia').value);
    var quantidadeHospedagem = Number(document.getElementById('quantidadeHospedagem').value);
    var quantidadeImpulsionamento = Number(document.getElementById('quantidadeImpulsionamento').value);
    var quantidadeIngresso = Number(document.getElementById('quantidadeIngresso').value);
    var quantidadeKitLanche = Number(document.getElementById('quantidadeKitLanche').value);
    var quantidadeMarketing = Number(document.getElementById('quantidadeMarketing').value);
    var quantidadeMicro = Number(document.getElementById('quantidadeMicro').value);
    var quantidadeOnibus = Number(document.getElementById('quantidadeOnibus').value);
    var quantidadePulseira = Number(document.getElementById('quantidadePulseira').value);
    var quantidadeSeguroViagem = Number(document.getElementById('quantidadeSeguroViagem').value);
    var quantidadeServicos = Number(document.getElementById('quantidadeServicos').value);
    var quantidadeTaxi = Number(document.getElementById('quantidadeTaxi').value);
    var quantidadeVan = Number(document.getElementById('quantidadeVan').value);
    //Seção de total de cada despesa
    var valorTotalAereo = valorAereo * quantidadeAereo;
    var valorTotalAlmocoCliente = valorAlmocoCliente * quantidadeAlmocoCliente;
    var valorTotalAlmocoMotorista = valorAlmocoMotorista * quantidadeAlmocoMotorista;
    var valorTotalTransporte = valorAutorizacaoTransporte * quantidadeAutorizacaoTransporte;
    var valorTotalEscuna = valorEscuna * quantidadeEscuna;
    var valorTotalEstacionamento = valorEstacionamento * quantidadeEstacionamento;
    var valorTotalGuia = valorGuia * quantidadeGuia;
    var valorTotalHospedagem = valorHospedagem * quantidadeHospedagem;
    var valorTotalImpulsionamento = valorImpulsionamento * quantidadeImpulsionamento;
    var valorTotalIngresso = valorIngresso * quantidadeIngresso;
    var valorTotalKitLanche = valorKitLanche * quantidadeKitLanche;
    var valorTotalMarketing = valorMarketing * quantidadeMarketing;
    var valorTotalMicro = valorMicro * quantidadeMicro;
    var valorTotalOnibus = valorOnibus * quantidadeOnibus;
    var valorTotalPulseira = valorPulseira * quantidadePulseira;
    var valorTotalSeguroViagem = valorSeguroViagem * quantidadeSeguroViagem;
    var valorTotalServicos = valorServicos * quantidadeServicos;
    var valorTotalTaxi = valorTaxi * quantidadeTaxi;
    var valorTotalVan = valorVan * quantidadeVan;

    document.getElementById('valorTotalAereo').value = valorTotalAereo;
    document.getElementById('valorTotalAlmocoCliente').value = valorTotalAlmocoCliente;
    document.getElementById('valorTotalAlmocoMotorista').value = valorTotalAlmocoMotorista;
    document.getElementById('valorTotalTransporte').value = valorTotalTransporte;
    document.getElementById('valorTotalEscuna').value = valorTotalEscuna;
    document.getElementById('valorTotalEstacionamento').value = valorTotalEstacionamento;
    document.getElementById('valorTotalGuia').value = valorTotalGuia;
    document.getElementById('valorTotalHospedagem').value = valorTotalHospedagem;
    document.getElementById('valorTotalImpulsionamento').value = valorTotalImpulsionamento;
    document.getElementById('valorTotalIngresso').value = valorTotalIngresso;
    document.getElementById('valorTotalKitLanche').value = valorTotalKitLanche;
    document.getElementById('valorTotalMarketing').value = valorTotalMarketing;
    document.getElementById('valorTotalMicro').value = valorTotalMicro;
    document.getElementById('valorTotalOnibus').value = valorTotalOnibus;
    document.getElementById('valorTotalPulseira').value = valorTotalPulseira;
    document.getElementById('valorTotalSeguroViagem').value = valorTotalSeguroViagem;
    document.getElementById('valorTotalServicos').value = valorTotalServicos;
    document.getElementById('valorTotalTaxi').value = valorTotalTaxi;
    document.getElementById('valorTotalVan').value = valorTotalVan;

    //ValorTotal
    var valorTotal = valorTotalAereo + valorTotalAlmocoCliente + valorTotalAlmocoMotorista + valorTotalTransporte + valorTotalEscuna + valorTotalEstacionamento + valorTotalGuia +
        valorTotalHospedagem + valorTotalImpulsionamento + valorTotalIngresso + valorTotalKitLanche + valorTotalMarketing + valorTotalMicro + valorTotalOnibus + valorTotalPulseira +
        valorTotalSeguroViagem + valorTotalServicos + valorTotalTaxi + valorTotalVan + outros;
    document.getElementById('totalDespesas').value = valorTotal;
}
//VERIFICAÇÕES
// VERIFICANDO PASSEIO EM CADASTRO DE DESPESAS
function verificaIdPasseioSelecionadoFun() {
    var idPasseioSelecionado = document.getElementById('selectIdPasseio').value;
    console.log(idPasseioSelecionado);

    document.getElementById('idPasseioSelecionado').value = idPasseioSelecionado;

}
//Detalhes sobre os clientes 
function tituloDetalhesListagem() {
    var clientesConfirmados = document.getElementById("clientesConfirmados").value;
    document.getElementById("confirmados").innerHTML = "CONFIRMADOS: " + clientesConfirmados;

    var interessados = document.getElementById("clientesInteressados").value;
    document.getElementById("interessados").innerHTML = "INTERESSADOS: " + interessados;

    var totalVagasDisponiveis = document.getElementById("totalVagasDisponiveis").value;
    document.getElementById("vagasDisponiveis").innerHTML = "DISPONÍVEIS:  " + totalVagasDisponiveis;

    var clientesParceiros = document.getElementById("clientesParceiros").value;
    document.getElementById("parceiros").innerHTML = "PARCEIROS:  " + clientesParceiros;

    var clientesCriancas = document.getElementById("clientesCriancas").value;
    document.getElementById("criancas").innerHTML = "CRIANÇAS:  " + clientesCriancas;

    var clientesDesistentes = document.getElementById("clientesDesistentes").value;
    document.getElementById("desistentes").innerHTML = "DESISTENTES:  " + clientesDesistentes;


}
//TransferirPagamento
function idPasseioSelecionadoFun() {
    var idPasseioSelecionado = document.getElementById('selectIdPasseio').value;
    console.log(idPasseioSelecionado);

    document.getElementById('idPasseioSelecionado').value = idPasseioSelecionado;

}

//TRASNFORMANDO TEXT EM UPPERCASE
function upperCaseF(a) {
    setTimeout(function() {
        a.value = a.value.toUpperCase();
    }, 1);
}
//CONFIRMAÇÃO DE APAGAR REGISTROS

function confirmationDelete(anchor) {
    var conf = confirm('VOCÊ TEM CERTEZA QUE DESEJA DESATIVAR ESTE CLIENTE??');
    if (conf)
        window.location = anchor.attr("href");
}

function confirmationDeletePasseio(anchor) {
    var conf = confirm('VOCÊ TEM CERTEZA QUE DESEJA APAGAR ESSE PASSEIO??');
    if (conf)
        window.location = anchor.attr("href");
}
//exportando arquivos    
function Export() {
    var conf = confirm("Exportar para EXCEL?");
    if (conf == true) {
        var idPasseio = document.getElementById('idPasseio').value;
        console.log("ok");
        window.open("SCRIPTS/exportarExcel.php?id=" + idPasseio, '_blank');
    }
}
//Verificando data de pagamento
function verificaDePrevisaoPagamento() {
    var previsaoPagamento = document.getElementById("previsaoPagamento").value;
    var data = new Date();
    var mes = data.getMonth() + 1;
    var dia = data.getDate();
    var ano = data.getFullYear();
    if (mes < 10) {
        mes = "0" + mes;
    }
    var dataCompleta = ano + "-" + mes + "-" + dia;
    if (dataCompleta == previsaoPagamento) {
        $(function() {
            $('#basicExampleModal').modal('show');
        });
    }

}