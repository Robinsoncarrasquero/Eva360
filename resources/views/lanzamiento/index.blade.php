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
                        <td>
                            <div class="form-check form-check-inline">
                                @if(Helper::estatus($evaluado->status)=='Finalizada')
                                <input id="inicio" class="form-check-input" type="checkbox" name=""  checked>
                                <input id="medio" class="form-check-input" type="checkbox" name="" checked >
                                <input id="fin" class="form-check-input" type="checkbox" name=""  checked >
                                @endif

                                @if(Helper::estatus($evaluado->status)=='Inicio')
                                <input id="inicio" class="form-check-input" type="checkbox" name="" value="false">
                                <input id="medio" class="form-check-input" type="checkbox" name="" value="false">
                                <input id="fin" class="form-check-input" type="checkbox" name="" value="false">
                                @endif
                                @if(Helper::estatus($evaluado->status)=='Lanzada')
                                <input id="inicio" class="form-check-input" type="checkbox" name="" checked value="false">
                                <input id="medio" class="form-check-input" type="checkbox" name="" checked value="false">
                                <input id="fin" class="form-check-input" type="checkbox" name="" value="false">
                                @endif
                            </div>
                        </td>
                        <td>
                            @if(Helper::estatus($evaluado->status)!='Finalizada')
                                <a href="{{route('lanzar.seleccionar', $evaluado->id)}}" >
                                <span><i class="material-icons ">send</i></span></a>
                            @else
                                <span><i class="material-icons">hourglass_full</i></span></a>

                            @endif


                        </td>
                        <td>
                            @if(Helper::estatus($evaluado->status)=='Finalizada')
                                <a href="{{route('resultados.evaluacion', $evaluado->id)}}" >
                                <span><i class="material-icons md-24">question_answer</i></span>
                            @else
                                <a href="{{route('resultados.evaluacion', $evaluado->id)}}" >
                                <span><i class="material-icons md-24 text-dark md-inactive">question_answer</i></span>
                            @endif

                        </td>
                        <td>
                            @if(Helper::estatus($evaluado->status)=='Finalizada')
                                <a href="{{route('resultados.finales', $evaluado->id)}}" >
                                <span><i class="material-icons md-24">score</i></span>
                            @else
                                <a href="{{route('resultados.finales', $evaluado->id)}}" >
                                <span><i class="material-icons md-24 text-dark md-inactive">score</i></span>
                            @endif

                        </td>
                        <td>
                            @if(Helper::estatus($evaluado->status)=='Finalizada')
                                <a href="{{route('resultados.graficas', $evaluado->id)}}" >
                                <span><i class="material-icons md-24">pie_chart</i></span>
                            @else
                            <a href="{{route('resultados.graficas', $evaluado->id)}}" >

                                <span><i class="material-icons md-24 text-dark md-inactive">pie_chart</i></span>
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
