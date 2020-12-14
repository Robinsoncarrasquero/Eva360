@extends('layout')

@section('title',"Lista de Departamentos")

@section('content')


<div class="container">

    <div class="col-sm-12">

        <div id="flash-message">
            @include('flash-message')

        </div>

        <div class="mt-1 text-center">
            <h5>Lista de Departamentos</h5>
        </div>

        <div class="text text-sm-right">
            <a href="{{ route('departamento.create')}}" class="btn btn-dark"><i class="material-icons">library_add</library-add></i> </a>
        </div>

        <table class="table table-light table-striped ">
            <thead>
                <th>#</th>
                <th>Departamento</th>
                <th>Descripcion</th>
                <th></th>
            </thead>
            <tbody>
                @foreach ($records as $record)
                <tr>
                    <td>{{ $record->id }}</td>
                    <td>{{ $record->name }}</td>
                    <td>{{ $record->description}}</td>
                    <td><a href="{{ route('departamento.edit',$record) }}" class="btn btn-dark"><i class="material-icons">create</i></a></td>
                    <td>
                        <form action="{{ route('departamento.destroy',$record) }}" method="POST">
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
    <div class=" d-flex justify-content-center">
        {{ $records->links() }}
    </div>

</div>

@endsection
