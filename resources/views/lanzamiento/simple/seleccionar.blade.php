@extends('layout')

@section('title',"Lanzamiento de Prueba")

@section('content')

<div class="container">

    <div id="flash-message">
        @include('flash-message')

    </div>

    <div class="panel panel pb-1">
        <h4 class="text text-md-center">Seleccione las Competencias para la evaluacion de : {{ $evaluado->name }}</h4>
    </div>

    @if ($evaluadores->isNotEmpty())
        <div class="col-sm-12">
            <form action="{{ route('lanzar.confirmar',$evaluado) }}" method="POST" id="form-select">
                {{ csrf_field() }}
                <div class="row ">
                    <div class="col-sm-8">
                        <table class="table table-table" id="table1">
                            <thead class="table-thead">
                                <th scope="col">#</th>
                                <th scope="col">Competencia</th>
                                <th scope="col">Descripcion</th>
                                <th scope="col">Tipo</th>
                                <th scope="col">Seleccione</th>
                            </thead>
                            <tbody>
                            @foreach ($competencias as $competencia)
                            <tr data-id="{{" $competencia->id "}}">
                                <th scope="row">{{ $competencia->id }}</th>
                                <td>{{$competencia->name}}</td>
                                <td>{{ substr($competencia->description,0,150)}}....</td>
                                <td>{{$competencia->tipo->tipo}}</td>
                                {{-- <td>{{$competencia->grupocompetencia->name}}</td> --}}
                                <td>

                                    <div class="form-check">
                                            <input type="checkbox" class="btncheck" id="{{"$competencia->id"}}"
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
                            <tbody class="modelocompetenciasseleccionadas">

                            </tbody>
                        </table>

                    </div>

                    <div class="col-sm-8 clearfix">
                        <span class="float-left"><a href="{{ route('lanzar.index') }}" class="btn btn-dark btn-lg">Back</a></span>
                        <button type="submit" class="btn btn-dark btn-lg float-right" value="Next">Next</button>

                    </div>

                </div>


            </form>

        </div>

    @else
        <p>No hay usuarios registrados</p>
    @endif
    <div class="clearfix">

        {{-- {{ $competencias->links() }} --}}
    </div>



</div>

@endsection


@section('scripts')

    <script src="{{ asset('js/seleccionar.js') }}"></script>

@endsection

@section('sidebar')

@endsection



