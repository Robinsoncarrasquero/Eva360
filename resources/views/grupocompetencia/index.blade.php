@extends('master')

@section('title',"Grupo de Competencias")

@section('content')


<div class="container">

    <div class="col-sm-12">

        <h2 class="display-5">Grupo de Competencias</h2>
        <div id="flash-message">
            @include('flash-message')

        </div>
        <div class="text text-sm-right">
            <a style="margin: 19px;" href="{{ route('grupocompetencia.create')}}" class="btn btn-dark"><i class="material-icons">library_add</library-add></i> </a>
        </div>

        <table class="table table-light table-striped ">
            <thead>
                <th>#</th>
                <th>Nombre</th>
                <th>Descripcion</th>
                <th>Nivel Requerido</th>
                <th>Tipo</th>
                <th></th>
                <th></th>
            </thead>
            <tbody>
                @foreach ($competencias as $competencia)
                <tr>
                    <td>{{ $competencia->id }}</td>
                    <td>{{ $competencia->name }}</td>
                    <td>{{ $competencia->description }}</td>
                    <td>{{ $competencia->nivelrequerido }}</td>
                    <td>{{ $competencia->tipo->tipo}}</td>
                    <td><a href="{{ route('grupocompetencia.edit',$competencia) }}" class="btn btn-dark"><i class="material-icons">create</i></a></td>
                    <td>
                        <form  action="{{ route('grupocompetencia.destroy',$competencia) }}" method="POST">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger"> <i class="material-icons">delete</i></button>
                        </form>

                    </td>
                </tr>
                @endforeach

                </tbody>
        </table>
        <div class=" d-flex justify-content-center">
            {{ $competencias->links() }}

        </div>
    </div>

</div>

@endsection
