@extends('master')

@section('title',"Editar Calificacion")

@section('content')

<div class="container">

    <div id="flash-message">
        @include('flash-message')
    </div>

    <div class="text text-center">
        <h5>Actualizar calificacion</h5>
    </div>

    <form class="card-header" action="{{route('qualify.update',$medida)  }}" method="post">
        @csrf
        @method('PATCH' )

        <div class="col-lg-12">
            <label for="nivel">Nivel</label>
            <input id="nivel" maxlength="20" class="form-control" type="text" name="nivel" value="{{$medida->nivel }}">
        </div>

        <div class="col-lg-12">
            <label for="name">Nombre</label>
            <input id="name" maxlength="50" class="form-control" type="text" name="name" value="{{$medida->name }}">
        </div>

        <div class="col-lg-12">
            <label for="description">Descripcion</label>
            <textarea id="description" maxlength="100" class="form-control"  name="description" rows="4" >{{$medida->description }}</textarea>
        </div>

        <div class="col-lg-12">
            <label for="description">Color</label>
            <input name="color" type="color"  value="{{ $medida->color }}">
        </div>


        <div class="clearfix col-lg-12 mt-2">
            <a href="{{url()->previous()}}" class="btn btn-dark float-left">Back</a>
            <button type="submit" class="btn btn-dark float-right">Save</button>
        </div>

    </form>
</div>

@endsection
