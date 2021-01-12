@extends('master')

@section('title',"Crear Usuario")

@section('content')

<div class="container">

    <div id="flash-message">
            @include('flash-message')
    </div>
    <div class="col-sm-8 text text-center">
        <h5 >Editar Usuario</h5>
    </div>

    <form action="{{route('user.store')  }}" method="post">
        @csrf
        <div class="justify-content-start">
            <div class="col-6">
                <label for="name">Nombre</label>
                <input id="name" class="form-control" type="text" name="name" value="{{old('name')}}">
            </div>
        </div>

        <div class="justify-content-start">
            <div class="col-6">
                <label for="email">Email</label>
                <input id="email" class="form-control"  name="email"  value="{{ old('email')}}">
            </div>
        </div>

        <div class="justify-content-start">
            <div class="col-6">
                <label >Cargo</label>
                <select class="form-control" id="cargo" name="cargo">
                    @foreach ($cargos as $cargo)
                        <option  value="{{ $cargo->id }}">{{ $cargo->name}}</option>
                    @endforeach
                </select>
            </div>
        </div>

        <div class="justify-content-start">
            <div class="col-6">
                <label >Ubicacion</label>
                <select class="form-control" id="departamento" name="departamento">
                    @foreach ($departamentos as $departamento)
                        <option  value="{{ $departamento->id }}">{{ $departamento->name}}</option>
                    @endforeach
                </select>
            </div>
        </div>

        <div class="justify-content-start">
            <div class="col-6">
                <label for="name">Codigo</label>
                <input type="text" class="form-control"  id="codigo" name="codigo" value="{{old('codigo')}}">
            </div>
        </div>

        <div class="justify-content-start">
            <div class="col-6">
                <label >Roles de Usuario</label>
                <select class="form-control" id="roluser" name="roluser">
                    @foreach ($roles as $roluser)
                        <option  value="{{ $roluser->id }}">{{ $roluser->name}}</option>
                    @endforeach
                </select>
            </div>
        </div>

        <div class="justify-content-start">
            <div class="col-sm-6">
                <label for="phone_number">Movil</label>
                <input id="phone_number" class="form-control"  name="phone_number"  value="{{ old('phone_number') }}">
            </div>
        </div>

        <div class="clearfix">
            <div class="col-6">
                <a href="{{route('user.index')}}" class="btn btn-dark float-left">Back</a>
                <button type="submit" class="btn btn-dark float-right">Save</button>

            </div>
        </div>

    </form>

</div>

@endsection
