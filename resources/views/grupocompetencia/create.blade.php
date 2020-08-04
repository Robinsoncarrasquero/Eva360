@extends('layout')

@section('title',"Creacion de Competencias")

@section('content')


<div class="container">

    <div class="panel panel-default">

        <h2 class="display-5">Nuevo Grupo de Competencia</h2>

        <div id="flash-message">
            @include('flash-message')
        </div>


        <form action="{{ route('grupocompetencia.store') }}" method="POST">
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


                </tr>

            </table>

            <div class="clearfix">
                <a href="{{route('grupocompetencia.index')}}" class="btn btn-dark float-left">Back</a>
                <button type="submit" class="btn btn-primary float-right">Crear</button>

            </div>

        </form>


    </div>

</div>
@section('scripts')
    <script src="{{ asset('js/preguntacreate.js') }}"></script>
@endsection

@endsection
