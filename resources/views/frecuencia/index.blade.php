@extends('master')

@section('title',"Lista de Frecuencias")

@section('content')


<div class="container">


        <div id="flash-message">
            @include('flash-message')
        </div>

        <div class="text text-center mt-2">
            <h5>Lista de Frecuencias</h5>
        </div>

        <div class="text text-sm-right">
            <a  href="{{ route('frecuencia.create')}}" class="btn btn-dark"><i class="material-icons">library_add</library-add></i> </a>
        </div>

        <table class="table table-light table-striped ">
            <thead>
                <th>#</th>
                <th>Frecuencia</th>
                <th>Descripcion</th>
                <th>Valor</th>
                <th></th>
                <th></th>
            </thead>
            <tbody>
                @foreach ($frecuencias as $record)
                <tr id="{{ $record->id }}">
                    <td>{{ $record->id }}</td>
                    <td>{{ $record->name }}</td>
                    <td>{{ $record->description}}</td>
                    <td>{{ $record->valor }}</td>

                    <td><a href="{{ route('frecuencia.edit',$record) }}" class="btn btn-dark"><i class="material-icons">create</i></a></td>
                    <td>
                        <button class="btn btn-danger" onclick="deleteConfirmation({{$record->id}},'{{route('frecuencia.delete',$record->id)}}')">Delete</button>
                    </td>
                </tr>
                @endforeach

                </tbody>
        </table>
</div>

@section('scripts')
    <script src="{{ asset('js/deleteConfirmation.js') }}"></script>
@endsection

@endsection
