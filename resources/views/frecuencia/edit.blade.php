@extends('layout')

@section('title',"Editar Tipo de Competencia eva360")

@section('content')

<div class="container">

    <div class="col-sm-8">
        <div class="mt-1 text-center">
            <h3>Actualizar Frecuencia</h3>
        </div>

        <div id="flash-message">
            @include('flash-message')

        </div>

        <div class="card-header">

            <form action="{{route('frecuencia.update',$frecuencia)  }}" method="post">

                @csrf
                @method('PATCH' )

                <div class="form-group">
                    <label for="name">Frecuencia</label>
                    <input id="name" class="form-control" type="text" name="name" value="{{$frecuencia->name}}">
                </div>
                <div class="form-group">
                    <label for="description">Descripcion</label>
                    <input id="description" class="form-control" maxlength="255" type="text" name="description" value="{{$frecuencia->description}}">
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
