@extends('master')

@section('title',"Responder la Evaluacion")

@section('content')

<div class="container">
    <div id="flash-message">
        @include('flash-message')
    </div>

    <div class="card-header mb-3">
        <h5 class="text text-center">Estimado evaluador {{  $evaluacion->evaluador->name }}, analice con criterio y determinacion la competencia de
        <span class="text text-danger"><br>{{ $evaluacion->evaluador->evaluado->name }}</span> relacionada con</h5>
    </div>

    <div class="mb-2">
        <h4 class="text text-center mt-2 border-primary "><strong> {{ $evaluacion->competencia->name }}</strong></h4>
        <h6 class="card card-header description" >{{ $evaluacion->competencia->description}}</h6>
    </div>


    @if ($evaluacion->competencia->grados->isNotEmpty())
        <form action="{{ route('evaluacion.store',$evaluacion) }}" method="POST" id="form-select">
        @csrf
            <div class="table table-responsive">
                <table class="table  table-striped table-table">
                    <thead class="table-preguntas border-warning">
                        <th scope="col">#</th>
                        <th scope="col">Descripcion</th>
                        <th scope="col">Seleccion</th>
                        <th scope="col">Frecuencia</th>
                    </thead>
                    <tbody>

                    @foreach ($evaluacion->competencia->grados as $grado)
                        <tr data-id="{{"$grado->id"}}" class="filas" >
                            <th scope="row">{{ $grado->grado }}</th>
                            <td>{{$grado->description}}</td>
                            <td>
                                @if($evaluacion->grado===$grado->grado)
                                    <div class="xform-check">
                                        <input type="radio" class="check-select radiogrado" id="{{"radiogrado$grado->id"}}"
                                        value="{{"$grado->id"}}" name="gradocheck[]" checked
                                        @if ($evaluacion->evaluador->status==2)
                                            disabled
                                        @endif>
                                    </div>
                                @else
                                    <div class="xform-check">
                                        <input type="radio" class="check-select" id="{{"radiogrado$grado->id"}}"
                                        value="{{"$grado->id"}}" name="gradocheck[]"
                                        @if ($evaluacion->evaluador->status==2)
                                            disabled
                                        @endif>
                                    </div>

                                @endif

                            </td>
                            <td>
                                @foreach ($frecuencias  as $frecuencia)
                                <div class="xform-check ">
                                    <label for="frecuencia[]" class="form-check-label">{{ $frecuencia->name}}</label>
                                    @if($evaluacion->frecuencia===$frecuencia->valor && $evaluacion->grado===$grado->grado)
                                        <input type="radio" class="radiofrecuencia" id="{{"radiofrecuencia$grado->id"}}"
                                        value="{{"$frecuencia->id"}}" name="frecuenciacheck[]" checked
                                        @if ($evaluacion->evaluador->status==2)
                                            disabled
                                        @endif>
                                    @else
                                        <input type="radio" class="radiofrecuencia" id="{{"radiofrecuencia$grado->id"}}"
                                        value="{{"$frecuencia->id"}}" name="frecuenciacheck[]"
                                        @if ($evaluacion->evaluador->status==2)
                                            disabled
                                        @endif>
                                    @endif
                                </div>
                                @endforeach
                            </td>
                        </tr>
                    @endforeach

                    </tbody>
                </table>

            </div>

            <div class="col-md-4 ">
                <div id="divtodo">

                </div>
            </div>


        <div class="clearfix">
            @if (Auth::user()->admin())
                {{-- <span class="float-left"><a href="{{route('talent.historicoevaluaciones',$evaluador->evaluado->user_id)}}" class="btn btn-dark btn-lg">Regresar</a></span> --}}
            @else
                <span class="float-left"><a href="{{route('evaluacion.index')}}" class="btn btn-dark btn-lg">Back</a></span>
                @if ($evaluacion->evaluador->status!=2)
                    <button type="submit" class="btn btn-dark btn-lg float-right" value="Next" >Next</button>
                 @endif
            @endif
            {{-- <span class="float-left"><a href="{{ url()->previous() }}" class="btn btn-dark btn-lg">Back</a></span> --}}


        </div>

    </form>

    @else
        <div class="col-md-12">
            <p>No hay datos disponible para evaluacion</p>
        </div>
    @endif


</div>

@endsection


@section('scripts')
    <script src="{{ asset('js/responder.js') }}"></script>
@endsection


