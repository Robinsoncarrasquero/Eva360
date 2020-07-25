@extends('layout')

@section('title',"Lista de Frecuencias")

@section('content')


<div class="container">

    <div class="col-sm-12">

        <h2 class="display-5">Lista de Frecuencias</h2>
        <div id="flash-message">
            @include('flash-message')

        </div>
        <div class="text text-sm-right">
            <a style="margin: 19px;" href="{{ route('frecuencia.create')}}" class="btn btn-dark"><i class="material-icons">library_add</library-add></i> </a>
        </div>

        <table class="table table-light table-striped ">
            <thead>
                <th>#</th>
                <th>Descripcion</th>
                <th>Valor</th>
                <th></th>
                <th></th>
            </thead>
            <tbody>
                @foreach ($frecuencias as $frecuencia)
                <tr>
                    <td>{{ $frecuencia->id }}</td>
                    <td>{{ $frecuencia->name }}</td>
                    <td>{{ $frecuencia->valor }}</td>

                    <td><a href="{{ route('frecuencia.edit',$frecuencia) }}" class="btn btn-dark"><i class="material-icons">create</i></a></td>
                    <td>
                        <form action="{{ route('frecuencia.destroy',$frecuencia) }}" method="POST">
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
