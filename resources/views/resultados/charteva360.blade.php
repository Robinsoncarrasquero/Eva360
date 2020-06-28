<!DOCTYPE html>
<html>
<head>
    <title>Evaluacion 360 Resultados</title>
</head>

<body>

<div id="container"></div>
</body>

<script src="https://code.highcharts.com/highcharts.js"></script>

<script type="text/javascript">

    var dataSerie =  <?php echo json_encode($dataSerie) ?>;
    var categorias =  <?php echo json_encode($dataCategoria) ?>;
    var evaluado =  <?php echo json_encode($evaluado->name) ?>;

    var fileevaluado=[
        {
            "name":"Pedro Perez",
            "Evaluadores":
            [
                {'name':'Pedro Martinez','relation':'Boss','email':'pmartinez@eva360.com'},
                {'name':'Maria Rodriguez','relation':'Parner','email':'mrodriguez@eva360.com'},
            ]
        }

        ];


    Highcharts.chart('container', {
        title: {
            text: "Eva360 de "+evaluado
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
