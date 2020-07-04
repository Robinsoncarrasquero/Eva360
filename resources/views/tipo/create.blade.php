@extends('layout')

@section('title',"Creacion de Tipo de Competencia eva360")

@section('content')


<div class="container">

    <div class="col-sm-8">
        <h1 class="display-5">Nuevo Tipo de Competencia</h1>

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
            <form action="{{ route('tipo.store') }}" method="POST">
                @csrf

                <div class="form-group">
                    <label for="tipo">Tipo</label>
                    <input id="tipo" placeholder="General" class="form-control" type="text" name="tipo" value="{{old('tipo')  }}">
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
