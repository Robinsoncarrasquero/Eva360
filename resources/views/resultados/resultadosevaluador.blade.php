@extends('layout')

@section('title',"Resultados")

@section('content')

<div class="container">

    <div class="panel panel-default">

        <div class="col-md-12">

            <div id="flash-message">
                @include('flash-message')

            </div>

            <div class="panel panel pb-3">

                <div class="clearfix">
                    <div class="alert alert-info text-center">
                        <h5>Resultados de la evaluacion de <span class="text-danger">{{ $evaluado->name }}</span></h5>
                    </div>

                    <div class="text text-center">
                        <h4>Competencias evaluadas y respuestas</span></h4>
                    </div>

                </div>

            </div>

            @if($evaluadores)

            <div class="panel-body">
                    @foreach($evaluadores as $evaluador)
                    <div class="table table-striped">
                        <table id="{{ 'table'.$evaluador->id }}mytable" class="table  table-bordred table-striped">
                        <thead>

                        <th>Competencia</th>
                        <th>Descripcion</th>
                        <th>Grado</th>
                        <th>%</th>
                        <th>Frecuencia</th>
                        <th>Resultado</th>
                        <tr>
                            <th class="text text-center alert alert-warning" colspan="6">
                            {{$evaluador->name}} == {{ $evaluador->relation }}
                            </th>
                        </tr>

                        </thead>
                        <tbody>


                        @foreach ($evaluador->evaluaciones as $evaluacion)
                        <tr>
                            <td>{{$evaluacion->competencia->name}}</td>
                            <td>{{$evaluacion->competencia->description}}</td>
                            <td>{{ $evaluacion->grado }}{{ $evaluacion->competencia_id }}</td>
                            <td class="text text-center">{{ $evaluacion->ponderacion}}</td>
                            <td class="text text-center">{{ $evaluacion->frecuencia/100}}</td>
                            <td class="text text-center alert-dark">{{ $evaluacion->resultado}}</td>
                        </tr>
                        @endforeach
                    </tbody>
                    </table>
                    @endforeach

                </div>
                <div class="clearfix">
                    <span class="float-left"><a href="{{url()->previous()}}" class="btn btn-dark btn-lg">Back</a></span>

                </div>


            </div>

            @else

            <div class="alert-info">
                <p>No Preguntas disponibles para responder</p>
            <div>

            @endif

            {{-- {{ $competencias->links() }} --}}

        </div>

    </div>

</div>


@endsection
