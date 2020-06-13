@extends('layout')

@section('title',"Responder la Prueba")

@section('content')

<div class="container">
    <div class="mb3">
        <div class="panel">
            <b class="text text-center">Estimado {{  $evaluacion->evaluador->name }}, analice con criterio y determinacion las siguientes conductas de
            <span class="text text-danger">{{ $evaluacion->evaluador->evaluado->name }}</span>.</b>
        </div>
    </div>

    <div class="panel">
        <h4 class="text text-center"><br><strong> {{ $evaluacion->competencia->name }} {{$evaluacion->grado }}</strong></h4>
        <h5 class="alert alert-success">{{ $evaluacion->competencia->description}}</h5>
    </div>

    @if ($errors->any())
        <div class="alert alert-danger">
            <p>Errores encontrados que debe corregir:</p>
            <ul>
                @foreach ($errors->all() as $error)
                    <li> {{ $error }} </li>
                @endforeach

            </ul>

        </div>

    @endif

    @if ($evaluacion->competencia->grados->isNotEmpty())
            <form action="{{ route('evaluacion.store',$evaluacion) }}" method="POST" id="form-select">
                {{-- {{ method_field('PUT') }} --}}
                {{ csrf_field() }}
    <div class="form-row">
        <div class="form-group col-md-8">
            <table class="table ">
                <thead>
                <tr>
                    <th scope="col">Grado</th>
                    <th scope="col">Descripcion</th>
                    <th scope="col">Seleccione</th>
                </tr>
                </thead>
                <tbody>

                @foreach ($evaluacion->competencia->grados as $grado)
                    <tr data-id="{{" $grado->id "}}">
                        <th scope="row">{{ $grado->grado }}</th>
                        <td>{{$grado->description}}</td>
                        <td>
                            @if($evaluacion->grado===$grado->grado)
                                <div class="form-check">
                                    <input type="radio" class="check-select" id="{{"$grado->id"}}"
                                    value="{{"$grado->id"}}" name="gradocheck[]" checked >
                                </div>
                            @else
                                <div class="form-check">
                                    <input type="radio" class="check-select" id="{{"$grado->id"}}"
                                    value="{{"$grado->id"}}" name="gradocheck[]">
                                </div>

                            @endif

                        </td>
                        <td>

                            @foreach ($frecuencias  as $vvalor)
                                @foreach ($vvalor  as $key=>$valor)
                                    <div class="form-check">
                                        <input type="radio" class="check-select" id="{{"$key"}}"
                                        value="{{"$valor"}}" name="frecuenciacheck[]" checked >
                                    </div>
                                    <label>{{ $key}}<label>
                                @endforeach

                            @endforeach


                        </td>

                    </tr>
                @endforeach

                </tbody>
            </table>

        </div>

        <div class="form-group col-md-4 ">


            <div class="d-flex flex-column ">
                <div class="p-2 pt-5"></div>
                <div class="p-2"></div>
                <div class="p-2"></div>
            </div>

            <h1 class="mt-auto">Frecuencia</h1>

            <div class="form-check">

                <input class="form-check-input" type="radio" name="radiofrecuencia[100]" id="gridRadios" value="100">
                <label class="form-check-label" for="gridRadios[]">
                Siempre
                </label>
            </div>
            <div class="form-check ">
                <input class="form-check-input" type="radio" name="radiofrecuencia[75]" id="gridRadios" value="75">
                <label class="form-check-label" for="gridRadios[]">
                Frecuentemente
                </label>
            </div>
            <div class="form-check ">
                <input class="form-check-input" type="radio" name="radiofrecuencia[50]" id="gridRadios" value="50">
                <label class="form-check-label" for="gridRadios[]">
                Medio
                </label>
            </div>

            <div class="form-check ">
                <input class="form-check-input" type="radio" name="radiofrecuencia[25]" id="gridRadios" value="25" >
                <label class="form-check-label" for="gridRadios[]">
                Ocacionalmente
                </label>
            </div>

        </div>

    </div>
    <div class="clearfix">
        <span class="float-left"><a href="{{url()->previous()}}" class="btn btn-dark btn-lg">Back</a></span>
        <button type="submit" class="btn btn-dark btn-lg float-right" value="Next">Next</button>

        </div>

       </form>


    @else
        <div class="col-md-12">
            <p>No datos disponible para evaluaciones</p>
        </div>
    @endif


</div>

@endsection


@section('sidebar')


@endsection


