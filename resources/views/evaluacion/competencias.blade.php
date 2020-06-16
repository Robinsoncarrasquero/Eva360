@extends('layout')

@section('title',"Respondiendo la Prueba")

@section('content')

<div class="container">

    <div class="panel panel-default">

        <div class="col-md-12">

            <div id="flash-message">
                @include('flash-message')

            </div>

            <div class="panel panel pb-3">

                <div class="clearfix">
                    <div class="alert alert-info text-center">
                        <h5>Estimado {{ $evaluador->name }}!!, por favor evalue las competencias de <span class="text-danger">{{ $evaluado->name }}</span></h5>
                    </div>

                    <div class="text text-center text-danger">
                        <h3>Competencias a Evaluar</h3>
                    </div>

                </div>

            </div>

            @if($evaluacions)

            <div class="panel-body">
                <form method="POST" action="{{ route('evaluacion.finalizar',$evaluador->id) }}">
                    @csrf
                <div class="table">
                    <table id="mytable" class="table  table-bordred table-striped">
                    <thead>
                    <th>Competencia</th>
                    <th>Descripcion</th>
                    <th>Status</th>
                    <th>Answer</th>
                    </thead>
                    <tbody>

                    @foreach($evaluacions as $competencia)

                    <tr>
                        <td>{{$competencia->competencia->name}}</td>
                        <td>{{$competencia->competencia->description}}</td>
                        <td>
                            @if($competencia->grado)
                                <span><i class="material-icons spellcheck">spellcheck</i></span></a>
                            @else
                                <span><i class="material-icons ">av_timer</i></span></a>
                            @endif
                        </td>
                        <td>
                            <a href="{{route('evaluacion.responder', $competencia->id)}}" >
                            <span><i class="material-icons ">create</i></span></a>

                        </td>

                    </tr>
                    @endforeach
                    </tbody>
                    </table>
                </div>
                <div class="clearfix">
                    <span class="float-left"><a href="{{back()}}" class="btn btn-dark btn-lg">Back</a></span>
                    <button type="submit" class="btn btn-dark btn-lg float-right" value="Finalizar">Finalice</button>

                </div>

                </form>

            </div>

            @else

            <div class="alert-info">
                <p>No Preguntas disponibles para responder</p>
            <div>

            @endif

            {{-- {{ $competencias->links() }} --}}

        </div>

    </div>

</div>


@endsection
