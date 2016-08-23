<?php
include ('../conectar.php');
include ('../config.php');

/*
 * Parametros recebidos via GET 
 */
$data_inicial = $_GET['data_inicial'];
$data_final = $_GET['data_final'];


//declaramos uma variavel para monstarmos a tabela
$dadosXls  = "";
$dadosXls .= "  <table border='1' >";
$dadosXls .= "          <tr>";
$dadosXls .= "          <th>$COLUNA01</th>";
$dadosXls .= "          <th>$COLUNA02</th>";
$dadosXls .= "          <th>$COLUNA03</th>";
$dadosXls .= "          <th>$COLUNA04</th>";
$dadosXls .= "          <th>$COLUNA05</th>";
$dadosXls .= "          <th>$COLUNA06</th>"; 
$dadosXls .= "          <th>$COLUNA07</th>";
$dadosXls .= "      </tr>";

//Fazendo Select
$resultado = $CONEXAO->query("SELECT * FROM $base.$tabela_pesquisa WHERE data BETWEEN '$data_inicial 00:00:00' and '$data_final 23:59:59' ");

//varremos o array com o foreach para pegar os dados
foreach($resultado as $res){
    $dadosXls .= "      <tr>";
    $dadosXls .= "          <td>".$res['data']."</td>";
    $dadosXls .= "          <td>".$res['callid']."</td>";
    $dadosXls .= "          <td>".$res['tempo_adequado']."</td>";
    $dadosXls .= "          <td>".$res['nota']."</td>";
    $dadosXls .= "          <td>".$res['codigo_analista']."</td>";
    $dadosXls .= "          <td>".$res['nome_analista']."</td>";
    $dadosXls .= "          <td>".$res['origem']."</td>";
    $dadosXls .= "      </tr>";
}
$dadosXls .= "  </table>";

// Definimos o nome do arquivo que será exportado  
$arquivo = "Relatorio_Pesquisa_$data_inicial_a_$data_final.xls";  

// Configurações header para forçar o download  
header('Content-Type: application/vnd.ms-excel');
header('Content-Disposition: attachment;filename="'.$arquivo.'"');
header('Cache-Control: max-age=0');
// Se for o IE9, isso talvez seja necessário
header('Cache-Control: max-age=1');

// Envia o conteúdo do arquivo  
echo $dadosXls;  
mysql_close();
exit;

