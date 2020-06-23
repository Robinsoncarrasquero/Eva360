<!DOCTYPE html>
<html>
<head>
    <title>Highcharts Example - codechief.org</title>
</head>

<body>

<div id="container"></div>
</body>

<script src="https://code.highcharts.com/highcharts.js"></script>

<script type="text/javascript">
    var categorias= ['Jan', 'Feb', 'March', 'April', 'May', 'June', 'July', 'Aug', 'Sept', 'Oct', 'Nov', 'Dec'];
    var dataEvaluacion= [0,100,50,20,100,01];
    var dataSerie2=[{"name":"Boss","data":[100,100,0,37.5,100,75]},{"name":"Par","data":[100,100,75,100,100,0]},
    {"name":"Nivel Requerido","data":["100.00","100.00","100.00","100.00","100.00","100.00"]},
    {"name":"Eva360","data":[100,100,37.5,68.75,100,37.5]}];

    var dataSerie =  <?php echo json_encode($dataSerie) ?>;

    var categorias =  <?php echo json_encode($dataCategoria) ?>;

    // dataSerie.forEach(function (e,i) {
    //     alert(e.name+e.data);
    // });


    //   series:[{
    //         name: 'Eva360',
    //         data: dataEvaluacion,
    //     },{
    //         name: 'Pares',
    //         data: [99,100,99,99,95,99],
    //     },{
    //         name: 'Super',
    //         data: [99,100,99,99,95,99],
    //     },{
    //         name: 'Requerido',
    //         data: [100,100,100,100,99,100],
    //     }],



    Highcharts.chart('container', {
        title: {
            text: 'Evaluacion 360, 2020'
        },
        subtitle: {
            text: 'Source code: https://github.com/Robinsoncarrasquero/Eva360'

        },
         xAxis: {
            categories: categorias
        },
        yAxis: {
            title: {
                text: 'Nivel de Dominio'
            }
        },
        legend: {
            layout: 'vertical',
            align: 'right',
            verticalAlign: 'middle'
        },
        plotOptions: {
            series: {
                allowPointSelect: true
            }
        },
        series:dataSerie,
        responsive: {
            rules: [{
                condition: {
                    maxWidth: 500
                },
                chartOptions: {
                    legend: {
                        layout: 'horizontal',
                        align: 'center',
                        verticalAlign: 'bottom'
                    }
                }
            }]
        }
});
</script>
</html>
