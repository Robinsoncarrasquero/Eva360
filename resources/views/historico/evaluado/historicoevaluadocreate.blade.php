@extends('lanzamiento.layout')

@section('title',"Crear un Evaluado")

@section('content')

<div class="container">

            <div id="flash-message">
                @include('flash-message')
            </div>

            <div class="mt-1 titulo text-center">
                <h6>Crear un Evaluado y sus Evaluadores</h6>
            </div>

            @if($evaluadores)
                <form action="{{ route('historico.storeevaluado') }}" method="POST" id="frm-evaluado">
                @csrf
                <div class="card mb-3">
                    <div class="card-header">
                            <select id="proyecto"  class="form-control" name="proyecto" >
                                <label  for="proyecto">Proyectos:</label>
                                @foreach ($proyectos as $data)
                                    @if (old('proyecto')==$data->id)
                                        <option selected value="{{$data->id}}">{{ $data->name }}</option>
                                    @else
                                        <option value="{{$data->id}}">{{ $data->name }}</option>
                                    @endif
                                @endforeach
                            </select>
                        </select>
                    </div>
                    <div class="card-header mb-3">
                        <select id="cargo"  class="form-control" name="cargo" >
                            <label  for="cargo">Cargo:</label>
                            @foreach ($cargos as $data)
                                @if ($empleado->cargo->id==$data->id)
                                    <option selected value="{{$data->id}}">{{ $data->name }}</option>
                                @endif
                            @endforeach
                        </select>
                        <input  class="form-control" placeholder="Nombre" maxlength="100" type="text" name="nameevaluado" value="{{old('nameevaluado',$empleado->name) }}" autofocus>
                    </div>

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
                        @foreach ($evaluadores as $key=>$evaluador)
                            <tr id="{{$key}}">
                                <td class="form-control">{{ $key }}</td>
                                <td><input class="form-control" type="text" maxlength="50" name="name[]" value="{{old('name.'.$key,$evaluador->name)}}"></td>
                                {{-- @if ($evaluador->id=$empleado->id)
                                    <td><input class="form-control" type="text" maxlength="15" name="relation[]" value="{{old('relation.'.$key,'Autoevaluacion')}}"></td>
                               @endif --}}
                               <td>
                               <select id="relation"  class="form-control" name="relation[]" >
                                @foreach ($relations as $data)
                                    @if ($evaluador->id==$empleado->id)
                                        <option selected value="Autoevaluacion">Autoevaluacion</option>
                                    @break
                                    @else
                                        @if (old('relation')==$data->relation)
                                            <option selected value="{{$data->relation}}">{{ $data->relation }}</option>
                                        @else
                                            <option value="{{$data->relation}}">{{ $data->relation }}</option>
                                        @endif
                                    @endif
                                @endforeach
                                </select>
                               </td>
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
                    <p>No hay informacion disponible</p>
                <div>
            @endif
</div>

@section('scripts')
<script src="{{ asset('js/evaluadocreate.js') }}"></script>

@endsection

@section('sidebar')
<div class="alert alert-info col-sm-hide">

<dl class="terminos-definicion  md-hide" style="font-size: 0.60rem">
    <dt class="col-md-3">Evaluado</dt>
    <dd class="col-md-9">Persona que ocupa un cargo con unas competencias y un nivel requerido para ejercer el puesto.</dd>

    <dt class="col-md-3">Evaluador</dt>
    <dd class="col-md-9">
      <p>Persona encargada de evaluar las competencias del Evaluado en el puesto.</p>
    </dd>

    <dt class="col-md-3 text-truncate">Relacion</dt>
    <dd class="col-md-9">
        <p>Es la relacion laboral entre Evaluado y el Evaluador.</p>
        <dl class="row">
            <dt class="col-md-6">La ponderacion es calculada basados en la "Relacion".</dt>
            <dd class="col-md-6">Super,Par,Sub,Auto</dd>
        </dl>
    </dd>

    <dt class="col-md-3 text-truncate">E90°</dt>
    <dd class="col-md-9">
        <dl class="row">
            <dt class="col-md-6">Prueba de E90°</dt>
            <dd class="col-md-6">Jefe , Super</dd>
        </dl>
    </dd>
    <dt class="col-md-3 text-truncate">E180°</dt>
    <dd class="col-md-9">
        <dl class="row">
            <dt class="col-md-6">Prueba de E180° para 2 grupos</dt>
            <dd class="col-md-6">Super, Par</dd>
        </dl>
    </dd>
    <dt class="col-md-3 text-truncate">E360°</dt>
    <dd class="col-md-9">
        <dl class="row">
            <dt class="col-md-6">Prueba de E360° para 3 grupos</dt>
            <dd class="col-md-6">Super, Par, Sub, Auto</dd>
        </dl>
    </dd>
</dl>
</div>

@endsection

@endsection

