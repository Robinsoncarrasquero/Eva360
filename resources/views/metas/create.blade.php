@extends('master')

@section('title',"Creacion de Meta")

@section('content')


<div class="container">

    <div class="panel panel-default">

        <div id="flash-message">
            @include('flash-message')
        </div>

        <div class="mt-1 text-center">
            <h5>Nueva Meta</h5>
        </div>

        <form action="{{ route('meta.store') }}" method="POST">
            @csrf
            <div class="row">

                <div class="col-sm-12">
                    <label for="name">Nombre meta</label>
                    <input type="text" id="name" placeholder="Indique una meta" class="form-control"  name="name" value="{{old('name')  }}" autofocus>
                </div>

                <div class="col-sm-12">
                    <label for="description">Descripcion</label>
                    <textarea placeholder="Describa sobre la meta" type="text" id="description" class="form-control" rows="4"
                        maxlength="1000" name="description">{{ old('description') }}</textarea>
                </div>
                <div class="col-sm-12">
                    <label for="pilarestrategico">Pilar Estratégico</label>
                    <input type="text" id="pilarestrategico" placeholder="Pilar Estratégico" class="form-control" maxlength="50"  name="pilarestrategico" value="{{old('pilarestrategico')  }}" autofocus>
                </div>

                <div class="row col-sm-12">
                    <div class="col-sm-4">
                        <label for="nivelrequerido">Minimo Alcanzar</label>
                        <input placeholder="Mimimo esperado entre 0 y 100" id="nivelrequerido" class="form-control" type="text" name="nivelrequerido" value="{{ old('nivelrequerido') }}">
                    </div>

                    <div class="col-sm-8">
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

                    <table  class="table">

                            <table id="tablepreguntas" class="table table-dark">
                                <thead >
                                    <tr>
                                        <th>Submeta</th>
                                        <th>Descripcion</th>
                                        <th>Valor Meta</th>
                                        <th>Peso Objetivo</th>
                                        <th>
                                            <button type="button" class="btnponer btn btn-dark " ><i class=" material-icons">library_add</library-add></i></button>
                                         </th>

                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($submetas['submetas'] as $key=>$value)
                                    <tr>
                                        <td>
                                            <input  type="text" name="submetaName[]" value="{{ old('submetaName.'.$key, $value->meta) }}">
                                        </td>
                                        <td>
                                            <textarea  cols="50" rows="1" name="submetaDescription[]">{{ old('submetaDescription.'.$key, $value->description)}}</textarea>
                                        </td>
                                        <td>
                                            <input  type="text" name="submetaValorMeta[]" value="{{ old('submetaValorMeta.'.$key, $value->valormeta)}}">
                                        </td>
                                        <td>
                                            <input  type="number" name="submetaPeso[]" value="{{ old('submetaPeso.'.$key, $value->peso)}}">
                                        </td>
                                        <td>
                                            <button type="button" class="btnquitar btn btn-danger"> <i class="material-icons">delete</i></button>
                                        </td>

                                    </tr>
                                    @endforeach
                                </tbody>



                    </table>


            </table>

            <div class="clearfix">
                <a href="{{route('meta.index')}}" class="btn btn-dark float-left">Back</a>
                <button type="submit" class="btn btn-dark float-right">Crear</button>
            </div>

        </form>


    </div>

</div>
@section('scripts')
    <script src="{{ asset('js/metasnivelescreate.js') }}"></script>
@endsection

@endsection
