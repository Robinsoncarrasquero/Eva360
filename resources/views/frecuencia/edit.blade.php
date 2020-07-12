@extends('layout')

@section('title',"Editar Tipo de Competencia eva360")

@section('content')

<div class="container">

    <div class="col-sm-8">
        <h1 class="display-5">Actualizar Frecuencia</h1>

        <div id="flash-message">
            @include('flash-message')

        </div>

        <div class="card-header">

            <form action="{{route('frecuencia.update',$frecuencia)  }}" method="post">

                @csrf
                @method('PATCH' )

                <div class="form-group">
                    <label for="name">Descripcion</label>
                    <input id="name" class="form-control" type="text" name="name" value="{{$frecuencia->name}}">
                </div>
                <div class="form-group">
                    <label for="valor">Valor</label>
                    <input id="valor" class="form-control" type="text" name="valor" value="{{$frecuencia->valor}}">
                </div>

                <div class="clearfix">
                    <a href="{{route('frecuencia.index')}}" class="btn btn-dark float-left">Back</a>
                    <button type="submit" class="btn btn-primary float-right">Save</button>

                </div>

            </form>
        <div>
    </div>
</div>

@endsection
