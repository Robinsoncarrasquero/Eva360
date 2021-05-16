@extends('master')

@section('title',"Catalogo de Mediciones")

@section('content')


<div class="container">

        <div id="flash-message">
            @include('flash-message')

        </div>

        <div class="mt-1 text-center">
            <h5>Catalogo de Mediciones</h5>
        </div>

        <div class="d-flex justify-content-end">
            <a  href="{{ route('medida.create')}}" class="btn btn-dark"><i class="material-icons">library_add</library-add></i> </a>
        </div>

        <div class="table table-responsive">
            <table class="table table-light table-striped ">
                <thead>
                    <th>#</th>
                    <th>Nombre</th>
                    <th>Medida</th>
                    <th>Descripcion</th>
                    <th></th>
                    <th></th>
                </thead>
                <tbody>
                    @foreach ($medidas as $medida)
                    <tr id="{{ $medida->id }}">
                        <td>{{ $medida->id }}</td>
                        <td>{{ $medida->name }}</td>
                        <td>{{ $medida->medida }}</td>
                        <td >{{ substr($medida->description,0,100) }} ....</td>

                        <td><a href="{{ route('medida.edit',$medida) }}" class="btn btn-dark"><i class="material-icons">create</i></a></td>
                        <td>
                            <button class="btn btn-danger" onclick="deleteConfirmation({{$medida->id}},'{{route('medida.delete',$medida->id)}}')">Delete</button>
                        </td>

                    </tr>
                    @endforeach
                    </tbody>
            </table>
        </div>


        <div class=" d-flex justify-content-center">
            {{ $medidas->links() }}
        </div>
</div>

@section('scripts')

    <script src="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/7.2.0/sweetalert2.all.min.js"></script>
    <script src="{{ asset('js/deleteConfirmation.js') }}"></script>
@endsection


@endsection
