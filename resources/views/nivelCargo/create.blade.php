@extends('master')

@section('title',"Creacion de Nivel de Cargo")

@section('content')



<div class="container">

    <div class="col-sm-8">

        <div id="flash-message">
            @include('flash-message')
        </div>
        <div class="mt-1 text-center">
            <h3>Nuevo Nivel de Cargo</h3>
        </div>

        <div class=" card-header">
            <form action="{{ route('nivelCargo.store') }}" method="POST">
                @csrf

                <div class="col-sm-12">
                    <label for="name">Nombre</label>
                    <input id="name" placeholder="General" class="form-control" type="text" name="name" value="{{old('name')  }}">
                </div>
                {{-- <div class="form-group">
                    <label for="description">Descripcion</label>
                    <input id="description"  placeholder="Descripcion" class="form-control" type="text" name="description" maxlength="255" value="{{old('description')  }}">
                </div> --}}

                <div class="col-sm-12">
                    <label for="description">Descripcion</label>
                    <textarea placeholder="Descripcion" type="text" id="description" class="form-control" rows="4"
                        maxlength="250" name="description">{{ old('description') }}</textarea>
                </div>

                <div class="clearfix">
                    <a href="{{route('nivelCargo.index')}}" class="btn btn-dark float-left">Back</a>
                    <button type="submit" class="btn btn-dark float-right btn-dark">Crear</button>

                </div>

            </form>
        </div>
    </div>
</div>

@endsection
