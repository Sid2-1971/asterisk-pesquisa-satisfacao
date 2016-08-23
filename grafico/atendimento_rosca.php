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
    
    
    
    $RAPIDO = $CONEXAO->query("SELECT * FROM pesquisa_satisfacao_magneti_marelli where solicitacao_atendida = 1");
    $DEMORADO = $CONEXAO->query("SELECT * FROM pesquisa_satisfacao_magneti_marelli where solicitacao_atendida = 2");

    ?>
    
    <div id="canvas-holder" style="width:100%">
        <canvas id="chart-area" />
    </div>

    <script>
    var rapido = function() {
        return <?php echo "$RAPIDO->num_rows" ?>; 
    };
    var demorado = function() {
        return <?php echo "$DEMORADO->num_rows" ?>;
    };
    
    
    var config = {
        type: 'doughnut',
        data: {
            datasets: [{
                data: [
                    rapido(),
                    demorado()

                ],
                backgroundColor: [
                    "#23FF0B",
                    "#FF0B0B"
                ],
                label: 'Grafico 1'
            }, {
                hidden: true,
                data: [
                    rapido(),
                    demorado()
                ],
                backgroundColor: [
                    "#949FB1",
                    "#23FF0B"
                ],
                
           
            }],
            labels: [
                "rapido",
                "Demorado"
            ]
        },
        options: {
            responsive: true,
            legend: {
                position: 'top',
            },
            title: {
                display: true,
                text: 'Qualidade do atendimento'
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
