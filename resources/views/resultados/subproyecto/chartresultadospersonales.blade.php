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


    <div class="panel panel-default">

        <div class="col-sm-12">


            <div class="panel panel">

                <div class="clearfix">
                    <div class=" text-center">
                        <h5>Resultados de Competencias Personales</span></h5>
                    </div>

                </div>

            </div>

            @if($subProyecto)

                <div class="row ">

                        <div class="table col-12">
                            <table id="{{ 'table'.$subProyecto->id }}" class="table  table-bordered table-striped table-table">
                                <thead class="table-thead">
                                    <tr>
                                        <th>
                                            Competencias/Participantes
                                        </th>
                                       @foreach ($dataCategoria as $key=>$value)
                                        <th>
                                            {{$value}}</strong>
                                        </th>
                                        @endforeach
                                    </tr>

                                </thead>
                                <tbody>
                                    @foreach ($dataSerie as $key=>$dataValue)
                                    <tr>
                                        <td>{{$dataValue['name']}}</td>
                                        {{-- <td>{{substr($evaluacion->competencia->description,0,50)}}</td> --}}
                                        @foreach ($dataValue['data'] as $vdata)
                                        <td>{{ number_format($vdata,2)}}</td>
                                        @endforeach
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>

                </div>

            @endif

            {{-- {{ $competencias->links() }} --}}

        </div>

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
<script type="text/javascript">
    var dataSerie =  @json($dataSerie);
    var categorias =  @json($dataCategoria);
    var subProyectoName = @json($subProyecto->name);
    Highcharts.chart('container', {
        chart: {
            type: 'column'
        },
        title: {
            text: 'Resultados de Competencias Personales'
        },
        subtitle: {
            text:  subProyectoName

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
