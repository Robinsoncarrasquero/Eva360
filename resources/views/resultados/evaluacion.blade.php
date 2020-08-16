@extends('layout')

@section('title',"Resultados")

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
                        <h5>Evaluacion Detallada de la Prueba realizada a <span class="text-danger">{{ $evaluado->name }}</span></h5>
                    </div>

                    <div class="text text-center">
                        <h4>Competencias evaluadas y respuestas</span></h4>
                    </div>

                </div>

            </div>

            @if($evaluadores)

                <div class="row ">

                    @foreach($evaluadores as $evaluador)
                        <div class="table col-6">
                            <table id="{{ 'table'.$evaluador->id }}" class="table  table-bordered table-striped table-table">
                                <thead>
                                    <th>Competencia</th>
                                    <th>Descripcion</th>
                                    <th>Grado</th>
                                    <th>%</th>
                                    <th>Frecuencia</th>
                                    <th>Resultado</th>
                                    <tr>
                                        <th class="text text-center  title-th-evaluador" colspan="6">
                                        Evaluador : {{$evaluador->name}} <strong>( {{ $evaluador->relation }} )</strong>
                                        </th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($evaluador->evaluaciones as $evaluacion)
                                    <tr>
                                        <td>{{$evaluacion->competencia->name}}</td>
                                        <td>{{substr($evaluacion->competencia->description,0,50)}}</td>
                                        <td>{{ $evaluacion->grado }}</td>
                                        <td class="text text-center">{{ $evaluacion->ponderacion}}</td>
                                        <td class="text text-center">{{ $evaluacion->frecuencia/100}}</td>
                                        <td class="text text-center"><span class="badge badge-dark">{{ $evaluacion->resultado}}</span></td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @endforeach
                </div>

                    <div class="clearfix">
                        <span class="float-left"><a href="{{url()->previous()}}" class="btn btn-dark btn-lg">Back</a></span>

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
