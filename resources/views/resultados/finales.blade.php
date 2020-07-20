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
                    @if ($evaluado->status!==Helper::estatus('Finalizada'))
                        <h2 class="alert alert-danger text text-center">La Prueba de <strong class=" text text-dark">{{ $evaluado->name }}</strong> aun no ha finalizado</h2>
                    @else
                        <div class="alert alert-info text-center">
                            <h5>Resultados Finales Ponderados de la Evaluacion de <span class="text-danger">{{ $evaluado->name }}</span></h5>
                        </div>
                    @endif

                    <div class="text text-center">
                        <h4>Competencias evaluadas y resultados finales</span></h4>
                    </div>

                </div>

            </div>

            @if($competencias)

            <div class="panel-body">

                @foreach($competencias as $key=>$value)
                    <div class="table ">
                        <table id="{{$key}}" class="table table-bordered">
                        <thead>
                        <tr>
                            <th class="text text-center alert alert alert-warning" colspan="2">
                            <span class="text text-dark">{{ $value['competencia']}} (Margen Requerido {{ $value['nivelRequerido'] }})
                            </strong> </th>
                        </tr>
                        <th>Grupo</th>
                        <th>Ponderacion</th>

                        </thead>
                        <tbody>
                        @foreach ($value['data'] as $item)

                        <tr>
                            <td >{{ $item['name']}}</td>
                            <td>{{ number_format($item['average'],2)}}</td>
                        </tr>

                       @endforeach
                       <tr>
                        <td class="text text-center"><strong>Resultado Final( sobre {{ count($value['data']) }} Grupos)</strong></td>
                        <td class="alert alert-dark">{{ number_format($value['eva360'],2)}}</td>
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
                <p>No hay informacion disponibles</p>
            <div>

            @endif

            {{-- {{ $competencias->links() }} --}}

        </div>

    </div>

</div>


@endsection
