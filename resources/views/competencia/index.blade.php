@extends('master')

@section('title',"Lista de Competencias")

@section('content')


<div class="container">

        <div id="flash-message">
            @include('flash-message')

        </div>

        <div class="mt-1 text-center">
            <h5>Diccionario de Competencias</h5>
        </div>

        <div class="d-flex justify-content-end">
            <a  href="{{ route('competencia.create')}}" class="btn btn-dark"><i class="material-icons">library_add</library-add></i> </a>
        </div>

        <div class="table table-responsive">
            <table class="table table-light table-striped ">
                <thead>
                    <th>#</th>
                    <th>Nombre</th>
                    {{-- <th>Descripcion</th> --}}
                    <th>Nivel</th>
                    <th>Requerido</th>
                    <th>Tipo</th>
                    <th></th>
                    <th></th>
                </thead>
                <tbody>
                    @foreach ($competencias as $competencia)
                    <tr id="{{ $competencia->id }}">
                        <td>{{ $competencia->id }}</td>
                        <td>{{ $competencia->name }}</td>
                        <td>@if ($competencia->seleccionmultiple) MultiNivel @else Simple @endif</td>
                        {{-- <td >{{ substr($competencia->description,0,100) }} ....</td> --}}
                        <td>{{ $competencia->nivelrequerido }}</td>
                        <td>{{ $competencia->tipo->tipo}}</td>
                        <td><a href="{{ route('competencia.edit',$competencia) }}" class="btn btn-dark"><i class="material-icons">create</i></a></td>
                        <td>
                            <button class="btn btn-danger" onclick="deleteConfirmation({{$competencia->id}},'{{route('competencia.delete',$competencia->id)}}')">Delete</button>
                        </td>

                    </tr>
                    @endforeach
                    </tbody>
            </table>
        </div>


        <div class=" d-flex justify-content-center">
            {{ $competencias->links() }}
        </div>
</div>

@section('scripts')

    <script src="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/7.2.0/sweetalert2.all.min.js"></script>
    <script src="{{ asset('js/deleteConfirmation.js') }}"></script>
@endsection


@endsection
