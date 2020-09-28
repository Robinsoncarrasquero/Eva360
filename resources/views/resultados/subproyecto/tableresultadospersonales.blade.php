@extends('layout')

@section('title',"Resultados Personales Tabulado")

@section('content')

<div class="container">

    <div class="panel panel-default">

        <div class="col-sm-12">

            <div id="flash-message">
                @include('flash-message')

            </div>

            <div class="panel panel pb-3">

                <div class="clearfix">
                    <div class=" text-center titulo">
                        <h5>Resultados de competencias personales</span></h5>
                    </div>

                    <div class="text text-center">
                        <h4>{{ $subProyecto->name }}</span></h4>
                    </div>

                </div>

            </div>

            @if($subProyecto)

                <div class="row ">

                        <div class="table col-12">
                            <table id="{{ 'table'.$subProyecto->id }}" class="table  table-bordered table-striped table-table">
                                <thead class="table-thead">
                                    <tr>
                                        <th>
                                            Competencias/Participantes
                                        </th>
                                       @foreach ($dataCategoria as $key=>$value)
                                        <th>
                                            {{$value}}</strong>
                                        </th>
                                        @endforeach
                                    </tr>

                                </thead>
                                <tbody>
                                    @foreach ($dataSerie as $key=>$dataValue)
                                    <tr>
                                        <td>{{$dataValue['name']}}</td>
                                        @foreach ($dataValue['data'] as $vdata)
                                        <td>{{ $vdata}}</td>
                                        @endforeach
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>

                </div>

                    <div class="clearfix">
                        <span class="float-left"><a href="{{url()->previous()}}" class="btn btn-dark btn-lg">Back</a></span>
                    </div>
            @else

                <div class="alert-info">
                    <p>No hay informacion disponible</p>
                <div>

            @endif

            {{-- {{ $competencias->links() }} --}}

        </div>

    </div>

</div>


@endsection
