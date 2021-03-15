@extends('master')

@section('title',"Editar Ubicacion")

@section('content')

<div class="container">

        <div id="flash-message">
            @include('flash-message')
        </div>

        <div class="mt-1 text-center">
            <h5>Actualizar Ubicacion</h5>
        </div>

        <div class="card-header">

            <form action="{{route('ubicacion.update',$record)  }}" method="post">
                @csrf
                @method('PATCH' )

                <div class="col-sm-12">
                    <label for="name">Nombre</label>
                    <input id="name" class="form-control" type="text" name="name" placeholder="ubicacion" value="{{$record->name}}">
                </div>

                <div class="col-sm-12">
                    <label for="description">Descripcion</label>
                    <textarea placeholder="Descripcion" type="text" id="description" class="form-control" rows="4"
                        maxlength="250" name="description">{{ $record->description }}</textarea>
                </div>

                <div class="justify-content-start">
                    <div class="col-sm-12">
                        <label >Manager</label>
                        <select class="form-control" id="manager_id" name="manager_id">
                            @foreach ($users as $user)
                                @if ($user->id==$record->manager_id)
                                    <option selected  value="{{ $user->id }}">{{ $user->name}}</option>
                                @else
                                    <option  value="{{ $user->id }}">{{ $user->name}}</option>
                                @endif
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="clearfix col-sm-12 mt-2">
                    <a href="{{url()->previous()}}" class="btn btn-dark float-left">Back</a>
                    <button type="submit" class="btn btn-dark float-right">Save</button>
                </div>

            </form>
        <div>

</div>

@endsection
