@extends('layout')

@section('title',"Creacion de Competencias")

@section('content')


<div class="container">

    <div class="panel panel-default">

        <h2 class="display-5">Nueva Competencia</h2>

        <div id="flash-message">
            @include('flash-message')
        </div>


        <form action="{{ route('competencia.store') }}" method="POST">
            @csrf

            <div class="table">
                <tr>
                    <td>
                        <div class="form-group">
                            <label for="name">Competencia</label>
                            <input id="name" placeholder="Competencia" class="form-control" type="text" name="name" value="{{old('name')  }}">
                        </div>
                        <div class="form-group">
                            <label for="description">Descripcion</label>
                            <textarea placeholder="Describa la competencia sus objetivos" type="text" id="description" class="form-control" rows="5"
                             maxlength="1000" name="description">{{ old('description') }}</textarea>
                        </div>
                        <div class="form-group">
                            <label for="nivelrequerido">Nivel Requerido</label>
                            <input placeholder="Indique el nivel requerido entre 0 y 100" id="nivelrequerido" class="form-control" type="text" name="nivelrequerido" value="{{ old('nivelrequerido') }}">
                        </div>


                        <div class="form-group">
                            <label for="tipo">Tipo</label>
                            <select id="tipo" class="form-control" name="tipo" >
                                @foreach ($tipos as $tipo)
                                    @if (old('tipo')==$tipo->id)
                                        <option selected value="{{$tipo->id}}">{{ $tipo->tipo }}</option>
                                    @else
                                        <option          value="{{$tipo->id}}">{{ $tipo->tipo }}</option>
                                    @endif
                                @endforeach
                            </select>
                        </div>

                    </td>
                </tr>

                <tr>

                    <table  class="table table-dark">
                        <thead>
                            <table id="tablepreguntas" class="table table-dark">
                                <thead class="thead-light">
                                    <tr>
                                        <th>Grado</th>
                                        <th>Pregunta</th>
                                        <th>Ponderacion</th>
                                        <th>
                                            <button type="button" class="btnponer btn btn-dark " ><i class=" material-icons">library_add</library-add></i></button>
                                         </th>

                                    </tr>
                                </thead>
                                <tbody>
                                    {{-- @foreach ($filegrado['Grados'] as $key=>$value)
                                    <tr>
                                        <td>
                                            <input type="text" name="gradoName[]" value="{{ old('gradoName.'.$key, $value->grado) }}">
                                        </td>
                                        <td>
                                            <textarea cols="50" rows="2" name="gradoDescription[]">{{ old('gradoDescription.'.$key, $value->description)}}</textarea>
                                        </td>
                                        <td>
                                            <input type="text" name="gradoPonderacion[]" value="{{ old('gradoPonderacion.'.$key, $value->ponderacion)}}">
                                        </td>
                                        <td>
                                            <button type="button" class="btnquitar btn btn-danger"> <i class="material-icons">delete</i></button>
                                        </td>

                                    </tr>
                                    @endforeach --}}
                                </tbody>

                        </thead>

                    </table>

                </tr>

            </table>

            <div class="clearfix">
                <a href="{{route('competencia.index')}}" class="btn btn-dark float-left">Back</a>
                <button type="submit" class="btn btn-primary float-right">Crear</button>

            </div>

        </form>


    </div>

</div>
@section('scripts')
    <script src="{{ asset('js/preguntacreate.js') }}"></script>
@endsection

@endsection
