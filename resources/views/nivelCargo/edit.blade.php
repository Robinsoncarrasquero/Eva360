@extends('layout')

@section('title',"Editar Nivel de Cargo")

@section('content')

<div class="container">

    <div class="col-sm-8">

        <div id="flash-message">
            @include('flash-message')

        </div>
        <div class="mt-1 text-center">
            <h3>Actualizar Nivel de Cargo</h3>
        </div>

        <div class="card-header">

            <form action="{{route('nivelCargo.update',$record)  }}" method="post">

                @csrf
                @method('PATCH' )

                <div class="col-sm-12">
                    <label for="name">Nombre</label>
                    <input id="name" class="form-control" type="text" name="name" value="{{$record->name}}">
                </div>

                <div class="col-sm-12">
                    <label for="description">Descripcion</label>
                    <textarea placeholder="Descripcion" type="text" id="description" class="form-control" rows="4"
                        maxlength="250" name="description">{{ $record->description }}</textarea>
                </div>

                <div class="clearfix">
                    <a href="{{route('nivelCargo.index')}}" class="btn btn-dark float-left">Back</a>
                    <button type="submit" class="btn btn-dark float-right">Save</button>
                </div>
            </form>
        <div>
    </div>
</div>

@endsection
