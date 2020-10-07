@extends('lanzamiento.layout')

@section('title',"Crear un Evaluado")

@section('content')

<div class="container">

    <div class="panel panel-default">

            <div id="flash-message">
                @include('flash-message')
            </div>

            <div class="mt-1 xtitulo">
                <h5>Formulario para la creacion de una Evaluado y sus Evaluadores</h5>
            </div>

            @if($evaluadoArray)
                <form action="{{ route('evaluado.store',$fileName) }}" method="POST" id="frm-evaluado">
                    @csrf
                    <div  class="card">
                        <div class="card-header">
                            <select id="subproyecto" class="form-control" name="subproyecto" >
                                <option selected value="{{$subproyecto->id}}">{{ $subproyecto->proyecto->name }}({{ $subproyecto->name }}) </option>
                            </select>
                        </div>
                        <div  class="card-header">

                            <select id="cargo"  class="form-control" name="cargo" >
                                <label  for="cargo">Cargo:</label>
                                @foreach ($cargos as $data)
                                    @if (old('cargo')==$data->id)
                                        <option selected value="{{$data->id}}">{{ $data->name }}</option>
                                    @else
                                        <option value="{{$data->id}}">{{ $data->name }}</option>
                                    @endif
                                @endforeach
                            </select>
                            <input  class="form-control" placeholder="Nombre" maxlength="100" type="text" name="nameevaluado" value="{{old('nameevaluado') }}" autofocus>

                        </div>

                    </div>

                    <div class="mt-1">
                        <table id="table-evaluado" >
                        <thead class="thead-evaluado">
                        <th>#</th>
                        <th>Evaluador</th>
                        <th>Relacion</th>
                        <th>Email</th>
                        <th>
                            <button type="button" class="btnponer btn btn-dark " ><i class=" material-icons">library_add</library-add></i></button>
                         </th>
                        </thead>
                        <tbody>

                            @foreach ($evaluadoArray['Evaluadores'] as $key=>$evaluador)

                                <tr id="{{ $key }}">
                                    <td class="form-control">{{ $key }}</td>
                                    <td><input class="form-control" type="text" maxlength="50" name="name[]" value="{{old('name.'.$key,$evaluador->name)}}"></td>
                                    <td><input class="form-control" type="text" maxlength="15" name="relation[]" value="{{old('relation.'.$key,$evaluador->relation)}}"></td>
                                    <td><input class="form-control" type="email" maxlength="100" name="email[]"  value="{{old('email.'.$key,$evaluador->email)}}" ></td>
                                    <td>
                                        <button type="button" class="btnquitar btn btn-danger"> <i class="material-icons">delete</i></button>
                                    </td>
                                </tr>

                            @endforeach

                        </tbody>

                    </table>

                    <div class="clearfix">
                        <span class="float-left"><a href="{{url()->previous()}}" class="btn btn-dark btn-lg">Back</a></span>
                        <button type="submit" class="btn btn-dark btn-lg float-right" value="Next">Save</button>

                    </div>

                </form>

            </div>

        @else

            <div class="alert alert-info">
                <p>No hay informacion disponibles</p>
            <div>

        @endif

    </div>

</div>

@section('scripts')
<script src="{{ asset('js/evaluadocreate.js') }}"></script>

@endsection

@section('sidebar')

<dl class="row terminos-definicion" style="font-size: 0.75rem">
    <dt class="col-md-3">Evaluado</dt>
    <dd class="col-md-9">Persona que ocupa un cargo con unas competencias y un nivel requerido para ejercer el puesto.</dd>

    <dt class="col-md-3">Evaluador</dt>
    <dd class="col-md-9">
      <p>Persona encargada de evaluar las competencias del Evaluado en el puesto.</p>
    </dd>

    <dt class="col-md-3 text-truncate">Relacion</dt>
    <dd class="col-md-9">
        <p>Es la conexion directa entre Evaluador y el Evaluado. Considere que es sensible a Mayuscula y Minusculas.</p>
        <dl class="row">
            <dt class="col-md-6">Las ponderacion es calculada basados en la "Relacion".</dt>
            <dd class="col-md-6">Super,Par,Sub,Auto</dd>
        </dl>

    </dd>

    <dt class="col-md-3 text-truncate">90°</dt>
    <dd class="col-md-9">
        <dl class="row">
            <dt class="col-md-6">Prueba de 90°</dt>
            <dd class="col-md-6">Jefe, Super</dd>
        </dl>
    </dd>
    <dt class="col-md-3 text-truncate">180°</dt>
    <dd class="col-md-9">
        <dl class="row">
            <dt class="col-md-6">Prueba de 180° grupos mayor 1</dt>
            <dd class="col-md-6">Super, Par</dd>
        </dl>
    </dd>
    <dt class="col-md-3 text-truncate">360°</dt>
    <dd class="col-md-9">
        <dl class="row">
            <dt class="col-md-6">Prueba de 360 grupos mayor 1</dt>
            <dd class="col-md-6">Super, Par, Sub, Auto</dd>
        </dl>
    </dd>
</dl>


@endsection

@endsection

