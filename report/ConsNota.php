<?php
    include ('../config.php');
    
    /*
     * Nota do atendimento
     */
    $PESSIMO = $CONEXAO->query("SELECT nota from $tabela_pesquisa WHERE nota = '0'");
    $RUIM = $CONEXAO->query("SELECT nota from $tabela_pesquisa WHERE nota = '1'");
    $REGULAR = $CONEXAO->query("SELECT nota from $tabela_pesquisa WHERE nota = '2'");
    $BOM = $CONEXAO->query("SELECT nota from $tabela_pesquisa WHERE nota = '3'");
    $OTIMO = $CONEXAO->query("SELECT nota from $tabela_pesquisa WHERE nota = '4'");
    $EXCELENTE = $CONEXAO->query("SELECT nota from $tabela_pesquisa WHERE nota = '5'");
    
    /*
     * Atendimento rapido ou demorado
     */
    $RAPIDO = $CONEXAO->query("SELECT * FROM $tabela_pesquisa where solicitacao_atendida = 1");
    $DEMORADO = $CONEXAO->query("SELECT * FROM $tabela_pesquisa where solicitacao_atendida = 2");
