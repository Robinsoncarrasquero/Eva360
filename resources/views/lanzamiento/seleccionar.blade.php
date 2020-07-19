@extends('layout')

@section('title',"Lanzamiento de Prueba")

@section('content')

<div class="container">

    <div class="panel panel pb-3">
        <h2 class="text text-md-center ">Seleccione las Competencias para la Evaluacion de</h2>
        <h2 class="text text-md-center text-danger">{{ $evaluado->name }}</h2>
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
    @if ($evaluadores->isNotEmpty())
        <div class="col-md-12">
            <form action="{{ route('lanzar.confirmar',$evaluado) }}" method="POST" id="form-select">
                {{-- {{ method_field('PUT') }} --}}
                {{ csrf_field() }}

            <table class="table ">
                <thead>
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">Competencia</th>
                    <th scope="col">Descripcion</th>
                    <th scope="col">Check</th>
                    <th scope="col">Seleccionar</th>
                </tr>
                </thead>
                <tbody>
                @foreach ($competencias as $competencia)
                <tr data-id="{{" $competencia->id "}}">
                    <th scope="row">{{ $competencia->id }}</th>
                    <td>{{$competencia->name}}</td>
                    <td>{{$competencia->description}}</td>
                    <td>

                           <div class="form-check">
                                <input type="checkbox" class="check-select" id="{{"$competencia->id"}}"
                                value="{{"$competencia->id"}}" name="competenciascheck[]">
                                <label class="form-check-label" for="{{"$competencia->id"}}">Evaluar</label>
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
                <span class="float-left"><a href="{{ route('lanzar.index') }}" class="btn btn-dark btn-lg">Back</a></span>
                <button type="submit" class="btn btn-dark btn-lg float-right" value="Next">Next</button>

            </div>

        </form>

        </div>



    @else
        <p>No hay usuarios registrados</p>
    @endif
    <div class="clearfix">

        {{-- {{ $competencias->links() }} --}}
    </div>



</div>

@endsection

@section('sidebar')



@endsection



