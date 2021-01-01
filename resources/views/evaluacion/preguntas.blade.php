@extends('evaluacion.layout')

@section('title',"Lanzamiento de Prueba")

@section('content')

<div class="container">

    <div class="panel panel pb-3">
        <h2 class="text text-centter">{{ $competencia->name}}</h2>
        <h2 class="text text-center">{{ $competencia->description}}</h2>
    </div>
    <div class="panel panel pb-3">
        <h2 class="text text-center">{{ $evaluado->name}}</h2>
    </div>
    <div id="flash-message">
        @include('flash-message')
    </div>

    @if ($grados->isNotEmpty())

            <form action="{{ route('evaluacion.responder',$evaluacion) }}" method="POST" id="form-select">
            @csrf
            <div class="table table-responsive">
                <table class="table">
                    <thead>
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">Grado</th>
                        <th scope="col">Descripcion</th>
                        <th scope="col">Check</th>
                        <th scope="col">Seleccionar</th>
                    </tr>
                    </thead>
                    <tbody class="tbody-preguntas" >
                    @foreach ($grados as $grado)
                    <tr data-id="{{" $grado->id "}}">
                        <td scope="row">{{ $grado->id }}</td>
                        <td>{{$grado->grado}}</td>
                        <td>{{$grado->description}}</td>
                        <td>
                            <div class="form-check">
                                <input type="checkbox" class="check-select" id="{{"$grado->id"}}"
                                value="{{"$grado->id"}}" name="gradoscheck[]"
                                @if ($evaluacion==$grado->grado) selected  @endif >
                                <label class="form-check-label" for="{{"$grado->id"}}">Evaluar</label>
                            </div>
                        </td>
                        <td>
                            <div class="form-check">
                                <a href="#"><span><i class="material-icons check-select">add-box</i></span></a>
                            </div>
                        </td>
                   </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>

            <div class="clearfix">
                <span class="float-left"><a href="{{ back() }}" class="btn btn-dark btn-lg">Back</a></span>
                <button type="submit" class="btn btn-dark btn-lg float-right" value="Next">Next</button>
            </div>

        </form>
    @else
        <div class="alert alert-info">
            <p>No hay preguntas registradas</p>
        </div>

    @endif
    <div class="clearfix">

        {{ $grados->links() }}
    </div>



</div>

@endsection

@section('sidebar')



@endsection



