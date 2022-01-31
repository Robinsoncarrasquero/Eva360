@extends('master')

@section('title',"Responder los comportamientos")

@section('content')

<div class="container">

    <div id="flash-message">
        @include('flash-message')
    </div>

    <div class="xclearfix">

        <div class="card-header mb-3">
            <h5 class="text text-center">Estimado evaluador {{  $evaluacion->evaluador->name }}, analice con criterio y determinacion las competencia de</h5>
            <h4 class="text text-danger d-flex justify-content-center">{{ $evaluacion->evaluador->evaluado->name }}</h4>
        </div>
        <h4 class="text text-center mt-2 border-primary "><strong> {{ $evaluacion->competencia->name }}</strong></h4>

        <div class="card mb-2">
            <h6 class="card card-header description" >{{ $evaluacion->competencia->description}}</h6>
        </div>


            <form action="{{ route('evaluacion.store',$evaluacion) }}" method="POST" id="form-select">
            @csrf

             @foreach ($evaluacion->comportamientos as $comportamiento)

                <div class="card  mt-4  @if($evaluacion->resultado) border-success @else border-danger @endif">
                    <div class="card-body ">
                        <h5 class="card-title  @if($evaluacion->resultado) text-success @else text-danger @endif">Pregunta #{{ $comportamiento->id }}</h5>
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
                                @if ($evaluacion->evaluador->status==2) disabled  @endif>
                            @else
                                <input type="radio" class="radiofrecuencia" id="{{"radiofrecuencia$comportamiento->grado_id"}}"
                                value="{{"$comportamiento->id,$frecuencia->id"}}" name="frecuenciacheck[{{ $comportamiento->grado_id }}]"
                                @if ($comportamiento->frecuencia===$frecuencia->valor) checked @endif
                                @if ($evaluacion->evaluador->status==2) disabled  @endif>
                            @endif
                        </div>
                        @endforeach
                    </div>
                </div>

            @endforeach


            <div class="clearfix mt-2">
                @if (Auth::user()->admin())

                @else
                    <span class="float-left"><a href="{{ route('evaluacion.competencias',$evaluacion->evaluador->id) }}" class="btn btn-dark btn-lg">Regresar</a></span>
                    @if ($evaluacion->evaluador->status!=2)
                        <button type="submit" class="btn btn-dark btn-lg float-right" value="Next" >Guardar</button>
                    @endif
                @endif

            </div>
            </form>





        {{-- @if ($evaluacion->competencia->grados->isNotEmpty())
            <form action="{{ route('evaluacion.store',$evaluacion) }}" method="POST" id="form-select">
            @csrf

                <div class="table clearfix">
                    <table class="table  table-striped table-table">
                        <thead class="table-preguntas text-dark ">

                            <th scope="col">Comportamiento observado</th>
                            <th scope="col">Seleccion</th>
                            <th scope="col">Frecuencia</th>
                        </thead>
                        <tbody>

                        @foreach ($evaluacion->comportamientos as $comportamiento)
                        <tr data-id="{{"$comportamiento->id"}}" >
                            <td>{{$comportamiento->grado->description}}</td>
                            <td >
                                <div class="form-check">
                                    <label class="form-check-label " for="gradocheck[]"></label>
                                    @if ($evaluacion->competencia->seleccionmultiple)
                                        <input type="checkbox" class="no-check-select " id="{{"radiogrado$comportamiento->id"}}" name="gradocheck[]" value="{{"$comportamiento->id"}}"
                                        disabled checked
                                        @if ($evaluacion->evaluador->status==2) disabled  @endif >
                                    @else
                                        <input type="checkbox" class="check-select "  id="{{"radiogrado$comportamiento->id"}}" name="gradocheck[]" value="{{"$comportamiento->id"}}"
                                        @if($comportamiento->frecuencia) checked @endif
                                        @if ($evaluacion->evaluador->status==2) disabled  @endif>
                                    @endif
                                </div>
                            </td>
                            <td >
                                @foreach ($frecuencias  as $frecuencia)
                                <div class="form-check d-flex justify-content-between">
                                    <label for="frecuenciacheck[]" class="xform-check-label">{{ $frecuencia->name}}</label>
                                    @if ($evaluacion->competencia->seleccionmultiple)
                                        <input  type="radio" class="no-radiofrecuencia" id="{{"radiofrecuencia$comportamiento->grado_id"}}"
                                        value="{{"$comportamiento->id,$frecuencia->id"}}" name="frecuenciacheck[{{ $comportamiento->grado_id }}]"
                                        @if ($comportamiento->frecuencia===$frecuencia->valor) checked @endif
                                        @if ($evaluacion->evaluador->status==2) disabled  @endif>
                                    @else
                                        <input type="radio" class="radiofrecuencia" id="{{"radiofrecuencia$comportamiento->grado_id"}}"
                                        value="{{"$comportamiento->id,$frecuencia->id"}}" name="frecuenciacheck[{{ $comportamiento->grado_id }}]"
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
                    @else
                        <span class="float-left"><a href="{{ route('evaluacion.competencias',$evaluacion->evaluador->id) }}" class="btn btn-dark btn-lg">Regresar</a></span>
                        @if ($evaluacion->evaluador->status!=2)
                            <button type="submit" class="btn btn-dark btn-lg float-right" value="Next" >Guardar</button>
                        @endif
                    @endif
                </div>

            </form>

        @else
            <div class="col-md-12">
                <p>No hay datos disponible para evaluacion</p>
            </div>
        @endif --}}

    </div>

</div>

@endsection


@section('scripts')
    <script src="{{ asset('js/responder.js') }}"></script>
@endsection


