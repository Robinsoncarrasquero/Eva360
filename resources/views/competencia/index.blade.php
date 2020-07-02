@extends('layout')

@section('title',"Lista de Competencias eva360")

@section('content')


<div class="container">

    <div class="col-sm-12">

        <h1 class="display-3">Lista de Competencias</h1>
        <div id="flash-message">
            @include('flash-message')

        </div>
        <div class="text text-sm-right">
            <a style="margin: 19px;" href="{{ route('competencia.create')}}" class="btn btn-dark"><i class="material-icons">library_add</library-add></i> </a>
        </div>

        <table class="table table-light ">
            <thead>
                <th>id</th>
                <th>Nombre</th>
                <th>Descripcion</th>
                <th>Nivel Requerido</th>
                <th>Tipo</th>
                <th></th>
                <th></th>
            </thead>
            <tbody>
                @foreach ($competencias as $competencia)
                <tr>
                    <td>{{ $competencia->id }}</td>
                    <td>{{ $competencia->name }}</td>
                    <td>{{ $competencia->description }}</td>
                    <td>{{ $competencia->nivelrequerido }}</td>
                    <td>{{ $competencia->tipo }}</td>
                    <td><a href="{{ route('competencia.edit',$competencia) }}" class="btn btn-dark"><i class="material-icons">create</i></a></td>
                    <td>
                        <form action="{{ route('competencia.destroy',$competencia) }}" method="POST">
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
