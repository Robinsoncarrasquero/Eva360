@extends('mastersimulador')

@section('title',"Cuestionario de competencias")

@section('content')

<div class="container">


        <div id="flash-message">
            @include('flash-message')

        </div>

        <div class="card">

            <div class="mb-2">

                <h5 class="text text-center">{{  $evaluador->name }}, analice con criterio y determinacion las competencia de :</h5>
                <h4 class="text text-danger d-flex justify-content-center" style="color:limegreen">{{ $evaluado->name }}</h4>
            </div>

            <div class="mb-2">
                <h4 class="text text-danger d-flex justify-content-center">Evaluacion de {{ $evaluado->word_key }} Grados</h4>
                @switch($evaluado->word_key)
                    @case('180')
                        <p class="text text-dark d-flex justify-content-center small" >
                        Sus Evaluadores Virtual son 3 : 1 EV Supervisor - EV 2 Pares </p>
                        @break
                    @case('270')
                        <p class="text text-dark d-flex justify-content-center small">
                        Sus Evaluadores Virtual son 5: 1 EV Supervisor - EV 2 Pares - EV 2 Colaboradores </p>
                        @break
                    @case('360')
                        <p class="text text-dark d-flex justify-content-center small" >
                            Sus Evaluadores Virtual son 7: 1 EV Supervisor - EV 2 Pares - EV 2 Colaboradores - EV 2 Clientes</p>
                            @break
                    @default
                        <p class="text text-dark d-flex justify-content-center small" >
                            Su Evaluador Virtual es 1 EV Supervisor </p>
                        @break

                @endswitch
            </div>


            {{-- <div class="small">
                <p>Se presentan las competencias del modelo para responder. Seleccione la competencia en el orden que considere conveniente, no hay un orden específico.</p>
            </div> --}}

            <p class="text text-center"><a href="{{route('simulador.resultados', $evaluado->id)}}" class="btn btn-danger btn-lg">Respuesta de Evaluadores</a></p>


        </div>

        <div class="text text-center mt-2 text-dark">
            <h4 >COMPETENCIAS</h4>
        </div>
        @if($competencias)

            <form method="POST" action="{{ route('simulador.finalizar',$evaluador->id) }}">
            @csrf

            <div class="card-columns ">

                @foreach($competencias as $competencia)
                <div class="card mt-4 pb-2  @if($competencia->resultado) border-success @else border-danger @endif">

                    <div class="card-body">

                        <div class="circle" style="background-color:{{ Color::getBGColor()}};color:white;fontsize:1rem;font-weight: bold;">
                            <span class="text-capitalize ">{{substr($competencia->competencia->name,0,1)}}</span>
                        </div>
                        <h5 class="badge">{{ $competencia->resultado }}</h5>
                        <h5 class="card-title">{{$competencia->competencia->name}}</h5>
                        <p class="card-text small">{{ substr($competencia->competencia->description,0,50) }}...</p>
                        {{-- <p class="card-text"><abbr>{{$competencia->competencia->description }}</abbr></p> --}}
                        <a href="{{route('simulador.responder', $competencia->id)}}" style="color: rgb(16, 17, 17)" >
                        @if($competencia->resultado)
                            {{-- <span ><i class="material-icons text-success">thumb_up_alt</i></span></a> --}}
                            <a href="{{route('simulador.responder', $competencia->id)}}" class="btn btn-dark">Listo ya respondí</a>
                        @else
                            {{-- <span class="spinner-grow spinner-grow-sm text-danger align-center" role="status"><i class="material-icons spellcheck"></i></span></a> --}}
                            <a href="{{route('simulador.responder', $competencia->id)}}" class="btn btn-danger">Voy a responder</a>
                        @endif

                    </div>
                </div>
                @endforeach
            </div>

            <div class="clearfix mt-3">
                @if (Auth::user()->admin())
                    {{-- <span class="float-left"><a href="{{ url()->previous()}}" class="btn btn-dark btn-lg">Regresar</a></span> --}}
                @else
                    <span class="float-left"><a href="{{ route('simulador.index') }}" class="btn btn-dark btn-lg">Regresar</a></span>
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
