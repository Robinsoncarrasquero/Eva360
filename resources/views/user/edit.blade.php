@extends('master')

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
            <div class="col-6">
                <label for="codigo">Codigo</label>
                <input type="text" class="form-control"  id="codigo" name="codigo" value="{{$user->codigo}}">
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
                <label for="email_super">Email Supervisor</label>
                <input id="email_super" class="form-control"  name="email_super"
                value="@if($user_admin) {{ $user->email}}@else {{ $user->email_super }}@endif">
            </div>
        </div>

        <div class="justify-content-start">
            <div class="col-sm-6">
                <label >Cargo</label>
                <select class="form-control" id="cargo" name="cargo">
                    @foreach ($cargos as $cargo)
                        @if($user_admin)
                            <option selected  value="0">Administrator</option>
                            @break
                        @endif
                        @if ($cargo->id==$user->cargo_id)
                            <option selected  value="{{ $cargo->id }}">{{ $cargo->name}}</option>
                        @else
                            <option  value="{{ $cargo->id }}">{{ $cargo->name}}</option>
                        @endif
                    @endforeach
                </select>
            </div>
        </div>
        <div class="justify-content-start">
            <div class="col-sm-6">
                <label >Ubicacion</label>
                <select class="form-control" id="departamento" name="departamento">
                    @foreach ($departamentos as $departamento)
                        @if($user_admin)
                            <option selected  value="0">Administrator</option>
                            @break
                        @endif
                        @if ($departamento->id==$user->departamento_id)
                            <option selected  value="{{ $departamento->id }}">{{ $departamento->name}}</option>
                        @else
                            <option  value="{{ $departamento->id }}">{{ $departamento->name}}</option>
                        @endif
                    @endforeach
                </select>
            </div>
        </div>
        <div class="justify-content-start">
            <div class="col-sm-6">
                <label >Rol de usuario</label>
                <select class="form-control" id="roluser" name="roluser">
                    @foreach ($user->roles as $roluser)
                        <option  selected  value="{{ $roluser->id}}">{{ $roluser->name}}</option>
                    @endforeach
                </select>
            </div>
        </div>
        {{-- <div class="justify-content-start">
            <div class="col-sm-6">
                <label >Nuevo Rol</label>
                <select  class="form-control" id="newrol" name="newrol">
                    @foreach ($roles as $rol)
                        @if ($rol->id==$roluser->id)
                            <option selected  value="{{$rol->id}}">{{ $rol->name}}</option>
                        @else
                            <option  value="{{$rol->id}}">{{ $rol->name}}</option>
                        @endif
                        @if($user_admin && $rol->id==$roluser->id))
                            @break
                        @endif
                    @endforeach
                </select>
            </div>
        </div> --}}

        <div class="justify-content-start">
            <div class="col-sm-6">
                <label for="phone_number">Movil</label>
                <input id="phone_number" class="form-control"  name="phone_number"  value="{{ $user->phone_number }}">
            </div>
        </div>

        <div class="justify-content-start">
            <div class="col-sm-6">
                <label class="form-check-label " for="active" style="color: rgb(255, 165, 0);font-size:1.5em">Activo</label>
                <input type="checkbox" class="check-select "  name="active" @if($user->active) checked @endif>
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
