<!doctype html>
<html>

<head>
    <title>Grafico Pesquisa</title>
    <script src="dist/Chart.bundle.js"></script>
    <script src="../js/jquery-1.12.3.js"></script>
    <style>
    canvas {
        -moz-user-select: none;
        -webkit-user-select: none;
        -ms-user-select: none;
    }
    </style>
</head>

<body>
    <?php
    include ('conectar.php');
    
    
    $PESSIMO = $CONEXAO->query("SELECT nota from $base.$tabela_pesquisa WHERE nota = '0'");
    $RUIM = $CONEXAO->query("SELECT nota from $base.$tabela_pesquisa WHERE nota = '1'");
    $REGULAR = $CONEXAO->query("SELECT nota from $base.$tabela_pesquisa WHERE nota = '2'");
    $BOM = $CONEXAO->query("SELECT nota from $base.$tabela_pesquisa WHERE nota = '3'");
    $OTIMO = $CONEXAO->query("SELECT nota from $base.$tabela_pesquisa WHERE nota = '4'");
    $EXCELENTE = $CONEXAO->query("SELECT nota from $base.$tabela_pesquisa WHERE nota = '5'");
        
    ?>
    
    <div id="canvas-holder" style="width:100%">
        <canvas id="chart-area" />
    </div>

    <script>
    var pessimo = function() {
        return <?php echo "$PESSIMO->num_rows" ?>; 
    };    
    var ruim = function() {
        return <?php echo "$RUIM->num_rows" ?>; 
    };
    var regular = function() {
        return <?php echo "$REGULAR->num_rows" ?>;
    };
    var bom = function() {
        return <?php echo "$BOM->num_rows" ?>; 
    };
    var otimo = function() {
        return <?php echo "$OTIMO->num_rows" ?>; 
    };
    var excelente = function() {
        return <?php echo "$EXCELENTE->num_rows" ?>; 
    };    
    
    var config = {
        type: 'doughnut',
        data: {
            datasets: [{
                data: [
                    pessimo(),
                    ruim(),
                    regular(),
                    bom(),
                    otimo(),
                    excelente(),
                ],
                backgroundColor: [
                    "#DC0101",
                    "#FF0000",
                    "#FF01BC",
                    "#2301FF",
                    "#00FFF7",
                    "#4CFF15",
                ],
                label: 'Grafico 1'
            }, {
                hidden: true,
                data: [
                    pessimo(),
                    ruim(),
                    regular(),
                    bom(),
                    otimo(),
                    excelente(),
                ],
                backgroundColor: [
                    "#DC0101",
                    "#F7464A",
                    "#46BFBD",
                    "#FDB45C",
                    "#949FB1",
                    "#4D5360",
                ],
                
           
            }],
            labels: [
                "Pessimo",
                "Ruim",
                "Regular",
                "Bom",
                "Otimo",
                "Excente"
            ]
        },
        options: {
            responsive: true,
            legend: {
                position: 'top',
            },
            title: {
                display: true,
                text: 'Nota para o atendimento'
            },
            animation: {
                animateScale: true,
                animateRotate: true
            }
        }
    };

    window.onload = function() {
        var ctx = document.getElementById("chart-area").getContext("2d");
        window.myDoughnut = new Chart(ctx, config);
    };
    </script>
    
    
</body>

</html>
