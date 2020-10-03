@extends('layout')

@section('title',"Creacion de Competencia")

@section('content')


<div class="container">

    <div class="panel panel-default">

        <div id="flash-message">
            @include('flash-message')
        </div>

        <div class="mt-1 text-center">
            <h3>Nueva Competencia</h3>
        </div>

        <form action="{{ route('competencia.store') }}" method="POST">
            @csrf
            <div class="row">

                <div class="col-sm-12">
                    <label for="name">Competencia</label>
                    <input type="text" id="name" placeholder="Competencia" class="form-control"  name="name" value="{{old('name')  }}" autofocus>
                </div>

                <div class="col-sm-12">
                    <label for="description">Descripcion</label>
                    <textarea placeholder="Descripcion de la competencia" type="text" id="description" class="form-control" rows="4"
                        maxlength="1000" name="description">{{ old('description') }}</textarea>
                </div>

                <div class="row col-sm-12">
                    <div class="col-sm-6">
                        <label for="nivelrequerido">Nivel Requerido</label>
                        <input placeholder="Nivel entre 0 y 100" id="nivelrequerido" class="form-control" type="text" name="nivelrequerido" value="{{ old('nivelrequerido') }}">
                    </div>

                    <div class="col-sm-6">
                        <label for="tipo">Tipo</label>
                        <select id="tipo" class="form-control" name="tipo" >
                            @foreach ($tipos as $tipo)
                                @if (old('tipo')==$tipo->id)
                                    <option selected value="{{$tipo->id}}">{{ $tipo->tipo }}</option>
                                @else
                                    <option value="{{$tipo->id}}">{{ $tipo->tipo }}</option>
                                @endif
                            @endforeach
                        </select>
                    </div>
                </div>

            </div>

            <div class="table">

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
                                    @foreach ($filegrado['Grados'] as $key=>$value)
                                    <tr>
                                        <td>
                                            <input  type="text" name="gradoName[]" value="{{ old('gradoName.'.$key, $value->grado) }}">
                                        </td>
                                        <td>
                                            <textarea  cols="50" rows="3" name="gradoDescription[]">{{ old('gradoDescription.'.$key, $value->description)}}</textarea>
                                        </td>
                                        <td>
                                            <input  type="text" name="gradoPonderacion[]" value="{{ old('gradoPonderacion.'.$key, $value->ponderacion)}}">
                                        </td>
                                        <td>
                                            <button type="button" class="btnquitar btn btn-danger"> <i class="material-icons">delete</i></button>
                                        </td>

                                    </tr>
                                    @endforeach
                                </tbody>

                        </thead>

                    </table>


            </table>

            <div class="clearfix">
                <a href="{{route('competencia.index')}}" class="btn btn-dark float-left">Back</a>
                <button type="submit" class="btn btn-dark float-right">Crear</button>

            </div>

        </form>


    </div>

</div>
@section('scripts')
    <script src="{{ asset('js/preguntacreate.js') }}"></script>
@endsection

@endsection
