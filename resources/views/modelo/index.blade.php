@extends('master')

@section('title',"Modelos")

@section('content')

<div class="container">

    <div id="flash-message">
        @include('flash-message')

    </div>

    <div class="panel panel pb-3">
        <div class="clearfix">
            <form class="form-inline mt-2 mt-md-0 float-left">
                <input class="form-control mr-sm-2" type="text" placeholder="Nombre" aria-label="Search" name="buscarWordKey">
                <button class="btn btn-outline-success my-2 my-sm-0" type="submit">Buscar</button>
            </form>

        </div>
        <div class="text text-center">
            <h5>Modelos de Evaluacion</h5>
        </div>
    </div>

    <div class="d-flex justify-content-end">
        <a style="margin: 19px;" href="{{ route('modelo.create')}}" class="btn btn-dark"><i class="material-icons">add</library-add></i> </a>
    </div>

    @if($modelos->count())

    <div class="panel-body">

        <div class="table table-responsive">
            <table id="mytable" class="table  table-striped">
            <thead>
                <th scope="col">#</th>
                <th scope="col">Nombre</th>
                <th scope="col">Objetivo</th>
                <th>Ver</th>
                <th>Borrar</th>
            </thead>
            <tbody>
                @foreach($modelos as $modelo)
                <tr>
                    <td>{{$modelo->id}}</td>
                    <td>{{$modelo->name}}</td>
                    <td>{{$modelo->description}}</td>
                    <td>
                        <a href="{{ route('modelo.show',$modelo->id) }}" class="btn bg-dark-gray"> <i class="material-icons">edit</i></a>
                    </td>
                    <td>
                        <form  action="{{ route('modelo.destroy',$modelo->id) }}" method="POST">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger"> <i class="material-icons">delete</i></button>
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
            </table>
        </div>

    </div>

    @else

        <div class="alert alert-info">
            <p>No hay modelos registrados para crear una evaluacion</p>
        <div>

    @endif

    <div class=" d-flex justify-content-center">
        {{ $modelos->links() }}

    </div>

</div>


@endsection
