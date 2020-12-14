@extends('layout')

@section('title',"Creacion de Departamento")

@section('content')

<div class="container">

    <div class="col-sm-8">

        <div id="flash-message">
            @include('flash-message')
        </div>

        <div class="mt-1 text-center">
            <h5>Nuevo Departamento</h5>
        </div>

        <div class=" card-header">
            <form action="{{ route('departamento.store') }}" method="POST">
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
                    <a href="{{route('departamento.index')}}" class="btn btn-dark float-left">Back</a>
                    <button type="submit" class="btn btn-dark float-right">Save</button>
                </div>

            </form>
        </div>
    </div>
</div>

@endsection
