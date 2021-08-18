@extends('master')

@section('title',"Periodo")

@section('content')


<div class="container">

    <div id="flash-message">
        @include('flash-message')

    </div>

    <div class="mt-1 text-center">
        <h5>Lista de frecuencia</h5>
    </div>

    <div class="d-flex justify-content-end">
        <a  href="{{ route('periodo.create')}}" class="btn btn-dark"><i class="material-icons">library_add</library-add></i> </a>
    </div>

    <div class="table table-responsive">
        <table class="table table-light table-striped ">
            <thead>
                <th>#</th>
                <th>Frecuencia</th>
                <th>Descripcion</th>
                <th></th>
                <th></th>
            </thead>
            <tbody>
                @foreach ($periodos as $periodo)
                <tr id="{{ $periodo->id }}">
                    <td>{{ $periodo->id }}</td>
                    <td>{{ $periodo->name }}</td>
                    <td >{{ substr($periodo->description,0,100) }} ....</td>

                    <td><a href="{{ route('periodo.edit',$periodo) }}" class="btn btn-dark"><i class="material-icons">create</i></a></td>
                    <td>
                        <button class="btn btn-danger" onclick="deleteConfirmation({{$periodo->id}},'{{route('periodo.delete',$periodo->id)}}')">Delete</button>
                    </td>

                </tr>
                @endforeach
                </tbody>
        </table>
    </div>

    <div class=" d-flex justify-content-center">
        {{ $periodos->links() }}
    </div>

</div>

@section('scripts')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/7.2.0/sweetalert2.all.min.js"></script>
    <script src="{{ asset('js/deleteConfirmation.js') }}"></script>
@endsection

@endsection
