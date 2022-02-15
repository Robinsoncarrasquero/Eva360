@extends('mastersimulador')

@section('title',"Cuestionario de comportamientos")

@section('content')

<div class="container">

    <div id="flash-message">
        @include('flash-message')
    </div>



        <div class="card-header mb-2">
            <h5 class="text text-center">{{  $evaluacion->evaluador->name }}, analice con criterio y determinacion las competencia de :</h5>
            <h4 class="text text-danger d-flex justify-content-center">{{ $evaluacion->evaluador->evaluado->name }}</h4>
        </div>

        <h4 class="text text-center mt-2 border-primary "><strong> {{ $evaluacion->competencia->name }}</strong></h4>

        <div class="card mb-2">
            <h6 class="card-header description" >{{ $evaluacion->competencia->description}}</h6>
        </div>

        <p>Se presenta la competencia del cuestionario que usted debe responder.
            Esta competencia tiene 4 preguntas y cada pregunta tiene 4 opciones que indican la frecuencia. Debe indicar
            la valoracion para esta competencia.
        </p>

        @if ($evaluacion->competencia->grados->isNotEmpty())

            <form action="{{ route('simulador.store',$evaluacion) }}" method="POST" id="form-select">
            @csrf

                @foreach ($evaluacion->comportamientos as $comportamiento)

                <div id="{{$comportamiento->id}}" class="card  filas mt-4  @if($evaluacion->resultado) border-success @else border-danger @endif">

                    <div class="card-body ">

                        {{-- <h5 class="card-title  @if($evaluacion->resultado) text-success @else text-danger @endif">Pregunta #{{ $comportamiento->id }}</h5> --}}
                        <div class="circle" style="background-color:{{ Color::getBGColor()}};color:white;fontsize:1rem;font-weight: bold;">
                            <span class="text-capitalize " >{{substr($comportamiento->grado->description,0,1)}}</span>
                        </div>
                        <h5 class="card-text"> {{$comportamiento->grado->description}}</h5>
                    </div>

                    <div class="card-footer" >
                        <h5 class="card-title @if($evaluacion->resultado) text-success @else text-danger @endif">Que frecuencia?</h5>
                        @foreach ($frecuencias  as $frecuencia)
                        {{-- <div class="form-check d-flex justify-content-between"> --}}
                        <div class="form-check ">
                            <label for="frecuenciacheck[]" class="xform-check-label">{{ $frecuencia->name}}</label>
                            @if ($evaluacion->competencia->seleccionmultiple)
                                <input  type="radio" class="no-radiofrecuencia" id="{{"radiofrecuencia$comportamiento->grado_id"}}"
                                value="{{"$comportamiento->id,$frecuencia->id"}}" name="frecuenciacheck[{{ $comportamiento->grado_id }}]"
                                @if ($comportamiento->frecuencia===$frecuencia->valor) checked @endif
                                @if ($evaluacion->evaluador->status==2) disabled  @endif
                                data-id="{{"$comportamiento->id"}}">
                            @else
                                <input type="radio" class="radiofrecuencia" id="{{"radiofrecuencia$comportamiento->grado_id"}}"
                                value="{{"$comportamiento->id,$frecuencia->id"}}" name="frecuenciacheck[{{ $comportamiento->grado_id }}]"
                                @if ($comportamiento->frecuencia===$frecuencia->valor) checked @endif
                                @if ($evaluacion->evaluador->status==2) disabled  @endif
                                data-id="{{"$comportamiento->id"}}">
                            @endif
                        </div>
                        @endforeach
                    </div>
                </div>
                @endforeach

                <div class="col-md-4 ">
                    <div id="divtodo">

                    </div>
                </div>

                <div class="clearfix">

                    <span class="float-left"><a href="{{ route('simulador.competencias',$evaluacion->evaluador->id) }}" class="btn btn-dark btn-lg">Regresar</a></span>
                    @if ($evaluacion->evaluador->status!=2)
                        <button type="submit" class="btn btn-dark btn-lg float-right" value="Next" >Guardar</button>
                    @endif

                </div>

            </form>

        @else
            <div class="col">
                <p>No hay datos disponible para evaluacion</p>
            </div>
        @endif



</div>

@endsection


@section('scripts')
<script src="{{ asset('js/elimina_div_padre_lista.js') }}"></script>
<script >
    $(document).ready(function() {
        var ultimo_click=0;

        $('.filas').click(function(e){

            if (ultimo_click > 0){
                document.getElementById(ultimo_click).style.backgroundColor="white";
            }

            var padre_id= $(this).attr('id');
            ultimo_click= $(this).attr('id');

            var btn =document.getElementById(padre_id);
            btn.style.backgroundColor="azure";

        });
});

</script>
@endsection


