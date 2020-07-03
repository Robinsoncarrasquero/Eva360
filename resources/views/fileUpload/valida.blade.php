@extends('layout')

@section('title',"Validacion de Archivo")

@section('content')

<div class="container">

    <div class="panel panel-default">

        <div class="col-md-12">

            <div id="flash-message">
                @include('flash-message')
            </div>

            <div class="panel panel pb-3">

                <div class="clearfix">

                    <div class="alert alert-info text-center">
                        <h5>Formulario para la Validacion de la Informacion subida en el archivo <span class="text-danger">{{ $fileOName }}</span></h5>
                    </div>

                    <div class="text text-left">
                        <h4>Revise la informacion y actualice cualquier dato antes de Guardar la data.</h4>
                    </div>

                </div>

            </div>

            @if($evaluadoArray)

            <div class="panel-body">

                <form action="{{ route('json.filesave',$fileName) }}" method="POST" id="form-jsonfile">
                    @csrf
                    <div class="table ">
                        <table id="evaluado" class="table  table-bordered">
                        <thead>
                        <tr>
                            <th class="text text-center  title alert-warning" colspan="3">
                            <h4>{{ $evaluadoArray['Evaluado']}}</h4>
                            </th>
                        </tr>
                        <th>Evaluador</th>
                        <th>Relation</th>
                        <th>Email</th>
                        </thead>
                        <tbody>

                            @foreach ($evaluadoArray['Evaluadores'] as $key=>$value)

                                <tr>
                                    <td><input type="text" name="name[]" value="{{$value->name}}"></td>
                                    <td><input type="text" name="relation[]" value="{{$value->relation}}"></td>
                                    <td><input type="email" name="email[]" value="{{$value->email}}"></td>
                                </tr>

                            @endforeach

                        </tbody>

                    </table>

                    <div class="clearfix">
                        <span class="float-left"><a href="{{ route('json.fileindex')}}" class="btn btn-dark btn-lg">Back</a></span>
                        <button type="submit" class="btn btn-dark btn-lg float-right" value="Next">Guardar</button>

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


@endsection
