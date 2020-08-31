@extends('layout')

@section('title',"Editar Tipo de Competencia eva360")

@section('content')

<div class="container">

    <div class="col-sm-8">
        <h2>Actualizar Tipo de Competencia</h2>

        <div id="flash-message">
            @include('flash-message')
        </div>

        <div class="card-header">
            <form action="{{route('tipo.update',$tipo)  }}" method="post">
                @csrf
                @method('PATCH' )
                <div class="form-group">
                    <label for="tipo">Tipo</label>
                    <input id="tipo" class="form-control" type="text" name="tipo" value="{{$tipo->tipo}}">
                </div>
                <div class="clearfix">
                    <a href="{{route('tipo.index')}}" class="btn btn-dark float-left">Back</a>
                    <button type="submit" class="btn btn-dark float-right">Save</button>
                </div>
            </form>
        <div>
    </div>
</div>

@endsection
