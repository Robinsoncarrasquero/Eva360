@extends('layout')

@section('title',"Creacion de Tipo de Competencia")

@section('content')


<div class="container">

    <div class="col-sm-8">
        <div id="flash-message">
            @include('flash-message')

        </div>
        <div class="mt-1 text-center">
            <h5>Nueva Frecuencia</h5>
        </div>

        <div class=" card-header">
            <form action="{{ route('frecuencia.store') }}" method="POST">
                @csrf
                <div class="form-group">
                    <label for="name">Frecuencia</label>
                    <input id="name" placeholder="Ingrese una frecuencia" class="form-control" type="text" name="name" value="{{old('name')  }}">
                </div>
                <div class="form-group">
                    <label for="description">Descripcion</label>
                    <input id="description"  placeholder="Ingrese una frecuencia" class="form-control" type="text" name="description" maxlength="255" value="{{old('description')  }}">
                </div>
                <div class="form-group">
                    <label for="valor">Valor</label>
                    <input id="valor" placeholder="Ingrese una valor entre 0 y 100" class="form-control" type="text" name="valor" value="{{old('valor')  }}">
                </div>

                <div class="clearfix col-sm-12 mt-2">
                    <a href="{{route('tipo.index')}}" class="btn btn-dark float-left">Back</a>
                    <button type="submit" class="btn btn-dark float-right">Crear</button>
                </div>

            </form>
        </div>
    </div>
</div>

@endsection
