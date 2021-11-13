@extends('master')

@section('title',"Editar Tipo de Competencia")

@section('content')

<div class="container">

    <div id="flash-message">
        @include('flash-message')
    </div>

    <div class="mt-1 text-center">
        <h5>Actualizar Tipo de Competencia</h5>
    </div>

    <div class="card-header">

        <form action="{{route('tipo.update',$tipo->id)  }}" method="post">

            @csrf
            @method('PATCH' )


            <div class="form-group">
                <label for="tipo">Tipo</label>
                <input id="tipo" class="form-control" type="text" name="tipo" value="{{$tipo->tipo}}">
            </div>

            <div class="clearfix col-sm-12 mt-2">
                <a href="{{route('tipo.index')}}" class="btn btn-dark float-left">Back</a>
                <button type="submit" class="btn btn-dark float-right">Save</button>
            </div>

        </form>
    <div>
</div>

@endsection
