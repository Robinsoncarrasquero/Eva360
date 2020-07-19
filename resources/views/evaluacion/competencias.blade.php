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

            @if($competencias)

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

                    @foreach($competencias as $competencia)

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
                            @if($evaluador->status!=2)
                                <a href="{{route('evaluacion.responder', $competencia->id)}}" >
                                <span><i class="material-icons ">create</i></span></a>
                            @else
                                <a href="{{route('evaluacion.responder',$competencia->id)}}" >
                                <i class="material-icons">visibility</i></a>


                            @endif
                        </td>

                    </tr>
                    @endforeach
                    </tbody>
                    </table>
                </div>
                <div class="clearfix">
                    <span class="float-left"><a href="{{route('evaluacion.index')}}" class="btn btn-dark btn-lg">Back</a></span>
                    @if($evaluador->status!=2)
                        <button type="submit" class="btn btn-dark btn-lg float-right" value="Finalizar">Finalice</button>
                    @endif
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
