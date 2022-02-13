@extends('master')

@section('title',"Comportamientos")

@section('content')

<div class="container">

    <div id="flash-message">
        @include('flash-message')
    </div>

    <div class="xclearfix">

        {{-- <div class="card-header mb-2">
            <h5 class="text text-center">Analice con criterio y determinacion las competencia de :</h5>
            <h4 class="text text-danger d-flex justify-content-center">Joe Doe</h4>
        </div> --}}

        <h3 class="text text-center mt-2 border-primary "><strong> {{ $competencia->name }}</strong></h3>

        @if($competencia->seleccionmultiple)

            <h3 class="text text-center mt-2 border-primary "><strong>Seleccion Multinivel</strong></h3>

        @else
            <h3 class="text text-center mt-2 border-primary "><strong>Seleccion Unica</strong></h3>
        @endif
        <h3 class="text text-center mt-2 border-primary "><strong>{{$competencia->tipo->tipo }}</strong></h3>

        <div class="card mb-2">
            <h6 class="card card-header description" style="background-color:chocolate;color:white;font-size:1.5rem" >{{ $competencia->description}}</h6>
        </div>

        @if ($competencia->grados->isNotEmpty())

            <form action="{{ route('vision360') }}" method="GET" id="form-select">
            @csrf

            @foreach ($competencia->grados as $comportamiento)

            <div id="{{$comportamiento->id}}" class="card  filas mt-4  @if($competencia->seleccionmultiple)) border-success @else border-danger @endif">

                <div class="card-body ">

                    {{-- <h5 class="card-title  @if($evaluacion->resultado) text-success @else text-danger @endif">Pregunta #{{ $comportamiento->id }}</h5> --}}
                    <div class="circle" style="background-color:{{ Color::getBGColor()}};color:white;fontsize:1rem;font-weight: bold;">
                        <span class="text-capitalize " >{{substr($comportamiento->description,0,1)}}</span>
                    </div>
                    <h5 class="card-text"> {{$comportamiento->description}}</h5>
                </div>

                <div class="card-footer" >
                    <h5 class="card-title @if($competencia->seleccionmultiple)) text-success @else text-danger @endif">Que frecuencia?</h5>
                    @foreach ($frecuencias  as $frecuencia)
                    {{-- <div class="form-check d-flex justify-content-between"> --}}
                    <div class="form-check ">
                        <label for="frecuenciacheck[]" class="xform-check-label">{{ $frecuencia->name}}</label>
                        @if ($competencia->seleccionmultiple)
                            <input  type="radio" class="no-radiofrecuencia" id="{{"radiofrecuencia$comportamiento->id"}}"
                            value="{{"$comportamiento->id,$frecuencia->id"}}" name="frecuenciacheck[{{ $comportamiento->id }}]"
                            data-id="{{"$comportamiento->id"}}">
                        @else
                            <input type="radio" class="radiofrecuencia" id="{{"radiofrecuencia$comportamiento->id"}}"
                            value="{{"$comportamiento->id,$frecuencia->id"}}" name="frecuenciacheck[{{ $comportamiento->id }}]"
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

            <div class="clearfix mt-2">
                <span class="float-left"><a href="{{ route('vision360') }}" class="btn btn-warning btn-lg">Regresar</a></span>
                <span class="float-right"><a href="{{ route('vision360') }}" class="btn btn-success btn-lg">Guardar</a></span>

            </div>

            </form>

        @else
            <div class="col">
                <p>No hay datos disponible para evaluacion</p>
            </div>
        @endif

    </div>

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


