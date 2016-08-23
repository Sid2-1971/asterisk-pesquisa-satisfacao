<!DOCTYPE html>
<html lang="pt-br">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- As 3 meta tags acima *devem* vir em primeiro lugar dentro do `head`; qualquer outro conteúdo deve vir *após* essas tags -->
    <title>Pesquisa por data</title>

    <!-- Bootstrap -->
    <link href="css/bootstrap-datepicker.css" rel="stylesheet">
    <link href="css/bootstrap.min.css" rel="stylesheet">

    <!-- HTML5 shim e Respond.js para suporte no IE8 de elementos HTML5 e media queries -->
    <!-- ALERTA: Respond.js não funciona se você visualizar uma página file:// -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
  </head>
<body>    

<?php
//var_dump($_GET);
    include ('conectar.php');
    include ('config.php');
    
    /*
     * Parametros recebidos via GET 
     */
    $data_inicial = $_GET['data_inicial'];
    $data_final = $_GET['data_final'];
    
    
    /* 
     * Paginação
     */
    $LIMITE = 10;
    $SQL_COUNT = $CONEXAO->query( "SELECT * FROM $base.$tabela_pesquisa WHERE data BETWEEN '$data_inicial 00:00:00' and '$data_final 23:59:59'");
    $SQL_RESUL = ceil($SQL_COUNT->num_rows / $LIMITE);
    $pg = (isset($_GET["pg"])) ? (int)$_GET["pg"] : 1 ;
    $START = ($pg - 1) * $LIMITE;
    $resultado = $CONEXAO->query( "SELECT * FROM $base.$tabela_pesquisa WHERE data BETWEEN '$data_inicial 00:00:00' and '$data_final 23:59:59'  LIMIT $START, $LIMITE"  );
    
    /*
     * Cabeçalho
     */
    echo "<div class='container'>";
    echo "<div class='page-header'>";
    echo "<h1>Pesquisa de Satisfação <span class='label label-default'>$NOME_CLIENTE</span> </h1>";
    echo "<br/>";
    
    /*
     * Grupos de botões drowp-down para download
     */
    echo "<div class='row'>";//-->> Inicio da tabulação horizontal
        echo "<div class='col-md-3'>";//-->> Inicio da tabulação 01 horizontal
            echo "  <div class='btn-group' role='group' aria-label='...'>";

            /*
             * Download
             */
            echo "  <div class='btn-group' role='group'>";
            echo "    <button type='button' class='btn btn-default dropdown-toggle' data-toggle='dropdown' aria-haspopup='true' aria-expanded='false'>";
            echo "      Download";
            echo "      <span class='caret'></span>";
            echo "    </button>";
            echo "    <ul class='dropdown-menu'>";
            echo "      <li><a href='report/xls.php'>Geral</a></li>";
            echo "      <li type='button'  data-toggle='modal' data-target='#XlsPorNome'><a href='#'>Por nome</a></li>";
            echo "      <li type='button'  data-toggle='modal' data-target='#XlsPorCodAnalista'><a href='#'>Por código</a></li>";            
            echo "    </ul>";
            echo "  </div>";

            /*
             *Graficos 
             */

            echo "  <div class='btn-group' role='group'>";
            echo "    <button type='button' class='btn btn-default dropdown-toggle' data-toggle='dropdown' aria-haspopup='true' aria-expanded='false'>";
            echo "      Graficos";
            echo "      <span class='caret'></span>";
            echo "    </button>";
            echo "    <ul class='dropdown-menu'>";
            echo "      <li type='button'  data-toggle='modal' data-target='#NotaGrfRosca'><a href='#'>Nota</a></li>";
            //echo "      <li type='button'  data-toggle='modal' data-target='#AtendimendoGrfRosca'><a href='#'>Atendimento</a></li>";
            echo "    </ul>";
            echo "  </div>";


            /*
             * Fim do grupo de Botões
             */
            echo    "</div>";
        echo "</div>"; //-->> Fim da tabulação 01 horizontal
        
        //-->> Inicio da tabulação 02 horizontal
        //-->> Pesquisa por data
        echo "<form class='form-horizontal' role='form' method='get' action='PesquisarPorData.php' onsubmit='return validar_form_data(this)'>";
        
        
        echo "<div class='col-md-2'>";    
            echo "<input type='text' class='form-control' name='data_inicial' id='dt_inicial' placeholder='Data inicial' aria-describedby='basic-addon2'>";
        echo "</div>";
        
        echo "<div class='col-md-2'>";
            echo "<input type='text' class='form-control' name='data_final' id='dt_final' placeholder='Data final' aria-describedby='basic-addon2'>";
        echo "</div>";
        
        echo "<div class='col-md-2'>";
            echo "<button type='submit' class='btn btn-default' class='btn btn-default'>Buscar</button>";
        echo "</div>";
        
        
        echo "</form>"; 
        //-->> Fim da tabulação 02 horizontal
        
        echo "<div class='col-md-3'>";//-->> Inicio da tabulação 03 horizontal
            /*
             * Pesquisa por nome do analista
             */
            echo "<div class='col-lg-18'>";
                echo "<form class='form-horizontal' role='form' method='get' action='PesquisarPorNome.php'  onsubmit='return validar_form_nome(this)'>";
                echo "<div class='input-group'>";
                  echo "<span class='input-group-btn'>";
                  
                  echo "  <button class='btn btn-default' type='submit' >Pesquisar </button>";
                  echo "</span>";
                  echo "<input type='text' id='nome' name='nome' class='form-control' placeholder='por nome'>";
                echo "</div>";
                echo "</form>";
            echo "</div>";
        echo "</div>"; //-->> Fim da tabulação 03horizontal
        
    echo "</div>";//-->> Fim da tabulação horizontal
  
    /*
     * Fim do cabeçalho
     */
    echo "</div>";
    
    /*
     * Tabela com os dados e informações
     */   
    echo "    <div class='row'>";
    echo "        <div class='col-md' >";
    echo "            <table class='table table-bordered table-hover'>";
    echo "                <tbody><tr'>";
    echo "                    <th>$COLUNA01</th>";
    echo "                    <th>$COLUNA02</th>";
    echo "                    <th>$COLUNA03</th>";
    echo "                    <th>$COLUNA04</th>";
    echo "                    <th>$COLUNA05</th>";
    echo "                    <th>$COLUNA06</th>";
    echo "                    <th>$COLUNA07</th>";
    echo "                </tr>";
    while ( $tabela = $resultado->fetch_array() )
    {
        echo '<tr><td>' . $tabela['data'] .
             '</td><td>' . $tabela['callid'] .
             '</td><td><center>' . $tabela['solicitacao_atendida'] .
             '</center></td><td><center>' . $tabela['nota'] .
             '</center></td><td><center>' . $tabela['codigo_analista'] .
             '</center></td><td>' . $tabela['nome_analista'] .
             '</td><td>' . $tabela['origem'] .'</tr></td>' ;
    }      
    echo "            </tbody></table>";
    echo "        </div>";
    echo "    </div>";
     
    /*
     * Menu numerico de paginação
     */
    echo "<div class='container text-center'> ";
    echo "<nav>";
    echo "  <ul class='pagination'>";
    echo "    <li>";
    echo "      <a href='?pg=1&data_inicial=$data_inicial&data_final=$data_final' aria-label='Previous'>";
    echo "        <span aria-hidden='true'>&laquo;</span>";
    echo "      </a>";
    echo "    </li>";
                $inicio = ((($pg - $LIMITE) > 1) ? $pg - $LIMITE : 1);
                $fim = ((($pg+$LIMITE) < $SQL_RESUL) ? $pg + $LIMITE : $SQL_RESUL);
                
                if ($SQL_RESUL > 1 && $pg<=$SQL_RESUL){
                   for ( $i=$inicio; $i<=$fim; $i++ ){
                       
                       if ($i == $pg){
                            echo "<li class='active'><a href='?pg=$i>$i</a></li>";
                            
                       }
                       else{
                            echo "<li><a href='?pg=$i&data_inicial=$data_inicial&data_final=$data_final'>$i</a></li>";
                       }
                   }        
                }
    echo "    <li>";
    echo "      <a href='?pg=$SQL_RESUL&data_inicial=$data_inicial&data_final=$data_final'' aria-label='Next'>";
    echo "        <span aria-hidden='true'>&raquo;</span>";
    echo "      </a>";
    echo "    </li>";
    echo "  </ul>";
    echo "</nav>"; 
    echo "</div>";    
    echo "</div>";
    
?>
    
<!-- Janela Grafico de Rosca (NOTA) -->
<div id="NotaGrfRosca" class="modal fade" role="dialog">
  <div class="modal-dialog modal-lg">

    <!-- Grafico-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Pesquisa de Satisfação</h4>
      </div>
      <div class="modal-body">
        <p><?php include ("grafico/nota_rosca.php"); ?> </p>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Sair</button>
      </div>
    </div>

  </div>
</div>




<!-- Erro Data Inicial -->
<div class="modal fade" id="erro_data_inicial" tabindex="1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header alert-danger">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">ERRO!</h4>
      </div>
      <div class="modal-body">
          <h4>Por gentileza, preencha uma data inicial</h4>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Sair</button>
        
      </div>
    </div>
  </div>
</div>    

<!-- Erro Data final -->
<div class="modal fade" id="erro_data_final" tabindex="1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header alert-danger">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">ERRO!</h4>
      </div>
      <div class="modal-body">
          <h4> Por gentileza, preencha uma data final</h4>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Sair</button>
        
      </div>
    </div>
  </div>
</div>  

<!-- Erro Nome Analista -->
<div class="modal fade " id="erro_nome" tabindex="1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog " role="document">
    <div class="modal-content ">
      <div class="modal-header alert alert-danger">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">ERRO!</h4>
      </div>
      <div class="modal-body">
          <h4>Por gentileza, preencha com o nome de algum analista</h4>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Sair</button>
        
      </div>
    </div>
  </div>
</div>    

<!-- XLS por Nome Analista -->
<div class="modal fade " id="XlsPorNome" tabindex="1" role="dialog" aria-labelledby="XlsPorNome">
  <div class="modal-dialog " role="document">
    <div class="modal-content ">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="XlsPorNome">Download</h4>
      </div>
      <div class="modal-body">
          <h5>Iforme o nome do analista</h5>
            <!--Pesquisa por nome do analista-->             
                <form class='form-horizontal' role='form' method='get' action='report/XlsPorNome.php'>
                    <div class='input-group'>
                        <span class='input-group-btn'>                  
                            <button class='btn btn-default' type='submit' >Pesquisar </button>
                        </span>
                        <input type='text' id='nome' name='nome' class='form-control' placeholder='Informe o nome'>
                    </div>
                </form>

      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Sair</button>
        
      </div>
    </div>
  </div>
</div>    


<!-- XLS por Codigo do Analista -->
<div class="modal fade " id="XlsPorCodAnalista" tabindex="1" role="dialog" aria-labelledby="XlsPorCodAnalista">
  <div class="modal-dialog " role="document">
    <div class="modal-content ">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="XlsPorCodAnalista">Download</h4>
      </div>
      <div class="modal-body">
          <h5>Iforme o codigo do analista</h5>
            <!--Pesquisa por codigo do analista-->             
            <form class='form-horizontal' role='form' method='get' action='report/XlsPorCodAnalista.php'>
                    <div class='input-group'>
                        <span class='input-group-btn'>                  
                            <button class='btn btn-default' type='submit' >Pesquisar </button>
                        </span>
                        <input type='text' id='cod_analista' name='cod_analista' class='form-control' placeholder='Informe o códio do analista'>
                    </div>
                </form>

      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Sair</button>
        
      </div>
    </div>
  </div>
</div>    

<!-- Grafico agilidade no atendimento -->
<div class="modal fade " id="AtendimendoGrfRosca" tabindex="1" role="dialog" aria-labelledby="AtendimendoGrfRosca">
  <div class="modal-dialog " role="document">
    <div class="modal-content ">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="AtendimendoGrfRosca">Download</h4>
      </div>
      <div class="modal-body">
          <h5>Iforme o codigo do analista</h5>
            

      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Sair</button>
        
      </div>
    </div>
  </div>
</div>    

    
    
    <!-- jQuery (obrigatório para plugins JavaScript do Bootstrap) -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
    <!-- Inclui todos os plugins compilados (abaixo), ou inclua arquivos separadados se necessário -->
    <!-- Datepicker -->
    <script src="js/bootstrap-datepicker.js"></script>    
    <script src="js/bootstrap.min.js"></script>
    <script src="js/func.js"></script>
  </body>
</html>
