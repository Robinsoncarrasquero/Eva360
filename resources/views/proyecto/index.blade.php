@extends('layout')

@section('title',"Lista de Proyectos")

@section('content')

<div class="container">

    <div class="col-sm-12">

        <div id="flash-message">
            @include('flash-message')
        </div>

        <div class="text text-center mt-2">
            <h5>Lista de Proyectos</h5>
        </div>
        <div class="text text-sm-right">
            <a href="{{ route('proyecto.create')}}" class="btn btn-dark"><i class="material-icons">library_add</library-add></i> </a>
        </div>

        <table class="table table-light table-striped ">
            <thead>
                <th>#</th>
                <th>Proyecto</th>
                <th></th>
                <th></th>
            </thead>
            <tbody>
                @foreach ($records as $record)
                <tr id="{{ $record->id }}">
                    <td>{{ $record->id }}</td>
                    <td>{{ $record->name }}</td>
                    <td><a href="{{ route('proyecto.edit',$record) }}" class="btn btn-dark"><i class="material-icons">create</i></a></td>
                    <td>
                        <button class="btn btn-danger" onclick="deleteConfirmation({{$record->id}},'{{route('proyecto.delete',$record->id)}}')">Delete</button>
                    </td>
                </tr>
                @endforeach

                </tbody>
        </table>

    </div>

</div>

@section('scripts')
    <script src="{{ asset('js/deleteConfirmation.js') }}"></script>
@endsection

@endsection
