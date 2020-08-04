@extends('layout')

@section('title',"Lanzamiento de Prueba")

@section('content')

<div class="container">

    <div class="panel panel pb-3">
        <h4 class="text text-md-center alert alert-warning ">Seleccione las Competencias a evaluar de {{ $evaluado->name }}</h4>
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
                    <th scope="col">Tipo</th>
                    <th scope="col">Seleccionar</th>
                </tr>
                </thead>
                <tbody>
                @foreach ($competencias as $competencia)
                <tr data-id="{{" $competencia->id "}}">
                    <th scope="row">{{ $competencia->id }}</th>
                    <td>{{$competencia->name}}</td>
                    <td>{{ substr($competencia->description,0,150)}}....</td>
                    <td>{{$competencia->tipo->tipo}}</td>
                    {{-- <td>{{$competencia->grupocompetencia->name}}</td> --}}
                    <td>

                           <div class="form-check">
                                <input type="checkbox" class="check-select" id="{{"$competencia->id"}}"
                                value="{{"$competencia->id"}}" name="competenciascheck[]">
                                <label class="form-check-label" for="{{"$competencia->id"}}">
                                </label>


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



