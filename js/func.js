
/*
 * Validar Preencimento dos inputs
 */
function validar_form_data (){
    var data_inicial = document.getElementById("dt_inicial").value.length;
    var data_final = document.getElementById("dt_final").value.length;
    
    if( data_inicial == " " || data_inicial == null ){
        $('#erro_data_inicial').modal({show:true});
        document.getElementById("dt_inicial").focus();        
        return false
    }
    
    if( data_final == " " || data_final == null  ){
        $('#erro_data_final').modal({show:true});
        document.getElementById("dt_final").focus();
        return false
    }
    
//    if( data_final < data_inicial ){
//        $('#erro_data_final').modal({show:true});
//        document.getElementById("dt_final").focus();
//        return false
//    }
}

function validar_form_nome (){
    var nome_analista = document.getElementById("nome").value.length; 
    if( nome_analista == " " || nome_analista == null ){
        $('#erro_nome').modal({show:true});
        document.getElementById("nome").focus();
        return false
    }
}

/*
 * Função calendario
 */
$(document).ready(function () {
    $('#dt_inicial').datepicker({
        format: "yyyy-mm-dd",
        language: "pt-br"
    });
});

$(document).ready(function () {
    $('#dt_final').datepicker({
        format: "yyyy-mm-dd",
        language: "pt-br"
    });
});
