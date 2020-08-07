@extends('layout')

@section('title',"Lanzamiento de Prueba")

@section('content')

<div class="container">

    <div class="panel panel pb-3">
        <h4 class="text text-md-center text text-warning ">Seleccione El Modelo de Prueba para la Evaluacion de {{ $evaluado->name }}</h4>
    </div>
    <div class="panel panel pb-3">
        <div class="clearfix">
            <form class="form-inline mt-2 mt-md-0 float-left" action="{{ route('lanzar.seleccionarmodelo',$evaluado) }}">
                <input class="form-control mr-sm-2" type="text" placeholder="Modelo" aria-label="Searh" name="buscarWordKey">
                <button class="btn btn-outline-success my-2 my-sm-0" type="submit">Buscar</button>
            </form>

        </div>
    </div>

    @if ($modelos)
            <form action="{{ route('lanzar.procesarmodelo',$evaluado) }}" method="POST">
                @csrf
                <div class="table">
                    <table id="table1" class="table  table-bordered table-striped">
                    <thead>
                        <th scope="col">#</th>
                        <th scope="col">Nombre</th>
                        <th scope="col">Descripcion</th>
                        <th scope="col">Seleccionar</th>
                    </thead>
                    <tbody>
                        @foreach($modelos as $modelo)
                        <tr>
                            <td>{{$modelo->id}}</td>
                            <td>{{$modelo->name}}</td>
                            <td>{{$modelo->description}}</td>
                            <td>
                                <div class="form-check">
                                    <input type="radio" class="btnradio" value="{{"$modelo->id"}}" name="modeloradio[]">
                                    <label class="form-check-label" for="{{"$modelo->id"}}">
                                    </label>
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                    </table>

                    <div class="clearfix">
                        <span class="float-left"><a href="{{ route('lanzar.modelo') }}" class="btn btn-dark btn-lg">Back</a></span>
                        <button type="submit" class="btn btn-dark btn-lg float-right" value="Next">Next</button>

                    </div>

            </form>


    @else
        <p>No hay modelos registrados</p>
    @endif

    <div class="clearfix">
        {{ $modelos->links() }}
    </div>

</div>

@endsection

@section('sidebar')



@endsection



