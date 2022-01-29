@extends('master')

@section('title',"Respondiendo la Evaluacion")

@section('content')

<div class="container">


        <div id="flash-message">
            @include('flash-message')

        </div>

        <div class="pb-1 ">

            <div class="text text-center">
                <h5>Estimado evaluador {{ $evaluador->name }}, analíce con criterio y determinacion las competencias de
                    <h5 class="text text-danger d-flex justify-content-center">{{ $evaluado->name }}</h5>
            </div>

            <div class="text text-center mt-3 text-success">
                <h4>COMPETENCIAS</h4>
            </div>

        </div>

        @if($competencias)

                <form method="POST" action="{{ route('evaluacion.finalizar',$evaluador->id) }}">
                    @csrf

                    @foreach($competencias as $competencia)

                        <div class="card-header mt-3 mb-2">
                            <div class="text text-center">
                                <a href="{{route('evaluacion.responder', $competencia->id)}}" style="color: rgb(16, 17, 17)" >
                                <h3 >{{$competencia->competencia->name}}</h3></a>
                            </div>

                            <div class="text text-center">
                                @if($competencia->resultado)
                                    <a href="{{route('evaluacion.responder', $competencia->id)}}" >
                                        <span ><i class="material-icons text-success">thumb_up_alt</i></span></a>
                                @else
                                    <a href="{{route('evaluacion.responder', $competencia->id)}}" >
                                    <span class="spinner-grow spinner-grow-sm text-danger align-center" role="status"><i class="material-icons spellcheck"></i></span></a>
                                @endif
                            </div>
                        </div>

                    @endforeach

                    <div class="clearfix mt-3">
                        @if (Auth::user()->admin())
                            {{-- <span class="float-left"><a href="{{ url()->previous()}}" class="btn btn-dark btn-lg">Regresar</a></span> --}}
                        @else
                            <span class="float-left"><a href="{{ route('evaluacion.index') }}" class="btn btn-dark btn-lg">Regresar</a></span>
                            @if($evaluador->status!=2)
                                <button type="submit" class="btn btn-dark btn-lg float-right" value="Finalizar">Finalicé</button>
                            @endif
                        @endif
                    </div>

                </form>

        @else

            <div class="alert-info">
                <p>No hay informacion disponibles para responder</p>
            <div>

        @endif

        {{-- {{ $competencias->links() }} --}}

</div>


@endsection
