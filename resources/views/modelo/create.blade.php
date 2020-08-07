@extends('layout')

@section('title',"Creacion de Modelos de Evaluacion")

@section('content')

<div class="container">

    <div class="panel panel pb-3">
        <h4 class="text text-md-center text text-info ">Seleccione las Competencias para Crear un Nuevo Modelo de Evaluacion</h4>
    </div>
    <div id="flash-message">
        @include('flash-message')

    </div>

    @if ($competencias->isNotEmpty())
        <div class="col-md-12">
            <form action="{{ route('modelo.store') }}" method="POST" id="form-select">
                {{-- {{ method_field('PUT') }} --}}
                {{ csrf_field() }}
                <div class="card-header">
                    <div class="row">
                        <div class="col-sm-12 col-md-6">
                            <label for="name">Modelo</label>
                            <input class="form-control" type="text" name="name" id="name" placeholder="Nombre">
                        </div>
                        <div class="col-sm-12 col-md-6">
                            <label for="description">Descripcion</label>
                            <textarea class="form-control" rows="2"  type="text" name="description" id="description" placeholder="Describa el modelo"></textarea>
                        </div>
                    </div>

                </div>

            <div class="row col-sm-12">
                <div class="col-sm-8">

                    <table class="table " id="table1">
                        <thead>
                            <th scope="col">#</th>
                            <th scope="col">Competencia</th>
                            <th scope="col">Descripcion</th>
                            <th scope="col">Tipo</th>
                            <th scope="col">Seleccionar</th>
                        </thead>
                        <tbody>
                            @foreach ($competencias as $competencia)
                                <tr id="{{ $competencia->id }}">
                                    <th scope="row">{{ $competencia->id }}</th>
                                    <td>{{$competencia->name}}</td>
                                    <td>{{ substr($competencia->description,0,50)}}....</td>
                                    <td>{{$competencia->tipo->tipo}}</td>
                                    {{-- <td>{{$competencia->grupocompetencia->name}}</td> --}}
                                    <td>
                                        <div class="form-check">
                                            <input type="checkbox" class="btncheck"
                                            value="{{"$competencia->id"}}" name="competenciascheck[]">
                                            <label class="form-check-label" for="{{"$competencia->id"}}">
                                            </label>
                                        </div>

                                    </td>
                                </tr>
                            @endforeach

                        </tbody>
                    </table>

                </div>

                <div class="col-sm-4 panel ">

                        <table class="table " id="table2">
                            <thead>
                                <th colspan="4" scope="col">Competencias Seleccionadas</th>
                            </thead>
                            <tbody >


                            </tbody>
                        </table>



                </div>


            </div>

            <div class="clearfix">
                <span class="float-left"><a href="{{ route('modelo.index') }}" class="btn btn-dark btn-lg">Back</a></span>
                <button type="submit" class="btn btn-dark btn-lg float-right" value="Next">Save</button>

            </div>

        </form>

        </div>

    @else
        <div class="alert alert-info">No hay usuarios registrados</div>

    @endif


</div>

@endsection

@section('scripts')

    <script src="{{ asset('js/modelocreate.js') }}"></script>

@endsection


@section('sidebar')


@endsection



