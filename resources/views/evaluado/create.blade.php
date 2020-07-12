@extends('layout')

@section('title',"Crear un Evaluado")

@section('content')

<div class="container">

    <div class="panel panel-default">

        <div class=" col-sm-12">
            <div id="flash-message">
                @include('flash-message')
            </div>


            <div class="panel panel pb-3">

                <div class="clearfix">

                    <div class="alert alert-info text-center">
                        <h5>Formulario para la creacion de un Evaluado con sus Evaluadores de forma <span class="text-danger">Manual</span></h5>
                    </div>

                    <div class="text text-left">
                        <h4>Revise la informacion y actualice cualquier dato correctamente antes de guardar la informacion.</h4>
                    </div>

                </div>

            </div>

            @if($evaluadoArray)

            <div class="panel-body">
                <form action="{{ route('evaluado.store',$fileName) }}" method="POST" id="frm-evaluado">
                    @csrf
                    <div  class="card-header">
                        <div class="col-sm-12">
                                <label for="nameevaluado">Nombre de la persona evaluar:</label>
                                <input  class="col-sm-8" maxlength="100" type="text" name="nameevaluado" value="{{old('nameevaluado') }}">
                                <button type="button" class="btnponer btn btn-dark " ><i class=" material-icons">library_add</library-add></i> </button>
                            </div>

                        </div>

                    </div>


                    <div class="table ">
                        <table id="tableevaluado" class="table">
                        <thead>
                        <th>Evaluador</th>
                        <th>Relation</th>
                        <th>Email</th>
                        </thead>
                        <tbody>

                            @foreach ($evaluadoArray['Evaluadores'] as $key=>$evaluador)

                                <tr id="{{ $key }}">
                                    <td><input type="text" maxlength="50" name="name[]" value="{{old('name.'.$key,$evaluador->name)}}"></td>
                                    <td><input type="text" maxlength="10" name="relation[]" value="{{old('relation.'.$key,$evaluador->relation)}}"></td>
                                    <td><input type="email" maxlength="100" name="email[]"  value="{{old('email.'.$key,$evaluador->email)}}" ></td>
                                    <td>
                                        <button type="button" class="btnquitar btn btn-danger"> <i class="material-icons">delete</i></button>
                                    </td>
                                </tr>

                            @endforeach

                        </tbody>

                    </table>

                    <div class="clearfix">
                        <span class="float-left"><a href="{{route('evaluado.index')}}" class="btn btn-dark btn-lg">Back</a></span>
                        <button type="submit" class="btn btn-dark btn-lg float-right" value="Next">Save</button>

                    </div>

                </form>

            </div>

            </div>

            @else

                <div class="alert-info">
                    <p>No hay informacion disponibles</p>
                <div>

            @endif


        </div>

    </div>

</div>

@section('scripts')
<script src="{{ asset('js/evaluadocreate.js') }}"></script>

@endsection

@endsection

