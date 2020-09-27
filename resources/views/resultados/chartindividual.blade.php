@extends('layout')

@section('title',"Resultados Personales")

@section('content')

{{-- <div class="container"> --}}
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Resultados Personales</title>
    <link rel="canonical" href="https://getbootstrap.com/docs/4.0/examples/sticky-footer-navbar/">

    <link href="/open-iconic/font/css/open-iconic-bootstrap.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons"  rel="stylesheet">

    <!-- Bootstrap core CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <script src = "https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/open-iconic/1.1.1/font/css/open-iconic-bootstrap.min.css" integrity="sha256-BJ/G+e+y7bQdrYkS2RBTyNfBHpA9IuGaPmf9htub5MQ=" crossorigin="anonymous" />
    <!-- Custom styles for this template -->
    <link href="{{asset('css/style.css')}}" rel="stylesheet">

    <meta name="csrf-token" content="{{ csrf_token() }}" />
</head>
<body>
<div class="container">

    <div class="mt-3">
        <div class="col-lg-12 mb-1" id="container"></div>
    </div>

    <div class="clearfix">
        <span class="float-left"><a href="{{url()->previous()}}" class="btn btn-dark btn-lg">Back</a></span>
    </div>
</div>

<script src="{{ asset('js/hchar/highcharts.js') }}"></script>
<script src="{{ asset('js/hchar/modules/series-label.js')}}"></script>
<script src="{{ asset('js/hchar/modules/exporting.js') }}"></script>
<script src="{{ asset('js/hchar/modules/export-data.js')}}"></script>
<script src="{{ asset('js/hchar/modules/accessibility.js')}}"></script>


{{-- <script type="text/javascript">

    var dataSerie =  @json($dataSerie);
    var categorias =  @json($dataCategoria);
    var evaluado =  @json($evaluado->name);

    
    alert(dataSerie);
    categorias.forEach(logArrayElements);

    function logArrayElements(element, index, array) {
        console.log("a[" + index + "] = " + element);
    }

    ['data1'].forEach(mychar);

    function mychar(element,index,array)
    {
        // Highcharts.chart('container'+index, {
    Highcharts.chart('container', {
            chart: {
                type: 'column'
            },
            title: {
                text: "Resultado de Competencias Personales "
            },
            subtitle: {
                text: 'Source code: https://github.com/Robinsoncarrasquero'

            },
            xAxis: {
                categories: categorias,
                crosshair: true
            },
            yAxis: {
                min:0,
                title: {
                    text: 'Nivel de Dominio'
                }
            },
            tooltip: {
                headerFormat: '<span style="font-size:10px">{point.key}</span><table>',
                pointFormat: '<tr><td style="color:{series.color};padding:0">{series.name}: </td>' +
                    '<td style="padding:0"><b>{point.y:.1f} mm</b></td></tr>',
                footerFormat: '</table>',
                shared: true,
                useHTML: true
            },
            plotOptions: {
                column: {
                    pointPadding: 0.2,
                    borderWidth: 0
                }
            },

            series: dataSerie

    });

}

</script> --}}

<script>
    var dataSerie =  @json($dataSerie);
    var categorias =  @json($dataCategoria);
    
    Highcharts.chart('container', {
        chart: {
            type: 'column'
        },
        title: {
            text: 'Resultados Inviduales Por Grupo'
        },
        subtitle: {
            text: 'Compare valores entre personas y competencias.'

        },
        xAxis: {
            categories:categorias,
            
            crosshair: true
        },
        yAxis: {
            min: 0,
            title: {
                text: 'Nivel de Dominio'
            }
        },
        tooltip: {
            headerFormat: '<span style="font-size:10px">{point.key}</span><table>',
            pointFormat: '<tr><td style="color:{series.color};padding:0">{series.name}: </td>' +
                '<td style="padding:0"><b>{point.y:.1f} mm</b></td></tr>',
            footerFormat: '</table>',
            shared: true,
            useHTML: true
        },
        plotOptions: {
            column: {
                pointPadding: 0.2,
                borderWidth: 0
            }
        },
        series:dataSerie,
    });
</script>

</body>
</html>