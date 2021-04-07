@extends('master')

@section('title',"Control de evaluados")

@section('content')

<div class="container">


            <div id="flash-message">
                @include('flash-message')

            </div>

            <div class="panel panel pb-2">
                <div class="clearfix">
                     <form class="form-inline mt-2 mt-md-0 float-left col-sm-6">
                        <input class="form-control mr-sm-2" type="text" placeholder="Nombre" aria-label="Searh" name="buscarWordKey">
                        <button class="btn btn-outline-success my-2 my-sm-0" type="submit">Buscar</button>
                    </form>
                </div>

                <div class="text text-center">
                    <h5 style="color:royalblue; font-size:1.5rem">Evaluados</h5>
                </div>
            </div>

            {{-- @if ($subproyecto>0)
            <div class=" float-right">
                <a  href="{{ route('json.fileindex')}}" class="btn btn-dark"><i class="material-icons">attachment person_add</library-add></i> </a>
                <a  href="{{ route('evaluado.create',$subproyecto)}}" class="btn btn-dark"><i class="material-icons">person_add</library-add></i> </a>
            </div>

            @endif --}}

            @if($evaluados->count())

            <div class="panel">

                <div class="table table-table table-responsive">
                    <table id="table-evaluados" class="table  table-striped">
                    <thead>
                    <th>Nombre</th>
                    <th>Subproyecto</th>
                    <th>Status</th>
                    <th>Progreso</th>
                    <th>Inicio</th>
                    <th>Update</th>
                    {{-- <th>Modelo</th> --}}
                    {{-- <th>Filtro</th> --}}
                    <th>Evaluadores</th>
                    <th>Resultado</th>
                    <th>Grafica</th>
                   </thead>
                    <tbody>
                    @foreach($evaluados as $evaluado)
                    <tr>
                        {{-- <td>{{$evaluado->name}} <br>{{$evaluado->cargo->name}}</td> --}}
                        <td>{{ $evaluado->name }}<p style="background:rgb(179, 248, 179);  color:rgb(15, 16, 24)">{{ $evaluado->cargo->name}}</p></td>
                        <td>{{$evaluado->subProyecto->name}}</td>
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
                        <td>
                            <div class="status-progress">
                                @if(Helper::estatus($evaluado->status)=='Finalizada')
                                    <span id="inicio" class="radio-checkeado" ></span>
                                    <span id="medio" class="radio-checkeado" ></span>
                                    <span id="final" class="radio-checkeado" ></span>
                                @endif

                                @if(Helper::estatus($evaluado->status)=='Inicio')
                                    <span id="inicio" class="radio-checkeado" ></span>
                                    <span id="medio" class="radio-no-checkeado" ></span>
                                    <span id="final" class="radio-no-checkeado"></span>
                                @endif

                                @if(Helper::estatus($evaluado->status)=='Lanzada')
                                    <span id="inicio" class="radio-checkeado"></span>
                                    <span id="medio" class="radio-checkeado"></span>
                                   <span id="final" class="radio-no-checkeado"></span>
                                @endif
                            </div>
                            <span>{{ Helper::estatus($evaluado->status) }}</span>
                        </td>
                        <td>{{ $evaluado->created_at }}</td>
                        <td>{{ $evaluado->updated_at }}</td>
                        {{-- <td>
                            @if(Helper::estatus($evaluado->status)=='Inicio')
                                <a href="{{ route('lanzar.seleccionarmodelo',$evaluado->id) }}"><span><i class="material-icons">flight_takeoff</i></span></a>
                            @else
                                <a ><span><i class="material-icons text-dark">flight_takeoff</i></span></a>
                            @endif

                        </td>   --}}
                        {{-- <td>
                            @if(Helper::estatus($evaluado->status)!='Finalizada')
                                <a href="{{route('lanzar.seleccionar',$evaluado->id)}}"><span><i class="material-icons">filter_list</i></span></a>
                            @else
                                <a href="{{route('lanzar.seleccionar',$evaluado->id)}}"><span><i class="material-icons">filter_list muted</i></span></a>
                            @endif
                        </td> --}}
                        <td>
                            @if(Helper::estatus($evaluado->status)=='Finalizada')
                                <a href="{{route('resultados.evaluacion', $evaluado->id)}}" >
                                <span><i class="material-icons ">question_answer</i></span>
                            @else
                                <a href="{{route('resultados.evaluacion', $evaluado->id)}}" >
                                <span><i class="material-icons text-dark ">question_answer</i></span>
                            @endif

                        </td>
                        <td>
                            @if(Helper::estatus($evaluado->status)=='Finalizada')
                                <a href="{{route('resultados.finales', $evaluado->id)}}" >
                                <span><i class="material-icons ">score</i></span>
                            @else
                                <a href="{{route('resultados.finales', $evaluado->id)}}" >
                                <span><i class="material-icons text-dark ">score</i></span>
                            @endif

                        </td>

                        <td >
                            @if(Helper::estatus($evaluado->status)=='Finalizada')
                                <a href="{{route('resultados.charindividual', $evaluado->id)}}"><span><i class="material-icons ">stacked_line_chart</i></span></a>
                            @else
                                <a href="{{route('resultados.charindividual', $evaluado->id)}}" ><span><i class="material-icons text-dark">stacked_line_chart</i></span></a>
                            @endif
                        </td>
                    </tr>
                    @endforeach
                    </tbody>
                    </table>
                </div>

            </div>

            @else

            <div class="d-flex alert alert-info">
                <p>No hay usuarios registrados</p>
            <div>

            @endif

            <div class=" d-flex justify-content-center">
                {{ $evaluados->links() }}
            </div>


</div>


@endsection
