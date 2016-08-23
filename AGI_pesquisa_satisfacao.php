#!/usr/bin/php -q
<?php

//Função para coneção
function conectardb(){
    mysql_connect("127.0.0.1","root","SENHA") or die ("Não consegui conectar!! O que você fez?");
    mysql_select_db("asterisk") or die ("erro de base");
}


//Chama arquivo phpagi.php
require('phpagi.php');

//Novo objeto
$agi = new AGI();

//Argumentos recebidos
$solic_atendida = $argv[1];
$nota = $argv[2];
$uniqueid = $argv[3];
$origem = $argv[4];

//Conecta na BASE
conectardb();

//Select para pegar o numero do agente que atendeu a chamada
$SELECT_CHAMADA = "select * from asterisk.queue_log WHERE callid = '$uniqueid' and event = 'COMPLETEAGENT';";
$resultado = mysql_query($SELECT_CHAMADA);

$linha_select_chamada = mysql_fetch_array($resultado);
$cod_agente = $linha_select_chamada["agent"];


// --- Consulta no SQLITE
// --- Utiliza o numero do agente para pegar o nome do agente. Porque está no sqlite!? Vai saber... u.u
$dir = 'sqlite:/var/www/db/acl.db';
$dbh  = new PDO($dir) or die("Isso realmente funciona?");

$query =  "SELECT * FROM acl_user WHERE name = 'agent_$cod_agente'";

foreach ($dbh->query($query) as $row)
{
    $analista = $row[2];
}

// --- Atente-se em mudar o nome da tabela
$INSERT_PESQUISA_SATISFACAO = "INSERT into asterisk.pesquisa_satisfacao_cliente (data, callid, solicitacao_atendida, nota, codigo_analista, nome_analista, origem) VALUES (now(),'$uniqueid','$solic_atendida', '$nota', '$cod_agente', '$analista', '$origem');";

$resultado = mysql_query($INSERT_PESQUISA_SATISFACAO);


if (!$resultado) {
     $agi->set_variable('RETORNO','ERRO AO INSERIR OS DADOS DA PESQUISA');
     $agi->set_variable('ARG1',$uniqueid);
     $agi->set_variable('ARG2',$solic_atendida);
     $agi->set_variable('ARG3',$nota);
     $agi->set_variable('ARG4',$cod_agente);
     $agi->set_variable('ARG5',$analista);


}
 else {
     $agi->set_variable('RETORNO','PESQUISA RELISADA COM SUCESSO');
     $agi->set_variable('ARG1',$uniqueid);
     $agi->set_variable('ARG2',$solic_atendida);
     $agi->set_variable('ARG3',$nota);
     $agi->set_variable('ARG4',$cod_agente);
     $agi->set_variable('ARG5',$analista);


}

mysql_close();
?>

