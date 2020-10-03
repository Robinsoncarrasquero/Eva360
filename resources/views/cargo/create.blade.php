@extends('layout')

@section('title',"Creacion de Cargo")

@section('content')

<div class="container">

    <div class="col-sm-8">

        <div id="flash-message">
            @include('flash-message')
        </div>
        <div class="mt-1 text-center">
            <h3>Nuevo Cargo</h3>
        </div>

        <div class=" card-header">
            <form action="{{ route('cargo.store') }}" method="POST">
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

                <div class="col-sm-12">
                    <label for="nivel">Nivel de Cargo</label>
                    <select id="nivel" class="form-control" name="nivel" >
                        @foreach ($nivel_cargos as $data)
                            @if (old('nivel')==$data->id)
                                <option selected value="{{$data->id}}">{{ $data->name }}</option>
                            @else
                                <option value="{{$data->id}}">{{ $data->name }}</option>
                            @endif
                        @endforeach
                    </select>
                </div>

                <div class="clearfix">
                    <a href="{{route('cargo.index')}}" class="btn btn-dark float-left">Back</a>
                    <button type="submit" class="btn btn-dark float-right btn-dark">Crear</button>
                </div>

            </form>
        </div>
    </div>
</div>

@endsection
