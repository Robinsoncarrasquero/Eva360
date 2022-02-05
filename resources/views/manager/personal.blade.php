@extends('master')

@section('title',"Modulo de talentos")

@section('content')

<div class="container">

            <div id="flash-message">
                @include('flash-message')
            </div>
            <div class="card pb-0 ">
                <div class="clearfix">
                     <form class="form-inline mt-2 mt-md-0 float-left col-sm-6">
                        <input class="form-control mr-sm-2" type="text" placeholder="Ubicacion" aria-label="Searh" name="buscarWordKey">
                        <button class="btn btn-outline-success my-2 my-sm-0" type="submit">Buscar</button>
                    </form>
                </div>
            </div>
            <div class="card pb-2 mt-2">

                <div class="text text-center">

                    <h4 style="color:royalblue; font-size:1.5rem">Equipo de trabajo</h4>
                </div>

            </div>
            <div class=" d-flex justify-content-center mt-2">
                {{ $departamentos->links() }}
            </div>
            @if ($departamentos->count())

                @foreach ($departamentos as $departamento)
                    <div class="panel panel mt-4">
                        <span class="titulo-subproyecto text-dark">{{ $departamento->name }} </span>
                        <span  style="font-size: 0.75rem" class="titulo-proyecto" >
                        <i class="material-icons">east</i> {{ $departamento->name }}</span>
                    </div>
                    <div class="table table-table table-responsive">

                        <table class="table">
                            <thead>
                                <tr>
                                <th style="width:30%" class="alert-success text-center">Nombre</th>
                                <th style="width:20%" class="alert-warning text-center">Historico <br>Evaluaciones</th>

                                <th style="width:10%" class="alert-dark text-center">Email</th>
                                <th style="width:20%" class="alert-danger text-center">Evaluacion <br>Objetivos</th>
                                </tr>
                            </thead>
                            <tbody>
                            @foreach ($departamento->empleados as $empleado)
                            @if ($empleado->active)
                            <tr>
                                {{-- <td>{{ substr($empleado->name,0,50) }}<span style="background:rgb(179, 248, 179);  color:rgb(15, 16, 24)"><br>{{ $empleado->cargo->name}}</span></td> --}}
                                <td>{{ ($empleado->name) }}
                                    @if ($empleado->id==$departamento->manager_id)
                                        <br>
                                        <a><i class="material-icons text-danger">person</i></a>
                                    @endif
                                </td>

                                <td class="d-flex justify-content-center" >
                                    @if ($empleado->evaluaciones->count()>0)
                                        <a href="{{route('manager.historicoevaluaciones', $empleado->id)}}"><span class="badge badge-warning">{{ $empleado->evaluaciones->count() }}</span></a></td>

                                    @else
                                        <a><i class="material-icons text-dark">question_answer</i></a></td>
                                    @endif
                                </td>



                                <td>{{ ($empleado->email) }}</td>

                                <td>
                                    <span class="d-flex justify-content-center">
                                        <a href="{{ route('lanzarobjetivo.seleccionar',$empleado->id)}}" class="btn btn-dark"><i class="material-icons">person_add</library-add></i> </a>
                                    </span>
                                </td>
                                {{-- <td>
                                    <form action="{{ route('empleado.destroy',$empleado->id) }}" method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger"> <i class="material-icons">delete</i></button>
                                    </form>
                                </td> --}}

                            </tr>
                            @endif
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                @endforeach

                <div class=" d-flex justify-content-center">
                    {{ $departamentos->links() }}
                </div>

            @else
                <div class="d-flex alert alert-info">
                    <p>No hay informacion disponible</p>
                <div>
            @endif

    </div>

@endsection
