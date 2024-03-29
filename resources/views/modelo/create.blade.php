@extends('master')

@section('title',"Creacion Modelo de Evaluacion")

@section('content')

<div class="container">

    <div id="flash-message">
        @include('flash-message')
    </div>

    <div class="mt-1">
        <h5 class="text text-center">Nuevo Modelo de evaluacion</h5>
    </div>

    @if ($competencias->isNotEmpty())
        <div class="col-sm-12">
            <form action="{{ route('modelo.store') }}" method="POST" id="form-select">
                @csrf
                <div class="card-header">
                    <div class="row">
                        <div class="col-sm-12 col-md-6">
                            <label for="name">Modelo</label>
                            <input class="form-control" type="text" name="name" id="name" placeholder="Modelo" autofocus>
                        </div>
                        <div class="col-sm-12 col-md-6">
                            <label for="description">Descripcion</label>
                            <textarea class="form-control" rows="2"  type="text" name="description" id="description" placeholder="Describa el modelo"></textarea>
                        </div>
                    </div>
                </div>

                <div class="row mt-2">
                    <div class="col-sm-6">
                        <table class="table table-table" id="table1">
                            <thead class="table-thead">
                                <th scope="col">#</th>
                                <th scope="col">Competencia</th>
                                <th scope="col">Nivel</th>
                                <th scope="col">Tipo</th>
                                <th scope="col">Select</th>
                            </thead>
                            <tbody>
                            @foreach ($competencias as $competencia)
                                <tr id="{{ $competencia->id }}">
                                    <th >{{ $competencia->id }}</th>
                                    <td>{{$competencia->name}}</td>
                                    <td>
                                        <input type="number" maxlength="3" value="{{ $competencia->nivelrequerido }}" name="nivelrequerido[{{$competencia->id}}]">
                                    </td>
                                    <td>{{$competencia->tipo->tipo}}</td>
                                    <td>
                                        <div class="form-check">
                                        <input type="checkbox" class="btncheck"
                                        value="{{ $competencia->id }}" name="competenciascheck[{{ $competencia->id }}]">
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
                            <table class="table" id="table2">
                                <thead class="table-thead-lanzarmodelo">
                                    <th colspan="5" scope="col">Seleccionadas</th>
                                </thead>
                                <tbody class="tbody-competencias-seleccionar">
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
        <div class="alert alert-info">No hay informacion disponible</div>
    @endif

</div>

@endsection

@section('scripts')

    <script src="{{ asset('js/modelocreate.js') }}"></script>

@endsection


@section('sidebar')


@endsection



