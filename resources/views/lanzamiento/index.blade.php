@extends('layout')

@section('title',"Lanzamiento de Prueba")

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
                    <th>Evaluacion</th>
                    <th>Resultado</th>
                    <th>Grafica</th>
                   </thead>
                    <tbody>
                    @foreach($evaluados as $evaluado)
                    <tr>
                        <td>{{$evaluado->name}}</td>
                        <td>{{Helper::estatus($evaluado->status) }}</td>
                        <td>
                            @if(Helper::estatus($evaluado->status)=='Inicio')
                                <a href="{{route('lanzar.seleccionar', $evaluado->id)}}" >
                                <span><i class="material-icons ">send</i></span></a>
                            @else
                                <span><i class="material-icons">hourglass_full</i></span></a>

                            @endif

                        </td>
                        <td>
                            @if(Helper::estatus($evaluado->status)=='Finalizada')
                                <a href="{{route('resultados.evaluacion', $evaluado->id)}}" >
                                <span><i class="material-icons md-24">preview</i></span>
                            @else
                                <a href="{{route('resultados.evaluacion', $evaluado->id)}}" >
                                <span><i class="material-icons md-24 text-dark md-inactive">preview</i></span>
                            @endif

                        </td>
                        <td>
                            @if(Helper::estatus($evaluado->status)=='Finalizada')
                                <a href="{{route('resultados.finales', $evaluado->id)}}" >
                                <span><i class="material-icons md-24">table_view</i></span>
                            @else
                                <a href="{{route('resultados.finales', $evaluado->id)}}" >
                                <span><i class="material-icons md-24 text-dark md-inactive">table_view</i></span>
                            @endif

                        </td>
                        <td>
                            @if(Helper::estatus($evaluado->status)=='Finalizada')
                                <a href="{{route('resultados.graficas', $evaluado->id)}}" >
                                <span><i class="material-icons md-24">assessment</i></span>
                            @else
                            <a href="{{route('resultados.graficas', $evaluado->id)}}" >

                                <span><i class="material-icons md-24 text-dark md-inactive">assessment</i></span>
                            @endif

                        </td>
                    </tr>
                    @endforeach
                    </tbody>
                    </table>
                </div>

            </div>

            @else

            <div class="alert-info">
                <p>No hay usuarios registrados</p>
            <div>

            @endif

            {{ $evaluados->links() }}

        </div>

    </div>

</div>


@endsection
