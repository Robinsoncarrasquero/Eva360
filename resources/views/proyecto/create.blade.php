@extends('layout')

@section('title',"Creacion de Proyecto")

@section('content')

<div class="container">

    <div class="col-sm-8">

        <div id="flash-message">
            @include('flash-message')
        </div>

        <div class="mt-1 text-center">
            <h5>Nuevo Proyecto</h5>
        </div>

        <div class=" card-header">
            <form action="{{ route('proyecto.store') }}" method="POST">
                @csrf

                <div class="col-sm-12">
                    <label for="name">Nombre</label>
                    <input id="name" placeholder="General" class="form-control" type="text" name="name" value="{{old('name')  }}">
                </div>

                <div class="col-sm-12">
                    <label for="description">Descripcion</label>
                    <textarea placeholder="Descripcion" type="text" id="description" class="form-control" rows="4"
                        maxlength="250" name="description">{{ old('description') }}</textarea>
                </div>

                <div class="clearfix col-sm-12 mt-2">
                    <a href="{{route('proyecto.index')}}" class="btn btn-dark float-left">Back</a>
                    <button type="submit" class="btn btn-dark float-right btn-dark">Crear</button>
                </div>

            </form>
        </div>
    </div>
</div>

@endsection
