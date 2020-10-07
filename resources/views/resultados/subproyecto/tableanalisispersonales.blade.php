@extends('layout')

@section('title',"Analisis de Resultados Personales")

@section('content')

<div class="container">

    <div class="panel panel-default">

        <div class="col-sm-12">

            <div id="flash-message">
                @include('flash-message')

            </div>

            <div class="panel panel pb-3">

                <div class="clearfix">
                    <div class=" text-center titulo">
                        <h5>Analisis de Resultados de Competencias Personales</span></h5>
                    </div>

                    <div class="text text-center">
                        <h4>{{ $subProyecto->name }}</span></h4>
                    </div>

                </div>

            </div>

            @if($subProyecto)

                <div class="row ">

                        <div class="table col-12">
                            <table id="{{ 'table'.$subProyecto->id }}" class="table  table-bordered table-striped table-table">
                                <thead class="table-thead">
                                <th>
                                    Participante
                                </th>
                                <th>
                                    % Cumplimiento
                                </th>
                                <th>
                                    % Brecha
                                </th>
                                <th>
                                    Oportunidades de Mejora
                                </th>
                                </thead>
                                <tbody>
                                    @foreach ($dataBrecha as $key=>$value)
                                    <tr>
                                    <td>{{$value['categoria']}}</strong></td>
                                    <td>{{ number_format($value['cumplimiento'],2) }}</td>
                                    <td>{{ number_format($value['brecha'],2) }}</td>
                                    <td>
                                    @foreach ($value['dataoportunidad'] as $vdata)
                                        {{$vdata['competencia']}},
                                    @endforeach
                                    </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>

                </div>

                    <div class="clearfix">
                        <span class="float-left"><a href="{{url()->previous()}}" class="btn btn-dark btn-lg">Back</a></span>

                    </div>
            @else

                <div class="alert-info">
                    <p>No hay informacion disponible</p>
                <div>

            @endif

            {{-- {{ $competencias->links() }} --}}

        </div>

    </div>

</div>


@endsection