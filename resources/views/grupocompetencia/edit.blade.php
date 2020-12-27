@extends('master')

@section('title',"Editar Grupo de Competencia")

@section('content')

<div class="container">

    <div class="col-sm-8 text text-center">
        <h2 class="display-5">Actualizar Grupo de Competencia</h2>
    </div>
    <div id="flash-message">
        @include('flash-message')

    </div>


    <form action="{{route('grupocompetencia.update',$competencia)  }}" method="post">

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

        <div class="clearfix">
            <a href="{{route('grupocompetencia.index')}}" class="btn btn-dark float-left">Back</a>
            <button type="submit" class="btn btn-primary float-right">Save</button>

        </div>

    </form>
</div>

@endsection
