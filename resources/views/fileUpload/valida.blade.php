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
                        <h5>Validacion de Informacion subida en el archivo <span class="text-danger">{{ $fileOriginalName}}</span></h5>
                    </div>

                    <div class="text text-center">
                        <h4>Revise la informacion si esta correcta para lanzar la Evaluacion</span></h4>
                    </div>

                </div>

            </div>

            @if($evaluadoArray)

            <div class="panel-body">

                    <div class="table ">
                        <table id="evaluado" class="table  table-bordered">
                        <thead>
                        <tr>
                            <th class="text text-center alert-warning" colspan="3">
                            {{ $evaluadoArray['Evaluado']}}
                            </th>
                        </tr>
                        <th>Evaluadores</th>
                        <th>Relation</th>
                        <th>Email</th>
                        </thead>
                        <tbody>

                        @foreach ($evaluadoArray['Evaluadores'] as $key=>$value)

                        <tr>
                            <td>{{$value->name}}</td>
                            <td>{{$value->relation}}</td>
                            <td>{{$value->email}}</td>
                        </tr>

                       @endforeach

                    </tbody>
                    </table>

            </div>
            <div class="clearfix">
                <span class="float-left"><a href="{{ url()->previous()}}" class="btn btn-dark btn-lg">Back</a></span>
            </div>


            </div>

            @else

            <div class="alert-info">
                <p>No hay informacion disponibles</p>
            <div>

            @endif

            {{-- {{ $competencias->links() }} --}}

        </div>

    </div>

</div>


@endsection
