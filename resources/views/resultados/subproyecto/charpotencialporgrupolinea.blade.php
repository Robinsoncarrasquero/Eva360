{{-- @extends('master') --}}

@section('title',"Resultado cumplimiento")

@section('content')

{{-- <div class="container"> --}}
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Resultados por grupo</title>

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
        <div class="col-12 mb-1" id="container"></div>
    </div>



        <div class="col-sm-12">

            <div class="panel panel">

                <div class="clearfix">
                    <div class=" text-center">
                        <h5>Indicadores de Cumplimiento</span></h5>
                    </div>

                </div>

            </div>

            <div class="table table-responsive">
                <table id="{{ 'table'.$subProyecto->id }}" class="table  table-bordered table-striped table-table">
                    <thead class="table-thead" style="text-align: center">
                    <th>Evaluado</th>
                    <th>% Cumplimiento</th>
                    <th>% Brecha</th>
                    <th>% Potencial</th>
                    <th>Oportunidades</th>
                    <th>Fortalezas</th>
                    </thead>
                    <tbody>
                        @foreach ($dataBrecha as $key=>$value)
                        <tr style="text-align: center">

                        <td style="text-align: left">{{$value['categoria']}}</strong></td>
                        <td>{{ number_format($value['cumplimiento'],2) }}</td>
                        <td>
                        @if ($value['cumplimiento']!=100)
                            {{ number_format($value['brecha'],2) }}
                        @endif
                        </td>
                        <td>
                            @if ($value['potencial']>100)
                            {{ number_format($value['potencial'],2) }}
                            @endif
                        </td>
                        <td>
                            @foreach ($value['dataoportunidad'] as $vdata)
                                {{$vdata['competencia']}},
                            @endforeach
                        </td>
                        <td>
                            @foreach ($value['datafortaleza'] as $vdata)
                                {{$vdata['competencia']}},
                            @endforeach
                        </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        <div class="panel panel-default">

            <div class="col-sm-12">

                <div class="panel panel">

                    <div class="clearfix">
                        <div class=" text-center">
                            <h5>Indicadores por competencias</span></h5>
                        </div>

                    </div>

                </div>

                @if($subProyecto)
                    <div class="table">
                        <table id="{{ 'table'.$subProyecto->id }}" class="table  table-bordered table-striped table-table">
                            <thead class="table-thead">
                                <tr>
                                    <th>

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
                @endif

                {{-- {{ $competencias->links() }} --}}

            </div>



        <div class="col-6">
            <span class="float-left"><a href="{{url()->previous()}}" class="btn btn-dark btn-lg">Back</a></span>
        </div>

    </div>

</div>

<script src="{{ asset('js/hchar/highcharts.js') }}"></script>
<script src="{{ asset('js/hchar/modules/series-label.js')}}"></script>
<script src="{{ asset('js/hchar/modules/exporting.js') }}"></script>
<script src="{{ asset('js/hchar/modules/export-data.js')}}"></script>
<script src="{{ asset('js/hchar/modules/accessibility.js')}}"></script>
<script type="text/javascript">
    var dataSerie =  @json($dataSerieBrecha);
    var categorias =  @json($dataCategoriaBrecha);
    var subProyectoName = @json($subProyecto->name);
    Highcharts.chart('container', {
        // chart: {
        //     type: 'column'
        // },
        title: {
            text: 'Analisis de cumplimiento'
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
    });
</script>

</body>
</html>
