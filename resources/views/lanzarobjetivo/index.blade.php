@extends('master')

@section('title',"Control de evaluaciones por objetivos")

@section('content')

<div class="container">

            <div id="flash-message">
                @include('flash-message')
            </div>

            <div class="card pb-2 mt-2">
                <div class="clearfix ">

                     <form class="form-inline mt-2 mt-md-0 float-left col-sm-6">
                        <input class="form-control mr-sm-2" type="text" placeholder="Proyecto" aria-label="Searh" name="buscarWordKey">
                        <button class="btn btn-outline-success my-2 my-sm-0" type="submit">Buscar</button>
                    </form>
                </div>
                <div class="text text-center">
                    <h5 style="color:royalblue; font-size:1.5rem">EVALUACION POR OBJETIVOS</h5>
                </div>

            </div>

            @if ($proyectos->count())
                @foreach ($proyectos as $proyecto)
                    <div class="card-header mt-4">
                        <span class="titulo-proyecto text-dark">{{$proyecto->name }} </span>
                        <span class="float-right d-flex flex-column ">
                            <a href="{{ route('objetivo.resultadosgeneralestipo',$proyecto->id) }}" style="color:green;"><span style="font-size: 0.75rem">Tipo <i class="material-icons">leaderboard</i></span></a>
                            <a href="{{ route('objetivo.resultadosgeneralesnivel',$proyecto->id) }}" style="color:green;"><span style="font-size: 0.75rem">Nivel <i class="material-icons">assessment</i></span></a>
                        </span>
                        </p>
                    </div>

                    @foreach ($proyecto->subproyectos as $subproyecto)
                    <div class="panel mt-2">

                        <span class="titulo-subproyecto">{{$subproyecto->name}} </span> <span  style="font-size: 0.75rem;" class="titulo-proyecto" ><i class="material-icons">east</i> {{$proyecto->name}}</span>
                        <span class="float-right d-flex justify-content-around">
                            <a href="{{ route('objetivo.charpersonalporgrupo',$subproyecto->id) }}" style="color:black"><span style="font-size: 0.75rem">Grupos <i class="material-icons">table_chart</i></span></a>
                            <a href="{{ route('objetivo.analisiscumplimiento',$subproyecto->id) }}" style="color: black"><span style="font-size: 0.75rem">Cumplimiento <i class="material-icons">dynamic_feed</i></span></a>
                            {{-- <a href="{{ route('evaluado.create',$subproyecto)}}" class="btn btn-dark"><i class="material-icons">person_add</library-add></i> </a> --}}
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
                                <th style="width: 5%"></th>
                            </thead>
                            <tbody>
                            @foreach ($subproyecto->evaluados as $evaluado)
                            <tr id="{{ $evaluado->id }}">
                            <td>{{ $evaluado->user->name}}<p style="background:rgb(179, 248, 179);  color:rgb(15, 16, 24)">{{ $evaluado->cargo->name}} {{ $evaluado->user->departamento_id}}</p></td>
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
                                    <a href="{{ route('lanzarobjetivo.seleccionar',$evaluado->user_id) }}"><i class="spinner-grow spinner-grow-sm text-danger" role="status"></i></a>
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
                            {{-- <td>
                                @if(Helper::estatus($evaluado->status)=='Inicio')
                                    <a href="{{ route('lanzar.seleccionarmodelo',$evaluado->id) }}"><span><i class="material-icons">flight_takeoff</i></span></a>
                                @else
                                    <a ><span><i class="material-icons text-dark m-0">flight_takeoff</i></span></a>
                                @endif

                            </td> --}}
                            <td >
                                @if(Helper::estatus($evaluado->status)=='Finalizada')
                                    <a href="{{route('objetivo.evaluacion', $evaluado->id)}}"><span><i class="material-icons">question_answer</i></span></a>
                                @else
                                    <a href="{{route('objetivo.evaluacion', $evaluado->id)}}"><span><i class="material-icons text-dark">question_answer</i></span></a>
                                @endif
                            </td>
                            <td>
                                @if(Helper::estatus($evaluado->status)=='Finalizada')
                                    <a href="{{route('objetivo.resultado', $evaluado->id)}}" ><span><i class="material-icons ">score</i></span></a>
                                @else
                                    <a href="{{route('objetivo.resultado', $evaluado->id)}}" ><span><i class="material-icons text-dark ">score</i></span></a>
                                @endif
                            </td>
                            <td >
                                @if(Helper::estatus($evaluado->status)=='Finalizada')
                                    <a href="{{route('objetivo.charindividual', $evaluado->id)}}"><span><i class="material-icons ">stacked_line_chart</i></span></a>
                                @else
                                    <a href="{{route('objetivo.charindividual', $evaluado->id)}}" ><span><i class="material-icons text-dark">stacked_line_chart</i></span></a>
                                @endif
                            </td>

                            <td>
                                <button class="btn btn-danger" onclick="deleteConfirmation({{$evaluado->id}},'{{route('evaluado.delete',$evaluado->id)}}')">Delete</button>
                            </td>
                            </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                    @endforeach
                @endforeach

                <div class=" d-flex justify-content-center">
                    {{ $proyectos->links() }}
                </div>

            @else
                <div class="d-flex alert alert-info">
                    <p>No hay informacion de proyectos registrado</p>
                <div>
            @endif

    </div>

    @section('scripts')
        <script src="{{ asset('js/deleteConfirmation.js') }}"></script>
    @endsection

@endsection
