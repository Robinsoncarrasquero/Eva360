@extends('mastersimulador')

@section('title',"Historico de evaluaciones")

@section('content')

<div class="container">

    <div id="flash-message">
        @include('flash-message')
    </div>

    <div class="card mt-3 ">
        <div class="text text-center p-3">
            <h4>Historico de Evaluaciones</h5>
        </div>
    </div>

    @if ($evaluaciones->count())

        <div  class="text text-center mt-2 d-flex justify-content-center" >
            <h4 style="color:brown;width:100%"class="p-2 col-6"> {{ $empleado->name }}</h4>
        </div>

        <div class="table  mt-3 text-center">
            <table class="table table-light table-responsive">
                <thead>
                    <th style="background-color:darkseagreen;width:10%" class="text-dark">Modelo</th>
                    <th style="background-color:rgb(102, 197, 7);width:10%" class="text-dark">St</th>
                    <th style="background-color:gray;width:14%" class="text-white">Inicio</th>
                    <th style="background-color:rgb(20, 20, 20);width:14%" class="text-white">Final</th>
                    <th style="background-color:darkkhaki;width:10%" class="text-dark">Evaluadores</th>
                    <th style="background-color:rgb(144, 142, 158);width:10%" class="text-white">Resultados</th>
                    <th style="background-color:gold;width:10%" class="text-dark">Grafica Individual</th>
                    <th style="background-color:chocolate;width:10%" class="text-white">Grafica Consolidada</th>
                    <th style="background-color:darkslategray;width:10%" class="text-white">Grafica Cumplimiento</th>
                    <th style="background-color:rgb(76, 0, 255);width:2%" class="text-white">FeedBack</th>
                    <th style="background-color:rgb(255, 0, 0);width:10%" class="text-white">Borrar</th>
                </thead>
                <tbody>
                @foreach ($evaluaciones as $key=>$evaluado)
                <tr id="{{ $evaluado->id }}" class="small">
                    <td>{{ $evaluado->subproyecto->name }} <br><strong class="text-dark">{{ $evaluado->word_key }}</strong>  <p style="background:rgb(179, 248, 179);  color:rgb(15, 16, 24)">{{ $evaluado->work_key}}</p></td>
                    <td class="status-progress" >
                        @if(Helper::estatus($evaluado->status)=='Finalizada')
                            <span><i class="spinner-grow spinner-grow-sm text-success" role="status"></i></span>

                        @endif

                        @if(Helper::estatus($evaluado->status)=='Inicio')
                           <span><a ><i class="spinner-grow spinner-grow-sm text-danger" role="status"></i></a></span>

                        @endif

                        @if(Helper::estatus($evaluado->status)=='Lanzada')
                            <span><i class="spinner-grow spinner-grow-sm text-warning" role="status"></i></span>

                        @endif

                    </td>
                    <td>{{ $evaluado->created_at }}</td>
                    <td>{{ $evaluado->updated_at }}</td>

                    <td >
                        @switch($evaluado->word_key)
                            @case('Objetivos')
                                <a href="{{route('objetivo.evaluacion', $evaluado->id)}}"><span><i class="material-icons">question_answer</i></span></a>
                                @break
                            @default
                            <a href="{{route('simulador.resultados', $evaluado->id)}}"><span><i class="material-icons text-dark">people</i></span></a>

                        @endswitch
                    </td>
                    <td>
                        @if($evaluado->word_key=='Objetivos')
                            <a href="{{route('objetivo.resultado', $evaluado->id)}}" ><span><i class="material-icons ">score</i></span></a>
                        @else
                            <a href="{{route('simulador.finales', $evaluado->id)}}" ><span><i class="material-icons text-danger">score</i></span></a>
                        @endif
                    </td>
                    <td >
                        @if($evaluado->word_key=='Objetivos')
                            <a href="{{route('objetivo.charindividual', $evaluado->id)}}"><span><i class="material-icons ">stacked_line_chart</i></span></a>
                        @else
                            <a href="{{route('simulador.charindividual', $evaluado->id)}}" ><span><i class="material-icons text-primary">stacked_line_chart</i></span></a>
                        @endif
                    </td>

                    <td >
                        @if($evaluado->word_key=='Objetivos')
                            <a href="{{route('feedback.edit', $evaluado->id)}}"><span><i class="material-icons ">comment</i></span></a>
                        @else
                            <a href="{{ route('simulador.charpersonalporgrupo',$evaluado->subproyecto_id) }}"><span><i class="material-icons text-success">stacked_line_chart</i></span></a>
                        @endif
                    </td>

                    <td >
                        @if($evaluado->word_key=='Objetivos')
                            <a href="{{route('feedback.edit', $evaluado->id)}}"><span><i class="material-icons ">comment</i></span></a>
                        @else
                            <a href="{{ route('simulador.analisiscumplimiento',$evaluado->subproyecto_id) }}"><span><i class="material-icons text-info">stacked_line_chart</i></span></a>
                        @endif
                    </td>

                    <td >
                        @if($evaluado->word_key=='Objetivos')
                            <a href="{{route('feedback.edit', $evaluado->id)}}"><span><i class="material-icons ">comment</i></span></a>
                        @else
                            <a href=""><span><i class="material-icons text-dark">comment</i></span></a>
                        @endif
                    </td>



                    <td>
                        <button class="btn btn-danger" onclick="deleteConfirmation({{$evaluado->id}},'{{route('evaluado.delete',$evaluado->id)}}')"
                        @if($evaluado->word_key=='Objetivos') enabled @else enabled @endif>Delete</button>
                    </td>
                </tr>
                @endforeach
                </tbody>
            </table>
        </div>

        <div class="clearfix">
            <span class="float-left"><a href=" {{route('simulador.index') }}" class="btn btn-dark btn-lg">Regresar</a></span>
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

@endsection

@section('scripts')
<script src="{{ asset('js/deleteConfirmation.js') }}"></script>
@endsection
