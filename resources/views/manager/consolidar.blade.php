@extends('master')

@section('title',"FeedBack Edit")

@section('content')

<div class="container">

    <div id="flash-message">
        @include('flash-message')
    </div>

    <div class="text text-center col">
        <h4 style="color:blue" >CONSOLIDACION DE RESULTADOS</h4>

    </div>

    {{-- @if ($feedbacks->count()>0)
        <div class="d-flex justify-content-start">
            <div class="col text text-center">
                <a href=" {{route('feedBack->exportfeedback',$evaluado)  }} "><h4 style="color:orange"> Exportar Feedback a Excel </h4></a>
            </div>
        </div>

    @endif --}}

    <div class="row">

        <div class="col-6 ">
            <div class="table">
                <table id="{{ 'tablex' }}" class="table table-bordered table-striped table-table">
                    <thead class="table-thead" style="text-align: center;background:black;color:white">
                        <tr>
                            <th>Competencias</th>
                            @foreach ($dataCategoriaCom as $key=>$value)
                            <th>
                                <strong>{{$value}}</strong>
                            </th>
                            @endforeach
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($dataSerieCom as $key=>$dataValue)
                        <tr>
                            @if ($dataValue['data'][0]>($dataValue['data'][1]))
                                <td  class="btn btn-danger" xstyle="font-size:1em; color:white;background:red">{{$dataValue['name']}}</td>
                            @else
                                <td >{{$dataValue['name']}}</td>
                            @endif
                            @foreach ($dataValue['data'] as $vdata)
                                @if ($dataValue['data'][0]>($dataValue['data'][1]))
                                    <td style="font-size:1em; color:red" class="text text-center">{{ number_format($vdata,2)}}</td>
                                @else
                                    <td class="text text-center">{{ number_format($vdata,2)}}</td>
                                @endif
                            @endforeach
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        <div class="col-6">
            <div class="table pb-2">
                <table  class="table  table-bordered table-striped table-table">
                    <thead class="table-thead" style="background-color:black;color:white">

                    <th>Cumplimiento</th>
                    <th>Brecha</th>
                    <th>Potencial</th>
                    <th>Oportunidad</th>
                    <th>Fortaleza</th>
                    </thead>
                    <tbody>
                        @foreach ($dataBrechaCom as $key=>$value)
                        <tr style="text-align: center">

                        <td>{{ number_format($value['cumplimiento'],2) }}</td>
                        <td>
                        @if ($value['cumplimiento']!=100)
                            {{ number_format($value['brecha'],2) }}
                        @endif
                        </td>
                        <td>
                            @if ($value['potencial']>100)
                            <span style="font-size:1em; color:white;background:green">{{ number_format($value['potencial']-100,2) }}</span>
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


    </div>


    <div class="row">

        <div class="col-6 ">
            <div class="table">
                <table id="{{ 'tablex' }}" class="table table-bordered table-striped table-table">
                    <thead class="table-thead" style="text-align: center;background:black;color:white">
                        <tr>
                            <th>Objetivos</th>
                            @foreach ($dataCategoriaObj as $key=>$value)
                            <th>
                                <strong>{{$value}}</strong>
                            </th>
                            @endforeach

                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($dataSerieObj as $key=>$dataValue)
                        <tr>
                            @if ($dataValue['data'][0]>($dataValue['data'][1]))
                                <td  class="btn btn-danger" xstyle="font-size:1em; color:white;background:red">{{$dataValue['name']}}</td>
                            @else
                                <td >{{$dataValue['name']}}</td>
                            @endif
                            @foreach ($dataValue['data'] as $vdata)
                                @if ($dataValue['data'][0]>($dataValue['data'][1]))
                                    <td style="font-size:1em; color:red" class="text text-center">{{ number_format($vdata,2)}}</td>
                                @else
                                    <td class="text text-center">{{ number_format($vdata,2)}}</td>
                                @endif
                            @endforeach

                        </tr>
                        @endforeach
                        @foreach ($objetivos as $key=>$value)
                            <tr>
                                <td>
                                    <strong>{{$value->submeta->description}}</strong>
                                </td>
                                <td>
                                    <strong>{{$value->valormeta}}</strong>
                                </td>
                                <td>
                                    <strong>{{$value->cumplido}}</strong>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        <div class="col-6">
            <div class="table pb-2">
                <table  class="table  table-bordered table-striped table-table">
                    <thead class="table-thead" style="background-color:black;color:white">

                    <th>Cumplimiento</th>
                    <th>Brecha</th>
                    <th>Excedente</th>
                    <th>Oportunidad</th>
                    <th>Fortaleza</th>
                    </thead>
                    <tbody>
                        @foreach ($dataBrechaObj as $key=>$value)
                        <tr style="text-align: center">

                        <td>{{ number_format($value['cumplimiento'],2) }}</td>
                        <td>
                        @if ($value['cumplimiento']!=100)
                            {{ number_format($value['brecha'],2) }}
                        @endif
                        </td>
                        <td>
                            @if ($value['potencial']>100)
                            <span style="font-size:1em; color:white;background:green">{{ number_format($value['potencial']-100,2) }}</span>
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


        <div class="col-12">
            <div class="text-center">
                <h2>Resultado Final</h2>
                <h4 class="text text-primary">{{ $evaluado_com->user->name }}</h4>
            </div>

            <div class="table table-responsive">
                <table  class="table  table-bordered table-striped table-dark">
                    <thead class=" text-center">

                    <th>Competencias</th>
                    <th>Resultado</th>
                    <th>Objetivos</th>

                    </thead>
                    <tbody class="text-center">
                        @foreach ($resultado as $key=>$value)
                        <tr >

                        <td>{{ $value['Competencias']}}</td>
                        <td class="btn btn-success">{{ $value['Resultado'] }}</td>
                        <td>{{ $value['Objetivos']  }}</td>

                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <div class="row mt-4">
        <div class="col">
            @if (Auth::user()->is_manager)
                <a href="{{ route('manager.staff',$evaluado_com->subproyecto_id)}}" class="btn btn-dark float-left">Back</a>
            @else
                <a href="{{ route('talent.historicoevaluaciones',$evaluado_com->user_id)}}" class="btn btn-dark float-left">Back</a>
            @endif
        </div>
    </div>



</div>

@endsection
