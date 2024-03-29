@extends('master')

@section('title',"Cuestionario lista de competencias")

@section('content')

<div class="container">


        <div id="flash-message">
            @include('flash-message')

        </div>

        <div class="pb-1 ">

            <div class="card-header mb-2">

                <h5 class="text text-center">{{  $evaluador->name }}, analice con criterio y determinacion las competencia de :</h5>
                <h4 class="text text-danger d-flex justify-content-center" style="color:limegreen">{{ $evaluado->name }}</h4>
            </div>

            <div class="text text-center mt-3" style="color:dodgerblue">
                <h4 >COMPETENCIAS</h4>
            </div>

        </div>

        @if($competencias)

            <form method="POST" action="{{ route('evaluacion.finalizar',$evaluador->id) }}">
            @csrf
            @php($nivel =0)
            <div class="card-columns ">

                @foreach($competencias as $competencia)
                <div class="card mt-4 pb-2  @if($competencia->resultado) border-success @else border-danger @endif">

                    <div class="card-body">

                        <div class="circle" style="background-color:{{ Color::getBGColor()}};color:white;fontsize:1rem;font-weight: bold;">
                            <span class="text-capitalize ">{{substr($competencia->competencia->name,0,1)}}</span>
                        </div>
                        <h5 class="badge badge-secondary">{{ ++$nivel }}</h5>
                        <h5 class="card-title">{{$competencia->competencia->name}}</h5>
                        <p class="card-text small">{{ substr($competencia->competencia->description,0,50) }}...</p>
                        <a href="{{route('evaluacion.responder', $competencia->id)}}" style="color: rgb(16, 17, 17)" >
                        @if($competencia->resultado)
                            {{-- <span ><i class="material-icons text-success">thumb_up_alt</i></span></a> --}}
                            <a href="{{route('evaluacion.responder', $competencia->id)}}" class="btn btn-dark">Listo ya respondí</a>
                        @else
                            {{-- <span class="spinner-grow spinner-grow-sm text-danger align-center" role="status"><i class="material-icons spellcheck"></i></span></a> --}}
                            <a href="{{route('evaluacion.responder', $competencia->id)}}" class="btn btn-danger">Voy a responder</a>
                        @endif

                    </div>
                </div>
                @endforeach
            </div>

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
