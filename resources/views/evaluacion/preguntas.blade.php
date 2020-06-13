@extends('evaluacion.layout')

@section('title',"Lanzamiento de Prueba")

@section('content')

<div class="container">

    <div class="panel panel pb-3">
        <h2 class="text text-md-centter">{{ $competencia->name}}</h2>
        <h2 class="text text-md-center">{{ $competencia->description}}</h2>
    </div>
    <div class="panel panel pb-3">
        <h2 class="text text-md-centter">{{ $evaluador->name}}</h2>
        <h2 class="text text-md-center">{{ $evaluado->name}}</h2>
    </div>

    @if ($errors->any())

        <div class="alert alert-danger">
            <p>Errores encontrados:</p>

            <ul>
                @foreach ($errors->all() as $error)
                    <li> {{ $error }} </li>
                @endforeach

            </ul>

        </div>

    @endif
    @if ($grados->isNotEmpty())
        <div class="col-md-12">
            <form action="{{ route('evaluacion.responder',$evaluacion) }}" method="POST" id="form-select">
                {{-- {{ method_field('PUT') }} --}}
                {{ csrf_field() }}

            <table class="table ">
                <thead>
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">Grado</th>
                    <th scope="col">Descripcion</th>
                    <th scope="col">Check</th>
                    <th scope="col">Seleccionar</th>
                </tr>
                </thead>
                <tbody>
                @foreach ($grados as $grado)
                <tr data-id="{{" $grado->id "}}">
                    <th scope="row">{{ $grado->id }}</th>
                    <td>{{$grado->name}}</td>
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
            <div class="clearfix">
                <span class="float-left"><a href="{{ back() }}" class="btn btn-dark btn-lg">Back</a></span>
                <button type="submit" class="btn btn-dark btn-lg float-right" value="Next">Next</button>

            </div>

        </form>

        </div>



    @else
        <p>No hay usuarios registrados</p>
    @endif
    <div class="clearfix">

        {{ $grados->links() }}
    </div>



</div>

@endsection

@section('sidebar')



@endsection



