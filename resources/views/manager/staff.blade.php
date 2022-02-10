@extends('master')

@section('title',"Control de evaluaciones")

@section('content')

<div class="container">

        <div id="flash-message">
            @include('flash-message')
        </div>

        <div class="card pb-2 mt-2">

            <div class="text text-center">
                <h4 style="color:rgb(4, 44, 165); font-size:1.5rem">EVALUACIONES DEL PERSONAL</h4>

            </div>

        </div>

        @if ($subproyecto->count())

                <div class="panel mt-3 pb-2">
                    <span class="titulo-subproyecto">{{$subproyecto->name}} </span> <span  style="font-size: 0.75rem;" class="titulo-proyecto" ><i class="material-icons">east</i> {{$subproyecto->proyecto->name}}</span>
                    <span class="float-right d-flex justify-content-around">
                        @if ($subproyecto->proyecto->tipo=='Objetivos')
                        <a href="{{ route('objetivo.charpersonalporgrupo',$subproyecto->id) }}" style="color:black"><span style="font-size: 0.75rem">Grupos <i class="material-icons">table_chart</i></span></a>
                        <a href="{{ route('objetivo.analisiscumplimiento',$subproyecto->id) }}" style="color: black"><span style="font-size: 0.75rem">Cumplimiento <i class="material-icons">dynamic_feed</i></span></a>
                        @endif
                    </span>
                </div>

                <div class="table table-table table-responsive">
                    <table class="table" id="p{{ $subproyecto->id }}">
                        <thead>
                            <th style="width: 30%">Nombre</th>
                            <th style="width: 5%">Status</th>
                            <th style="width: 15%">Inicio</th>
                            <th style="width: 15%">Update</th>
                            {{-- <th>Lanzar</th> --}}
                            <th style="width: 10%">Evaluadores</th>
                            <th style="width: 10%">Resultado</th>
                            <th style="width: 10%">Grafica</th>
                            <th style="width: 5%">Feedback</th>
                            <th style="width: 5%">Borrar</th>
                        </thead>
                        <tbody>
                        @foreach ($evaluados as $evaluado)
                        @if ($evaluado->user->active)
                        <tr id="{{ $evaluado->id }}">
                        <td>{{ $evaluado->user->name }}<p style="background:rgb(179, 248, 179);  color:rgb(15, 16, 24)">{{ $evaluado->cargo->name}}</p><p style="color:rgb(228, 74, 82)" >{{ $evaluado->word_key}}</p></td>
                        <td class="status-progress" >
                            @if(Helper::estatus($evaluado->status)=='Finalizada')
                                {{-- <span id="inicio" class="radio-checkeado" ></span>
                                <span id="medio" class="radio-checkeado" ></span>
                                <span id="final" class="radio-checkeado" ></span> --}}
                                <i class="spinner-grow spinner-grow-sm text-success" role="status"></i>
                            @endif

                            @if(Helper::estatus($evaluado->status)=='Inicio')
                                {{-- <span id="inicio" class="radio-checkeado" ></span>
                                <span id="medio" class="radio-no-checkeado" ></span>
                                <span id="final" class="radio-no-checkeado"></span> --}}
                                <a href="{{ route('lanzar.seleccionarmodelo',$evaluado->id) }}"><i class="spinner-grow spinner-grow-sm text-danger" role="status"></i></a>
                            @endif

                            @if(Helper::estatus($evaluado->status)=='Lanzada')
                                {{-- <span id="inicio" class="radio-checkeado"></span>
                                <span id="medio" class="radio-checkeado"></span>
                                <span id="final" class="radio-no-checkeado"></span> --}}
                                <i class="spinner-grow spinner-grow-sm text-warning" role="status"></i>
                            @endif
                        </td>
                        <td>{{ $evaluado->created_at }}</td>
                        <td>{{ $evaluado->updated_at }}</td>

                        <td >
                            @switch($evaluado->word_key)
                                @case('Objetivos')
                                    @if(Helper::estatus($evaluado->status)=='Finalizada')
                                        <a href="{{route('objetivo.evaluacion', $evaluado->id)}}"><span><i class="material-icons">question_answer</i></span></a>
                                    @else
                                        <a href="{{route('objetivo.evaluacion', $evaluado->id)}}"><span><i class="material-icons text-dark">question_answer</i></span></a>
                                    @endif
                                    @break
                                @case('90')
                                    @if(Helper::estatus($evaluado->status)=='Finalizada')
                                        <a href="{{route('resultados.evaluacion', $evaluado->id)}}"><span><i class="material-icons">question_answer</i></span></a>
                                    @else
                                        <a href="{{route('resultados.evaluacion', $evaluado->id)}}"><span><i class="material-icons text-dark">question_answer</i></span></a>
                                    @endif
                                @default
                                    @break
                            @endswitch
                        </td>

                        <td>
                            @if($evaluado->word_key=='Objetivos')
                                @if(Helper::estatus($evaluado->status)=='Finalizada')
                                    <a href="{{route('objetivo.resultado', $evaluado->id)}}" ><span><i class="material-icons ">score</i></span></a>
                                @else
                                    <a href="{{route('objetivo.resultado', $evaluado->id)}}" ><span><i class="material-icons text-dark ">score</i></span></a>
                                @endif
                            @else
                                @if(Helper::estatus($evaluado->status)=='Finalizada')
                                        <a href="{{route('resultados.finales', $evaluado->id)}}" ><span><i class="material-icons ">score</i></span></a>
                                    @else
                                        <a href="{{route('resultados.finales', $evaluado->id)}}" ><span><i class="material-icons text-dark ">score</i></span></a>
                                    @endif
                                @endif
                        </td>
                        <td >
                            @if($evaluado->word_key=='Objetivos')
                                @if(Helper::estatus($evaluado->status)=='Finalizada')
                                    <a href="{{route('objetivo.charindividual', $evaluado->id)}}"><span><i class="material-icons ">stacked_line_chart</i></span></a>
                                @else
                                    <a href="{{route('objetivo.charindividual', $evaluado->id)}}" ><span><i class="material-icons text-dark">stacked_line_chart</i></span></a>
                                @endif
                            @else
                                @if(Helper::estatus($evaluado->status)=='Finalizada')
                                    <a href="{{route('resultados.charindividual', $evaluado->id)}}"><span><i class="material-icons ">stacked_line_chart</i></span></a>
                                @else
                                    <a href="{{route('resultados.charindividual', $evaluado->id)}}" ><span><i class="material-icons text-dark">stacked_line_chart</i></span></a>
                                @endif
                            @endif

                        </td>

                        <td >
                            @if(Helper::estatus($evaluado->status)=='Finalizada')
                                <a href="{{route('feedback.edit', $evaluado->id)}}"><span><i class="material-icons ">comment</i></span></a>
                            @else
                                <a href="{{route('feedback.edit', $evaluado->id)}}" ><span><i class="material-icons text-dark">comment</i></span></a>
                            @endif
                        </td>
                        <td>
                            <button class="btn btn-danger" onclick="deleteConfirmation({{$evaluado->id}},'{{route('evaluado.delete',$evaluado->id)}}')"
                            @if($evaluado->word_key=='Objetivos') enabled @else disabled @endif>Delete</button>
                        </td>
                        </tr>
                        @endif
                        @endforeach
                        </tbody>
                    </table>
                </div>

            {{-- <div class=" d-flex justify-content-center">
                {{ $subproyectos->links() }}
            </div> --}}

        @else
            <div class="d-flex alert alert-info">
                <p>No hay informacion de evaluaciones registradas</p>
            <div>
        @endif


        <div class="clearfix col-lg-12">
            <a href="{{ route('manager.index')}}" class="btn btn-dark float-left">Back</a>
        </div>

</div>

@section('scripts')
    <script src="{{ asset('js/deleteConfirmation.js') }}"></script>
@endsection

@endsection
