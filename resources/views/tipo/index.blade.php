@extends('master')

@section('title',"Lista de Tipos de Competencias")

@section('content')

<div class="container">

    <div id="flash-message">
        @include('flash-message')
    </div>

    <div class="text text-center mt-2">
        <h5>Tipos de Competencias</h5>
    </div>

    <div class="text text-sm-right">
        <a href="{{ route('tipo.create')}}" class="btn btn-dark"><i class="material-icons">library_add</library-add></i> </a>
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
            <tr id="{{ $tipo->id }}">
                <td>{{ $tipo->id }}</td>
                <td>{{ $tipo->tipo }}</td>
                <td><a href="{{ route('tipo.edit',$tipo) }}" class="btn btn-dark"><i class="material-icons">create</i></a></td>

                <td>
                    <button class="btn btn-danger" onclick="deleteConfirmation({{$tipo->id}},'{{route('tipo.delete',$tipo->id)}}')">Delete</button>
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
