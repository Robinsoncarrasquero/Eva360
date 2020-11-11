@extends('lanzamiento.proyecto.layout')

@section('title',"Panel de Control de Proyectos de Evaluacion")

@section('content')

<div class="container">

    <div class="mt-1 panel panel-default">


            <div id="flash-message">
                @include('flash-message')

            </div>

            <div class="panel panel pb-1">
                <div class="clearfix">

                    <div class="text text-center">
                        <h5>Control de Proyectos de Evaluacion</h5>
                    </div>

                     <form class="form-inline mt-2 mt-md-0 float-left col-sm-6">
                        <input class="form-control mr-sm-2" type="text" placeholder="Proyecto" aria-label="Searh" name="buscarWordKey">
                        <button class="btn btn-outline-success my-2 my-sm-0" type="submit">Buscar</button>
                    </form>
                </div>
            </div>


            @if ($proyectos->count())

                @foreach ($proyectos as $proyecto)
                <div class="table-table">
                    <table  class="table" >
                    <thead >
                        <th >Proyecto</th>
                    </thead>
                    <tbody>
                    <tr>
                        <td class="titulo-proyecto" >{{$proyecto->name}}
                        <div class="float-left">
                            <a href="{{ route('resultados.resultadosgeneralestipo',$proyecto->id) }}"><span><i class="material-icons">leaderboard</i></span></a>
                            <a href="{{ route('resultados.resultadosgeneralesnivel',$proyecto->id) }}"><span><i class="material-icons">assessment</i></span></a>
                        </div>
                        </td>

                    </tr>
                    <tr>
                    </tr>

                    @foreach ($proyecto->subproyecto as $subproyecto)
                    <tr>
                        <td>
                        <span class="titulo-subproyecto">{{$subproyecto->name}} </span> <span class="titulo-proyecto" ><i class="material-icons">east</i> {{$proyecto->name}}</span>
                        <div class="float-right">
                            <a href="{{ route('resultados.graficaPersonales',$subproyecto->id) }}"><span><i class="material-icons">table_chart</i></span></a>
                            <a href="{{ route('resultados.analisispersonalestabulados',$subproyecto->id) }}"><span><i class="material-icons">dynamic_feed</i></span></a>
                            <a  href="{{ route('evaluado.create',$subproyecto)}}" class="btn btn-dark"><i class="material-icons">person_add</library-add></i> </a>
                        </div>
                        </td>
                        </tr>
                        <tr>
                            <table  class="table">
                            <thead>
                                <th>Nombre</th>
                                <th>Cargo</th>
                                <th>Status</th>
                                <th>Lanzar</th>
                                <th>Prueba</th>
                                <th>Resultado</th>
                                <th>Grafica</th>
                                <th>Del</th>
                            </thead>
                            <tbody>
                            @foreach ($subproyecto->evaluado as $evaluado)
                            <tr>
                            <td>{{ $evaluado->name }}</td>
                            <td>{{ $evaluado->cargo->name}}</td>
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
                            </td>

                            <td>
                                @if(Helper::estatus($evaluado->status)=='Inicio')
                                    <a href="{{ route('lanzar.seleccionarmodelo',$evaluado->id) }}"><span><i class="material-icons">flight_takeoff</i></span></a>
                                @else
                                    <a ><span><i class="material-icons text-dark">flight_takeoff</i></span></a>
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
                                <form action="{{ route('evaluado.destroy',$evaluado->id) }}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger"> <i class="material-icons">delete</i></button>
                                </form>
                            </td>
                            </tr>
                            @endforeach
                            </tbody>
                            </table>
                    </tr>
                    @endforeach
                    </tbody>
                    </table>
                </div>
                @endforeach
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
