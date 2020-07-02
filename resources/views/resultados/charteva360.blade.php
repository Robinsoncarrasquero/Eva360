{{-- @extends('layout')

@section('title',"Lanzamiento de Prueba")

@section('content') --}}

{{-- <div class="container"> --}}
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<body>

<div id="container"></div>

<div class="clearfix">
    <span class="float-left"><a href="{{url()->previous()}}" class="btn btn-dark btn-lg">Back</a></span>
</div>

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
</body>
</html>
