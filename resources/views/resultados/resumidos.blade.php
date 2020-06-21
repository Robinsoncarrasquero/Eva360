@extends('layout')

@section('title',"Resultados Resumido")

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
                        <h5>Evaluacion de <span class="text-danger">{{ $evaluado->name }}</span></h5>
                    </div>

                    <div class="text text-center">
                        <h4>Competencias evaluadas y resultados finales</span></h4>
                    </div>

                </div>

            </div>

            @if($competencias)

            <div class="panel-body">

                @foreach($competencias as $key=>$value)
                    <div class="table ">
                        <table id="{{$key}}" class="table  table-bordred table-striped">
                        <thead>
                        <tr>
                            <th class="text text-center alert-warning" colspan="2">
                            {{ $value['competencia']}} (Nivel Requerido {{ $value['nivelRequerido'] }})
                            </th>
                        </tr>
                        <th>Evaluador</th>
                        <th>Valoracion</th>

                        </thead>
                        <tbody>


                       @foreach ($value['data'] as $item)

                        <tr>
                            <td >{{ $item['name']}}</td>
                            <td>{{$item['average']}}</td>
                        </tr>

                       @endforeach
                       <tr>
                        <td class="text text-center">Evaluacion final </td>
                        <td class="  alert alert-info">{{ $value['eva360']}}</td>
                       </tr>

                    </tbody>
                    </table>
                @endforeach

            </div>
            <div class="clearfix">
                <span class="float-left"><a href="{{url()->previous()}}" class="btn btn-dark btn-lg">Back</a></span>
            </div>


            </div>

            @else

            <div class="alert-info">
                <p>No hay informacion de resultados procesados</p>
            <div>

            @endif

            {{-- {{ $competencias->links() }} --}}

        </div>

    </div>

</div>


@endsection
