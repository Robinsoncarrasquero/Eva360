{{-- @extends('master') --}}

{{-- @section('title',"Resultados Generales nivel de cargo")

@section('content') --}}

{{-- <div class="container"> --}}
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="canonical" href="https://getbootstrap.com/docs/4.0/examples/sticky-footer-navbar/">
    <title>Resultados Generales nivel de cargo</title>

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

    <div class="mt-1">
        <div class="col-lg-12 mb-1" id="container-0"></div>
    </div>

    <div class="mt-1">
        <div class="col-lg-12 mb-1" id="container-1"></div>
    </div>

    <div class="mt-1">
        <div class="col-lg-12 mb-1" id="container-2"></div>
    </div>

    <div class="mt-1">
        <div class="col-lg-12 mb-1" id="container-3"></div>
    </div>

    <div class="mt-1">
        <div class="col-lg-12 mb-1" id="container-4"></div>
    </div>


    <div class="col-lg-12">
        <div class="text-left">
            <h6>Cuadro Nivel de Cargo Fortalezas / Debilidades</h6>
        </div>

        @if($subProyecto)

            <div class="table">
                <table id="{{ 'table'.$subProyecto->id }}" class="table  table-bordered table-striped table-table">
                    <thead class="table-thead">
                        <th>Nivel</th>
                        <th>Debilidad</th>
                        <th>Fortaleza</th>
                    </thead>
                    <tbody>
                        @foreach ($dataDofa as $ddata)
                        <tr>
                        <td>{{$ddata['agrupa']}}</strong></td>
                        <td>
                            @if ($ddata['dataoportunidad'])
                            @foreach ($ddata['dataoportunidad'] as $key=>$vdata)
                                {{$vdata['competencia']}},
                            @endforeach
                            @endif
                        </td>
                        <td>
                            @if ($ddata['datafortaleza'])
                            @foreach ($ddata['datafortaleza'] as $key=>$vdata)
                                {{$vdata['competencia']}},
                            @endforeach
                            @endif

                        </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @endif
        {{-- {{ $competencias->links() }} --}}
        <div class="clearfix">
            <span class="float-left"><a href="{{url()->previous()}}" class="btn btn-dark btn-lg">Back</a></span>
        </div>
    </div>
</div>



{{-- <script src="{{ asset('js/hchar/highcharts.js') }}"></script>
<script src="{{ asset('js/hchar/modules/series-label.js')}}"></script>
<script src="{{ asset('js/hchar/modules/exporting.js') }}"></script>
<script src="{{ asset('js/hchar/modules/export-data.js')}}"></script>
<script src="{{ asset('js/hchar/modules/accessibility.js')}}"></script> --}}
<script src="https://code.jquery.com/jquery-3.1.1.min.js"></script>
<script src="https://code.highcharts.com/highcharts.js"></script>
<script src="https://code.highcharts.com/highcharts-more.js"></script>
<script src="https://code.highcharts.com/modules/exporting.js"></script>
<script src="https://code.highcharts.com/modules/export-data.js"></script>
<script src="https://code.highcharts.com/modules/accessibility.js"></script>

<script type="text/javascript">
    var dataSerie =  @json($dataSerie);
    var categorias =  @json($dataCategoria);

    var subProyectoName = @json($subProyecto->name);
    var i=0;
    for ( obj of dataSerie) {
        [obj].forEach(mychar);
        i= i + 1;
    }

    function mychar(element,index,array)
    {
        name=categorias[i];
        dataSeriex=array[0];
        categoriasx=categorias[i];
        Highcharts.chart('container-'+i, {
            chart: {
                type: 'column'
            },
            title: {
                text: 'Indicadores Generales por nivel de cargo ' + name
            },
            subtitle: {
                text:  subProyectoName

            },

            xAxis: {
                categories:categoriasx,
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
            series:dataSeriex,

        });
    }

</script>
</body>
</html>
