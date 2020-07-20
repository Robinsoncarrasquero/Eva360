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
            <div class="text text-sm-right">
                <a style="margin: 19px;" href="{{ route('evaluado.create')}}" class="btn btn-dark"><i class="material-icons">library_add</library-add></i> </a>
            </div>

            @if($evaluados->count())

            <div class="panel-body">

                <div class="table">
                    <table id="mytable" class="table  table-bordred table-striped">
                    <thead>
                    <th>Nombre</th>
                    <th>Status</th>
                    <th>Lanzar</th>
                    <th>Evaluacion</th>
                    <th>Resultado</th>
                    <th>Grafica</th>
                   </thead>
                    <tbody>
                    @foreach($evaluados as $evaluado)
                    <tr>
                        <td>{{$evaluado->name}}</td>
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
                                <a href="{{route('lanzar.seleccionar', $evaluado->id)}}" >
                                <span><i class="material-icons ">send</i></span></a>
                            @else
                                <span><i class="material-icons">timer_off</i></span></a>
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

            <div class="alert alert-info">
                <p>No hay usuarios registrados</p>
            <div>

            @endif

            <div class=" d-flex justify-content-center">
                {{ $evaluados->links() }}
                {{-- {{ $evaluados->appends(["name"=>$evaluado->name])  }} --}}

            </div>

        </div>

    </div>

</div>


@endsection
