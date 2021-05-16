@extends('master')

@section('title',"Analisis de Cumplimiento")

@section('content')

<div class="container">

            <div id="flash-message">
                @include('flash-message')

            </div>

            <div class="clearfix">
                <div class=" text-center">
                    <h5>Analisis de Cumplimiento</h5>
                </div>

                <div class="text text-center">
                    <h5>{{ $subProyecto->name }}</h5>
                </div>

            </div>


            @if($subProyecto)
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

            <div class="float-left">
                <span><a href="{{url()->previous()}}" class="btn btn-dark btn-lg">Back</a></span>
            </div>

            @else
                <div class="alert-info">
                    <p>No hay informacion disponible</p>
                <div>
            @endif

            {{-- {{ $competencias->links() }} --}}

</div>


@endsection
