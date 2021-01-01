@extends('master')

@section('title',"Lista de Niveles de Cargos")

@section('content')


<div class="container">

    <div id="flash-message">
        @include('flash-message')

    </div>

    <div class="text text-center mt-2">
        <h5>Lista de Niveles de Cargos</h5>
    </div>

    <div class="d-flex justify-content-end">
        <a href="{{ route('nivelCargo.create')}}" class="btn btn-dark"><i class="material-icons">library_add</library-add></i> </a>
    </div>

    <div class="table table-responsive">
        <table class="table table-light table-striped ">
            <thead>
                <th>#</th>
                <th>Nivel de Cargo</th>
                <th></th>
                <th></th>
            </thead>
            <tbody>
                @foreach ($records as $record)
                <tr id="{{ $record->id }}">
                    <td>{{ $record->id }}</td>
                    <td>{{ $record->name }}</td>
                    <td><a href="{{ route('nivelCargo.edit',$record) }}" class="btn btn-dark"><i class="material-icons">create</i></a></td>
                    <td>
                        <button class="btn btn-danger" onclick="deleteConfirmation({{$record->id}},'{{route('nivelcargo.delete',$record->id)}}')">Delete</button>
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
