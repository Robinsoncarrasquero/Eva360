@extends('master')

@section('title',"Responder los comportamientos")

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
                        <th scope="col">Comportamiento observado</th>
                        <th scope="col">Indique</th>
                        <th scope="col">Frecuencia</th>
                    </thead>
                    <tbody>

                    @foreach ($evaluacion->comportamientos as $comportamiento)
                        <tr data-id="{{"$comportamiento->id"}}" class="filas" >
                            <th scope="row">{{ $comportamiento->grado_id }}</th>
                            <td>{{$comportamiento->grado->description}}</td>
                            <td>
                                <div class="form-check">
                                    <label class="form-check-label " for="gradocheck[]" style="color: rgb(255, 165, 0);font-size:1.5em"></label>
                                    @if ($evaluacion->competencia->seleccionmultiple)
                                        <input type="checkbox" class="no-check-select "  id="{{"radiogrado$comportamiento->grado_id"}}" name="gradocheck[]" value="{{"$comportamiento->id"}}"
                                        @if($comportamiento->frecuencia) checked @endif>
                                    @else
                                        <input type="checkbox" class="check-select "  id="{{"radiogrado$comportamiento->grado_id"}}" name="gradocheck[]" value="{{"$comportamiento->id"}}"
                                        @if($comportamiento->frecuencia) checked @endif>
                                    @endif
                                </div>
                            </td>
                            <td>
                                @foreach ($frecuencias  as $frecuencia)
                                <div class="xform-check ">
                                        <label for="frecuencia[]" class="xform-check-label">{{ $frecuencia->name}}</label>
                                        @if ($evaluacion->competencia->seleccionmultiple)
                                            <input type="radio" class="no-radiofrecuencia" id="{{"radiofrecuencia$comportamiento->grado_id"}}"
                                            value="{{"$comportamiento->grado_id,$frecuencia->id"}}" name="frecuenciacheck[{{ $comportamiento->grado_id }}]"
                                            @if ($comportamiento->frecuencia===$frecuencia->valor) checked @endif
                                            @if ($evaluacion->evaluador->status==2) disabled  @endif>
                                        @else
                                            <input type="radio" class="radiofrecuencia" id="{{"radiofrecuencia$comportamiento->grado_id"}}"
                                            value="{{"$frecuencia->id"}}" name="frecuenciacheck[{{ $comportamiento->grado_id }}]"
                                            @if ($comportamiento->frecuencia===$frecuencia->valor) checked @endif
                                            @if ($evaluacion->evaluador->status==2) disabled  @endif>
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


