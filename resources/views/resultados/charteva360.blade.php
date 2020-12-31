{{-- @extends('master') --}}

@section('title',"Grafica Individual")

@section('content')

{{-- <div class="container"> --}}
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">

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
        <div class="col-lg-12 mb-1" id="container0"></div>
    </div>

    {{-- <div class="mt-3">

        @if($competencias)

            <div class="row">
                @foreach($competencias as $key=>$value)
                    <div class="table col-6 ">
                        <table id="{{$key}}" class="table table-bordered table-table">
                            <thead>
                            <tr>
                                <th class="text text-center title-th-competencia" colspan="2">
                                <strong >{{ $value['competencia']}} (Margen Requerido {{ $value['nivelRequerido'] }})
                                </strong> </th>
                            </tr>
                            <th>Evaluador</th>
                            <th>Poderado</th>
                            </thead>
                            <tbody>
                                @foreach ($value['data'] as $item)
                                <tr>
                                    <td >{{ $item['name']}}</td>
                                    <td>{{ number_format($item['average'],2)}}</td>
                                </tr>
                                @endforeach
                                <tr>
                                    <td class="text text-center"><strong>Resultado Final</strong></td>
                                    <td class="text text-dark" ><a href=""><i class="material-icons">bar_chart</i></a>{{ number_format($value['eva360'],2)}}</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                @endforeach
            </div>
        @endif
    </div> --}}
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
    var evaluado =  @json($evaluado->name);

    categorias.forEach(logArrayElements);

    function logArrayElements(element, index, array) {
        console.log("a[" + index + "] = " + element);
    }

    ['data1'].forEach(mychar);

    function mychar(element,index,array)
    {
        Highcharts.chart('container'+index, {
        //Highcharts.chart('container', {
            title: {
                text: "Resultado de la evaluacion"
            },
            subtitle: {
                text: evaluado

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

    }


</script>
</body>
</html>
