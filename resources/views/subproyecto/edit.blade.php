@extends('master')

@section('title',"Editar Sub Proyecto")

@section('content')

<div class="container">

    <div id="flash-message">
        @include('flash-message')
    </div>

    <div class="mt-1 text-center">
        <h5>Actualizar Sub Proyecto</h5>
    </div>

    <div class="card-header">

        <form action="{{route('subproyecto.update',$record)  }}" method="post">
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

            <div class="col-sm-12">
                <label for="proyecto">Proyecto de pertenencia</label>
                <select id="proyecto" class="form-control" name="proyecto" >
                    @foreach ($proyectos as $data)
                        @if ($record->proyecto_id==$data->id)
                            <option selected value="{{$data->id}}">{{ $data->name }}</option>
                        @else
                            <option value="{{$data->id}}">{{ $data->name }}</option>
                        @endif
                    @endforeach
                </select>
            </div>

            <div class="card-header">
                <label  for="tipo">Tipo</label>
                <select id="tipo"  class="form-control" name="tipo" >

                    @foreach ( $tipos as $tipo )
                        @if ($record->tipo==$tipo)
                            <option selected value="{{ $tipo }}">{{ $tipo }}</option>
                        @else
                            <option          value="{{ $tipo }}">{{ $tipo }}</option>
                        @endif
                    @endforeach

                </select>
            </div>

            <div class="justify-content-start">
                <div class="col">
                    <label >Ubicacion</label>
                    <select class="form-control" id="departamento" name="departamento">
                        @foreach ($departamentos as $departamento)

                           @if ($record->departamento_id==$departamento->id)
                                <option selected value="{{ $departamento->id }}">{{ $departamento->name}}</option>
                            @else
                                <option          value="{{ $departamento->id }}">{{ $departamento->name}}</option>
                            @endif
                         @endforeach

                    </select>
                </div>
            </div>

            <div class="clearfix col-sm-12 mt-2">
                <a href="{{route('subproyecto.index')}}" class="btn btn-dark float-left">Back</a>
                <button type="submit" class="btn btn-dark float-right">Save</button>
            </div>
        </form>
    <div>
</div>

@endsection
