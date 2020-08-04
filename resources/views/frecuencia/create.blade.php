@extends('layout')

@section('title',"Creacion de Tipo de Competencia")

@section('content')


<div class="container">

    <div class="col-sm-8">
        <h1 class="display-5">Nuevo Frecuencia</h1>

        @if ($errors->any())
            <div class="alert alert-danger" role="alert">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

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

                <div class="clearfix">
                    <a href="{{route('tipo.index')}}" class="btn btn-dark float-left">Back</a>
                    <button type="submit" class="btn btn-primary float-right">Crear</button>

                </div>

            </form>
        </div>
    </div>
</div>

@endsection
