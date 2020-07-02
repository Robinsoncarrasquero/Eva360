@extends('layout')

@section('title',"Editar Competencias eva360")

@section('content')

<div class="container">

    <div class="col-sm-8 text text-center">
        <h1 class="display-5">Actualizar Competencia</h1>
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
                @if ($competencia->tipo==Helper::tipoCompetencia($competencia->tipo))
                    <option selected value="{{$competencia->tipo}}">{{ Helper::tipoCompetencia($competencia->tipo) }}</option>
                @else
                    <option value="{{ $competencia->tipo }}">{{ Helper::tipoCompetencia($competencia->tipo) }}</option>
                @endif

            </select>
        </div>
        <button type="submit" class="btn btn-primary"><i class="material-icons">save</i></button>
    </form>
</div>

@endsection
