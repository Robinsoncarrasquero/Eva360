@extends('layout')

@section('title',"Responder la Prueba")

@section('content')

<div class="container">

    <div class="panel panel-default">

        <div class="col-md-12">

            <div id="flash-message">
                @include('flash-message')

            </div>

            <div class="panel panel pb-3">

                <div class="clearfix">
                    <div class="alert alert-info">
                        <h3>Bienvenido {{ $evaluador->name }}!! Usted evalua a {{ $evaluado->name }}</h3>
                    </div>


                    <div class="text text-center">
                        <h3>Competencias a Evaluar</h3>
                    </div>

                </div>

            </div>

            @if($competencias->count())

            <div class="panel-body">

                <div class="table">
                    <table id="mytable" class="table  table-bordred table-striped">
                    <thead>
                    <th>Competencias</th>
                    <th>Descripcion</th>
                    <th>Answer</th>
                    </thead>
                    <tbody>
                    @foreach($competencias as $competencia)
                    <tr>
                        <td>{{$competencia->name}}</td>
                        <td>{{$competencia->description}}</td>
                        <td>
                            @if($competencia->status==0)
                                <a href="{{route('evaluacion.responder', $competencia->id)}}" >
                                <span><i class="material-icons ">send</i></span></a>
                            @else
                                <a href="{{route('evaluacion.responder', $competencia->id)}}" >
                                <span><i class="material-icons"></i></span></a>

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

            {{-- {{ $competencias->links() }} --}}

        </div>

    </div>

</div>


@endsection
