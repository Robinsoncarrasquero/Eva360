@extends('layout')

@section('title',"Lista de Tipos de Competencias eva360")

@section('content')


<div class="container">

    <div class="col-sm-12">

        <h1 class="display-5">Lista de Tipos de Competencias</h1>
        <div id="flash-message">
            @include('flash-message')

        </div>
        <div class="text text-sm-right">
            <a style="margin: 19px;" href="{{ route('tipo.create')}}" class="btn btn-dark"><i class="material-icons">library_add</library-add></i> </a>
        </div>

        <table class="table table-light table-striped ">
            <thead>
                <th>#</th>
                <th>Tipo</th>
                <th></th>
                <th></th>
            </thead>
            <tbody>
                @foreach ($tipos as $tipo)
                <tr>
                    <td>{{ $tipo->id }}</td>
                    <td>{{ $tipo->tipo }}</td>
                    <td><a href="{{ route('tipo.edit',$tipo) }}" class="btn btn-dark"><i class="material-icons">create</i></a></td>
                    <td>
                        <form action="{{ route('tipo.destroy',$tipo) }}" method="POST">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger"> <i class="material-icons">delete</i></button>
                        </form>

                    </td>
                </tr>
                @endforeach

                </tbody>
        </table>

    </div>

</div>

@endsection
