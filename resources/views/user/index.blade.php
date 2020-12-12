@extends('layout')

@section('title',"Lista de Usuarios")

@section('content')


<div class="container">

    <div class="col-sm-12">

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
            <div class="text text-center">
                <h3>Lista de Usuarios</h3>
            </div>
        </div>

        <div class="text text-sm-right">
            <a  href="{{ route('user.create')}}" class="btn btn-dark"><i class="material-icons">library_add</library-add></i> </a>
        </div>

        <table class="table table-light table-striped table-condensed">
            <thead>
                <th>#</th>
                <th>User</th>
                <th>Email</th>
                <th>accion</th>
                <th></th>
            </thead>
            <tbody>
                @foreach ($users as $user)
                <tr>
                    <td>{{ $user->id }}</td>
                    <td>{{ $user->name }}</td>
                    <td>{{ $user->email}}</td>
                    <td><a href="{{ route('user.edit',$user) }}" class="btn btn-dark"><i class="material-icons">create</i></a></td>
                    <td>
                        <form action="{{ route('user.destroy',$user) }}" method="POST">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger"> <i class="material-icons">delete</i></button>
                        </form>

                    </td>
                </tr>
                @endforeach

                </tbody>
        </table>
        <div class="d-flex justify-content-center">
            {{ $users->links() }}


        </div>

    </div>

</div>

@endsection
