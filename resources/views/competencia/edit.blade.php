@extends('layout')

@section('title',"Editar Competencias eva360")

@section('content')

<div class="container">

    <div class="col-sm-8 text text-center">
        <h2 class="display-5">Actualizar Competencia</h2>
    </div>
    <div id="flash-message">
        @include('flash-message')

    </div>


    <form action="{{route('competencia.update',$competencia)  }}" method="post">

        @csrf
        @method('PATCH' )

        <div class="form-group">
            <label for="name">Nombre</label>
            <input id="name" class="form-control" type="text" name="name" value="{{$competencia->name }}">
        </div>

        <div class="form-group">
            <label for="description">Descripcion</label>
            <textarea id="description" class="form-control"  name="description" rows="4" >{{$competencia->description }}</textarea>
        </div>

        <div class="form-group">
            <label for="nivelrequerido">Nivel Requerido</label>
            <input id="nivelrequerido" class="form-control" type="text" name="nivelrequerido" value="{{ $competencia->nivelrequerido}}">
        </div>

        <div class="form-group">
            <label for="tipo">Tipo</label>
            <select id="tipo" class="form-control" name="tipo">

                @foreach ($tipos as $tipo)
                     @if ($competencia->tipo==$tipo)
                        <option selected value="{{$tipo->id}}">{{ $tipo->tipo }}</option>
                     @else
                        <option          value="{{$tipo->id}}">{{ $tipo->tipo }}</option>

                     @endif
                @endforeach

            </select>
        </div>
        <table class="table table-light">
            <thead>
                <table class="table table-light">
                    <thead class="thead-light">
                        <tr>
                            <th>#</th>
                            <th>Grado</th>
                            <th>Pregunta</th>
                            <th>Ponderacion</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($competencia->grados as $key=>$value)
                        <tr>
                            <td>
                                {{ $key }}
                                <input hidden type="text" name="gradoid[]" value="{{ $value->id }}">
                            </td>
                            <td>
                                <input type="text" name="gradoName[]" value="{{ old('gradoName.'.$key, $value->grado) }}">
                            </td>
                            <td>
                                <textarea cols="50" rows="4" name="gradoDescription[]">{{ old('gradoDescription.'.$key, $value->description)}}</textarea>
                            </td>
                            <td>
                                <input type="text" name="gradoPonderacion[]" value="{{ old('gradoPonderacion.'.$key, $value->ponderacion)}}">
                            </td>
                        </tr>
                        @endforeach
                    </tbody>

            </thead>

        </table>

        <div class="clearfix">
            <a href="{{route('competencia.index')}}" class="btn btn-dark float-left">Back</a>
            <button type="submit" class="btn btn-primary float-right">Save</button>

        </div>

    </form>
</div>

@endsection
