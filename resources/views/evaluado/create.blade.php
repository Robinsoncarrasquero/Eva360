@extends('lanzamiento.layout')

@section('title',"Crear un Evaluado")

@section('content')

<div class="container">

    <div class="panel panel-default">

            <div id="flash-message">
                @include('flash-message')
            </div>

            <div class="mt-1 titulo">
                <h5>Formulario para la creacion de un Evaluado y sus Evaluadores.</h5>
            </div>


            @if($evaluadoArray)


                <form action="{{ route('evaluado.store',$fileName) }}" method="POST" id="frm-evaluado">
                    @csrf
                    <div  class="card">
                        <div  class="card-header">
                            <label  for="nameevaluado">Nombre Evaluado:</label>
                            <input  class=" form-control" maxlength="100" type="text" name="nameevaluado" value="{{old('nameevaluado') }}">

                        </div>
                        <div  class="card-header">
                            <label  for="cargo">Cargo:</label>
                            <input  class=" form-control" maxlength="30" type="text" name="cargoevaluado" value="{{old('cargoevaluado') }}">

                        </div>
                    </div>

                    <div class="table">
                        <table id="tableevaluado" class="table">
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
                                    <td>{{ $key }}</td>
                                    <td><input class="form-control" type="text" maxlength="50" name="name[]" value="{{old('name.'.$key,$evaluador->name)}}"></td>
                                    <td><input class="form-control" type="text" maxlength="10" name="relation[]" value="{{old('relation.'.$key,$evaluador->relation)}}"></td>
                                    <td><input class="form-control" type="email" maxlength="100" name="email[]"  value="{{old('email.'.$key,$evaluador->email)}}" ></td>
                                    <td>
                                        {{-- <button type="button" class="btnquitar btn btn-danger"> <i class="material-icons">delete</i></button> --}}
                                    </td>
                                </tr>

                            @endforeach

                        </tbody>

                    </table>

                    <div class="clearfix">
                        <span class="float-left"><a href="{{route('lanzar.index')}}" class="btn btn-dark btn-lg">Back</a></span>
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
        <p>Es la conexion directa entre Evaluador con respecto al Evaluado. Defina cualquier <strong>"Relacion"</strong>. Considere que es sensible a Mayuscula y Minusculas.</p>
        <dl class="row">
            <dt class="col-md-6">Las ponderacion es calculada agrupando la "Relacion".</dt>
            <dd class="col-md-6">Jefe, Super, Partner, Cliente, Boss, etc.</dd>
        </dl>
    </dd>
</dl>


@endsection

@endsection

