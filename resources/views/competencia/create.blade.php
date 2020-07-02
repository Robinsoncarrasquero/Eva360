@extends('layout')

@section('title',"Creacion de Competencias eva360")

@section('content')


<div class="container">

    <div class="col-sm-8">

        <div class="col-sm-12 offset-sm-2">
           <h1 class="display-3">Add Competencia</h1>
        </div>

        @if ($errors->any())
            <div class="alert alert-danger" role="alert">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('competencia.store') }}" method="POST">
            @csrf
            <div class="form-group">
                <label for="name">Nombre</label>
                <input id="name" class="form-control" type="text" name="name">
            </div>
            <div class="form-group">
                <label for="description">Description</label>
                <textarea type="text" id="description" class="form-control" rows="5"  maxlength="1000" name="description"></textarea>
            </div>
            <div class="form-group">
                <label for="nivelrequerido">Nivel Requerido</label>
                <input id="nivelrequerido" class="form-control" type="text" name="nivelrequerido">
            </div>


            <div class="form-group">
                <label for="tipo">Tipo</label>
                <select id="tipo" class="form-control" name="tipo">
                    <option selected value="G">General</option>
                    <option value="T">Tecnica</option>
                    <option value="S">Supervisor</option>
                    <option value="E">Especifica</option>

                </select>
            </div>

            <button type="submit" class="btn btn-primary btn-primary">Add Competencia</button>

        </form>

    </div>

</div>

@endsection
