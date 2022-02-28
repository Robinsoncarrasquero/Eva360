@extends('master')

@section('title',"Lista de Metas Objetivos")

@section('content')


<div class="container">

        <div id="flash-message">
            @include('flash-message')

        </div>

        <div class="mt-1 text-center">
            <h5>Lista de Metas</h5>
        </div>

        <div class="d-flex justify-content-end">
            <a  href="{{ route('meta.create')}}" class="btn btn-dark"><i class="material-icons">library_add</library-add></i> </a>
        </div>

        <div class="table table-responsive">
            <table class="table table-light table-striped ">
                <thead>
                    <th>#</th>
                    <th>Nombre</th>
                    {{-- <th>Descripcion</th> --}}
                    <th>Requerido</th>
                    <th>Tipo</th>
                    <th>Copy</th>
                    <th>Edit</th>
                    <th>Del</th>
                </thead>
                <tbody>
                    @foreach ($metas as $meta)
                    <tr id="{{ $meta->id }}">
                        <td>{{ $meta->id }}</td>
                        <td>{{ $meta->name }}</td>
                        {{-- <td >{{ substr($competencia->description,0,100) }} ....</td> --}}
                        <td>{{ $meta->nivelrequerido }}</td>
                        <td>{{ $meta->tipo->tipo}}</td>
                        <td><a href="{{ route('meta.copy',$meta) }}" class="btn btn-dark"><i class="material-icons">copy_all</i></a></td>

                        <td><a href="{{ route('meta.edit',$meta) }}" class="btn btn-dark"><i class="material-icons">create</i></a></td>
                        <td>
                            <button class="btn btn-danger btnquitar" onclick="deleteConfirmation({{$meta->id}},'{{route('metas.delete',$meta->id)}}')">Delete</button>
                        </td>

                    </tr>
                    @endforeach
                    </tbody>
            </table>
        </div>


        <div class=" d-flex justify-content-center">
            {{ $metas->links() }}
        </div>
</div>

@section('scripts')

    <script src="{{ asset('js/deleteConfirmation.js') }}"></script>
@endsection


@endsection
