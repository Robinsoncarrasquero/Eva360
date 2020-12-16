@extends('lanzamiento.proyecto.layout')

@section('title',"Historico de Evaluaciones")

@section('content')

<div class="container">

            <div id="flash-message">
                @include('flash-message')
            </div>

            <div class="card mt-3 ">
                <div class="text text-center p-3">
                    <h5>Historico de Evaluaciones</h5>
                </div>
            </div>

            <div class="panel panel">

            @if ($evaluaciones->count())

                <div  class="text text-center mt-2 d-flex justify-content-center" >
                    <h4 style="color:brown;width:100%"class="p-2 col-6"> {{ $empleado->name }}</h4>
                </div>

                <div class="table mt-4">
                <table class="table table-light">
                    <thead>
                        <th style="background-color:darkseagreen;width:40%" class="text-dark">Proyecto</th>
                        <th style="background-color:gray;width:15%" class="text-white">Inicio</th>
                        <th style="background-color:gray;width:15%" class="text-white">Final</th>
                        <th style="background-color:lawngreen;width:10%" class="text-dark">Status</th>
                        <th style="background-color:darkkhaki;width:10%" class="text-dark">Prueba</th>
                        <th style="background-color:rgb(144, 142, 158);width:10%" class="text-dark">Resultado</th>
                        <th style="background-color:gold;width:10%" class="text-dark">Grafica</th>

                    </thead>
                    <tbody>
                    @foreach ($evaluaciones as $key=>$evaluado)
                    <tr>
                        <td>{{ $evaluado->subproyecto->name }} <br><strong class="text-dark">{{ $evaluado->word_key }}</strong>  <p style="background:rgb(179, 248, 179);  color:rgb(15, 16, 24)">{{ $evaluado->work_key}}</p></td>
                        <td>{{ $evaluado->created_at }}</td>
                        <td>{{ $evaluado->updated_at }}</td>
                        <td class="status-progress" >
                            @if(Helper::estatus($evaluado->status)=='Finalizada')
                                <span><i class="spinner-grow spinner-grow-sm text-success" role="status"></i></span>
                            @endif

                            @if(Helper::estatus($evaluado->status)=='Inicio')
                                <span><a ><i class="spinner-grow spinner-grow-sm text-warning" role="status"></i></a></span>
                            @endif

                            @if(Helper::estatus($evaluado->status)=='Lanzada')
                                <span><i class="spinner-grow spinner-grow-sm text-info" role="status"></i></span>
                            @endif
                        </td>
                        <td >
                            @if(Helper::estatus($evaluado->status)=='Finalizada')
                                <a href="{{route('resultados.evaluacion', $evaluado->id)}}"><span><i class="material-icons">question_answer</i></span></a>
                            @else
                                <a href="{{route('resultados.evaluacion', $evaluado->id)}}"><span><i class="material-icons text-dark">question_answer</i></span></a>
                            @endif
                        </td>
                        <td>
                            @if(Helper::estatus($evaluado->status)=='Finalizada')
                                <a href="{{route('resultados.finales', $evaluado->id)}}" ><span><i class="material-icons ">score</i></span></a>
                            @else
                                <a href="{{route('resultados.finales', $evaluado->id)}}" ><span><i class="material-icons text-dark ">score</i></span></a>
                            @endif
                        </td>
                        <td >
                            @if(Helper::estatus($evaluado->status)=='Finalizada')
                                <a href="{{route('resultados.graficas', $evaluado->id)}}"><span><i class="material-icons ">stacked_line_chart</i></span></a>
                            @else
                                <a href="{{route('resultados.graficas', $evaluado->id)}}" ><span><i class="material-icons text-dark">stacked_line_chart</i></span></a>
                            @endif
                        </td>
                        <td>
                    </tr>
                    @endforeach
                    </tbody>
                </table>
                </div>
                <div class="clearfix">
                    <span class="float-left"><a href=" {{route('talent.index') }}" class="btn btn-dark btn-lg">Back</a></span>
                </div>

                <div class=" d-flex justify-content-center">
                    {{-- {{ $evaluaciones->links() }} --}}
                    {{-- {{ $evaluados->appends(["name"=>$evaluado->name])  }} --}}
                </div>

            @else
                <div class="d-flex alert alert-info mt-2">
                    <p>No hay informacion disponible</p>
                <div>
            @endif



        </div>

    </div>

@endsection
