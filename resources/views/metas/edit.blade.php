@extends('master')

@section('title',"Editar Meta")

@section('content')

<div class="container">

    <div id="flash-message">
        @include('flash-message')
    </div>

    <div class="text text-center">
        <h5>Actualizar meta</h5>
    </div>

    <div class="card">

        <form class="card-header" action="{{route('meta.update',$meta)  }}" method="post">
            @csrf
            @method('PATCH' )

            <div class="col-sm-6">
                <label for="name">Nombre</label>
                <input id="name" class="form-control" type="text" name="name" value="{{$meta->name }}">
            </div>

            <div class="col-sm-12">
                <label for="description">Descripcion</label>
                <textarea id="description" class="form-control"  name="description" rows="4" >{{$meta->description }}</textarea>
            </div>

            <div class="col-sm-12">
                <label for="pilarestrategico">Pilar Estratégico</label>
                <input type="text" id="pilarestrategico" placeholder="Pilar Estratégico" class="form-control" maxlength="50"  name="pilarestrategico" value="{{ $meta->pilarestrategico }}">
            </div>

            <div class="col-sm-6">
                <label for="nivelrequerido">Minimo Requerido</label>
                <input id="nivelrequerido" class="form-control" type="text" name="nivelrequerido" value="{{ $meta->nivelrequerido}}">
            </div>

            <div class="col-sm-6">
                <label for="tipo">Tipo</label>
                <select id="tipo" class="form-control" name="tipo">
                @foreach ($tipos as $tipo)
                        @if ($meta->tipo==$tipo)
                            <option selected value="{{$tipo->id}}">{{ $tipo->tipo }}</option>
                        @else
                            <option          value="{{$tipo->id}}">{{ $tipo->tipo }}</option>
                        @endif
                    @endforeach
                </select>
            </div>

            <div class="justify-content-start">
                <div class="col-6">
                    <label >Ubicacion</label>
                    <select class="form-control" id="departamento" name="departamento">
                        @foreach ($departamentos as $departamento)

                           @if ($meta->departamento_id==$departamento->id)
                                <option selected value="{{ $departamento->id }}">{{ $departamento->name}}</option>
                            @else
                                <option          value="{{ $departamento->id }}">{{ $departamento->name}}</option>
                            @endif
                         @endforeach

                    </select>
                </div>
            </div>

            <table id="tablepreguntas" class="table table-dark">
                <thead >
                    <th>#</th>
                    <th>Submeta</th>
                    <th>Descripcion</th>
                    <th>Valor Meta</th>
                    <th>Peso Objetivo</th>
                    <th>
                        <button type="button" class="btnponer btn btn-dark " ><i class=" material-icons">library_add</library-add></i></button>
                     </th>
                </thead>
                <tbody>
                    @foreach ($meta->submetas as $key=>$value)
                    <tr id="{{ $value->id }}">
                        <td>
                            <input  type="text" name="submetaid[]" value="{{ $value->id }}" >
                        </td>
                        <td>
                            <input  type="text" name="submetaName[]" value="{{ old('submetaName.'.$key, $value->submeta) }}">
                        </td>

                        <td>
                            <textarea  cols="50" rows="1" name="submetaDescription[]">{{ old('submetaDescription.'.$key, $value->description)}}</textarea>
                        </td>
                        <td>
                            <input  type="text" name="submetaValorMeta[]" value="{{ old('submetaValorMeta.'.$key, $value->valormeta)}}">
                        </td>
                        <td>
                            <input  type="text" name="submetaPeso[]" value="{{ old('submetaPeso.'.$key, $value->peso)}}">
                        </td>
                        {{-- <td>
                            <button type="button" class="btnquitar btn btn-danger"> <i class="material-icons">delete</i></button>
                        </td> --}}
                        <td>
                            <button class="btn btn-danger btnquitar" onclick="deleteConfirmationSubItem({{$value->id}},'{{route('submeta.delete',$value->id)}}')">Delete</button>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>

            <div class="clearfix col-sm-12 mt-2">
                <a href="{{url()->previous()}}" class="btn btn-dark float-left">Back</a>
                <button type="submit" class="btn btn-dark float-right">Save</button>
            </div>

        </form>



    </div>

</div>

@section('scripts')

    <script src="{{ asset('js/deleteConfirmationSubItem.js') }}"></script>
    <script src="{{ asset('js/metasnivelescreate.js') }}"></script>
@endsection

@endsection


