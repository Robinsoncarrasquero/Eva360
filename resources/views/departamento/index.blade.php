@extends('master')

@section('title',"Lista de Ubicaciones")

@section('content')


<div class="container">


        <div id="flash-message">
            @include('flash-message')

        </div>

        <div class="mt-1 text-center">
            <h5>Lista de Ubicacionesx</h5>
        </div>

        <div class="d-flex justify-content-end">
            <a href="{{ route('ubicacion.create')}}" class="btn btn-dark"><i class="material-icons">library_add</library-add></i> </a>
        </div>

        <table class="table table-light table-striped ">
            <thead>
                <th>#</th>
                <th>Ubicacion</th>
                <th>Descripcion</th>
                <th></th>
            </thead>
            <tbody>
                @foreach ($records as $record)
                <tr id="{{ $record->id }}">
                    <td>{{ $record->id }}</td>
                    <td>{{ $record->name }}</td>
                    <td>{{ $record->description}}</td>
                    <td><a href="{{ route('ubicacion.edit',$record) }}" class="btn btn-dark"><i class="material-icons">create</i></a></td>
                    <td>
                        <button class="btn btn-danger" onclick="deleteConfirmation({{$record->id}},'{{route('departamento.delete',$record->id)}}')">Delete</button>
                    </td>
                </tr>
                @endforeach

                </tbody>
        </table>

        <div class=" d-flex justify-content-center">
            {{ $records->links() }}
        </div>

</div>

@section('scripts')
    <script src="{{ asset('js/deleteConfirmation.js') }}"></script>
@endsection

@endsection
