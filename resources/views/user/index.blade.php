@extends('master')

@section('title',"Lista de Usuarios")

@section('content')


<div class="container">

    <div id="flash-message">
        @include('flash-message')

    </div>

    <div class="panel panel pb-3">
        <div class="clearfix">
            <form class="form-inline mt-2 mt-md-0 float-left">
                <input class="form-control mr-sm-2" type="text" placeholder="Nombre" aria-label="Search" name="buscarWordKey">
                <button class="btn btn-outline-success my-2 my-sm-0" type="submit">Buscar</button>
            </form>
        </div>
    </div>

    <div class="text text-center">
        <h5>Lista de Usuarios</h5>
    </div>

    <div class="d-flex justify-content-end">
        <a  href="{{ route('user.create')}}" class="btn btn-dark"><i class="material-icons">library_add</library-add></i> </a>
    </div>

    <div class="table table-responsive">
        <table class="table table-light table-striped">
            <thead>
                <th>#</th>
                <th>User</th>
                <th>Email</th>
                <th></th>
                <th></th>
            </thead>
            <tbody>
            @foreach ($users as $user)
            <tr id="{{ $user->id }}">
                <td>{{ $user->id }}</td>
                <td>{{ $user->name }}</td>
                <td>{{ $user->email}}</td>
                <td><a href="{{ route('user.edit',$user) }}" class="btn btn-dark"><i class="material-icons">create</i></a></td>
                <td>
                    <button class="btn btn-danger" onclick="deleteConfirmation({{$user->id}},'{{route('user.delete',$user->id)}}')">Delete</button>
                </td>
            </tr>
            @endforeach
            </tbody>
        </table>
    </div>

    <div class="d-flex justify-content-center">
        {{ $users->links() }}
    </div>

</div>

@section('scripts')
    <script src="{{ asset('js/deleteConfirmation.js') }}"></script>
@endsection

@endsection
