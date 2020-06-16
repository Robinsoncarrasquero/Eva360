@extends('layout')

@section('title',"Evaluacion de Prueba")

@section('content')

<div class="container">

    <div class="panel panel-default">

        <div class="col-md-12">

            <div id="flash-message">
                @include('flash-message')

            </div>

            <div class="panel panel pb-3">

                <div class="clearfix">

                    <form class="form-inline mt-2 mt-md-0 float-left">
                        <input class="form-control mr-sm-2" type="text" placeholder="Search" aria-label="Search" name="buscarWordKey">
                        <button class="btn btn-outline-success my-2 my-sm-0" type="submit">Search</button>
                    </form>

                    <div class="text text-center">
                        <h3>Lista de Evaluados</h3>
                    </div>

                </div>

            </div>

            @if($evaluados->count())

            <div class="panel-body">

                <div class="table">
                    <table id="mytable" class="table  table-bordred table-striped">
                    <thead>
                    <th>Nombre</th>
                    <th>Status</th>
                    <th>Editar</th>
                    <th>Resultados</th>
                    </thead>
                    <tbody>
                    @foreach($evaluados as $evaluado)
                    <tr>
                        <td>{{$evaluado->name}}</td>
                        <td>
                            @switch($evaluado->status)
                                @case(0)
                                    Inicio
                                    @break
                                @case(1)
                                    Lanzada
                                    @break
                                @case(2)
                                    Finalizada
                                    @break
                                @default

                            @endswitch
                        </td>
                        <td>
                            @if($evaluado->status==0)
                                <a href="{{route('evaluacion.competencias', $evaluador->remember_token)}}" >
                                <span><i class="material-icons ">send</i></span></a>
                            @else
                                <a href="#" >
                                <span><i class="material-icons">hourglass_disabled</i></span></a>

                            @endif

                        </td>
                        <td><i class="material-icons md-24">preview</i>
                        </td>
                    </tr>
                    @endforeach
                    </tbody>
                    </table>
                </div>

            </div>

            @else

            <div class="alert alert-info">
                <p>No hay usuarios registrados</p>
            <div>

            @endif


        </div>

    </div>

</div>


@endsection
