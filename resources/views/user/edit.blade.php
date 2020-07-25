@extends('layout')

@section('title',"Editar Usuario")

@section('content')

<div class="container">

    <div class="col-sm-8 text text-center">
        <h1 class="display-5">Editar Usuario</h1>
    </div>
    <div id="flash-message">
            @include('flash-message')
    </div>


    <form action="{{route('user.update',$user)  }}" method="post">

        @csrf
        @method('PATCH' )

        <div class="row justify-content-start">
            <div class="col-6">
                <label for="name">Nombre</label>
                <input id="name" class="form-control" type="text" name="name" value="{{$user->name }}">
            </div>
        </div>

        <div class="row justify-content-start">
            <div class="col-6">
                <label for="email">Email</label>
                <input id="email" class="form-control"  name="email"  value="{{ $user->email }}">
            </div>
        </div>

        <div class="row justify-content-start">
            <div class="col-6">
                <label >Actual Rol</label>
                <select class="form-control" id="roluser" name="roluser">
                    @foreach ($user->roles as $roluser)
                        <option  selected  value="{{ $roluser->id}}">{{ $roluser->name}}</option>
                    @endforeach
                </select>
            </div>
        </div>
        <div class="row justify-content-start">
            <div class="col-6">
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

        <div class="clearfix">
            <div class="col-6">
                <a href="{{route('user.index')}}" class="btn btn-dark float-left">Back</a>
                <button type="submit" class="btn btn-primary float-right">Save</button>

            </div>
        </div>

    </form>

</div>

@endsection
