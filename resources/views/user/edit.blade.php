@extends('layout')

@section('title',"Editar Usuario")

@section('content')

<div class="container">

    <div id="flash-message">
        @include('flash-message')
    </div>
    <div class="mt-2 pb-2 text text-center col-sm-6">
        <h5>Modificar Usuario</h5>
    </div>
    <form  class="card-header" action="{{route('user.update',$user)  }}" method="post">
        @csrf
        @method('PATCH' )
        <div class="justify-content-start">
            <div class="col-sm-6">
                <label for="name">Nombre</label>
                <input id="name" class="form-control" type="text" name="name" value="{{$user->name }}">
            </div>
        </div>

        <div class="justify-content-start">
            <div class="col-sm-6">
                <label for="email">Email</label>
                <input id="email" class="form-control"  name="email"  value="{{ $user->email }}">
            </div>
        </div>

        <div class="justify-content-start">
            <div class="col-sm-6">
                <label >Actual Rol</label>
                <select class="form-control" id="roluser" name="roluser">
                    @foreach ($user->roles as $roluser)
                        <option  selected  value="{{ $roluser->id}}">{{ $roluser->name}}</option>
                    @endforeach
                </select>
            </div>
        </div>
        <div class="justify-content-start">
            <div class="col-sm-6">
                <label >Nuevo Rol</label>
                <select  class="form-control" id="newrol" name="newrol">
                    @foreach ($roles as $rol)
                        @if ($rol->id==$roluser->id)
                            <option selected  value="{{$rol->id}}">{{ $rol->name}}</option>
                        @else
                            <option  value="{{$rol->id}}">{{ $rol->name}}</option>
                        @endif
                        @if(Auth::user()->admin() && $rol->id==$roluser->id))
                            @break
                        @endif
                    @endforeach
                </select>
            </div>
        </div>

        <div class="clearfix col-sm-12 mt-2">
            <div class="col-sm-6">
                <a href="{{url()->previous()}}" class="btn btn-dark float-left">Back</a>
                <button type="submit" class="btn btn-dark float-right">Save</button>
            </div>
        </div>

    </form>


</div>

@endsection
