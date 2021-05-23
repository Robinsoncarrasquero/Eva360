@extends('lanzamiento.layout')

@section('title',"Crear un Evaluado")

@section('content')

<div class="container">

            <div id="flash-message">
                @include('flash-message')
            </div>

            <div class="mt-1 alert alert-info text text-center ">
                <h6>Crear un Evaluado con sus evaluadores</h6>
            </div>

            @if($evaluadores)
                <form action="{{ route('talent.storeevaluado',$empleado->id) }}" method="POST" id="frm-evaluado">
                @csrf
                <div class="card mb-3">
                    <div class="card-header">
                        <label  for="proyecto">Proyectos</label>
                        <select id="subproyecto"  class="form-control" name="subproyecto" >
                            @foreach ($proyectos as $proyectodata)
                                @foreach ( $proyectodata->subproyectos as $subpro )
                                    @if (old('subproyecto')==$proyectodata->id)
                                        <option selected value="{{ $subpro->id }}">{{ $proyectodata->name }} ({{ $subpro->name }})</option>
                                    @else
                                        <option value="{{ $subpro->id }}">{{ $proyectodata->name }} ({{ $subpro->name }})</option>
                                    @endif
                                @endforeach
                            @endforeach
                        </select>
                    </div>
                    <div class="card-header mb-3">
                        <label>Ficha administrativa</label>
                        <select  class="form-control" name="departamento" id="{{ $empleado->departamento->id}}">
                            <option readonly value=" {{ $empleado->departamento->id}}">{{ $empleado->departamento->name}}
                        </select>
                        <select  class="form-control" name="cargo" id="{{ $empleado->cargo->id}}">
                            <option readonly value=" {{ $empleado->cargo->id}}">{{ $empleado->cargo->name}}
                        </select>
                        <input  readonly class="form-control" placeholder="Nombre" maxlength="100" type="text" name="nameevaluado" value="{{ $empleado->name }}" >
                    </div>
                    <div class="card-header mb-3">
                        <label for="metodo">Metodos</label>
                        <select id="metodo" class="form-control" name="metodo" >
                            @foreach ($metodos as $metodo)
                                <option value="{{$metodo}}">{{ $metodo }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-lg-12 ">
                        <label class="form-check-label " for="autoevaluacion" style="color: rgb(255, 165, 0);font-size:1.5em"> Autoevaluacion</label>
                        <input type="checkbox" class="check-select  "  name="autoevaluacion" >
                    </div>
                    <table id="table-evaluado" >
                        <thead class="thead-evaluado" style="color:black">
                        <th>#</th>
                        <th>Evaluador</th>
                        <th>Relacion</th>
                        {{-- <th>
                        <button type="button" class="btnponer btn btn-dark " ><i class=" material-icons">library_add</library-add></i></button>
                        </th> --}}
                        </thead>
                        <tbody>
                        @foreach ($evaluadores as $key=>$evaluador)
                            <tr id="{{$key}}">
                                <td class="form-control">{{ $key }}</td>
                                <td><input disabled class="form-control" type="text" maxlength="50" name="name[]" value="{{$evaluador['name']}}"></td>
                                <td><input disabled class="form-control" type="text" maxlength="50" name="relation[]" value="{{ $evaluador['relations'] }}"></td>
                               {{-- <td>
                                <button type="button" class="btnquitar btn btn-danger"> <i class="material-icons">delete</i></button>
                                </td> --}}
                            </tr>
                            @endforeach
                        </tbody>
                    </table>

                    <div class="clearfix">
                        <span class="float-left"><a href=" {{route('talent.index') }}" class="btn btn-dark btn-lg">Back</a></span>
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
<script src="{{ asset('js/evaluadocreate2.js') }}"></script>

@endsection

@section('sidebar')
<div class="alert alert-info col-sm-hide">

<dl class="terminos-definicion  md-hide" style="font-size: 0.60rem">
    <dt class="col-md-3">Evaluado</dt>
    <dd class="col-md-9">Persona que ocupa un cargo con unas competencias y un nivel para ejercer el puesto.</dd>

    <dt class="col-md-3">Evaluador</dt>
    <dd class="col-md-9">
      <p>Persona encargada de evaluar las competencias del Evaluado en el puesto.</p>
    </dd>

    <dt class="col-md-3 text-truncate">Relacion</dt>
    <dd class="col-md-9">
        <p>Es la relacion laboral entre Evaluado y el Evaluador.</p>
        <dl class="row">
            <dt class="col-md-6">La ponderacion es calculada basados en la "Relacion".</dt>
            <dd class="col-md-6">Supervisor, Par, Subordinado, Autoevaluacion</dd>
        </dl>
    </dd>

    <dt class="col-md-3 text-truncate">E90°</dt>
    <dd class="col-md-9">
        <dl class="row">
            <dt class="col-md-6">Prueba de E90° para 2 grupos</dt>
            <dd class="col-md-6">Manager y Supervisor</dd>
        </dl>
    </dd>
    <dt class="col-md-3 text-truncate">E180°</dt>
    <dd class="col-md-9">
        <dl class="row">
            <dt class="col-md-6">Prueba de E180° para 2 grupos</dt>
            <dd class="col-md-6">Supervisores, Pares</dd>
        </dl>
    </dd>
    <dt class="col-md-3 text-truncate">E360°</dt>
    <dd class="col-md-9">
        <dl class="row">
            <dt class="col-md-6">Prueba de E360° para 3 grupos</dt>
            <dd class="col-md-6">Supervisors, Pars, Subordinados, Autoevaluacion</dd>
        </dl>
    </dd>
</dl>
</div>

@endsection

@endsection

