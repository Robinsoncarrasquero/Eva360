@extends('master')

@section('title',"Editar Competencia")

@section('content')

<div class="container">

    <div id="flash-message">
        @include('flash-message')
    </div>

    <div class="text text-center">
        <h5>Actualizar Competencia</h5>
    </div>

    <form class="card-header" action="{{route('competencia.update',$competencia)  }}" method="post">
        @csrf
        @method('PATCH' )

        <div class="col-sm-6">
            <label for="name">Nombre</label>
            <input id="name" class="form-control" type="text" name="name" value="{{$competencia->name }}">
        </div>

        <div class="col-sm-12">
            <label for="description">Descripcion</label>
            <textarea id="description" class="form-control"  name="description" rows="4" >{{$competencia->description }}</textarea>
        </div>

        <div class="col-sm-6">
            <label for="nivelrequerido">Nivel Requerido</label>
            <input id="nivelrequerido" class="form-control" type="text" name="nivelrequerido" value="{{ $competencia->nivelrequerido}}">
        </div>

        <div class="col-sm-6">
            <label for="tipo">Tipo</label>
            <select id="tipo" class="form-control" name="tipo">
                @foreach ($tipos as $tipo)
                <option @if ($competencia->tipo==$tipo) selected @endif value="{{$tipo->id}}">{{ $tipo->tipo }}</option >
                @endforeach
            </select>
        </div>

        <div class="form-check">
            <label class="form-check-label " for="seleccionmultiple[]" style="color: rgb(255, 165, 0);font-size:1.5em">Los comportamiento son de seleccion multiple</label>
            <input type="checkbox" class="check-select "  id="{{"seleccionmultiple$competencia->id"}}" name="seleccionmultiple[]" @if($competencia->seleccionmultiple) checked @endif>
        </div>

        <table class="table table-table">
            <thead class="table-thead">
                <th>#</th>
                <th>Grado</th>
                <th>Pregunta</th>
                <th>Ponderacion</th>
            </thead>
            <tbody>
            @foreach ($competencia->grados as $key=>$value)
            <tr>
                <td>
                    {{ $key }}
                    <input class="col-sm-2" hidden type="text" name="gradoid[]" value="{{ $value->id }}">
                </td>
                <td>
                    <input class="col-sm-2" type="text" name="gradoName[]" value="{{ old('gradoName.'.$key, $value->grado) }}">
                </td>
                <td>
                    <textarea class="col-sm-12" cols="50" rows="4" name="gradoDescription[]">{{ old('gradoDescription.'.$key, $value->description)}}</textarea>
                </td>
                <td>
                    <input class="col-sm-4" type="text" name="gradoPonderacion[]" value="{{ old('gradoPonderacion.'.$key, $value->ponderacion)}}">
                </td>
            </tr>
            @endforeach
            </tbody>
        </table>

        <div class="clearfix col-sm-12 mt-2">
            <a href="{{url()->previous()}}" class="btn btn-dark float-left">Back</a>
            <button type="submit" class="btn btn-dark float-right">Save</button>
        </div>

    </form>
</div>

@endsection
