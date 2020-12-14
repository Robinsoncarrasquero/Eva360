@extends('layout')

@section('title',"Panel de Empleados")

@section('content')

<div class="container">

            <div id="flash-message">
                @include('flash-message')
            </div>

            <div class="card pb-1">
                <div class="clearfix">
                     <form class="form-inline mt-2 mt-md-0 float-left col-sm-6">
                        <input class="form-control mr-sm-2" type="text" placeholder="Departamento" aria-label="Searh" name="buscarWordKey">
                        <button class="btn btn-outline-success my-2 my-sm-0" type="submit">Buscar</button>
                    </form>
                </div>
                <div class="text text-center">
                    <h5>Lista de Empleados</h5>
                </div>
            </div>

            @if ($departamentos->count())

                @foreach ($departamentos as $departamento)
                    <div class="panel panel mt-2">
                        <span class="titulo-subproyecto">{{ $departamento->name }} </span>
                        <span  style="font-size: 0.75rem" class="titulo-proyecto" >
                        <i class="material-icons">east</i> {{ $departamento->name }}</span>
                    </div>
                    <div class="table">
                        <table class="table table-condensed">
                            <thead>
                                <tr>
                                <th>Nombre</th>
                                <th>Historico</th>
                                <th>Evaluacion</th>
                                </tr>
                            </thead>
                            <tbody>
                            @foreach ($departamento->empleados as $empleado)
                            <tr>
                                {{-- <td>{{ substr($empleado->name,0,50) }}<span style="background:rgb(179, 248, 179);  color:rgb(15, 16, 24)"><br>{{ $empleado->cargo->name}}</span></td> --}}
                                <td>{{ ($empleado->name) }}</td>
                                <td>
                                    @if ($empleado->evaluaciones->count()>0)
                                        <a href="{{route('empleado.lista', $empleado->id)}}"><i class="material-icons">question_answer</i></a></td>
                                    @else
                                        <a><i class="material-icons text-dark">question_answer</i></a></td>
                                    @endif
                                </td>
                                <td >
                                    <span class="float-center">
                                        <a href="{{ route('empleado.createevaluado',$empleado->id)}}" class="btn btn-dark "><i class="material-icons">person_add</library-add></i> </a>
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
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                @endforeach


    </div>
                <div class=" d-flex justify-content-center">
                    {{ $departamentos->links() }}
                    {{-- {{ $evaluados->appends(["name"=>$evaluado->name])  }} --}}
                </div>

            @else
                <div class="d-flex alert alert-info">
                    <p>No hay informacion disponible</p>
                <div>
            @endif
    </div>

@endsection
