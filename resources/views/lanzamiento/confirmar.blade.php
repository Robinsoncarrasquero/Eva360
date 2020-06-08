@extends('lanzamiento.layout')

@section('title',"Lanzamiento de Prueba")

@section('content')

<div class="container">

    <div class="panel panel pb-3">
        <h2 class="text text-md-center ">Competencias seleccionadas para Lanzar de:</h2>
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
            <form action="{{ route('lanzar.procesar',$evaluado) }}" method="POST">
                {{-- {{ method_field('PUT') }} --}}
                {{ csrf_field() }}

            <table class="table ">
                <thead>
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">Competencia</th>
                    <th scope="col">Descripcion</th>
                    <th scope="col">Check</th>
                </tr>
                </thead>
                <tbody>
                @foreach ($competencias as $competencia)
                <tr>
                    <th scope="row">{{ $competencia->id }}</th>
                    <td>{{$competencia->name}}</td>
                    <td>{{$competencia->description}}</td>
                    <td>
                        <div class="form-check">
                            <input type="checkbox" class="form-check-input" id="{{"$competencia->id"}}"
                            value="{{"$competencia->id"}}" name="competenciascheck[]" checked readonly >
                            <label class="form-check-label" for="{{"$competencia->id"}}">Evaluar</label>
                        </div>
                    </td>
                </tr>

                @endforeach

                </tbody>
            </table>
            <div class="clearfix">
                <span class="float-left"><a href="{{route('lanzar.index')}}" class="btn btn-dark btn-lg">Back</a></span>
                <button type="submit" class="btn btn-dark btn-lg float-right" value="Next">Lanzar</button>

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
@foreach ($evaluadores as $evaluador )

@endforeach
<div class="col-md-12">
<form >
    {{-- {{ method_field('PUT') }} --}}
    {{ csrf_field() }}

<table class="table ">
    <thead>
    <tr>
        <th scope="col">Evaluador</th>
        <th scope="col">Email</th>
        <th scope="col">Evaluar</th>
    </tr>
    </thead>
    <tbody>
    @foreach ($evaluadores as $evaluador)
    <tr>
        <td scope= "row">{{$evaluador->name}}</td>
        <td>{{$evaluador->email}}</td>
        <td>
            <div class="form-check">
                <input type="checkbox" class="form-check-input" id="{{"$evaluador->id"}}"
                value="{{"$evaluador->id"}}" name="evaluador[]" checked disabled>
                <label class="form-check-label" for="{{"$evaluador->id"}}"></label>
            </div>
        </td>
    </tr>

    @endforeach

    </tbody>
</table>

</form>

</div>



@endsection

<script src="{{ asset('js/lanzar.js') }}"></script>

