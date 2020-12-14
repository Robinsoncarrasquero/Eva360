@extends('lanzamiento.proyecto.layout')

@section('title',"Historico de Evaluaciones")

@section('content')

<div class="container">

            <div id="flash-message">
                @include('flash-message')
            </div>

            <div class="card mt-2 p-2 alert-info">
                <div class="text text-center pb-2">
                    <h5>Historico de Evaluaciones de {{ $empleado->name }}</h5>
                </div>
            </div>
            <div class="panel panel">

            @if ($evaluaciones->count())
                <div class="table ">
                <table class="table table-table">
                    <thead>
                        <th>Proyecto</th>
                        <th>Inicio</th>
                        <th>Final</th>
                    </thead>
                    <tbody>
                    @foreach ($evaluaciones as $key=>$evaluado)
                    <tr>
                        <td>{{ $evaluado->subproyecto->name }} <p style="background:rgb(179, 248, 179);  color:rgb(15, 16, 24)">{{ $evaluado->work_key}}</p></td>
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
                    <span class="float-left"><a href=" {{route('empleado.index') }}" class="btn btn-dark btn-lg">Back</a></span>
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
