@extends('layout')

@section('title',"Panel de control")

@section('content')

<div class="container">

    <div class="mt-1 panel panel-default">


            <div id="flash-message">
                @include('flash-message')

            </div>

            <div class="panel panel pb-1">
                <div class="clearfix">

                    <div class="text text-center">
                        <h5>Proyectos de Evaluacion</h5>
                    </div>

                     <form class="form-inline mt-2 mt-md-0 float-left col-sm-6">
                        <input class="form-control mr-sm-2" type="text" placeholder="Proyecto" aria-label="Searh" name="buscarWordKey">
                        <button class="btn btn-outline-success my-2 my-sm-0" type="submit">Buscar</button>
                    </form>
                </div>
            </div>


            @if ($proyectos->count())

                    <div class="table col-12" >
                        <table id="table-proyectos" >
                        <thead>
                            <th>Proyecto</th>
                        </thead>
                        <tbody>

                        @foreach ($proyectos as $proyecto)
                        <tr>
                            <td class="text text-danger" >{{$proyecto->name}}</td>
                            <td>
                            @foreach ($proyecto->subproyecto as $subproyecto)
                                <ul>
                                    <p >Sub Proyecto</p>

                                    <li class="panel panel-content">
                                    {{$subproyecto->name}}
                                    <div class="float-right">
                                        {{-- <a  href="{{ route('json.fileindex')}}" class="btn btn-dark"><i class="material-icons">attachment person_add</library-add></i> </a> --}}
                                        <a  href="{{ route('evaluado.create',$subproyecto)}}" class="btn btn-dark"><i class="material-icons">person_add</library-add></i> </a>
                                    </div>
                                    <div class="data-evaluado">
                                    <table id="table-evaluado" class="table">
                                        <thead>
                                            <th>Nombre</th>
                                            <th>Progreso</th>
                                            <th>Lanzar</th>
                                            <th>Prueba</th>
                                            <th>Resultado</th>
                                            <th>Grafica</th>
                                        </thead>
                                        <tbody>
                                        @foreach ($subproyecto->evaluado as $evaluado)
                                        <tr>
                                            <td>
                                            {{ substr($evaluado->name,1,30) }}<br>
                                            {{ substr($evaluado->cargo,1,30)}}
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
                                            <td>
                                                @if(Helper::estatus($evaluado->status)!='Finalizada')
                                                    <a href="{{ route('lanzar.seleccionarmodelo',$evaluado->id) }}"><span><i class="material-icons">select_all</i></span></a>
                                                @else
                                                    <a href="{{ route('lanzar.seleccionarmodelo',$evaluado->id) }}"><span><i class="material-icons">select_all muted</i></span></a>
                                                @endif
                                            </td>
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
                                            <td>
                                                @if(Helper::estatus($evaluado->status)=='Finalizada')
                                                    <a href="{{route('resultados.graficas', $evaluado->id)}}" >
                                                    <span><i class="material-icons ">pie_chart</i></span>
                                                @else
                                                  <a href="{{route('resultados.graficas', $evaluado->id)}}" >
                                                    <span><i class="material-icons md-24 text-dark">pie_chart</i></span>
                                                @endif

                                            </td>

                                        </tr>
                                        @endforeach

                                        </tbody>
                                    </table>
                                    </div>
                                </li>
                                </ul>
                            @endforeach
                        </td>
                    </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>

            @else

                <div class="d-flex alert alert-info">
                    <p> hay usuarios proyectos registrados</p>
                <div>

            @endif



            <div class=" d-flex justify-content-center">
                {{ $proyectos->links() }}
                {{-- {{ $evaluados->appends(["name"=>$evaluado->name])  }} --}}

            </div>

        </div>


</div>

@endsection
